<?php
include 'conn.php';

// Fetch events data
$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <div class="w-64 h-screen fixed bg-white shadow-lg transition-all duration-300" id="sidebar">
    <div class="flex items-center px-4 py-4">
      <button id="toggle-sidebar" class="text-2xl bg-transparent border-none cursor-pointer">
        <span class="material-icons">menu</span>
      </button>
      <div class="flex items-center space-x-2 ml-4">
        <img src="logo.png" alt="SlotMein Logo" class="w-10 h-10 object-contain" id="logo-img">
        <h2 class="text-2xl font-bold font-serif" id="logo-text">SlotMein</h2>
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
  <div class="ml-64 p-8 bg-gray-100 min-h-screen transition-all duration-300" id="main-content">
    <h1 class="text-3xl font-bold mb-2">Hi, (insert name)</h1>

    <!-- Create Button -->
    <div class="absolute right-10 top-10 bg-orange-500 text-white rounded-lg px-4 py-2 flex items-center space-x-2 text-lg shadow-lg hover:bg-orange-600">
      <a href="create.php" class="flex items-center space-x-2">
        <span class="fas fa-plus text-2xl mr-2"></span>
        <span class="text-lg">Add Event</span>
      </a>
    </div>

    <p class="text-lg text-gray-600 mb-2 mt-0">Welcome to your dashboard! Here, you can create a reservation on different venues, check upcoming events and manage  <br> your account efficiently.</p>

    <!-- Event Grid -->
    <div class="flex flex-wrap gap-5 p-5 mt-9">
      <?php foreach ($events as $event): ?>
        <div class="flex flex-col justify-center items-center relative bg-white shadow-lg border border-gray-300 rounded-lg p-6 hover:shadow-xl hover:scale-105 transition-transform duration-300 ease-in-out w-full sm:w-[calc(33%-20px)] h-80">
          <!-- Event Image -->
          <?php if (!empty($event['photo'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($event['photo']); ?>" 
                 alt="Event Image" 
                 class="w-full h-44 object-cover rounded-t-xl">
          <?php endif; ?>

          <!-- Event Title Overlay -->
          <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-orange-400 to-transparent text-white flex items-end justify-center px-3 rounded-b-lg">
            <h3 class="text-2xl font-bold transform -translate-y-2"><?php echo htmlspecialchars($event['title']); ?></h3>
          </div>

          <!-- Event Actions -->
          <div class="absolute top-4 right-6 flex space-x-3">
            <a href="update.php?id=<?php echo $event['id']; ?>" class="text-gray-600 hover:text-gray-800">
              <span>Edit</span>
          </a>
          <a>
              <span>|</span>
        
            </a>
            <a href="delete.php?id=<?php echo $event['id']; ?>" class="text-gray-600 hover:text-gray-800" onclick="return confirm('Are you sure you want to delete this?')">
              <span>Delete</span>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
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

    toggleButton.addEventListener('click', () => {
      if (sidebar.classList.contains('w-64')) {
        // Minimize Sidebar
        sidebar.classList.replace('w-64', 'w-16');
        mainContent.classList.replace('ml-64', 'ml-16');
        logoImg.classList.add('hidden');
        logoText.classList.add('hidden');
        menuTexts.forEach(text => text.classList.add('hidden'));
      } else {
        // Expand Sidebar
        sidebar.classList.replace('w-16', 'w-64');
        mainContent.classList.replace('ml-16', 'ml-64');
        logoImg.classList.remove('hidden');
        logoText.classList.remove('hidden');
        menuTexts.forEach(text => text.classList.remove('hidden'));
      }
    });
  </script>
</body>
</html>
