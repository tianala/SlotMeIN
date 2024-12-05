<?php
include '../../connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $capacity_pax = $_POST['capacity_pax'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $sql = "INSERT INTO venues (name, capacity_pax, description, image) VALUES (:name, :capacity_pax, :description, :image)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':capacity_pax', $capacity_pax);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->execute();

    header("Location: ../dashboard.php");
    exit();
}
?>

