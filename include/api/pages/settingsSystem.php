<?php

    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }

    $action = $_GET['action'];

    
    if ($action == 'UpdateSettings') {

        if (!$edit_website_settings) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

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
        $governorate_state = $_POST['governorate_state'];

        if (empty($site_name) || empty($description) || empty($keywords) || empty($email) || empty($phone) || empty($address) || empty($governorate_state)) {
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
        Settings::set('governorate_state', $governorate_state);


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
        if (!$edit_website_settings) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

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
        $smtp_service_type = isset($_POST['smtp_service_type']) ? $_POST['smtp_service_type'] : 'smtp';
        $smtp_timeout = isset($_POST['smtp_timeout']) ? $_POST['smtp_timeout'] : '30';
        $smtp_auth = isset($_POST['smtp_auth']) ? $_POST['smtp_auth'] : '1';
        $smtp_debug = isset($_POST['smtp_debug']) ? $_POST['smtp_debug'] : '0';

        // التحقق من الحقول الأساسية
        if (empty($smtp_email) || empty($smtp_host) || empty($smtp_port)) {
            echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني والمضيف والمنفذ مطلوبة'));
            die();
        }

        // التحقق من كلمة المرور فقط إذا كانت المصادقة مفعلة
        if ($smtp_auth == '1' && empty($smtp_password)) {
            echo json_encode(array('status' => 'error', 'message' => 'كلمة المرور مطلوبة عند تفعيل المصادقة'));
            die();
        }

        if (!filter_var($smtp_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني غير صالح'));
            die();
        }

        // التحقق من صحة المنفذ
        if (!is_numeric($smtp_port) || $smtp_port < 1 || $smtp_port > 65535) {
            echo json_encode(array('status' => 'error', 'message' => 'رقم المنفذ غير صالح'));
            die();
        }

        // التحقق من صحة مهلة الاتصال
        if (!is_numeric($smtp_timeout) || $smtp_timeout < 5 || $smtp_timeout > 300) {
            echo json_encode(array('status' => 'error', 'message' => 'مهلة الاتصال يجب أن تكون بين 5 و 300 ثانية'));
            die();
        }

        Settings::set('smtp_email', $smtp_email);
        Settings::set('smtp_password', $smtp_password);
        Settings::set('smtp_host', $smtp_host);
        Settings::set('smtp_port', $smtp_port);
        Settings::set('smtp_encryption', $smtp_encryption);
        Settings::set('smtp_service_type', $smtp_service_type);
        Settings::set('smtp_timeout', $smtp_timeout);
        Settings::set('smtp_auth', $smtp_auth);
        Settings::set('smtp_debug', $smtp_debug);

        echo json_encode(array('status' => 'success', 'message' => 'تم تحديث الاعدادات بنجاح'));



    }elseif($action == 'TestSMTP'){
        if (!$edit_website_settings) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

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

