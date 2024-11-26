<?php
include 'conn.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM events WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':id', $id);
    
    $stmt->execute();
    
    header("Location: dashboard.php");
    exit();
}
?>
