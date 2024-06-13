<?php
session_start();

// Errors Reporting:
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Common Files:
require 'config.php';
require 'connect.php';
require_once 'router.php';
require_once 'Class.php';
require_once 'import.php';


date_default_timezone_set('Africa/Algiers');

if (!defined("BASEURL")) {
    die("BASEURL is not defined");
}
