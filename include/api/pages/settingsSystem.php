<?php

    include '../../init.php';


    $action = $_GET['action'];

    
    if ($action == 'UpdateSettings') {
        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $site_name = $_POST['site_name'];
        $logo = isset($_FILES['logo']) ? $_FILES['logo'] : null;
        $icon = isset($_FILES['icon']) ? $_FILES['icon'] : null;
        $description = $_POST['description'];
        $keywords = $_POST['keywords'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        if (empty($site_name) || empty($description) || empty($keywords) || empty($email) || empty($phone) || empty($address)) {
            echo json_encode(array('status' => 'error', 'message' => 'جميع الحقول مطلوبة'));
            die();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني غير صالح'));
            die();
        }

        Settings::set('site_name', $site_name);
        Settings::set('description', $description);
        Settings::set('keywords', $keywords);
        Settings::set('email', $email);
        Settings::set('phone', $phone);
        Settings::set('address', $address);

        $pathLogo = 'Logos/';
        $pathIcon = 'Icons/';

        if (!empty($logo['name'])) {
            $result = Upload::upload_image($logo, $pathLogo);
            if ($result['status'] == 'success') {
                $saveLogo = $pathLogo . $result['file_name'];
                Settings::set('logo', $saveLogo);
            } else {
                echo json_encode(array('status' => 'error', 'message' => $result['message']));
                die();
            }

        }

        if (!empty($icon['name'])) {
            $result = Upload::upload_image($icon, $pathIcon);
            if ($result['status'] == 'success') {
                $saveIcon = $pathIcon . $result['file_name'];
                Settings::set('icon', $saveIcon);
            } else {
                echo json_encode(array('status' => 'error', 'message' => $result['message']));
                die();
            }

        }

        echo json_encode(array('status' => 'success', 'message' => 'تم تحديث الاعدادات بنجاح'));

    }elseif($action == 'UpdateSmtp'){

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $smtp_email = $_POST['smtp_email'];
        $smtp_password = $_POST['smtp_password'];
        $smtp_host = $_POST['smtp_host'];
        $smtp_port = $_POST['smtp_port'];
        $smtp_encryption = $_POST['smtp_encryption'];

        if (empty($smtp_email) || empty($smtp_password) || empty($smtp_host) || empty($smtp_port) || empty($smtp_encryption)) {
            echo json_encode(array('status' => 'error', 'message' => 'جميع الحقول مطلوبة'));
            die();
        }

        if (!filter_var($smtp_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني غير صالح'));
            die();
        }

        Settings::set('smtp_email', $smtp_email);
        Settings::set('smtp_password', $smtp_password);
        Settings::set('smtp_host', $smtp_host);
        Settings::set('smtp_port', $smtp_port);
        Settings::set('smtp_encryption', $smtp_encryption);

        echo json_encode(array('status' => 'success', 'message' => 'تم تحديث الاعدادات بنجاح'));



    }elseif($action == 'TestSMTP'){

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $test_email = $_POST['test_email'];

        if (empty($test_email)) {
            echo json_encode(array('status' => 'error', 'message' => 'جميع الحقول مطلوبة'));
            die();
        }
        
        if (!filter_var($test_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني غير صالح'));
            die();
        }
        
        if (Mail::send_smtp_test($test_email)) {
            echo json_encode(array('status' => 'success', 'message' => 'تم إرسال رسالة البريد الإلكتروني بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'رسالة البريد الإلكتروني لم تتم الإرسال'));
        }

    }

