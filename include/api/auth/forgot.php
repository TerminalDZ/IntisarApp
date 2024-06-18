<?php
include '../../init.php';

$token = $_POST['token'];

if (!CSRF::validate($token)) {
    echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
    die();
}

$Email = $_POST['Email'];

if ($Email == '') {
    echo json_encode(array('status' => 'error', 'message' => 'الرجاء ملء جميع الحقول'));
    die();
}

$where = "email = '" . $Email . "'";
$result = DB::select('users', $where);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($row['access'] == 0) {
        echo json_encode(array('status' => 'error', 'message' => 'الحساب غير مفعل'));
        die();
    }

    $current_time = time();
    $tokens = json_decode($row['tokens'], true) ?: [];
    $tokens = array_filter($tokens, function($token) use ($current_time) {
        return ($current_time - $token['time']) < 300;
    });

    if (count($tokens) >= 3) {
        echo json_encode(array('status' => 'error', 'message' => 'لا يمكن إضافة أكثر من ثلاثة رموز في 5 دقائق'));
        die();
    }

    $tokens = array_filter($tokens, function($token) use ($current_time) {
        return ($current_time - $token['time']) < 300;
    });

    $new_token = md5(uniqid(rand(), true));
    $tokens[] = ['token' => $new_token, 'time' => $current_time];
    $tokens_json = json_encode($tokens);

    $data = array('tokens' => $tokens_json);
    DB::update('users', $data, $where);

    Mail::send_forgot_password($Email, $new_token, $base_url);

    echo json_encode(array('status' => 'success', 'message' => 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'البريد الإلكتروني غير موجود'));
}
?>
