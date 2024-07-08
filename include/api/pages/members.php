<?php
    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }

    $action = $_GET['action'];



  
    
    if ($action == 'GetMemberData') {

        if (!$show_scout) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

        $member_id = $_POST['member_id'];

        $member = Members::get_data_member_id($member_id);
        
        $insurances = Members::get_all_insurances($member_id);
        
        if ($member != null) {
            echo json_encode(array('status' => 'success', 'message' => 'تم العثور على العضو', 'data' => $member , 'insurances' => $insurances));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'لم يتم العثور على العضو'));
        }
        

    }elseif ($action == 'GetUser') {

        $user_id = $_POST['id'];

        $user = User::get_data_id($user_id);

        $FullName = $user['fr_name'] . ' ' . $user['ls_name'];

        if ($user != null) {
            echo json_encode(array('status' => 'success', 'message' => 'تم العثور على المستخدم', 'FullName' => $FullName));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'لم يتم العثور على المستخدم'));
        }
        
    }elseif ($action == 'DeleteMember') {

        if (!$delete_scout) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

        $member_id = $_POST['member_id'];

        $where = "member_id = '$member_id'";
        $check = DB::select('members', $where);

        if ($check->num_rows > 0) {
            $data = [
                'archiv' => '1'
            ];
            $result = DB::update('members', $data, $where);
            

            if ($result) {
                echo json_encode(array('status' => 'success', 'message' => 'تم حذف العضو بنجاح'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء حذف العضو'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'العضو غير موجود'));
        }
    }elseif ($action == 'restoreMember') {

        if (!$delete_scout) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

        $member_id = $_POST['member_id'];

        $where = "member_id = '$member_id'";
        $check = DB::select('members', $where);

        if ($check->num_rows > 0) {
            $data = [
                'archiv' => '0'
            ];
            $result = DB::update('members', $data, $where);
            

            if ($result) {
                echo json_encode(array('status' => 'success', 'message' => 'تم استعادة العضو بنجاح'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء استعادة العضو'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'العضو غير موجود'));
        }
    }elseif ($action == 'SearchMembers') {
        if (!$show_scout) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

        $search = $_POST['q'];

        if (empty($search) || ctype_space($search)) {
            echo json_encode(array('status' => 'error', 'message' => 'أدخل كلمة البحث'));
            return;
        }

        $members = Members::search($search);

        if ($members != null) {
            echo json_encode(array('status' => 'success', 'message' => 'تم العثور على الأعضاء', 'data' => $members));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'لم يتم العثور على الأعضاء'));
        }
    }
        


      