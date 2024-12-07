<?php
include '../../connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $capacity_pax = $_POST['capacity_pax'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    if(!empty($image['tmp_name'])) {
        $source = $image['tmp_name'];
        list($width, $height) = getimagesize($source);
        $max_w = 896;
        $max_h = 640;
        $resize_ratio = min($max_w / $width, $max_h / $height);
        $new_width = $width * $resize_ratio;
        $new_height = $height * $resize_ratio;

        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        }

        $tn = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        ob_start();
        imagejpeg($tn, NULL, 60);
        $img_content = ob_get_clean();

        $sql = "INSERT INTO venues (name, capacity_pax, description, image) VALUES (:name, :capacity_pax, :description, :image)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':capacity_pax', $capacity_pax);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $img_content, PDO::PARAM_LOB);
        $stmt->execute();

        header("Location: ../dashboard.php");
    } else {
        $sql = "INSERT INTO venues (name, capacity_pax, description) VALUES (:name, :capacity_pax, :description)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':capacity_pax', $capacity_pax);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        header("Location: ../dashboard.php");
    }


    exit();
}
