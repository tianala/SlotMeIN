<?php
include_once "../connect_db.php";


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
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="../assets/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome/fontawesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="../assets/js/jquery-3.7.1.min.js"></script>

</head>


<body class="m-0 bg-gray-200">
    <?php include("layout/nav.php") ?>
    <main class="flex items-center justify-center h-screen ">



        <div id="main-content" class="p-6 bg-white rounded-lg shadow-lg w-96 h-fit">
            <h2 class="mb-6 text-xl font-medium text-center text-gray-500">Update User</h2>
            <form method="POST" action="" class="flex flex-col w-full">
                <div class="mb-4">
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email:</label>
                    <input type="text" id="email" name="email" value="<?php echo $users['email']; ?>"
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-gray-400 focus:border-gray-400"
                        required>
                </div>

                <div class="mb-4">
                    <label for="first_name" class="block mb-1 text-sm font-medium text-gray-700">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $users['first_name']; ?>"
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-gray-400 focus:border-gray-400"
                        required>
                </div>

                <div class="mb-4">
                    <label for="last_name" class="block mb-1 text-sm font-medium text-gray-700">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $users['last_name']; ?>"
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-gray-400 focus:border-gray-400"
                        required>
                </div>

                <div class="mb-6">
                    <label for="organization_search"
                        class="block mb-1 text-sm font-medium text-gray-700">Organization:</label>
                    <div class="relative">
                        <input id="organization_search" type="text" placeholder="Search organization..."
                            class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-gray-400 focus:border-gray-400">

                        <div id="organization_dropdown"
                            class="absolute z-10 hidden w-full mt-1 overflow-y-auto bg-white border border-gray-300 rounded-md shadow-md max-h-48">
                            <?php
                            $stmt2 = $pdo->query("SELECT * FROM organizations ORDER BY name");
                            $organizations = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($organizations as $organization):
                                ?>
                                <div class="px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                    data-value="<?= $organization['idorganizations'] ?>">
                                    <?= $organization['name'] ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" id="organization_name" name="organization_name"
                            value="<?php echo $users['organization_name'] ?? ''; ?>">
                    </div>
                </div>


                <button type="submit"
                    class="w-full py-2 font-medium text-white bg-gray-400 rounded-md hover:bg-gray-500">
                    Update User
                </button>

            </form>
        </div>
    </main>

</body>


<script src="layout/nav.js"></script>
<script>
    document.getElementById('account-nav').classList.add('bg-gray-200');;

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