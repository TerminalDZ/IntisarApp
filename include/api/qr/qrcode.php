<?php
include '../../init.php';

$text = isset($_GET['text']) ? $_GET['text'] : '';

$text = urldecode($text);


QRcode::png($text);
?>
