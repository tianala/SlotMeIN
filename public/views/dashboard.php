<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("../connect_db.php");

if ($_SESSION["logged_in"] == !true) {
    header("Location: ../index.php");
} else {
    $stmt = $pdo->prepare("
            SELECT * FROM users WHERE idusers = ?;
        ");

    $stmt->execute([$_SESSION['user_id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT * FROM venues");
    $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
        <script src="../assets/js/jquery-3.7.1.min.js"></script>
    </head>

    <body class="font-sans text-gray-800 bg-gray-100 shadow-lg">

    <header class="bg-orange-500 shadow-4xl flex items-center justify-between px-7 py-4 md:hidden">
    <!-- Logo Section -->
    <div class="flex items-center space-x-2">
    <img src="../assets/images/logo-w.png" alt="Logo" class="h-12 w-auto">
    <div class="mt-1 font-serif text-xl text-white font-bold transition-all duration-500 whitespace-nowrap bg-orange-500 ">SlotMein</div>
</div>
    
    <!-- Menu Icon (Three Dots) -->
    <div class="relative flex items-center">
    <button class="text-white shadow-lg cursor-pointer  hover:bg-gray-300">
        <span class="fas fa-ellipsis-v text-2xl "></span>
    </button>
</div>


        <!-- Dropdown menu -->
        <div class="absolute right-0 w-48 bg-white border border-gray-300 rounded-lg shadow-lg mt-2 hidden">
            <ul>
                <li class="px-4 py-2 hover:bg-gray-200">Option 1</li>
                <li class="px-4 py-2 hover:bg-gray-200">Option 2</li>
                <li class="px-4 py-2 hover:bg-gray-200">Option 3</li>
            </ul>
        </div>
    </div>
</header>

        <!-- Sidebar -->
        <div class="fixed w-64 h-screen transition-all duration-500 bg-white shadow-lg z-40 md:visible invisible" id="sidebar">
            <div class="flex items-center px-4 py-4">
                <!-- Toggle Sidebar Button -->
                <button id="toggle-sidebar" class="mr-4 text-2xl bg-transparent border-none cursor-pointer">
                    <span class="material-icons">menu</span>
                </button>

                <!-- Logo and Text -->
                <div class="flex items-center space-x-3 overflow-hidden">
                    <img src="../assets/images/logo.png" alt="SlotMein Logo" class="object-contain w-12 h-12 transition-all duration-500" id="logo-img">
                    <h2 class="mt-1 font-serif text-2xl font-bold transition-all duration-500 whitespace-nowrap" id="logo-text">SlotMein</h2>
                </div>
            </div>
            <hr class="my-4 border-t border-gray-300">
            <ul class="list-none">
                <li class="bg-gray-200">
                    <a href="dashboard.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                        <span class="material-icons">&#xe871;</span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="account.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                        <span class="material-icons">&#xe853;</span>
                        <span class="menu-text ">Account</span>
                    </a>
                </li>
                <li>
                    <a href="help.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                        <span class="material-icons">&#xe8fd;</span>
                        <span class="menu-text">Help</span>
                    </a>
                </li>
                <a href="logout.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                        <span class="material-icons-outlined">logout</span>
                        <span class="menu-text">Log out</span>
                </a>
                <li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="min-h-screen p-8 md:ml-64 transition-all duration-500 bg-gray-100" id="main-content">
            <h1 class="mb-2 text-4xl font-bold">Hi, <?= $row['first_name'] ?></h1>

            <!-- Create Button -->
<div class="fixed flex z-50 md:z-auto items-center px-4 py-2 space-x-2 text-lg text-white bg-orange-500 rounded-lg shadow-lg cursor-pointer md:right-10 right-5 md:top-10 top-5 hover:bg-orange-600 hidden md:flex"
                onclick="openCreateModal()">
                <span class="md:mr-2 text-2xl  md:text-2xl fas fa-plus"></span>
                <span class="text-sm md:text-lg md:flex hidden">Add Venue</span>
            </div>


            <div class="fixed flex z-50 items-center px-6 py-4 space-x-2 text-lg text-white bg-orange-500 rounded-lg shadow-4xl cursor-pointer right-5 bottom-14 hover:bg-orange-600 flex md:hidden"
     onclick="openCreateModal()">
    <span class="md:mr-2 text-2xl md:text-2xl fas fa-plus"></span>
</div>



<p class="mt-0 mb-1 text-xs md:text-lg text-gray-600 leading-relaxed">
    Welcome to your dashboard! Here, you can create a reservation on different venues, check upcoming events, and manage your account efficiently.
</p>

            <!-- Venue Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 justify-center w-full p-4 mt-2 md:mt-9">
    <?php foreach ($venues as $venue): ?>
        <div id="<?= $venue['idvenues'] ?>-venue"
            data-idvenues="<?= $venue['idvenues'] ?>"
            data-name="<?= $venue['name'] ?>"
            data-capacity_pax="<?= $venue['capacity_pax'] ?>"
            data-description="<?= $venue['description'] ?>"
            data-image="data:image/jpeg;base64,<?= base64_encode($venue['image']); ?>"
            class="flex flex-col justify-center items-center relative bg-white shadow-lg border border-gray-300 rounded-lg hover:shadow-xl hover:scale-105 transition-transform duration-300 ease-in-out lg:min-h-[20rem] lg:min-w-[18rem] lg:max-w-[35rem] h-auto  md:min-h-[10rem] md:min-w-[13rem] md:max-w-[20rem]">

                            <!-- Venue Image -->
                            <?php if (!empty($venue['image'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($venue['image']); ?>"
                                    alt="Venue Image"
                                    class="object-cover w-full h-full rounded-lg">
                            <?php endif; ?>
    
                            <!-- Venue Title Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 flex items-end justify-center h-16 px-3 text-white rounded-b-lg bg-gradient-to-t from-orange-400 to-transparent">
                                <h3 class="text-2xl font-bold transform -translate-y-3"><?php echo htmlspecialchars($venue['name']); ?></h3>
                            </div>
    
                            <!-- Venue Actions -->
                            <div class="absolute flex rounded-full top-4 right-6 bg-[#ffffffa8] border border-zinc-700/60">
                                <div onclick="openEditModal(<?= $venue['idvenues'] ?>)" class="flex justify-center w-1/2 h-full px-2 py-1 text-gray-600 border-r rounded-l-full cursor-pointer border-r-gray-600 hover:bg-orange-200">
                                    <i class="hover:text-gray-800 fa-solid fa-pen-to-square"></i>
                                </div>
                                <div onclick="openDeleteModal(<?= $venue['idvenues'] ?>, '<?= htmlspecialchars($venue['name'], ENT_QUOTES) ?>')" class="flex justify-center w-1/2 h-full px-2 py-1 text-gray-600 rounded-r-full cursor-pointer hover:bg-orange-200">
                                    <i class="fa-solid fa-trash hover:text-gray-800"></i>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Edit Venue Modal -->
        <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50 backdrop-blur-sm">
            <div class="relative p-6 bg-white rounded-lg shadow-lg w-96 h-fit" onclick="event.stopPropagation()">
            <div class="relative w-full mb-4 text-xl font-bold text-center text-gray-700">
                    Edit Venue
                    <i class="absolute right-0 px-4 py-2 ml-auto rounded-md text-zinc-700 fa-solid fa-xmark hover:text-red-800 hover:cursor-pointer" onclick="closeEditModal()"></i>
                </div>
                <form id="editForm" method="POST" action="logic/update.php" enctype="multipart/form-data" class="flex flex-col">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-4">
                        <label for="editName" class="block mb-1 text-sm font-medium text-gray-700">Name:</label>
                        <input type="text" id="editName" name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="editCapacity" class="block mb-1 text-sm font-medium text-gray-700">Capacity Pax:</label>
                        <input type="text" id="editCapacity" name="capacity_pax"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="editDescription" class="block mb-1 text-sm font-medium text-gray-700">Description:</label>
                        <input type="text" id="editDescription" name="description"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="relative mt-2 mb-4 font-medium text-gray-700"> Image:
                        <input id="currentImg" type="hidden" name="currentImg" class=""> 
                        <div class="w-full mt-3 mb-2 border border-gray-300 rounded-md min-h-44 max-h-44">
                            <img id="displayImg" src="" class="object-cover w-full rounded-md full min-h-44 max-h-44">
                        </div>
                        <label for="editImage" class="absolute w-20 p-1 font-medium text-center text-gray-700 bg-gray-200 border rounded-lg cursor-pointer -right-1 border-zinc-400 -bottom-4 hover:bg-gray-300">Change</label>
                        <input type="file" id="editImage" name="image" class="hidden">
                    </div>
                    <div class="flex justify-center mt-2 space-x-4">
                        <button type="submit" class="px-4 py-2 text-white bg-orange-500 rounded-md hover:bg-orange-600">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Create Venue Modal -->
        <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50 backdrop-blur-sm">
            <div class="relative p-6 bg-white rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
                <div class="relative w-full mb-4 text-xl font-bold text-center text-gray-700">
                    Add Venue
                    <i class="absolute right-0 px-4 py-2 ml-auto rounded-md text-zinc-700 fa-solid fa-xmark hover:text-red-800 hover:cursor-pointer" onclick="closeCreateModal()"></i>
                </div>
                <form id="createForm" method="POST" action="logic/create.php" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="createName" class="block mb-1 text-sm font-medium text-gray-700">Name:</label>
                        <input type="text" id="createName" name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="createCapacity" class="block mb-1 text-sm font-medium text-gray-700">Capacity Pax:</label>
                        <input type="text" id="createCapacity" name="capacity_pax"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="createDescription" class="block mb-1 text-sm font-medium text-gray-700">Description:</label>
                        <input type="text" id="createDescription" name="description"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="createImage" class="block mb-1 text-sm font-medium text-gray-700">Image:</label>
                        <input type="file" id="createImage" name="image"
                            class="w-full text-sm border border-gray-300 rounded-md file:h-full file:rounded file:bg-gray-200 file:border-none file:w-1/3 file:cursor-pointer hover:file:bg-gray-300 file:hover:bg-gray-200 file:text-zinc-700 h-11">
                    </div>
                    <div class="flex justify-center space-x-4">
                        <button type="submit" class="px-4 py-2 mt-5 text-white bg-orange-500 rounded-md hover:bg-orange-600">Add Venue</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50 backdrop-blur-sm">
            <div class="relative p-6 bg-white rounded-lg shadow-lg w-96">
                <h2 class="mb-4 text-xl font-bold text-center text-gray-700">Confirm Delete</h2>
                <p class="mb-6 text-sm text-gray-600">
                    Are you sure you want to delete the venue: <span id="venueName" class="font-semibold text-gray-800"></span>?
                </p>
                <div class="flex justify-center space-x-4">
                    <a type="button" class="px-4 py-2 text-gray-700 rounded-md cursor-pointer hover:underline" onclick="closeDeleteModal()">Cancel</a>
                    <a id="confirmDelete" class="px-4 py-2 text-white bg-orange-500 rounded-md hover:bg-orange-600">Delete</a>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleButton = document.getElementById('toggle-sidebar');
            const logoImg = document.getElementById('logo-img');
            const logoText = document.getElementById('logo-text');
            const menuTexts = document.querySelectorAll('.menu-text');
            const editModal = document.getElementById('editModal');
            const createModal = document.getElementById('createModal');
            let deleteModal = document.getElementById('deleteModal');
            let confirmDelete = document.getElementById('confirmDelete');

            function openEditModal(id) {
                const venueCard = document.getElementById(`${id}-venue`);
                const name = venueCard.dataset.name;
                const capacityPax = venueCard.dataset.capacity_pax;
                const description = venueCard.dataset.description;
                const image = venueCard.dataset.image;

                document.getElementById('editId').value = id;
                document.getElementById('editName').value = name;
                document.getElementById('editCapacity').value = capacityPax;
                document.getElementById('editDescription').value = description;
                document.getElementById('displayImg').src = image;
                document.getElementById('currentImg').value = image.replace(/^data:image\/[a-z]+;base64,/, '');

                editModal.classList.remove('hidden');

                const fileInput = document.getElementById('editImage');
                fileInput.addEventListener('change', function () {
                    const file = fileInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById('displayImg').src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            function toggleDropdownMenu() {
            var menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }

            // Close the modal and redirect
            function closeEditModal() {
                editModal.classList.add('hidden');
                window.location.href = 'dashboard.php';
            }

            // Close modal when clicking the backdrop
            editModal.addEventListener('click', (event) => {
                if (event.target === editModal) {
                    closeEditModal();
                }
            });

            // Prevent modal content from triggering backdrop click
            document.querySelector('#editModal > div').addEventListener('click', (event) => {
                event.stopPropagation();
            });

            function openCreateModal() {
                createModal.classList.remove('hidden');
            }

            function closeCreateModal() {
                createModal.classList.add('hidden');
            }

            // Close modal when clicking the backdrop
            createModal.addEventListener('click', (event) => {
                if (event.target === createModal) {
                    closeCreateModal();
                }
            });

            // Prevent modal content from triggering backdrop click
            document.querySelector('#createModal > div').addEventListener('click', (event) => {
                event.stopPropagation();
            });

            function openDeleteModal(id, name) {
                confirmDelete.href = `logic/delete.php?id=${id}`;
                document.getElementById('venueName').textContent = name;
                deleteModal.classList.remove('hidden');
            }

            function closeDeleteModal() {
                deleteModal.classList.add('hidden');
            }

            // Close modal when clicking outside the modal content
            deleteModal.addEventListener('click', (event) => {
                if (event.target === deleteModal) {
                    closeDeleteModal();
                }
            });

            toggleButton.addEventListener('click', () => {
                if (sidebar.classList.contains('w-64')) {
                    // Minimize Sidebar
                    sidebar.classList.replace('w-64', 'w-16');
                    mainContent.classList.replace('ml-64', 'ml-16');
                    logoImg.classList.add('w-8', 'h-8', 'mt-2'); // Adjust size and margin
                    logoText.classList.add('hidden'); // Hide text smoothly
                    menuTexts.forEach(text => text.classList.add('hidden'));
                } else {
                    // Expand Sidebar
                    sidebar.classList.replace('w-16', 'w-64');
                    mainContent.classList.replace('ml-16', 'ml-64');
                    logoImg.classList.remove('w-8', 'h-8', 'mt-2'); // Restore size and margin
                    logoText.classList.remove('hidden'); // Show text smoothly
                    menuTexts.forEach(text => text.classList.remove('hidden'));
                }
            });
        </script>
    </body>

    </html>


<?php } ?>