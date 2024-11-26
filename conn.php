<?php
$host = 'localhost';
$db = 'psu_reservation';
$user = 'root';
$pass = 'root'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection successful.";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
