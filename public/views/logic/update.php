<?php
include '../../connect_db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM venues WHERE idvenues = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $venues = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $capacity_pax = $_POST['capacity_pax'];
    $description = $_POST['description'];
    $image = $_FILES['image'];
    $cur_image = $_POST['currentImg'];

    if (!empty($image['tmp_name'])) {
        $img_content = file_get_contents($image['tmp_name']);
    } else {
        $img_content = base64_decode($cur_image);
    }
    $sql = "UPDATE venues SET name = :name, capacity_pax = :capacity_pax, description = :description, image = :image WHERE idvenues = :idvenues";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':capacity_pax', $capacity_pax);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $img_content, PDO::PARAM_LOB);
    $stmt->bindParam(':idvenues', $id);
    $stmt->execute();

    header("Location: ../dashboard.php");
    exit();
}
?>
