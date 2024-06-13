<?php
    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('location: ../../index.php');
    }

    $text = $_GET['text'];
    
    
    
    // outputs image directly into browser, as PNG stream
    QRcode::png($text);

    ?>