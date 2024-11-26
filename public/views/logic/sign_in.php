<?php
include_once "../../connect_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_pw = hash('sha256', $password);

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

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