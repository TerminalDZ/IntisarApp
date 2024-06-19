<?php
include '../include/init.php';


$memberId = $_GET['MemberID'];
if (empty($memberId)) {
    header('location: ../index.php');
    exit();
}

$year = $_GET['year'];
if (empty($year)) {
    header('location: ../index.php');
    exit();
}

$where = 'archiv = 0 AND member_id = ' . intval($memberId);
$result = DB::select('members', $where);
if ($result->num_rows == 0) {
    header('location: ../index.php');
    exit();
}

$member = $result->fetch_assoc();

$whereInsurance = 'year = ' . intval($year) . ' AND member_id = ' . intval($memberId) . ' AND archiv = 0 AND paid = 1';
$resultInsurance = DB::select('insurances', $whereInsurance);


$insurance = $resultInsurance->fetch_assoc();

function FormartDate($date) {
    if (empty($date)) {
        return '';
    }

    $datePart = explode(' ', $date)[0];
    $dateComponents = explode('-', $datePart);
    return $dateComponents[0] . '/' . $dateComponents[1] . '/' . $dateComponents[2];
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
<title><?=$member['first_name'] . ' ' . $member['last_name']?></title>
<link rel="stylesheet" href="<?=$base_url?>check/css/Insurances.css">

</head>
<body>
        <div class="container">
            <?php
            if ($resultInsurance->num_rows != 0) {
            ?>
               
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
                <p> تـــأكيد من صحة الوصل</p>
            </div>

            <div class="description">
                <span id="completed">تم إستلام</span>
                <span id="price">المبلغ: <span class="red"><?=$insurance['amount']?></span> د.ج</span>
                <span id="date">بالتاريخ: <span class="red"><?=FormartDate($insurance['updated_at_paid'])?></span></span><br>
                <span id="inc">لتامين الكشاف:</span>
                <span id="name" class="red"><?=$member['first_name'] . ' ' . $member['last_name']?></span>
                <span id="year">لسنة: <span class="red"><?=$insurance['year']?></span></span>
            </div>

            <div class="QRCode">
                <img src="<?=$urlQR?>?text=<?=$base_url?>check/Insurances.php?MemberID=<?=$member['member_id']?>&year=<?=$insurance['year']?>" alt="QRCode">
            </div>

            <div class="MemberID">
                <span>رقم المنخرط: <?=$member['member_id']?></span>
            </div>

          
        </div>
        <div class="dotted-line"></div>
        <?php
        }else{
            echo '<div class="alert alert-danger">لم يتم العثور على تأمين لهذا العضو أو لم يتم دفعه تأمين بعد <br> يرجى التوجه إلى القائد للمزيد من المعلومات</div>';

        }?>

    <!-- latest jquery-->
    <script src="<?=$urlAssets?>js/jquery-3.5.1.min.js"></script>
    <script src="<?=$urlAssets?>js/jquery.session.min.js"></script>
    <!-- Bootstrap js-->
    <script src="<?=$urlAssets?>js/bootstrap/popper.min.js"></script>
    <script src="<?=$urlAssets?>js/bootstrap/bootstrap.js"></script>
    <script src="<?=$base_url?>check/js/Insurances.js"></script>

</body>
</html>
