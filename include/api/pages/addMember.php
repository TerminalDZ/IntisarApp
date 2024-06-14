<?php
    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }

    $action = $_GET['action'];

    
    if ($action == 'member_id') {

        //check if the member id is already exist
        $member_id = $_POST['member_id'];
        $where = "member_id = '$member_id'";
        $check = DB::select('members', $where);
        if ($check->num_rows > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'رقم العضو موجود بالفعل'));
        } else {
            echo json_encode(array('status' => 'success', 'message' => 'رقم العضو غير موجود'));
        }

    }elseif ($action == 'AddMember') {

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }


        $member_id = $_POST['member_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $place_of_increase = $_POST['place_of_increase'];
        $father_name = $_POST['father_name'];
        $mother_name = $_POST['mother_name'];
        $mother_last_name = $_POST['mother_last_name'];
        $job_father = $_POST['job_father'];
        $job_mother = $_POST['job_mother'];
        $family_status = $_POST['family_status'];
        $caregiver = $_POST['caregiver'];
        $living_condition = $_POST['living_condition'];
        $chronic_diseases = $_POST['chronic_diseases'];
        $hobbies = $_POST['hobbies'];
        $sport = $_POST['sport'];
        $educational_institution = $_POST['educational_institution'];
        ////
        $guardian_id_number = $_POST['guardian_id_number'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
       
        $has_scout_uniform = $_POST['has_scout_uniform'];
        $scout_uniform_size = $_POST['scout_uniform_size'];
        $scout_uniform_payer = $_POST['scout_uniform_payer'];
        $scout_unit = $_POST['scout_unit'];
        ////
        if (isset($_FILES['picture'])) {
            $picture = $_FILES['picture'];
        }

        $joining_date = $_POST['joining_date'];




        if ($member_id == '' || $first_name == '' || $last_name == '' || $gender == '' || $dob == ''|| $place_of_increase == '' || $father_name == '' || $mother_name == '' || $mother_last_name == '' || $job_father == '' || $job_mother == '' || $family_status == '' || $living_condition == '' || $guardian_id_number == '' || $phone_number == '' || $address == '' || $has_scout_uniform == '' || $scout_uniform_payer == '' || $scout_unit == '' || $joining_date == '') {
            echo json_encode(array('status' => 'error', 'message' => 'جميع الحقول مطلوبة'));
            die();
        }

        if ($family_status == 'وفاة كلا الوالدين' || $family_status == 'مطلقان' || $family_status == 'وفاة الأب') {
            if ($caregiver == '') {
                echo json_encode(array('status' => 'error', 'message' => 'الرجاء إدخال اسم الوصي'));
                die();
            }
        }

       

        //check member_id if already exist
        $where = "member_id = '$member_id'";
        $check = DB::select('members', $where);
        if ($check->num_rows > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'رقم العضو موجود بالفعل'));
            die();
        }

        if (!empty($picture['name'])) {
            $path = 'Members/'.$member_id.'/';
            $upload = Upload::upload_image($picture, $path);

            if ($upload['status'] == 'success') {
                $picture = $path . $upload['file_name'];
            } else {
                echo json_encode(array('status' => 'error', 'message' => $upload['message']));
                die();
            }
        }else {
            $picture = 'Members/user.png';
        }




        
        $data = [
            'member_id' => $member_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'gender' => $gender,
            'dob' => $dob,
            'place_of_increase' => $place_of_increase,
            'father_name' => $father_name,
            'mother_name' => $mother_name,
            'mother_last_name' => $mother_last_name,
            'job_father' => $job_father,
            'job_mother' => $job_mother,
            'family_status' => $family_status,
            'caregiver' => $caregiver,
            'living_condition' => $living_condition,
            'chronic_diseases' => $chronic_diseases,
            'hobbies' => $hobbies,
            'sport' => $sport,
            'educational_institution' => $educational_institution,
            
            'guardian_id_number' => $guardian_id_number,
            'phone_number' => $phone_number,
            'address' => $address,

            'has_scout_uniform' => $has_scout_uniform,
            'scout_uniform_size' => $scout_uniform_size,
            'scout_uniform_payer' => $scout_uniform_payer,
            'scout_unit' => $scout_unit,
            'picture' => $picture,
            'added_by' => $profile['id'],
            'last_modified_by' => $profile['id'],
            'joining_date' => $joining_date
        ];

        $result = DB::insert('members', $data);

        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'تم إضافة العضو بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء إضافة العضو'));
        }



    }elseif ($action == 'Getfamiles') {

        $select = "SELECT * FROM members";
        $result = $db->query($select);
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        

        echo json_encode(array('status' => 'success', 'data' => $data));

    }elseif ($action == 'GetMemberById') {

        $member_id = $_POST['member_id'];

        $where = "member_id = '$member_id'";
        $result = DB::select('members', $where);

      
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode(array('status' => 'success', 'data' => $data, 'message' => 'تم جلب البيانات بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'العضو غير موجود'));
        }

    }elseif ($action == 'UpdateMember') {

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $member_id = $_POST['member_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $place_of_increase = $_POST['place_of_increase'];
        $father_name = $_POST['father_name'];
        $mother_name = $_POST['mother_name'];
        $mother_last_name = $_POST['mother_last_name'];
        $job_father = $_POST['job_father'];
        $job_mother = $_POST['job_mother'];
        $family_status = $_POST['family_status'];
        $caregiver = $_POST['caregiver'];
        $living_condition = $_POST['living_condition'];
        $chronic_diseases = $_POST['chronic_diseases'];
        $hobbies = $_POST['hobbies'];
        $sport = $_POST['sport'];
        $educational_institution = $_POST['educational_institution'];
        ////
        $guardian_id_number = $_POST['guardian_id_number'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
    
        $has_scout_uniform = $_POST['has_scout_uniform'];
        $scout_uniform_size = $_POST['scout_uniform_size'];
        $scout_uniform_payer = $_POST['scout_uniform_payer'];
        $scout_unit = $_POST['scout_unit'];
        ////
        if (isset($_FILES['picture'])) {
            $picture = $_FILES['picture'];
        }

        $joining_date = $_POST['joining_date'];




        if ($member_id == '' || $first_name == '' || $last_name == '' || $gender == '' || $dob == ''|| $place_of_increase == '' || $father_name == '' || $mother_name == '' || $mother_last_name == '' || $job_father == '' || $job_mother == '' || $family_status == '' || $living_condition == '' || $guardian_id_number == '' || $phone_number == '' || $address == '' || $has_scout_uniform == '' || $scout_uniform_payer == '' || $scout_unit == '' || $joining_date == '') {
            echo json_encode(array('status' => 'error', 'message' => 'جميع الحقول مطلوبة'));
            die();
        }

        if ($family_status == 'وفاة كلا الوالدين' || $family_status == 'مطلقان' || $family_status == 'وفاة الأب') {
            if ($caregiver == '') {
                echo json_encode(array('status' => 'error', 'message' => 'الرجاء إدخال اسم الوصي'));
                die();
            }
        }

  


        //update data where member_id 
        $where = "member_id = '$member_id'";
        $check = DB::select('members', $where);

        if ($check->num_rows > 0) {
            $data = $check->fetch_assoc();

            if (!empty($picture['name'])) {
                $path = 'Members/'.$member_id.'/';
                $upload = Upload::upload_image($picture, $path);

                if ($upload['status'] == 'success') {
                    $picture = $path . $upload['file_name'];
                } else {
                    echo json_encode(array('status' => 'error', 'message' => $upload['message']));
                    die();
                }
            }else {
                $picture = $data['picture'];
            }

            $data = [
                'member_id' => $member_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'dob' => $dob,
                'place_of_increase' => $place_of_increase,
                'father_name' => $father_name,
                'mother_name' => $mother_name,
                'mother_last_name' => $mother_last_name,
                'job_father' => $job_father,
                'job_mother' => $job_mother,
                'family_status' => $family_status,
                'caregiver' => $caregiver,
                'living_condition' => $living_condition,
                'chronic_diseases' => $chronic_diseases,
                'hobbies' => $hobbies,
                'sport' => $sport,
                'educational_institution' => $educational_institution,
                
                'guardian_id_number' => $guardian_id_number,
                'phone_number' => $phone_number,
                'address' => $address,
             
                'has_scout_uniform' => $has_scout_uniform,
                'scout_uniform_size' => $scout_uniform_size,
                'scout_uniform_payer' => $scout_uniform_payer,
                'scout_unit' => $scout_unit,
                'picture' => $picture,
                'last_modified_by' => $profile['id'],
                'joining_date' => $joining_date
            ];

            $result = DB::update('members', $data, $where);

            if ($result) {
                echo json_encode(array('status' => 'success', 'message' => 'تم تحديث البيانات بنجاح', 'member_id' => $member_id));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء تحديث البيانات'));
            }
                

        } else {
            echo json_encode(array('status' => 'error', 'message' => 'العضو غير موجود'));
        }
    }