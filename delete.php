<?php
include 'conn.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM venues WHERE idvenues = :idvenues";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idvenues', $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error deleting the venue.";
    }
}
?>
