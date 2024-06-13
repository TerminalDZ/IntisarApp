<?php
           
    if(isset($_GET['p'])){
        $page = $_GET['p'];
        $file = './pages/app/'.$page.'.php';
        if(file_exists($file)){
            include($file);
        }else{
            include('./pages/error/404.php');
        }
    }else{
        include('./pages/app/home.php');
    }
