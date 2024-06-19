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

$year = $_GET['year'];
if(empty($year)) {
    header('location: ../index.php');
}




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
                background-color: #f4f4f4;
            }

            .page {
                width: 210mm;
                height: 297mm;
                margin: 0 auto;
                background-color: #fff;
                box-sizing: border-box;
                position: relative;
            }

        }

        body {
                margin: 0;
                padding: 0;
                direction: rtl;
                font-family: "Lemonada", cursive !important;
              font-optical-sizing: auto !important;
              font-weight: 700 !important;
              font-style: normal !important;
                background-color: #f4f4f4;
            }

            .page {
                width: 210mm;
                height: 297mm;
                margin: 0 auto;
                background-color: #fff;
                box-sizing: border-box;
                position: relative;
            }


        .container {
            width: 100%;
            margin-bottom: 10mm;
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: calc((297mm - 30mm) / 3); 
            box-sizing: border-box;
        }

        .container .logo {
            width: 3cm;
            height: 3cm;
            position: relative;
            margin-right: 0.5cm;
            top: -3mm;
            right: -4mm;
            
        }

        .container .logo img {
            width: 100%;
            height: 100%;
        }

        .container .names {
            position: relative;
            bottom: 70px;
        }

        


        .container .nameScout {
            font-size: 10px;
            position: absolute;
            top: -40px;
            right: 300px;
        }

        .container .nameMohafdt {
            font-size: 10px;
            position: absolute;
            top: -20px;
            right: 320px;
        }

        .container .nameGroup {
            font-size: 10px;
            position: absolute;
            top: 0px;
            right: 340px;

        }

        .container .title {
            position: relative;
            top: -1cm;
            right: 10px;
            font-size: 20px;
            text-align-last: center;

        }

        .container .description {
            position: relative;
            top: -1cm;
            right: 10px;
        }

        .container .description span {
            margin: 0;
            padding: 0;
        }

        .container .description #completed {
            font-size: 15px;
            font-weight: bold;
        }

        .container .description #price {
            font-size: 15px;
            font-weight: bold;
        }

        .container .description #date {
            font-size: 15px;
            font-weight: bold;
        }

        .container .description #inc {
            font-size: 15px;
            font-weight: bold;
        }

        .container .description #name {
            font-size: 15px;
            font-weight: bold;
        }

        .container .description #year {
            font-size: 15px;
            font-weight: bold;
        }

        .container .description .red {
            color: red;
        }

        .container .QRCode {
            position: relative;
            top: -5mm;
            right: 10px;
            width: 2cm;
            height: 2cm;
        }

        .container .QRCode img {
            width: 100%;
            height: 100%;
        }

        .container .MemberID {
            position: relative;
            top: -12mm;
            right: 90px;
            font-size: 10px;
            font-weight: bold;
        }


        .container .Signature {
            position: relative;
            top: -35mm;
            right: 262px;
            font-size: 10px;
            text-align-last: center;
        }



        .dotted-line {
            width: 100%;
            border-bottom: 1px dashed #000;
            position: absolute;
            left: 0;
            margin-top: -5mm;

        }

       
    </style>
</head>
<body>
<?php
$container = count($membersId);
$containersPerPage = 3;

$membersData = [];
$insurancesData = [];

foreach ($membersId as $memberId) {
    $where = 'archiv = 0 AND member_id = ' . $memberId;
    $result = DB::select('members', $where);
    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc();
        
        $whereInsurance = 'year = ' . $year . ' AND member_id = ' . $memberId . ' AND archiv = 0 AND paid = 1';
        $resultInsurance = DB::select('insurances', $whereInsurance);
        if ($resultInsurance->num_rows > 0) {
            $insurance = $resultInsurance->fetch_assoc();
            $membersData[] = $member;
            $insurancesData[] = $insurance;
        }
    }
}

$container = count($membersData); 

function FormartDate($date) {
    if (empty($date)) {
        return '';
    }

    $datePart = explode(' ', $date)[0];
    $dateComponents = explode('-', $datePart);
    return $dateComponents[0] . '/' . $dateComponents[1] . '/' . $dateComponents[2];
}

for ($i = 0; $i < $container; $i++) {
    $member = $membersData[$i];
    $insurance = $insurancesData[$i];

    if ($i % $containersPerPage == 0) {
        if ($i != 0) {
            echo '</div>';
        }
        echo '<div class="page">';
    }
?>
        <div class="container">
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

            <div class="title">
                <p>وصل استلام مبلغ التأمين</p>
            </div>

            <div class="description">
                <span id="completed"> تم إستلام </span>
                <span id="price"> المبلغ : <span class="red"> <?=$insurance['amount']?> </span> د.ج </span>
                <span id="date"> بالتاريخ :  <span class="red"> <?=FormartDate($insurance['updated_at_paid'])?> </span> </span><br>
                <span id="inc">لتامين الكشاف :</span>
                <span id="name" class="red"> <?=$member['first_name'] . ' ' . $member['last_name']?></span>
                <span id="year">لسنة :  <span class="red"> <?=$insurance['year']?> </span> </span>
            </div>

            <div class="QRCode">
                <img src="<?=$urlQR?>?text=<?=$base_url?>check/Insurances.php?MemberID=<?=$member['member_id']?>" alt="QR Code">
            </div>
            
            <div class="MemberID">
                <span> رقم المنخرط : <?=$member['member_id']?></span>
            </div>

            <div class="Signature">
                <span> قائد الفوج : </span>
            </div>


           
        </div>
        <?php 
        $containerNumber = $i + 1;
        if ($containerNumber % 3 != 0) {
            ?>
            <div class="dotted-line"></div>
        <?php } ?>
<?php
    if ($i == $container - 1) {
        echo '</div>';
    }
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
