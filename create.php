<?php
include 'conn.php';

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

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Venue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 flex justify-center items-center h-screen m-0">

    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-center text-gray-500 text-xl font-medium mb-6">Add New Venue</h2>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
                <input type="text" id="name" name="name" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-400 focus:border-gray-400" 
                       required>
            </div>

            <div class="mb-4">
                <label for="capacity_pax" class="block text-sm font-medium text-gray-700 mb-1">Capacity Pax:</label>
                <input type="text" id="capacity_pax" name="capacity_pax" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-400 focus:border-gray-400" 
                       required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
                <input type="text" id="description" name="description" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-400 focus:border-gray-400" 
                       required>
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image:</label>
                <input type="text" id="image" name="image" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-400 focus:border-gray-400">
            </div>

            <button type="submit" 
                    class="w-full bg-gray-400 hover:bg-gray-500 text-white font-medium py-2 rounded-md transition-colors">
                Add Venue
            </button>
        </form>
    </div>

</body>
</html>