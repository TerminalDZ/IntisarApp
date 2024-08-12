<?php
    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }

    $action = $_GET['action'];

    


    if ($action == 'get_uniforms') {
        $sql = "SELECT * FROM uniforms";
        $result = DB::query($sql);
    
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $member_id = $row['member_id'];
    
            $member_data = DB::select('members', "member_id = '$member_id'", 'first_name, last_name')->fetch_assoc();
    
            $row['member'] = array(
                'first_name' => $member_data['first_name'],
                'last_name' => $member_data['last_name']
            );
    
            $data[] = $row;
        }
    
        if (empty($data)) {
            echo json_encode(array('status' => 'error', 'message' => 'No data found'));
            exit();
        }
    
        echo json_encode(array('status' => 'success', 'message' => 'Data fetched successfully', 'data' => $data));
        
    }elseif($action == 'GetMembers'){

        if (!$add_uniform) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

        $q = $_GET['q'];

        $where = "first_name LIKE '%$q%' OR last_name LIKE '%$q%' OR member_id LIKE '%$q%'";
        $data = DB::select('members', $where, 'member_id, first_name, last_name');

        $members = array();
        while ($row = $data->fetch_assoc()) {
            $members[] = array(
                'member_id' => $row['member_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name']
            );
        }

        echo json_encode(array('status' => 'success', 'message' => 'تم جلب الأعضاء بنجاح', 'members' => $members));




    }elseif ($action == 'GetMembersByMemberId'){


        $member_id = $_POST['member_id'];

        $data = DB::select('members', "member_id = '$member_id' AND archiv = 0")->fetch_assoc();

        if ($data == null) {
            echo json_encode(array('status' => 'error', 'message' => 'العضو غير موجود'));
            die();
        }



        echo json_encode(array('status' => 'success', 'message' => 'تم جلب العضو بنجاح', 'member' => $data));

    }elseif ($action == 'AddUniform'){
        if (!$add_uniform) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }
    
        $member_id = $_POST['member_id'];
        $uniform_type = $_POST['uniform_type'];
        $size = $_POST['uniform_size'];
        $amount_paid = $_POST['uniform_price'];
        $paid = $_POST['uniform_paid'];
        $received = $_POST['uniform_received'];
        $note = $_POST['uniform_notes'];
    
        if ($member_id == '' || $uniform_type == '' || $size == '' || $amount_paid == '' || $paid == '' || $received == '') {
            echo json_encode(array('status' => 'error', 'message' => 'الرجاء ملء جميع الحقول'));
            return;
        }
    
        $check_member = DB::query("SELECT COUNT(*) AS count FROM members WHERE member_id = '$member_id' AND archiv = 0")->fetch_assoc();
        if ($check_member['count'] == 0) {
            echo json_encode(array('status' => 'error', 'message' => 'العضو غير موجود'));
            return;
        }
    
        $data = array(
            'member_id' => $member_id,
            'uniform_type' => $uniform_type,
            'size' => $size,
            'amount_paid' => $amount_paid,
            'payment_date' => date('Y-m-d'),
            'paid' => $paid,
            'received' => $received,
            'note' => $note
        );
    
        $result = DB::insert('uniforms', $data);
    
        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'تمت الإضافة بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء الإضافة'));
        }
    }
    


    


    

