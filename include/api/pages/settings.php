<?php

    include '../../init.php';


    $action = $_GET['action'];

    if ($action == 'UpdateAcount') {
        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $bio = $_POST['Bio'];
        $email = $_POST['Email'];

        if (empty($email)) {
            echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني مطلوب'));
            die();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني غير صالح'));
            die();
        }


        $where = "email = '" . $email . "' AND id != " . $_SESSION['id'];
        $result = DB::select('users', $where);

        if ($result->num_rows > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني مستخدم بالفعل'));
            die();
        }
        


    
        $data = [
            'bio' => $bio,
            'email' => $email
        ];

        $where = "id = " . $_SESSION['id'];

        $result = DB::update('users', $data, $where);

        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'تم تحديث البيانات بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء تحديث البيانات'));
        }



    }elseif ($action == 'UpdateProfile'){

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }


        $username = $_POST['username'];
        $First_Name = $_POST['First_Name'];
        $Last_Name = $_POST['Last_Name'];

        if (empty($username)) {
            echo json_encode(array('status' => 'error', 'message' => 'اسم المستخدم مطلوب'));
            die();
        }

        if (empty($First_Name)) {
            echo json_encode(array('status' => 'error', 'message' => 'الاسم الأول مطلوب'));
            die();
        }

        if (empty($Last_Name)) {
            echo json_encode(array('status' => 'error', 'message' => 'الاسم الأخير مطلوب'));
            die();
        }




       
        $where = "username = '" .$username . "' AND id != " . $_SESSION['id'];
        $result = DB::select('users', $where);


        if ($result->num_rows > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'اسم المستخدم مستخدم بالفعل'));
            die();
        }

    
        $data = [
            'username' => $username,
            'fr_name' => $First_Name,
            'ls_name' => $Last_Name
        ];
        
        $where = "id = " . $_SESSION['id'];

        $result = DB::update('users', $data, $where);

        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'تم تحديث البيانات بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء تحديث البيانات'));
        }
        
    }elseif($action == 'UpdatePassword'){

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $old_password = $_POST['OldPassword'];
        $new_password = $_POST['NewPassword'];
        $confirm_password = $_POST['ConfirmPassword'];





        if (empty($old_password)) {
            echo json_encode(array('status' => 'error', 'message' => 'كلمة المرور الحالية مطلوبة'));
            die();
        }

        if (empty($new_password)) {
            echo json_encode(array('status' => 'error', 'message' => 'كلمة المرور الجديدة مطلوبة'));
            die();
        }

        if (empty($confirm_password)) {
            echo json_encode(array('status' => 'error', 'message' => 'تأكيد كلمة المرور مطلوب'));
            die();
        }

        if ($new_password != $confirm_password) {
            echo json_encode(array('status' => 'error', 'message' => 'كلمة المرور الجديدة وتأكيد كلمة المرور غير متطابقين'));
            die();
        }

    
        if (!password_verify($old_password, User::my_profile()['password'])) {
            echo json_encode(array('status' => 'error', 'message' => 'كلمة المرور الحالية غير صحيحة'));
            die();
        }


        $cryptPassword = password_hash($new_password, PASSWORD_DEFAULT);

        $data = [
            'password' => $cryptPassword
        ];

        $where = "id = " . $_SESSION['id'];

        $result = DB::update('users', $data, $where);


        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'تم تحديث كلمة المرور بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء تحديث كلمة المرور'));
        }




    
    }elseif($action == 'UploadAvatar'){

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $Avatar = $_FILES['Avatar'];

        $FullName = User::my_profile()['fr_name'] . ' ' . User::my_profile()['ls_name'];

        $path = 'Avatar/' . $FullName . '/';
        
        $result = Upload::upload_image($Avatar, $path);

        $Save = $path . $result['file_name'];
        
        if ($result['status'] == 'success') {
            $sql = "UPDATE users SET avatar = '" . $Save . "' WHERE id = " . $_SESSION['id'];
            $db->query($sql);
            echo json_encode(array('status' => 'success', 'message' => 'تم تحديث الصورة الشخصية بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => $result['message']));
        }
        




    }