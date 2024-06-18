<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require  'vendor/phpmailer/src/PHPMailer.php';
require  'vendor/phpmailer/src/SMTP.php';
require  'vendor/phpmailer/src/Exception.php';




class User
{
    public static function get_data_id($id)
    {
       global $db;

        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }




    }

    public static function is_logged_in()
    {
        return isset($_SESSION['id']);
    }

    public static function my_profile()
    {
        if (self::is_logged_in()) {
            $id = $_SESSION['id'];
            $data = self::get_data_id($id);
            return $data;
        } else {
            return null;
        }
    }

  

}



class Upload
{
    public static function upload_image($file, $path)
    {
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 2097152) {
                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $file_destination = '../../../uploads/' . $path . $file_name_new;

                    if (!is_dir('../../../uploads/' . $path)) {
                        mkdir('../../../uploads/' . $path, 0777, true);
                    }

                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        return array('status' => 'success', 'file_name' => $file_name_new);
                    } else {
                        return array('status' => 'error', 'message' => 'Failed to move uploaded file.');
                    }
                } else {
                    return array('status' => 'error', 'message' => 'File size exceeds the limit.');
                }
            } else {
                return array('status' => 'error', 'message' => 'Error during file upload.');
            }
        } else {
            return array('status' => 'error', 'message' => 'Invalid file type.');
        }
    }
}


class Settings
{
    public static function get()
    {
        global $db;

        $sql = "SELECT `key`, `value` FROM settings";
        $result = $db->query($sql);
        $settings = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $settings[$row['key']] = $row['value'];
            }
        }

        return $settings;
    }

    public static function set($key, $value)
    {
        global $db;

        $sql = "UPDATE settings SET `value` = '$value' WHERE `key` = '$key'";
        $result = $db->query($sql);

        return $result;
    }
}
class Mail
{
    public static function send($to, $subject, $body, $htmlFilePath = null, $variables = [])
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = Settings::get()['smtp_host'];
            $mail->SMTPAuth = true;
            $mail->Username = Settings::get()['smtp_email'];
            $mail->Password = Settings::get()['smtp_password'];
            $mail->SMTPSecure = Settings::get()['smtp_encryption'];
            $mail->Port = Settings::get()['smtp_port'];
            $mail->CharSet = 'UTF-8';
            $mail->setFrom(Settings::get()['smtp_email'], Settings::get()['site_name']);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;

            if ($htmlFilePath) {
                $realPath = realpath($htmlFilePath);
                if ($realPath && file_exists($realPath)) {
                    $template = file_get_contents($realPath);
                    if (is_array($variables)) {
                        foreach ($variables as $key => $value) {
                            $template = str_replace('{{ ' . $key . ' }}', $value, $template);
                        }
                    }
                    $mail->Body = $template;
                } else {
                    echo json_encode(array('status' => 'error', 'message' => 'File does not exist: ' . $htmlFilePath . ' Resolved path: ' . $realPath));
                    die();
                }
            } else {
                $mail->Body = $body;
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function send_smtp_test($email)
    {

        $to = $email;
        $htmlFilePath = __DIR__ . '/../mail/TestSMTP.tpl';
        $subject = 'اختبار SMTP';
        $body = 'تم اختبار البريد الإلكتروني بنجاح.';

        //$variables = [
        //    'key1' => 'test'
        //];


        return self::send($to, $subject, $body, $htmlFilePath);
    }


    public static function send_create_account($email, $username, $password)
    {
        $to = $email;
        $htmlFilePath = __DIR__ . '/../mail/CreateAccount.tpl';
        $subject = 'تم انشاء حساب جديد';
        $body = 'تم انشاء حساب جديد بنجاح.';

        $variables = [
            'username' => $username,
            'password' => $password,
            'site_name' => Settings::get()['site_name'],
            'site_url' => $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI'])

        ];

        return self::send($to, $subject, $body, $htmlFilePath, $variables);
    }


    public static function send_forgot_password($email, $token, $base_url)
    {
        $to = $email;
        $htmlFilePath = __DIR__ . '/../mail/ForgotPassword.tpl';
        $subject = 'نسيت كلمة المرور';
        $body = 'نسيت كلمة المرور';

        $variables = [
            'token' => $token,
            'site_name' => Settings::get()['site_name'],
            'site_url' => $base_url,

        ];

        return self::send($to, $subject, $body, $htmlFilePath, $variables);
    }



}



class Members
{
    public static function get_data_id($id)
    {
        global $db;

        $sql = "SELECT * FROM members WHERE id = $id";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }



    public static function get_data_member_id($member_id)
    {
        global $db;

        $sql = "SELECT * FROM members WHERE member_id = '$member_id' AND archiv = 0";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public static function get_all_insurances($member_id)
    {
        global $db;

        $sql = "SELECT * FROM insurances WHERE member_id = '$member_id'";
        $result = $db->query($sql);

        $insurances = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $insurances[] = $row;
            }
        }

        return $insurances;
    }

    public static function get_all()
    {
        global $db;

        $sql = "SELECT * FROM members WHERE archiv = 0";
        $result = $db->query($sql);

        $members = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $members[] = $row;
            }
        }

        return $members;
    }


    public static function get_all_archiv()
    {
        global $db;

        $sql = "SELECT * FROM members WHERE archiv = 1";
        $result = $db->query($sql);

        $members = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $members[] = $row;
            }
        }

        return $members;
    }



    public static function search($search)
    {
        global $db;

        //change space to % to search for all words
        $search = str_replace(' ', '%', $search);

        $searchTerms = explode(' ', $search);

        $searchCondition = "archiv = 0 AND (";
        $conditions = [];

        foreach ($searchTerms as $term) {
            $conditions[] = "member_id LIKE '%$term%'";
            $conditions[] = "first_name LIKE '%$term%'";
            $conditions[] = "last_name LIKE '%$term%'";
            $conditions[] = "CONCAT(first_name, ' ', last_name) LIKE '%$term%'";
            $conditions[] = "CONCAT(last_name, ' ', first_name) LIKE '%$term%'";
            $conditions[] = "address LIKE '%$term%'";
            $conditions[] = "phone_number LIKE '%$term%'";
            $conditions[] = "scout_unit LIKE '%$term%'";
            $conditions[] = "dob LIKE '%$term%'";

        }

        $searchCondition .= implode(' OR ', $conditions) . ")";
        $sql = "SELECT member_id, first_name, last_name, scout_unit FROM members WHERE $searchCondition";

        $result = $db->query($sql);

        $members = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $members[] = $row;
            }
        }

        return $members;


    }
    

   

    public static function get_select_multi_data($select, $where = null)
    {
        global $db;

        $sql = "SELECT $select FROM members";

        if ($where != null) {
            $sql .= " WHERE $where";
        }

        $result = $db->query($sql);

        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public static function getAge($dob)
    {
        $dob = new DateTime($dob);
        $now = new DateTime();
        $difference = $now->diff($dob);

        return $difference->y;
    }






}






class DB
{
    public static function update($table, $data, $where)
    {
        global $db;

        $sql = "UPDATE $table SET ";

        foreach ($data as $key => $value) {
            $sql .= "$key = '" . $db->real_escape_string($value) . "', ";
        }

        $sql = rtrim($sql, ', ');

        $sql .= " WHERE $where";

        $result = $db->query($sql);

        return $result;
    }

    public static function select($table, $where = null)
    {
        global $db;

        $sql = "SELECT * FROM $table";

        if ($where != null) {
            $sql .= " WHERE $where";
        }

        $result = $db->query($sql);

        return $result;
    }

    public static function insert($table, $data)
    {
        global $db;

        $sql = "INSERT INTO $table (";

        foreach ($data as $key => $value) {
            $sql .= "$key, ";
        }

        $sql = rtrim($sql, ', ');

        $sql .= ") VALUES (";

        foreach ($data as $key => $value) {
            $sql .= "'" . $db->real_escape_string($value) . "', ";
        }

        $sql = rtrim($sql, ', ');

        $sql .= ")";

        $result = $db->query($sql);

        return $result;
    }

    public static function delete($table, $where)
    {
        global $db;

        $sql = "DELETE FROM $table WHERE $where";

        $result = $db->query($sql);

        return $result;
    }

    public static function query($sql)
    {
        global $db;

        $result = $db->query($sql);

        return $result;
    }


    public static function Count($table, $where = null) {
        global $db;

        $sql = "SELECT COUNT(*) as count FROM `$table`";

        if ($where != null) {
            $sql .= " WHERE $where";
        }

        $result = $db->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0;
        }
    }
}



class CSRF
{
    public static function create_token()
    {
        $token = md5(time());
        $_SESSION['token'] = $token;

        echo "<input id='token' name='token' value='$token' type= 'hidden'>";
    }


    public static function validate($token)
    {
        return isset($_SESSION['token']) && $_SESSION['token'] == $token;
    }
}


