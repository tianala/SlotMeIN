<?php
include_once "../../connect_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_pw = hash('sha256', $password);

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute(['email', $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if($user["password"] == $hashed_pw) {
            session_start();
            $_SESSION["logged_in"] = True;
            $_SESSION["user_id"] = $user["idusers"];
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "Invalid Password.";
        }
    } else {
        echo "User does not exist";
    }
}