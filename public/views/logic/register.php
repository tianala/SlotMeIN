<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "../../connect_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $pdo->beginTransaction();

        $email = trim($_POST["reg_email"]);
        
        $stmt = $pdo->prepare("SELECT email FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $existing_email = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_email) {
            $_SESSION['message'] = "User already exists.";
            $_SESSION['message_type'] = "error";
            header("Location: ../../index.php");
            exit();
        }

        $first_name = htmlspecialchars(trim($_POST["first_name"]));
        $last_name = htmlspecialchars(trim($_POST["last_name"]));
        $organization = htmlspecialchars(trim($_POST["organization"]));
        $password = $_POST["set_password"];

        $stmt = $pdo->prepare("INSERT INTO users (email, first_name, last_name, organization, user_type, password) 
                               VALUES (:email, :first_name, :last_name, :organization, 1, SHA2(:password, 256))");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':organization', $organization, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $pdo->commit();
            $_SESSION['message'] = "Account created successfully.";
            $_SESSION['message_type'] = "success";
            header("Location: ../../index.php");
            exit();
        } else {
            throw new Exception("Account cannot be created.");
        }

    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['message'] = "Transaction failed: " . $e->getMessage();
        $_SESSION['message_type'] = "error";
        header("Location: ../../index.php");
        exit();
    }
}
?>
