<?php
include '../include/init.php';



$memberId = $_GET['MemberID'];
if(empty($memberId)) {
    header('location: ../index.php');
}


$member = Members::get_data_member_id($memberId);

if ($member['scout_unit'] == 'أشبال') {
    $scout_unit = 'الشبل';
    $ColorUnit = 'Yellow';
}elseif ($member['scout_unit'] == 'زهرات') {
    $scout_unit = 'الزهرة';
    $ColorUnit = 'Yellow';
}else if ($member['scout_unit'] == 'كشاف') {
    $scout_unit = 'الكشاف';
    $ColorUnit = 'Green';
}elseif($member['scout_unit'] == 'دليلات'){
    $scout_unit = 'الدليلة';
    $ColorUnit = 'Green';
}else if ($member['scout_unit'] == 'جوال') {
    $scout_unit = 'الجوال';
    $ColorUnit = 'Red';
}elseif($member['scout_unit'] == 'مرشدات'){
    $scout_unit = 'المرشدة';
    $ColorUnit = 'Red';
}else if ($member['scout_unit'] == 'قائد') {
    $scout_unit = 'القائد';
    $ColorUnit = 'Blue';
}elseif($member['scout_unit'] == 'عميد'){
    $scout_unit = 'العميد';
    $ColorUnit = 'Blue';
}


?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="idriss boukmouche">
    <link rel="icon" href="<?=$urlUploads?><?=$settings['icon']?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?=$urlUploads?><?=$settings['icon']?>" type="image/x-icon">
    <title><?=$member['first_name'] . ' ' . $member['last_name']?></title>
    <link rel="stylesheet" type="text/css" href="<?=$urlAssets?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=$urlAssets?>css/style.css">
    <link id="color" rel="stylesheet" href="<?=$urlAssets?>css/color-1.css" media="screen">
    <link rel="stylesheet" href="<?=$base_url?>check/css/Profile.css">
    
</head>
<body>

<style>
  .scoutunitName{
    position: absolute;
    top: 33px;
    transform: rotate(-45deg);
    font-weight: 900;
    left: 20px;
    color: white !important;
  }
</style>


    <div class="container">
       <div class="main-body">
            <div>
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h3>لوحة المعلومات الكشفية </h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            

          <div class="row gutters-sm">
                <div class="col-md-4 mb-3">

                    <div class="card">
                       <div class="card-body CardID">
                          <div class="Line <?=$ColorUnit?>"></div> 
                          <div class="d-flex flex-column align-items-center text-center">
                             <img src="<?=$urlUploads?><?=$member['picture']?>" alt="Admin" class="rounded-circle img-thumbnail" style="width: 100px !important;height: 100px !important;cursor: pointer;" >
                             <div class="mt-3">
                                <p class="text-secondary mb-1 scoutunitName"><?=$scout_unit?></p>
                                <h4><?=$member['first_name'] . ' ' . $member['last_name']?></h4>
                                <p class="text-muted font-size-sm">رقم المنخرط : <span class="badge badge-info"><?=$member['member_id']?></span></p>
                                <p class="text-muted font-size-sm">تاريخ الانخراط : <span class="badge badge-info"><?=$member['joining_date']?></span></p>
                               
                             </div>
                          </div>
                       </div>
                    </div>

                    

                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                       <div class="card-body">
                          <div class="row">
                             <div class="col-sm-3 text-right">
                                <h6 class="mb-0 lh-Normal">الاسم و اللقب :</h6>
                             </div>
                             <div class="col-sm-9 text-secondary textTitle">
                                <?=$member['first_name'] . ' ' . $member['last_name']?>
                             </div>
                          </div>
                          <hr>

                            <div class="row">
                                <div class="col-sm-3 text-right">
                                    <h6 class="mb-0 lh-Normal">الجنس :</h6>
                                </div>
                                <div class="col-sm-9 text-secondary textTitle">
                                    <?php 

                                        if ($member['gender'] == 'ذكر') {
                                            echo '<span class="badge badge-primary">ذكر</span>';
                                        }else{
                                            echo '<span class="badge badge-danger">أنثى</span>';
                                        }
                                     
                                    ?>

                                </div>
                            </div>

                          <hr>

                            <div class="row">
                                <div class="col-sm-3 text-right">
                                    <h6 class="mb-0 lh-Normal">تاريخ الميلاد و مكان الازدياد :</h6>
                                </div>
                                <div class="col-sm-9 text-secondary textTitle">
                                        <?=$member['dob']?> - <?=$member['place_of_increase']?>
                                </div>
                            </div>




                          <hr>
                         
                          <div class="row">
                             <div class="col-sm-3 text-right">
                                <h6 class="mb-0 lh-Normal">رقم الهاتف :</h6>
                             </div>
                             <div class="col-sm-9 text-secondary textTitle">
                                <?=$member['phone_number']?>
                             </div>
                          </div>
                          <hr>
                          <div class="row">
                             <div class="col-sm-3 text-right">
                                <h6 class="mb-0 lh-Normal">العنوان :</h6>
                             </div>
                             <div class="col-sm-9 text-secondary textTitle">
                                <?=$member['address']?>
                             </div>
                          </div>
                          
                          <hr>
                       </div>
                    </div>
                    
                    
                </div>
          </div>
       </div>
    </div>

<script src="<?=$urlAssets?>js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap js-->
<script src="<?=$urlAssets?>js/bootstrap/popper.min.js"></script>
<script src="<?=$urlAssets?>js/bootstrap/bootstrap.js"></script>
<script src="<?=$base_url?>check/js/Profile.js"></script>
    
</body>
</html>