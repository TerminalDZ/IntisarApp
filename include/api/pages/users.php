<?php
    include '../../init.php';

    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }
    
    $action = $_GET['action'];

    
    if ($action == 'deleteUser') {


        $id = $_POST['userId'];
        $where = 'id = '.$id;
        $user = DB::select('users', $where);
        $user = $user->fetch_assoc();
        if ($user['id'] != 1) {
            DB::delete('users', $where);
            echo json_encode(['status' => 'success', 'message' => 'تم حذف المستخدم بنجاح']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'لا يمكن حذف هذا المستخدم']);
        }
    }elseif($action =='addUser'){

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $fr_name = $_POST['fr_name'];
        $ls_name = $_POST['ls_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $access = $_POST['access'];


        $where = "username = '$username' OR email = '$email'";
        $check = DB::select('users', $where);
        if ($check->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'اسم المستخدم او البريد الالكتروني موجود مسبقا']);
            die();
        }
        
        if (strlen($password) < 6) {
            echo json_encode(['status' => 'error', 'message' => 'يجب ان تكون كلمة المرور اكبر من 6 احرف']);
            die();
        }

        if ($password != $confirmPassword) {
            echo json_encode(['status' => 'error', 'message' => 'كلمة المرور غير متطابقة']);
            die();
        }



        $data = [
            'fr_name' => $fr_name,
            'ls_name' => $ls_name,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'avatar' => 'Avatar/user.png',
            'access' => $access
        ];

        $result = DB::insert('users', $data);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'تم اضافة المستخدم بنجاح']);
            $mail = Mail::send_create_account($email, $username, $password);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'حدث خطأ ما']);
        }


    }elseif($action == 'editUser'){

        $token = $_POST['token'];
        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $id = $_POST['userId'];
        $fr_name = $_POST['fr_name'];
        $ls_name = $_POST['ls_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $access = $_POST['access'];

        $where = "id = $id";
        $user = DB::select('users', $where);
        $user = $user->fetch_assoc();

        if ($user['username'] != $username) {
            $where = "username = '$username'";
            $check = DB::select('users', $where);
            if ($check->num_rows > 0) {
                echo json_encode(['status' => 'error', 'message' => 'اسم المستخدم موجود مسبقا']);
                die();
            }
        }

        if ($user['email'] != $email) {
            $where = "email = '$email'";
            $check = DB::select('users', $where);
            if ($check->num_rows > 0) {
                echo json_encode(['status' => 'error', 'message' => 'البريد الالكتروني موجود مسبقا']);
                die();
            }
        }

        
        if (!empty($password)) {
            if (strlen($password) < 6) {
                echo json_encode(['status' => 'error', 'message' => 'يجب ان تكون كلمة المرور اكبر من 6 احرف']);
                die();
            }

            if ($password != $confirmPassword) {
                echo json_encode(['status' => 'error', 'message' => 'كلمة المرور غير متطابقة']);
                die();
            }

            $data = [
                'fr_name' => $fr_name,
                'ls_name' => $ls_name,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'access' => $access
            ];
        } else {
            $data = [
                'fr_name' => $fr_name,
                'ls_name' => $ls_name,
                'username' => $username,
                'email' => $email,
                'access' => $access
            ];
        }

        $result = DB::update('users', $data, "id = $id");

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'تم تعديل المستخدم بنجاح']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'حدث خطأ ما']);
        }

        



    }