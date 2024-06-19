<?php
    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }

    $action = $_GET['action'];


    if ($action == 'CountMembersInsuranced'){

        $year = $_POST['year'];
        $where = "year = '$year' AND archiv = '0'";
        $count = DB::select('insurances', $where);
        $totalMembers = DB::Count('members', "archiv = 0 AND YEAR(joining_date) <= '$year'");


        echo json_encode(array('status' => 'success', 'message' => 'تم جلب عدد المنخرطين المأمنين بنجاح', 'count' => $count->num_rows, 'totalMembers' => $totalMembers));
    }elseif ($action == 'CountMembersSumamountInsuranced'){

        $year = $_POST['year'];
        $where = "year = '$year' AND archiv = '0' AND paid = '1'";
        $count = DB::select('insurances', $where);

        $sum = 0;
        while ($row = $count->fetch_assoc()) {
            $sum += $row['amount'];
        }

        echo json_encode(array('status' => 'success', 'message' => 'تم جلب مجموع المدفوعات بنجاح', 'sum' => $sum));
       
        

    }elseif ($action == 'GetYearsInput'){
        $query = "SELECT DISTINCT year FROM insurances";
        
        $result = $db->query($query);

        $years = array();
        while ($row = $result->fetch_assoc()) {
            $years[] = $row['year'];
        }

        echo json_encode(array('status' => 'success', 'message' => 'تم جلب السنوات بنجاح', 'years' => $years));
    }elseif ($action == 'GetAllinsurances'){

        if (isset($_POST['year'])) {
            $year = $_POST['year'];
            $where = "year = '$year' AND archiv = '0'";
            $data = DB::select('insurances', $where);
        
            $insurances = array();
            while ($row = $data->fetch_assoc()) {
                $member_id = $row['member_id'];
                $member_data = DB::select('members', "member_id = '$member_id'", 'first_name, last_name')->fetch_assoc();
                $row['member'] = array(
                    'first_name' => $member_data['first_name'],
                    'last_name' => $member_data['last_name']
                );
                $insurances[] = $row;
            }
            
        
            echo json_encode(array('status' => 'success', 'message' => 'تم جلب التأمينات بنجاح', 'insurances' => $insurances));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'لم يتم توفير السنة'));
        }



    }elseif ($action == 'UpdatePaidStatus'){


        $id = $_POST['id'];
        $paid = $_POST['paid'];

        $data = array(
            'paid' => $paid,
            'updated_at_paid' => date('Y-m-d H:i:s')
        );

        $where = "id = '$id'";

        $update = DB::update('insurances', $data, $where);

        if ($update) {
            echo json_encode(array('status' => 'success', 'message' => 'تم تحديث حالة الدفع بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ اثناء تحديث حالة الدفع'));
        }


    }elseif ($action == 'DeleteInsurance'){

        $id = $_POST['id'];

        $data = array(
            'archiv' => 1
        );


        $where = "id = '$id'";

        $update = DB::update('insurances', $data, $where);

        if ($update) {
            echo json_encode(array('status' => 'success', 'message' => 'تم حذف التأمين بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ اثناء حذف التأمين'));
        }

    }elseif ($action == 'GetInsuranceById'){

        $id = $_POST['id'];

        $data = DB::select('insurances', "id = '$id'")->fetch_assoc();

        echo json_encode(array('status' => 'success', 'message' => 'تم جلب التأمين بنجاح', 'insurance' => $data));

    }elseif ($action == 'UpdateInsurance'){

        $id = $_POST['id'];
        $insurance_number = $_POST['insuranceNumber'];
        $general_command = $_POST['GeneralCommand'];
        $amount = $_POST['amount'];
        $year = $_POST['year'];
        if (isset($_POST['paid'])){
            $paid = $_POST['paid'];
           
        }else{
            $paid = "off";
        }
        $updated_at_paid =  date('Y-m-d H:i:s');

        $updated_by = $profile['id'];

        $paid = $paid == "on" ? 1 : 0;

        $data = array(
            'insurance_number' => $insurance_number,
            'amount' => $amount,
            'year' => $year,
            'paid' => $paid,
            'general_command' => $general_command,
            'updated_by' => $updated_by,
            'updated_at_paid' => $updated_at_paid
        );

        $where = "id = '$id'";
        $update = DB::update('insurances', $data, $where);

        if ($update) {
            echo json_encode(array('status' => 'success', 'message' => 'تم تحديث التأمين بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ اثناء تحديث التأمين'));
        }

 
    }elseif ($action == 'AddInsurance'){

    

        $member_id = $_POST['member_id'];
        $insurance_number = $_POST['insurance_number'];
        $amount = $_POST['amount'];
        $year = $_POST['year'];
        $paid = $_POST['paid'];
        $general_command = $_POST['general_command'];
        $updated_at_paid = date('Y-m-d H:i:s');
       

        $created_by = $profile['id'];

     

        if ($member_id == '' || $general_command == '' || $amount == '' || $year == '' || $paid == '') {
            echo json_encode(array('status' => 'error', 'message' => 'الرجاء ملئ جميع الحقول'));
            die();
        }

        if($insurance_number != ''){
            $general_command == 1;
        }else{
            $general_command == 0;
        }

        $check = DB::select('insurances', "member_id = '$member_id' AND year = '$year' AND archiv = 0")->fetch_assoc();
        if ($check != null) {
            echo json_encode(array('status' => 'error', 'message' => 'العضو مأمن بالفعل في هذه السنة'));
            die();
        }


        

        $data = array(
            'member_id' => $member_id,
            'insurance_number' => $insurance_number,
            'amount' => $amount,
            'year' => $year,
            'paid' => $paid,
            'general_command' => $general_command,
            'created_by' => $created_by,
            'updated_by' => $created_by,
            'updated_at_paid' => $updated_at_paid
        );

        $insert = DB::insert('insurances', $data);

        $dataReturn = array(
            'member_id' => $member_id,
            'year' => $year,
            'paid' => $paid
        );
        

        if ($insert) {
            echo json_encode(array('status' => 'success', 'message' => 'تم اضافة التأمين بنجاح', 'data' => $dataReturn));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ اثناء اضافة التأمين'));
        }

    }elseif ($action == 'GetMembersByMemberId'){

        $member_id = $_POST['member_id'];

        $data = DB::select('members', "member_id = '$member_id' AND archiv = 0", 'member_id , scout_unit')->fetch_assoc();

        if ($data == null) {
            echo json_encode(array('status' => 'error', 'message' => 'العضو غير موجود'));
            die();
        }

        $amount = 0;

        if ($data['scout_unit'] == 'أشبال') {
            $amount = $settings['amount_cubs'];
        }elseif ($data['scout_unit'] == 'زهرات') {
            $amount = $settings['amount_sprouts'];
        }elseif ($data['scout_unit'] == 'كشاف') {
            $amount = $settings['amount_scouts'];
        }elseif ($data['scout_unit'] == 'دليلات') {
            $amount = $settings['amount_dalilat'];
        }elseif ($data['scout_unit'] == 'جوال') {
            $amount = $settings['amount_rangers'];
        }elseif ($data['scout_unit'] == 'مرشدات') {
            $amount = $settings['amount_guides'];
        }elseif ($data['scout_unit'] == 'قائد') {
            $amount = $settings['amount_leaders'];
        }elseif ($data['scout_unit'] == 'عميد') {
            $amount = $settings['amount_masters'];
        }



        echo json_encode(array('status' => 'success', 'message' => 'تم جلب العضو بنجاح', 'member' => $data, 'amount' => $amount));

    }elseif($action == 'UpdateInsuranceNumber'){
        $id = $_POST['id'];
        $insurance_number = $_POST['insuranceNumber'];

        $data = array(
            'insurance_number' => $insurance_number,
            'general_command' => 1,
            'updated_by' => $profile['id'] 
        );

        $where = "id = '$id'";

        $update = DB::update('insurances', $data, $where);

        if ($update) {
            echo json_encode(array('status' => 'success', 'message' => 'تم تحديث رقم التأمين بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ اثناء تحديث رقم التأمين'));
        }
    }elseif($action == 'GetMembers'){

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




    }






    
    