<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include_once("../connect_db.php");

    if ($_SESSION["logged_in"] == !true) { header ("Location: ../index.php"); } else { 
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
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
  <!-- Sidebar -->
  <div class="w-64 h-screen fixed bg-white shadow-lg transition-all duration-500" id="sidebar">
  <div class="flex items-center px-4 py-4">
    <!-- Toggle Sidebar Button -->
    <button id="toggle-sidebar" class="text-2xl bg-transparent border-none cursor-pointer mr-4">
      <span class="material-icons">menu</span>
    </button>
    
    <!-- Logo and Text -->
    <div class="flex items-center space-x-3 overflow-hidden">
      <img src="../assets/images/logo.png" alt="SlotMein Logo" class="w-12 h-12 object-contain transition-all duration-500" id="logo-img">
      <h2 class="text-2xl font-bold font-serif transition-all duration-500 whitespace-nowrap mt-1" id="logo-text">SlotMein</h2>
    </div>
  </div>
  <hr class="border-t border-gray-300 my-4">
  <ul class="list-none">
    <li class="bg-gray-200">
      <a href="dashboard.php" class="flex items-center px-4 py-3 text-lg space-x-4 hover:bg-gray-300">
        <span class="material-icons">&#xe871;</span>
        <span class="menu-text">Dashboard</span>
      </a>
    </li>
    <li>
      <a href="account.php" class="flex items-center px-4 py-3 text-lg space-x-4 hover:bg-gray-300">
        <span class="material-icons">&#xe853;</span>
        <span class="menu-text">Account</span>
      </a>
    </li>
    <li>
      <a href="help.php" class="flex items-center px-4 py-3 text-lg space-x-4 hover:bg-gray-300">
        <span class="material-icons">&#xe8fd;</span>
        <span class="menu-text">Help</span>
      </a>
    </li>
  </ul>
</div>

<!-- Main Content -->
<div class="ml-64 p-8 bg-gray-100 min-h-screen transition-all duration-500" id="main-content">
  <h1 class="text-3xl font-bold mb-2">Hi, <?=$row['first_name']?></h1>

    <!-- Create Button -->
    <div class="absolute right-10 top-10 bg-orange-500 text-white rounded-lg px-4 py-2 flex items-center space-x-2 text-lg shadow-lg hover:bg-orange-600 cursor-pointer"
          onclick="openCreateModal()">
      <span class="fas fa-plus text-2xl mr-2"></span>
      <span class="text-lg">Add Venue</span>
    </div>

    <p class="text-lg text-gray-600 mb-2 mt-0">Welcome to your dashboard! Here, you can create a reservation on different venues, check upcoming events and manage  <br> your account efficiently.</p>

    <!-- Event Grid -->
    <div class="flex flex-wrap gap-5 p-5 mt-9">
      <?php foreach ($venues as $venues): ?>
        <div id="<?=$venues['idvenues']?>-venue"
            data-idvenues="<?=$venues['idvenues']?>" 
            data-name="<?=$venues['name']?>"
            data-capacity_pax="<?=$venues['capacity_pax']?>"
            data-description="<?=$venues['description']?>"
        class="flex flex-col justify-center items-center relative bg-white shadow-lg border border-gray-300 rounded-lg p-6 hover:shadow-xl hover:scale-105 transition-transform duration-300 ease-in-out w-full sm:w-[calc(33%-20px)] h-80">
          <!-- Event Image -->
          <?php if (!empty($venues['photo'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($venues['photo']); ?>" 
                 alt="Event Image" 
                 class="w-full h-44 object-cover rounded-t-xl">
          <?php endif; ?>

          <!-- Event Title Overlay -->
          <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-orange-400 to-transparent text-white flex items-end justify-center px-3 rounded-b-lg">
            <h3 class="text-2xl font-bold transform -translate-y-2"><?php echo htmlspecialchars($venues['name']); ?></h3>
          </div>

          <!-- Event Actions -->
          <div class="absolute top-4 right-6 flex space-x-3">
            <a onclick="openEditModal(<?=$venues['idvenues']?>)" class="text-gray-600 hover:text-gray-800 cursor-pointer">
              <span>Edit</span>
            </a>
            <a>
              <span>|</span>
            </a>
            <a onclick="openDeleteModal(<?=$venues['idvenues']?>, '<?=htmlspecialchars($venues['name'], ENT_QUOTES)?>')" class="text-gray-600 hover:text-gray-800 cursor-pointer">
              <span>Delete</span>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

<!-- Edit Venue Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 backdrop-blur-sm flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative" onclick="event.stopPropagation()">
    <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Edit Venue</h2>
    <form id="editForm" method="POST" action="logic/update.php">
      <input type="hidden" id="editId" name="id">
      <div class="mb-4">
        <label for="editName" class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
        <input type="text" id="editName" name="name" 
               class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
      </div>
      <div class="mb-4">
        <label for="editCapacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity Pax:</label>
        <input type="text" id="editCapacity" name="capacity_pax" 
               class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
      </div>
      <div class="mb-4">
        <label for="editDescription" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
        <input type="text" id="editDescription" name="description" 
               class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
      </div>
      <div class="mb-4">
        <label for="editImage" class="block text-sm font-medium text-gray-700 mb-1">Image URL:</label>
        <input type="text" id="editImage" name="image" 
               class="w-full px-4 py-2 border border-gray-300 rounded-md">
      </div>
      <div class="flex justify-center space-x-4">
        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md" 
                onclick="closeEditModal()">Cancel</button>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md">Update</button>
      </div>
    </form>
  </div>
</div>

<!-- Create Venue Modal -->
<div id="createModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 backdrop-blur-sm flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative" onclick="event.stopPropagation()">
    <h2 class="text-xl font-bold text-gray-700 mb-4  text-center">Add Venue</h2>
    <form id="createForm" method="POST" action="logic/create.php">
      <div class="mb-4">
        <label for="createName" class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
        <input type="text" id="createName" name="name" 
               class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
      </div>
      <div class="mb-4">
        <label for="createCapacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity Pax:</label>
        <input type="text" id="createCapacity" name="capacity_pax" 
               class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
      </div>
      <div class="mb-4">
        <label for="createDescription" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
        <input type="text" id="createDescription" name="description" 
               class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
      </div>
      <div class="mb-4">
        <label for="createImage" class="block text-sm font-medium text-gray-700 mb-1">Image:</label>
        <input type="text" id="createImage" name="image" 
               class="w-full px-4 py-2 border border-gray-300 rounded-md">
      </div>
      <div class="flex justify-center space-x-4">
        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md" onclick="closeCreateModal()">Cancel</button>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md">Add Venue</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 backdrop-blur-sm flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
    <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Confirm Delete</h2>
    <p class="text-sm text-gray-600 mb-6">
      Are you sure you want to delete the venue: <span id="venueName" class="font-semibold text-gray-800"></span>?
    </p>
    <div class="flex justify-center space-x-4">
      <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md" onclick="closeDeleteModal()">Cancel</button>
      <a id="confirmDelete" class="bg-orange-500 text-white px-4 py-2 rounded-md">Delete</a>
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
    document.getElementById('editImage').value = image;

    editModal.classList.remove('hidden');
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