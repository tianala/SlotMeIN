<?php
include_once "../../connect_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["reg_email"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $organization = $_POST["organization"];
    $password = $_POST["set_password"];

    $stmt = $mysqli->prepare("INSERT INTO users (email, first_name, last_name, organization, user_type, password)
                            VALUES (?, ?, ?, ?, 1, SHA2(?, 256))");
    $stmt->bind_param('sssis', $email, $first_name, $last_name, $organization, $password);
    if ($stmt->execute()) {
        echo "Account created successfully";
    } else {
        echo "Account cannot be created";
    }
    header("Location: ../../index.php");
    $stmt->close();
}