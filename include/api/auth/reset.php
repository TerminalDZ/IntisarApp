<?php
include '../../init.php';

$token = $_POST['token'];

if (!CSRF::validate($token)) {
    echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
    die();
}

$TokenReset = $_POST['TokenReset'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];


if ($password == '' || $confirm_password == '') {
    echo json_encode(array('status' => 'error', 'message' => 'الرجاء ملء جميع الحقول'));
    die();
}

if ($password != $confirm_password) {
    echo json_encode(array('status' => 'error', 'message' => 'كلمة المرور غير متطابقة'));
    die();
}

if (strlen($password) < 6) {
    echo json_encode(array('status' => 'error', 'message' => 'يجب أن تكون كلمة المرور 6 أحرف على الأقل'));
    die();
}

$where = "tokens LIKE '%" . $TokenReset . "%'";
$result = DB::select('users', $where);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $tokens = json_decode($row['tokens'], true);
    $tokens = array_filter($tokens, function($token) use ($TokenReset) {
        return $token['token'] != $TokenReset;
    });

    $data = array('tokens' => json_encode($tokens), 'password' => password_hash($password, PASSWORD_DEFAULT));
    DB::update('users', $data, $where);

    echo json_encode(array('status' => 'success', 'message' => 'تم تغيير كلمة المرور بنجاح'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'الرمز غير صحيح'));
}


