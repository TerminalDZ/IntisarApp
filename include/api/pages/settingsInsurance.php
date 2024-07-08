<?php
  include '../../init.php';
  if (!isset($_SESSION['username'])) {
    header('Location: ' . BASEURL . 'index.php');
    exit();
}

  $action = $_GET['action'];

  
  if ($action == 'saveSettingsInsurance') {

    if (!$edit_insurance_settings) {
        echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
        return;
    }

      $token = $_POST['token'];

      if (!CSRF::validate($token)) {
          echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
          die();
      }


      $amount_cubs = $_POST['amount_cubs'];
      $amount_sprouts = $_POST['amount_sprouts'];
      $amount_scouts =  $_POST['amount_scouts'];
      $amount_guides =  $_POST['amount_guides'];
      $amount_rangers = $_POST['amount_rangers'];
      $amount_leaders = $_POST['amount_leaders'];
      $amount_masters = $_POST['amount_masters'];
      $amount_dalilat = $_POST['amount_dalilat'];
         


        if (!is_numeric($amount_cubs) || !is_numeric($amount_sprouts) || !is_numeric($amount_scouts) || !is_numeric($amount_guides) || !is_numeric($amount_rangers) || !is_numeric($amount_leaders) || !is_numeric($amount_masters) || !is_numeric($amount_dalilat)) {
            echo json_encode(array('status' => 'error', 'message' => 'المبلغ يجب ان يكون رقم'));
            die();
        }

        if ($amount_cubs < 0 || $amount_sprouts < 0 || $amount_scouts < 0 || $amount_guides < 0 || $amount_rangers < 0 || $amount_leaders < 0 || $amount_masters < 0 || $amount_dalilat < 0) {
            echo json_encode(array('status' => 'error', 'message' => 'المبلغ يجب ان يكون اكبر من الصفر'));
            die();
        }

        Settings::set('amount_cubs', $amount_cubs);
        Settings::set('amount_sprouts', $amount_sprouts);
        Settings::set('amount_scouts', $amount_scouts);
        Settings::set('amount_guides', $amount_guides);
        Settings::set('amount_rangers', $amount_rangers);
        Settings::set('amount_leaders', $amount_leaders);
        Settings::set('amount_masters', $amount_masters);
        Settings::set('amount_dalilat', $amount_dalilat);

        echo json_encode(array('status' => 'success', 'message' => 'تم تحديث الاعدادات بنجاح'));

      
    }