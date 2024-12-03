<?php
include_once "../../connect_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["reg_email"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $organization = $_POST["organization"];
    $password = $_POST["set_password"];

    $stmt = $pdo->prepare("INSERT INTO users (email, first_name, last_name, organization, user_type, password)
                            VALUES (:email, :first_name, :lastname, :organization, 1, SHA2(:password, 256))");
    $stmt->execute([
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'organization' => $organization,
        'password' => $$password
    ]);    
    
    if ($stmt->execute()) {
        echo "Account created successfully";
        header("Location: ../../index.php");
    } else {
        echo "Account cannot be created";
    }
}