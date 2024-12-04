<?php
include 'conn.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM venues WHERE idvenues = :idvenues";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':idvenues', $id);
    $stmt->execute();
    
    header("Location: dashboard.php");
    exit();
}
?>
