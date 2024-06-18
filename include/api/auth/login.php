<?php
    include '../../init.php';

    $token = $_POST['token'];

    if (!CSRF::validate($token)) {
        echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
        die();
    }

    $EmailOrUsername = $_POST['EmailOrUsername'];
    $password = $_POST['password'];
    $remember = $_POST['remember'];

    if ($EmailOrUsername == '' || $password == '') {
        echo json_encode(array('status' => 'error', 'message' => 'الرجاء ملء جميع الحقول'));
        die();
    }


    $where = "email = '" . $EmailOrUsername . "' OR username = '" . $EmailOrUsername . "'";
    $result = DB::select('users', $where);



    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['access'] == 0) {
            echo json_encode(array('status' => 'error', 'message' => 'الحساب غير مفعل'));
            die();
        }

        
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            if ($remember == 'true') {
                setcookie('username', $row['username'], time() + 60 * 60 * 24 * 30, '/');
                setcookie('password', $row['password'], time() + 60 * 60 * 24 * 30, '/');
            }

            echo json_encode(array('status' => 'success', 'message' => 'تم تسجيل الدخول بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'خطأ في اسم المستخدم أو كلمة المرور'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'خطأ في اسم المستخدم أو كلمة المرور'));
    }






