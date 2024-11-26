<?php
include 'conn.php';

$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="dashboard.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="logo.png" alt="SlotMein Logo" class="logo-image">
      <h2>SlotMein</h2>
    </div>
    <hr class="divider">

    <ul class="menu">
      <li><a href="dashboard.php">
        <span class="material-icons">&#xe871;</span> Dashboard
      </a></li>

      <li><a href="account.php">
        <span class="material-icons">&#xe853;</span> Account
      </a></li>

      <li><a href="help.php">
        <span class="material-icons">&#xe8fd;</span> Help
      </a></li>
    </ul>
  </div>

  <div class="main-content">
    <h1 class="dashboard-title">Dashboard</h1>
        <!-- CREATE ICON-->
        <div class="create-icon">
        <a href="create.php" class="create-button">
            <span class="material-icons">folder_open</span>
            </a>
        </div>
    <p class="dashboard-description">Welcome to your dashboard! Here, you can view upcoming events and manage your account efficiently.</p>

    <div class="events">
      <?php foreach ($events as $event): ?>
        <div class="event-box">
          <h2><?php echo htmlspecialchars($event['title']); ?></h2>
          <a href="time_picker.php"></a>
          <p><?php echo htmlspecialchars($event['description']); ?></p>

          <!-- ICONS DIV FOR UPDATE AND DELETE -->
          <div class="event-actions">
            <a href="update.php?id=<?php echo $event['id']; ?>" class="action-button">
              <!-- UPDATE ICON -->
              <span class="material-icons">edit</span> 
            </a>
            <a href="delete.php?id=<?php echo $event['id']; ?>" class="action-button" onclick="return confirm('Are you sure you want to delete this?')">
              <!-- DELETE ICON -->
              <span class="material-icons">delete</span>
            </a>
          </div>
          <br>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
