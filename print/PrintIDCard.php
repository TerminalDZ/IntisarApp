<?php
include '../include/init.php';
if (!isset($_SESSION['username'])) {
    header('location: ../index.php');
}

$membersId = $_GET['membersId'];
if(empty($membersId)) {
    header('location: ../index.php');
}


$membersId = explode(',', $membersId);
$membersId = array_filter($membersId);
$membersId = array_unique($membersId);
sort($membersId);




?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="idriss boukmouche">
    <link rel="icon" href="<?=$urlUploads?><?=$settings['icon']?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?=$urlUploads?><?=$settings['icon']?>" type="image/x-icon">
    <title><?=$settings['site_name']?></title>
    <link rel="stylesheet" type="text/css" href="<?=$urlAssets?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=$urlAssets?>css/style.css">
<link id="color" rel="stylesheet" href="<?=$urlAssets?>css/color-1.css" media="screen">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lalezar&family=Lemonada:wght@700&display=swap');

        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                direction: rtl;
                font-family: "Lemonada", cursive !important;
              font-optical-sizing: auto !important;
              font-weight: 700 !important;
              font-style: normal !important;
               
            }

            .containerID {
                width: 21cm;
                height: 29.7cm;
                padding: 0;
                margin: 0;
                border: 1px solid #000;
                
            }
        }

        .containerID {
            width: 21cm;
            height: 29.7cm;
            padding: 0;
            margin: 0;
            border: 1px solid #000;
            margin-top: 0.2cm;
            margin-left: 0.2cm;
            font-family: "Lemonada", cursive !important;
            font-optical-sizing: auto !important;
            font-weight: 700 !important;
            font-style: normal !important;
        }

        .CardID {
            width: 9.5cm;
            height: 6cm;
            padding: 0;
            margin: 0;
            border: 1px solid #000;
            float: left;
            margin-right: 0.75cm;
            margin-bottom: 0.5cm;
            margin-top: 0.2cm;
            margin-left: 0.2cm;
            overflow: hidden;
            position: relative;
        }

        .CardID .Line {
            width: 4cm;
            height: 0.6cm;
            transform: rotate(-45deg);
            position: absolute;
            top: 0.9cm;
            right: 7cm;
        }

        .CardID .Green {
            background-color: #025702;
        }

        .CardID  .Yellow {
            background-color: #f5f50c;
        }

        .CardID  .Red {
            background-color: #d90c0c;
        }

        .CardID .Blue {
            background-color: #03035e;
        }

        .CardID .logo {
            width: 2cm;
            height: 2cm;
            position: relative;
            margin-right: 0.5cm;
            top: 0cm;
            right: 0cm;
        }

        .CardID .logo img {
            width: 100%;
            height: 100%;
        }

        .CardID .names {
            position: relative;
            bottom: 70px;
        }

        


        .CardID .nameScout {
            font-size: 9px;
            position: absolute;
            top: 0px;
            right: 90px;
        }

        .CardID .nameMohafdt {
            font-size: 9px;
            position: absolute;
            top: 12px;
            right: 110px;
        }

        .CardID .nameGroup {
            font-size: 11px;
            position: absolute;
            top: 25px;
            right: 115px;
        }

        .CardID .picTure {
            width: 2cm;
            height: 2.5cm;
            position: relative;
            margin-right: 0.5cm;
            top: 30px;
            right: 250px;
            border: 1px solid #000;
            border-radius: 10px 10px 10px 10px;
        }

        .CardID .picTure img {
            width: 100%;
            height: 100%;
            border-radius: 10px 10px 10px 10px;
        }

        .CardID .CardRed {
            width: 4cm;
            height: 0.8cm;
            background-color: red;
            position: absolute;
            right: 105px;
            top: 53px;
            border-radius: 5px;
        }

        .CardID .CardRed span {
            font-size: 12px;
            color: white;
            position: absolute;
            top: 5px;
            right: 15px;
        }

        .CardID .LabelName {
            font-size: 8px;
            position: absolute;
            top: 90px;
            right: 35px;
        }

        .CardID .LabelDate {
            font-size: 8px;
            position: absolute;
            top: 110px;
            right: 35px;
        }

        .CardID .LabelScoutUnit {
            font-size: 8px;
            position: absolute;
            top: 130px;
            right: 35px;
        }

        .CardID .Signature {
            font-size: 8px;
            position: absolute;
            top: 150px;
            right: 170px;

        }

        
        .CardID .QRCode {
            width: 2cm;
            height: 2cm;
            position: relative;
            margin-right: 0.5cm;
            right: 10px;
            bottom: 25px;
            border: 1px solid #000;
            border-radius: 10px 10px 10px 10px;
        }

        .CardID .QRCode img {
            width: 100%;
            height: 100%;
            border-radius: 10px 10px 10px 10px;
        }
        
        .CardID .MemberID {
            font-size: 8px;
            position: absolute;
            top: 206px;
            right: 115px;
        }


        
        

    </style>
</head>
<body main-theme-layout="rtl">

<?php

$totalCards = count($membersId);
$cardsPerPage = 8; 

$cardIndex = 0;
$membersData = [];

foreach ($membersId as $memberId) {
    $where = 'archiv = 0 AND member_id = ' . $memberId;
    $result = DB::select('members', $where);
    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc();
        $membersData[] = $member;
    }
}

$scoutUnitOrder = [
    'أشبال' => 1,
    'زهرات' => 2,
    'كشاف' => 3,
    'دليلات' => 4,
    'جوال' => 5,
    'مرشدات' => 6,
    'قائد' => 7,
    'عميد' => 8
];

function compareScoutUnit($a, $b) {
    global $scoutUnitOrder;
    return $scoutUnitOrder[$a['scout_unit']] <=> $scoutUnitOrder[$b['scout_unit']];
}

usort($membersData, 'compareScoutUnit');

foreach ($membersData as $member) {
    if ($member['scout_unit'] == 'أشبال' || $member['scout_unit'] == 'زهرات') {
        $ColorUnit = 'Yellow';
    } else if ($member['scout_unit'] == 'كشاف' || $member['scout_unit'] == 'دليلات') {
        $ColorUnit = 'Green';
    } else if ($member['scout_unit'] == 'جوال' || $member['scout_unit'] == 'مرشدات') {
        $ColorUnit = 'Red';
    } else if ($member['scout_unit'] == 'قائد' || $member['scout_unit'] == 'عميد') {
        $ColorUnit = 'Blue';
    } else {
        $ColorUnit = ' ';
    }

    if ($cardIndex % $cardsPerPage == 0) {
        if ($cardIndex != 0) {
            echo '</div>'; 
        }
        echo '<div class="containerID" id="printIDCard">'; 
    }
    ?>
    <div class="CardID">
        <div class="Line <?=$ColorUnit?>"></div> 
        <div class="logo">
            <img src="<?=$urlUploads?><?=$settings['logo']?>" alt="logo">
        </div>
        <div class="names">
            <div class="nameScout">
                <span>قدماء الكشافة الاسلامية الجزائرية</span>
            </div>
            <div class="nameMohafdt">
                <span>المحافظة الولائية سطيف</span>
            </div>
            <div class="nameGroup">
                <span><?=$settings['site_name']?></span>
            </div>
        </div>
        <div class="CardRed">
            <span>بطاقة المعلومات</span>
        </div>

        <div class="picTure">
            <img src="<?=$urlUploads?><?=$member['picture']?>" alt="picture">
        </div> 
        
        <div class="LabelName">
            <span>الاسم و اللقب : <?=$member['first_name'] . ' ' . $member['last_name']?></span>
        </div>
        <div class="LabelDate">
            <span>تاريخ و مكان الميلاد : <?=$member['dob'] . ' ' . $member['place_of_increase']?></span>
        </div>
        <div class="LabelScoutUnit">
            <span>الوحدة الكشفية :  <?=$member['scout_unit']?></span>
        </div>

        <div class="Signature">
            <span> قائد الفوج : </span>
        </div>

        <div class="QRCode">
            <img src="<?=$urlQR?>?text=<?=$member['member_id']?>" alt="QR Code">
        </div>

        <div class="MemberID">
            <span> رقم المنخرط : <?=$member['member_id']?></span>
        </div>

    </div>
    <?php
    $cardIndex++;
}
if ($cardIndex % $cardsPerPage != 0) {
    echo '</div>';
}
?>


 <!-- latest jquery-->
 <script src="<?=$urlAssets?>js/jquery-3.5.1.min.js"></script>
 <script src="<?=$urlAssets?>js/jquery.session.min.js"></script>
<!-- Bootstrap js-->
<script src="<?=$urlAssets?>js/bootstrap/popper.min.js"></script>
<script src="<?=$urlAssets?>js/bootstrap/bootstrap.js"></script>
<!-- feather icon js-->
<script>
    $(document).ready(function() {
        
       
        window.print();

    });

    
</script>




</body>
</html>