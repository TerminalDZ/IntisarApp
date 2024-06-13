<?php
// Define a constant for the site URL
define('BASEURL', $base_url);

// Define constants for the database connection details
define('DATABASE_HOST', $host);
define('DATABASE_USER', $user);
define('DATABASE_PASS', $password);
define('DATABASE_NAME', $userdb);

// Database Connection:
$db = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

$db->set_charset("utf8");


if ($db->connect_errno || !$db->ping()) {
echo "Failed to connect to MySQL: " . $db->connect_error;
exit;
}