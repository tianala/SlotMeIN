<?php
session_start();
include_once "../../connect_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_pw = hash('sha256', $password);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user["password"] == $hashed_pw) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $user["idusers"];
            header("Location: ../dashboard.php");
            exit();
        } else {
            $_SESSION["error_message"] = "Invalid Password.";
            header("Location: ../../index.php");
            exit();
        }
    } else {
        $_SESSION["error_message"] = "User does not exist.";
        header("Location: ../../index.php");
        exit();
    }
}