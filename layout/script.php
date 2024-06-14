 <!-- latest jquery-->
 <script src="<?=$urlAssets?>js/jquery-3.5.1.min.js"></script>
 <script src="<?=$urlAssets?>js/jquery.session.min.js"></script>
<!-- Bootstrap js-->
<script src="<?=$urlAssets?>js/bootstrap/popper.min.js"></script>
<script src="<?=$urlAssets?>js/bootstrap/bootstrap.js"></script>
<!-- feather icon js-->
<script src="<?=$urlAssets?>js/icons/feather-icon/feather.min.js"></script>
<script src="<?=$urlAssets?>js/icons/feather-icon/feather-icon.js"></script>
<!-- Sidebar jquery-->
<script src="<?=$urlAssets?>js/sidebar-menu.js"></script>
<script src="<?=$urlAssets?>js/config.js"></script>
<!-- Plugins JS start-->
<script src="<?=$urlAssets?>js/prism/prism.min.js"></script>
<script src="<?=$urlAssets?>js/clipboard/clipboard.min.js"></script>
<script src="<?=$urlAssets?>js/custom-card/custom-card.js"></script>
<script src="<?=$urlAssets?>js/chat-menu.js"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="<?=$urlAssets?>js/script.js"></script>
<script src="<?=$urlAssets?>js/theme-customizer/customizer.js"></script>
<!-- login js-->
<!-- Plugin used-->
<script src="<?=$urlAssets?>js/notify/bootstrap-notify.min.js"></script>
<script src="<?=$urlAssets?>js/notify/notify-script.js"></script>
<script src="<?=$urlAssets?>js/sweet-alert/sweetalert.min.js"></script>
<script src="<?=$urlAssets?>js/form-validation-custom.js" ></script>
<script src="<?=$urlAssets?>js/dropify.js" ></script>
<script src="<?=$urlAssets?>js/select2/select2.full.min.js"></script>

<script src="<?=$urlAssets?>js/selectize.min.js"></script>

<script src="<?=$urlAssets?>js/datatable/datatables/jquery.dataTables.min.js" ></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/jszip.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/pdfmake.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/vfs_fonts.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/dataTables.select.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/buttons.print.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/buttons.html5.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/responsive.bootstrap4.min.js"></script>
<script src="<?=$urlAssets?>js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>

<script src="<?=$urlAssets?>js/webcam.min.js"></script>
<script src="<?=$urlAssets?>js/pdf-lib.js"></script>
<script src="<?=$urlAssets?>js/jspdf.js"></script>
<script src="<?=$urlAssets?>js/html5-qrcode.min.js"></script>


<script src="<?=$urlAssets?>js/owlcarousel/owl.carousel.js"></script>
<script src="<?=$urlAssets?>js/counter/jquery.waypoints.min.js"></script>
<script src="<?=$urlAssets?>js/counter/jquery.counterup.min.js"></script>
<script src="<?=$urlAssets?>js/counter/counter-custom.js"></script>
<script src="<?=$urlAssets?>js/datepicker/date-picker/datepicker.js"></script>
<script src="<?=$urlAssets?>js/datepicker/date-picker/datepicker.en.js"></script>
<script src="<?=$urlAssets?>js/datepicker/date-picker/datepicker.custom.js"></script>
<script src="<?=$urlAssets?>js/general-widget.js"></script>
<script src="<?=$urlAssets?>js/height-equal.js"></script>
<script src="<?=$urlAssets?>js/typeahead-search/handlebars.js"></script>


<script src="<?=$base_url?>include/js/pages/config.js"></script>
<?php
    if(isset($_GET['p'])){
        if (isset($_SESSION['username'])) {
            $page = $_GET['p'];
            $file = './include/js/pages/'.$page.'.js';
            if(file_exists($file)){
                echo '<script src="'.$base_url.'include/js/pages/'.$page.'.js"></script>';
            }
        }
    }else{
        if (!isset($_SESSION['username'])) {
            echo '<script src="'.$base_url.'include/js/auth/login.js"></script>';
        }else{
            echo '<script src="'.$base_url.'include/js/pages/home.js"></script>';
        }
        
        
    }

?>

