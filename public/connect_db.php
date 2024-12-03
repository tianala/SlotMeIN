<?php
date_default_timezone_set("Asia/Manila");

$hostname = 'slot-me-in-slot-me-in.l.aivencloud.com';
$defaultSchema = 'defaultdb';
$username = 'avnadmin';
$password = 'AVNS_6xSC86qbw3QruG3JdYI';
$charset = 'utf8mb4';
$port = 17432;

$$dsn = "mysql:host=$hostname;dbname=$defaultSchema;charset=$charset;port=$port";

$option =[PDO::ATTR_ERRMODE 			=> PDO::ERRMODE_EXCEPTION,
		 PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC,
		 PDO::ATTR_EMULATE_PREPARES		=> false];

global $pdo;
$pdo= new PDO($dsn,$username,$password,$option);
