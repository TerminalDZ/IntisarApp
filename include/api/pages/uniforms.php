<?php
include '../../init.php';
if (!isset($_SESSION['username'])) {
    header('Location: ' . BASEURL . 'index.php');
    exit();
}


// Redirect if no view permission
if (!$show_uniform) {
    echo json_encode(['status' => 'error', 'message' => 'ليس لديك الصلاحية لعرض الأزياء الكشفية']);
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
if (empty($action) && isset($_POST['action'])) {
    $action = $_POST['action'];
}

/**
 * Get all uniforms grouped by member
 */
if ($action == 'get_uniforms' || $action == 'getUniforms') {
    try {
        // Join with members table to get complete information
        $sql = "SELECT u.*, m.first_name, m.last_name 
                FROM uniforms u 
                JOIN members m ON u.member_id = m.member_id 
                WHERE m.archiv = 0
                ORDER BY u.created_at DESC";
        
        $result = DB::query($sql);

        if (!$result) {
            throw new Exception("Error executing query: " . $db->error);
        }

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $member_id = $row['member_id'];

            // Group by member_id
            if (isset($data[$member_id])) {
                $data[$member_id]['uniforms'][] = [
                    'id' => $row['id'],
                    'uniform_type' => $row['uniform_type'],
                    'size' => $row['size'],
                    'amount_paid' => $row['amount_paid'],
                    'payment_date' => $row['payment_date'],
                    'paid' => $row['paid'],
                    'received' => $row['received'],
                    'note' => $row['note'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at'],
                ];
            } else {
                $data[$member_id] = [
                    'member' => [
                        'member_id' => $member_id,
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                    ],
                    'uniforms' => [
                        [
                            'id' => $row['id'],
                            'uniform_type' => $row['uniform_type'],
                            'size' => $row['size'],
                            'amount_paid' => $row['amount_paid'],
                            'payment_date' => $row['payment_date'],
                            'paid' => $row['paid'],
                            'received' => $row['received'],
                            'note' => $row['note'],
                            'created_at' => $row['created_at'],
                            'updated_at' => $row['updated_at'],
                        ]
                    ]
                ];
            }
        }

        // Convert associative array to indexed array for DataTables
        $formatted_data = array_values($data);

        echo json_encode([
            'status' => 'success', 
            'message' => 'تم جلب البيانات بنجاح', 
            'data' => $formatted_data,
            'recordsTotal' => count($formatted_data),
            'recordsFiltered' => count($formatted_data)
        ]);
        
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage()]);
    }
}

/**
 * Search for members to add uniforms
 */
elseif ($action == 'GetMembers') {
    if (!$add_uniform) {
        echo json_encode(['status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية']);
        exit();
    }

    try {
        $q = isset($_GET['q']) ? $db->real_escape_string($_GET['q']) : '';

        if (empty($q)) {
            echo json_encode(['status' => 'error', 'message' => 'الرجاء إدخال كلمة البحث']);
            exit();
        }

        $where = "archiv = 0 AND (first_name LIKE '%$q%' OR last_name LIKE '%$q%' OR member_id LIKE '%$q%')";
        $result = DB::select('members', $where, 'member_id, first_name, last_name');

        $members = [];
        while ($row = $result->fetch_assoc()) {
            $members[] = [
                'id' => $row['member_id'],
                'text' => $row['member_id'] . ' - ' . $row['first_name'] . ' ' . $row['last_name']
            ];
        }

        echo json_encode([
            'status' => 'success', 
            'message' => 'تم جلب الأعضاء بنجاح', 
            'results' => $members,
            'pagination' => ['more' => false]
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء جلب الأعضاء: ' . $e->getMessage()]);
    }
} 

/**
 * Get member details by ID
 */
elseif ($action == 'GetMembersByMemberId') {
    try {
        $member_id = isset($_POST['member_id']) ? $db->real_escape_string($_POST['member_id']) : '';

        if (empty($member_id)) {
            echo json_encode(['status' => 'error', 'message' => 'معرف العضو مطلوب']);
            exit();
        }

        $data = DB::select('members', "member_id = '$member_id' AND archiv = 0")->fetch_assoc();

        if (!$data) {
            echo json_encode(['status' => 'error', 'message' => 'العضو غير موجود']);
            exit();
        }

        echo json_encode(['status' => 'success', 'message' => 'تم جلب العضو بنجاح', 'member' => $data]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء جلب بيانات العضو: ' . $e->getMessage()]);
    }
} 

/**
 * Add or update uniform record
 */
elseif ($action == 'AddUniform') {
    try {
        // Check permissions
        if (isset($_POST['uniform_id']) && !empty($_POST['uniform_id'])) {
            if (!$edit_uniform) {
                echo json_encode(['status' => 'error', 'message' => 'ليس لديك الصلاحية لتعديل الأزياء']);
                exit();
            }
        } else {
            if (!$add_uniform) {
                echo json_encode(['status' => 'error', 'message' => 'ليس لديك الصلاحية لإضافة الأزياء']);
                exit();
            }
        }

        // Validate input data
        $member_id = isset($_POST['member_id']) ? $db->real_escape_string($_POST['member_id']) : '';
        $uniform_id = isset($_POST['uniform_id']) ? $db->real_escape_string($_POST['uniform_id']) : '';
        $uniform_type = isset($_POST['uniform_type']) ? $db->real_escape_string($_POST['uniform_type']) : '';
        $size = isset($_POST['uniform_size']) ? $db->real_escape_string($_POST['uniform_size']) : '';
        $amount_paid = isset($_POST['uniform_price']) ? $db->real_escape_string($_POST['uniform_price']) : '';
        $paid = isset($_POST['uniform_paid']) ? $db->real_escape_string($_POST['uniform_paid']) : '';
        $received = isset($_POST['uniform_received']) ? $db->real_escape_string($_POST['uniform_received']) : '';
        $note = isset($_POST['uniform_notes']) ? $db->real_escape_string($_POST['uniform_notes']) : '';

        // Basic validation
        if (empty($member_id) || empty($uniform_type) || empty($size) || $amount_paid === '' || $paid === '' || $received === '') {
            echo json_encode(['status' => 'error', 'message' => 'الرجاء ملء جميع الحقول المطلوبة']);
            exit();
        }

        // Verify member exists
        $check_member = DB::query("SELECT COUNT(*) AS count FROM members WHERE member_id = '$member_id' AND archiv = 0")->fetch_assoc();
        if ($check_member['count'] == 0) {
            echo json_encode(['status' => 'error', 'message' => 'العضو غير موجود']);
            exit();
        }

        // Prepare data for database operation
        $data = [
            'member_id' => $member_id,
            'uniform_type' => $uniform_type,
            'size' => $size,
            'amount_paid' => $amount_paid,
            'payment_date' => date('Y-m-d'),
            'paid' => $paid,
            'received' => $received,
            'note' => $note,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update or insert based on uniform_id
        if (!empty($uniform_id)) {
            // Update existing record
            $result = DB::update('uniforms', $data, "id = '$uniform_id'");
            $message = 'تم تعديل بيانات الزي بنجاح';
        } else {
            // Add created_at for new records
            $data['created_at'] = date('Y-m-d H:i:s');
            
            // Insert new record
            $result = DB::insert('uniforms', $data);
            $uniform_id = DB::get_last_id();
            $message = 'تمت إضافة الزي بنجاح';
        }

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => $message, 'uniform_id' => $uniform_id]);
        } else {
            throw new Exception("فشل في تنفيذ عملية قاعدة البيانات");
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء معالجة طلبك: ' . $e->getMessage()]);
    }
} 

/**
 * Delete uniform record
 */
elseif ($action == 'DeleteUniform') {
    try {
        if (!$delete_uniform) {
            echo json_encode(['status' => 'error', 'message' => 'ليس لديك الصلاحية لحذف الأزياء']);
            exit();
        }

        $uniform_id = isset($_POST['uniform_id']) ? $db->real_escape_string($_POST['uniform_id']) : '';

        if (empty($uniform_id)) {
            echo json_encode(['status' => 'error', 'message' => 'معرف الزي مطلوب']);
            exit();
        }

        $result = DB::delete('uniforms', "id = '$uniform_id'");

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'تم حذف الزي بنجاح']);
        } else {
            throw new Exception("فشل في تنفيذ عملية قاعدة البيانات");
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء حذف الزي: ' . $e->getMessage()]);
    }
}

/**
 * Get uniforms by member ID
 */
elseif ($action == 'GetUniformByMemberId') {
    try {
        $member_id = isset($_POST['member_id']) ? $db->real_escape_string($_POST['member_id']) : '';

        if (empty($member_id)) {
            echo json_encode(['status' => 'error', 'message' => 'معرف العضو مطلوب']);
            exit();
        }

        $data = DB::select('uniforms', "member_id = '$member_id'");
        
        if ($data->num_rows == 0) {
            echo json_encode(['status' => 'info', 'message' => 'لا يوجد زي مسجل لهذا العضو']);
            exit();
        }

        $uniforms = [];
        while ($row = $data->fetch_assoc()) {
            $uniforms[] = [
                'uniform_id' => $row['id'],
                'uniform_type' => $row['uniform_type'],
                'size' => $row['size'],
                'amount_paid' => $row['amount_paid'],
                'payment_date' => $row['payment_date'],
                'paid' => $row['paid'],
                'received' => $row['received'],
                'note' => $row['note'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ];
        }

        echo json_encode(['status' => 'success', 'message' => 'تم جلب بيانات الزي بنجاح', 'uniform' => $uniforms]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء جلب بيانات الزي: ' . $e->getMessage()]);
    }
}
else {
    echo json_encode(['status' => 'error', 'message' => 'العملية غير صالحة']);
}
