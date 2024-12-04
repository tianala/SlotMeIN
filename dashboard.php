<?php
include 'conn.php';

// Fetch events data
$stmt = $pdo->query("SELECT * FROM venues");
$venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
      <img src="logo.png" alt="SlotMein Logo" class="w-12 h-12 object-contain transition-all duration-500" id="logo-img">
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
  <h1 class="text-3xl font-bold mb-2">Hi, (insert name)</h1>

    <!-- Create Button -->
    <div class="absolute right-10 top-10 bg-orange-500 text-white rounded-lg px-4 py-2 flex items-center space-x-2 text-lg shadow-lg hover:bg-orange-600">
      <a href="create.php" class="flex items-center space-x-2">
        <span class="fas fa-plus text-2xl mr-2"></span>
        <span class="text-lg">Add Venue</span>
      </a>
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
            <a href="delete.php?id=<?php echo $venues['idvenues']; ?>" class="text-gray-600 hover:text-gray-800" onclick="return confirm('Are you sure you want to delete this venue?')">
              <span>Delete</span>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Update Modal -->
  <div id="editModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
      <h2 class="text-xl font-bold text-gray-700 mb-4">Edit Venue</h2>
      <form id="editForm" method="POST" action="update.php">
        <input type="hidden" id="editId" name="id">
        <div class="mb-4">
          <label for="editName" class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
          <input type="text" id="editName" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
          <label for="editCapacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity Pax:</label>
          <input type="text" id="editCapacity" name="capacity_pax" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
          <label for="editDescription" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
          <input type="text" id="editDescription" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
          <label for="editImage" class="block text-sm font-medium text-gray-700 mb-1">Image:</label>
          <input type="text" id="editImage" name="image" class="w-full px-4 py-2 border border-gray-300 rounded-md">
        </div>
        <div class="flex justify-end space-x-4">
          <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md" onclick="closeEditModal()">Cancel</button>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
        </div>
      </form>
    </div>
  </div>

    <!-- Create Modal -->

    <!-- Delete Modal -->

  <!-- JavaScript -->
  <script>
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('main-content');
  const toggleButton = document.getElementById('toggle-sidebar');
  const logoImg = document.getElementById('logo-img');
  const logoText = document.getElementById('logo-text');
  const menuTexts = document.querySelectorAll('.menu-text');
  const updateModal = document.getElementById('updateModal');
  const createModal = document.getElementById('createModal'); 
  const deleteModal = document.getElementById('deleteModal');
  // let eventIdToDelete = null;

  function openEditModal(venue) {
      $id = "#" + venue + "-venue";
      $name = $id.attr("data-name");
      $capacity_pax = $id.attr("data-capacity_pax");
      $description = $id.attr("data-description");
      $image = $id.attr("data-image");

      document.getElementById('editId').value = venue;
      document.getElementById('editName').value = $name;
      document.getElementById('editCapacity').value = $capacity_pax;
      document.getElementById('editDescription').value = $capacity_pax;
      document.getElementById('editImage').value = $image;
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
      modal.classList.add('hidden');
      window.location.href = 'dashboard.php';
    }

    function openCreateModal() {
      createEventModal.classList.remove('hidden');
    }

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