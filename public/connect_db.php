<?php
date_default_timezone_set("Asia/Manila");

$hostname = 'slot-me-in-slot-me-in.l.aivencloud.com';
$defaultSchema = 'defaultdb';
$username = 'avnadmin';
// $password = 'AVNS_6xSC86qbw3QruG3JdYI';
$charset = 'utf8mb4';
$port = 17432;

$mysqli = new mysqli($hostname, $username, $password, $defaultSchema, $port);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (!$mysqli->set_charset($charset)) {
    die("Error loading character set $charset: " . $mysqli->error);
}

echo "Connection successful.";
?>
