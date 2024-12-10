<?php
include_once "../../connect_db.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id = $_SESSION['user_id'];
$sql = "SELECT 
            users.email, 
            users.first_name, 
            users.last_name, 
            organizations.name AS organization_name
        FROM 
            users
        INNER JOIN 
            organizations
        ON 
            users.organization = organizations.idorganizations
        WHERE 
            idusers = ?;";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$users = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $organization_name = $_POST['organization_name'];

    $sql = "UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name, organization = :organization WHERE idusers =:idusers";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':organization', $organization_name);
    $stmt->bindParam(':idusers', $id);
    $stmt->execute();


    header("Location: ../dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Information</title>
   <link rel="stylesheet" href="../../assets/css/output.css">

</head>
<body class="bg-gray-200 flex justify-center items-center h-screen m-0">

    <div class="bg-white rounded-lg shadow-lg p-6 w-96 h-fit">
        <h2 class="text-center text-gray-500 text-xl font-medium mb-6">Update User</h2>
        <form method="POST" action="" class="flex flex-col w-full">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $users['email']; ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-400 focus:border-gray-400" 
                       required>
            </div>

            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $users['first_name']; ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-400 focus:border-gray-400" 
                       required>
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $users['last_name']; ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-400 focus:border-gray-400" 
                       required>
            </div>

            <div class="mb-6">
                <label for="organization_search" class="block text-sm font-medium text-gray-700 mb-1">Organization:</label>
                <div class="relative">
                    <input id="organization_search" type="text" placeholder="Search organization..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-400 focus:border-gray-400">

                    <div id="organization_dropdown" 
                        class="absolute w-full bg-white border border-gray-300 rounded-md shadow-md mt-1 max-h-48 overflow-y-auto hidden z-10">
                        <?php
                        $stmt2 = $pdo->query("SELECT * FROM organizations ORDER BY name");
                        $organizations = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($organizations as $organization):
                        ?>
                            <div class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 cursor-pointer" 
                                data-value="<?= $organization['idorganizations'] ?>">
                                <?= $organization['name'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" id="organization_name" name="organization_name" 
                        value="<?php echo $users['organization_name'] ?? ''; ?>">
                </div>
            </div>


            <button type="submit" class="w-full bg-gray-400 hover:bg-gray-500 text-white font-medium py-2 rounded-md">
                Update User
            </button>

        </form>
    </div>

</body>

<script>
    const searchInput = document.getElementById('organization_search');
    const dropdown = document.getElementById('organization_dropdown');
    const hiddenInput = document.getElementById('organization_name');

    searchInput.addEventListener('focus', () => {
        dropdown.classList.remove('hidden');
    });

    searchInput.addEventListener('input', () => {
        const filter = searchInput.value.toLowerCase();
        const items = dropdown.querySelectorAll('div[data-value]');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(filter)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target) && !searchInput.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    dropdown.addEventListener('click', (e) => {
        if (e.target.dataset.value) {
            searchInput.value = e.target.textContent.trim();
            hiddenInput.value = e.target.dataset.value;
            dropdown.classList.add('hidden');
        }
    });
</script>
</html>
