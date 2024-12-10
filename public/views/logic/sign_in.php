<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}include_once "../../connect_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $pdo->beginTransaction();

        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $hashed_pw = hash('sha256', $password);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ($user["password"] === $hashed_pw) {
                    $_SESSION["logged_in"] = true;
                    $_SESSION["user_id"] = $user["idusers"];

                    $pdo->commit();

                    header("Location: ../dashboard.php");
                    exit();
                } else {
                    $_SESSION["message"] = "Invalid password.";
                }
            } else {
                $_SESSION["message"] = "User does not exist.";
            }
        } else {
            throw new Exception("Error: " . $stmt->errorInfo()[2]);
        }

        $pdo->rollBack();
        $_SESSION['message_type'] = "error";
        header("Location: ../../index.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['message'] = "Transaction failed: " . $e->getMessage();
        $_SESSION['message_type'] = "error";
        header("Location: ../../index.php");
        exit();
    }
}
