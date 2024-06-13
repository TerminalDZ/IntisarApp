
<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$settings['description']?>">
    <meta name="keywords" content="<?=$settings['keywords']?>">
    <meta name="author" content="idriss boukmouche">
    <link rel="icon" href="<?=$urlUploads?><?=$settings['icon']?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?=$urlUploads?><?=$settings['icon']?>" type="image/x-icon">
    <title><?=$settings['site_name']?></title>
    <?php
      include 'style.php';
    ?>
  
  </head>
  <body main-theme-layout="rtl">
    <!-- Loader starts-->
    <?php
      include 'loader.php';
    ?>
    
    <?php
       if (!isset($_SESSION['username'])) {
        
        if(isset($_GET['auth'])){
          $auth = $_GET['auth'];
          $path = './pages/auth/';
          if($auth == 'forgotP'){
            include $path . 'forgot-password.php';
          }else if($auth == 'resetP'){
            include $path . 'reset-password.php';
          }
        }else{

          include './pages/auth/login.php';

        }


      }else{?>


    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
      <!-- Page Header Start-->
      <div class="page-main-header">
        <?php
          include 'header.php';
        ?>
      </div>
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php
          include 'sidebar.php';
        ?>
        <!-- Page Sidebar Ends-->
       
        <div class="page-body">
          <?php
              include 'include/pages.php';
            ?>



        </div>
        <!-- footer start-->
        <?php
          include 'footer.php';
        ?>
        <!-- footer end-->
      </div>
    </div>

    <?php
      }
    ?>
    <?php
      include 'script.php';
    ?>
   
  </body>
</html>