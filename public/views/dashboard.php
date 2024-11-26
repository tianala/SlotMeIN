<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include_once("../connect_db.php");

    if ($_SESSION["logged_in"] == !true) { header("Location: ../index.php"); } else { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="../assets/css/fontawesome/all.min.css"> 
    <link rel="stylesheet" href="../assets/css/fontawesome/fontawesome.min.css">
</head>
<body class="flex items-center justify-center h-screen">
    <div>
        <h1 class="text-[44px]">
        <?php 
            $stmt = $mysqli->prepare("
                SELECT * FROM users WHERE idusers = ?;
            ");
    
            $stmt->execute([$_SESSION['user_id']]);
            $row = $stmt->get_result()->fetch_assoc();
            echo ucfirst($row['first_name']);
        ?> 
        
        loves <span class="text-[69px]"><span class="font-bold text-red-600">6</span><span class="font-bold text-blue-600">9</span></span>  UwU <span class="text-green-500"><i class="fa-solid fa-face-grin-beam"></i></span></h1>
    </div>
    <a class="w-10 font-bold rounded-full hover:text-emerald-500" href="./logic/log_out.php"><i class="fa-solid fa-right-from-bracket"></i></a>

    <script src="./js/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            setTimeout(function() {
                alert(69);
            }, 1500);
        });
    </script>
</body>
</html>


<?php } ?>