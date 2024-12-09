<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("../connect_db.php");

if ($_SESSION["logged_in"] == !true) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome/fontawesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
</head>
<body class="font-sans text-gray-800 bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed w-64 h-screen transition-all duration-500 bg-white shadow-lg" id="sidebar">
        <div class="flex items-center px-4 py-4">
            <button id="toggle-sidebar" class="mr-4 text-2xl bg-transparent border-none cursor-pointer">
                <span class="material-icons">menu</span>
            </button>
            <div class="flex items-center space-x-3 overflow-hidden">
                <img src="../assets/images/logo.png" alt="SlotMein Logo" class="object-contain w-12 h-12 transition-all duration-500" id="logo-img">
                <h2 class="mt-1 font-serif text-2xl font-bold transition-all duration-500 whitespace-nowrap" id="logo-text">SlotMein</h2>
            </div>
        </div>
        <hr class="my-4 border-t border-gray-300">
        <ul class="list-none">
            <li>
                <a href="dashboard.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                    <span class="material-icons">&#xe871;</span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="account.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                    <span class="material-icons">&#xe853;</span>
                    <span class="menu-text">Account</span>
                </a>
            </li>
            <li class="bg-gray-200">
                <a href="help.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                    <span class="material-icons">&#xe8fd;</span>
                    <span class="menu-text">Help</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen p-8 ml-64 transition-all duration-500 bg-gray-100" id="main-content">
        <div class="p-6 bg-white shadow-lg rounded-xl">
            <div class="mb-8 text-center">
                <!-- Title with Icon -->
                <h1 class="flex items-center justify-center space-x-2 text-4xl font-bold text-gray-800">
                    <!-- Help Title -->
                    <span>Help & Support</span>
                    <!-- Help Icon aligned to the right and with font size adjusted -->
                    <span class="ml-2 text-4xl text-blue-500 material-icons">help_outline</span>
                </h1>
                <p class="text-lg text-gray-600">
                    Find answers to common questions or contact support if you need assistance.
                </p>
            </div>
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                <!-- FAQ 1 -->
                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-blue-500"><i class="fas fa-plus-circle"></i></span>
                        <h2 class="text-xl font-semibold text-gray-700">How do I add a new venue?</h2>
                    </div>
                    <p class="text-gray-600">
                        Navigate to the dashboard and click the "Add Venue" button at the top-right corner. Fill in the required details and click "Add Venue."
                    </p>
                </div>
                <!-- FAQ 2 -->
                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-green-500"><i class="fas fa-edit"></i></span>
                        <h2 class="text-xl font-semibold text-gray-700">How do I edit venue details?</h2>
                    </div>
                    <p class="text-gray-600">
                        On the dashboard, locate the venue you want to edit and click "Edit." Update the details in the modal and click "Update."
                    </p>
                </div>
                <!-- FAQ 3 -->
                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-red-500"><i class="fas fa-trash-alt"></i></span>
                        <h2 class="text-xl font-semibold text-gray-700">How do I delete a venue?</h2>
                    </div>
                    <p class="text-gray-600">
                        Find the venue on the dashboard and click "Delete." Confirm your action in the popup.
                    </p>
                </div>
                <!-- FAQ 4 -->
                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-yellow-500"><i class="fas fa-key"></i></span>
                        <h2 class="text-xl font-semibold text-gray-700">How can I reset my password?</h2>
                    </div>
                    <p class="text-gray-600">
                        If you forgot your password, click the "Forgot Password" link on the login page. Enter your email address, and a reset link will be sent to you.
                    </p>
                </div>
                <!-- FAQ 5 -->
                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-purple-500"><i class="fas fa-envelope"></i></span>
                        <h2 class="text-xl font-semibold text-gray-700">Can I change my email address?</h2>
                    </div>
                    <p class="text-gray-600">
                        Yes, you can change your email address from your account settings page. Go to "Account" and click "Edit" to update your email.
                    </p>
                </div>
                <!-- FAQ 6 -->
                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-blue-500"><i class="fas fa-headset"></i></span>
                        <h2 class="text-xl font-semibold text-gray-700">How do I contact support?</h2>
                    </div>
                    <p class="text-gray-600">
                        You can contact support by emailing us at <a href="mailto:support@slotmein.com" class="text-blue-500 underline">support@slotmein.com</a>.
                    </p>
                </div>

                <!-- New FAQ: How to Reserve -->
                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-blue-500"><i class="fas fa-calendar-check"></i></span>
                        <h2 class="text-xl font-semibold text-gray-700">How to Reserve?</h2>
                    </div>
                    <p class="text-gray-600">
                        To make a reservation, follow these steps:
                        <ol class="pl-5 list-decimal">
                            <li>Click on the venue you want to book.</li>
                            <li>Select your desired date.</li>
                            <li>Select the time slot that works for you.</li>
                            <li>Confirm your reservation.</li>
                        </ol>
                    </p>
                </div>

                <!-- New FAQ: How to Understand and Navigate the Website -->
                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-green-500"><i class="fas fa-info-circle"></i></span>
                        <h2 class="text-xl font-semibold text-gray-700">How do I navigate the website?</h2>
                    </div>
                    <p class="text-gray-600">
                        The website is designed to be simple and easy to use. Use the sidebar on the left to navigate between the dashboard, account settings, and help sections. The main content area displays detailed information and actions. You can also find quick access links at the top of the page for essential actions.
                    </p>
                </div> 

                <div class="p-5 transition-all bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <span class="mr-4 text-2xl text-blue-500">
                            <i class="fas fa-question-circle"></i> 
                        </span>
                        <h2 class="text-xl font-semibold text-gray-700">About</h2>
                    </div>
                    <p class="text-gray-600">
                        SlotMein is a venue management platform that allows you to book and manage reservations at various venues for your events. It simplifies the process of booking by providing detailed information about available venues and their capacities.
                    </p>
                </div>
            </div>
        </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleButton = document.getElementById('toggle-sidebar');
        const logoImg = document.getElementById('logo-img');
        const logoText = document.getElementById('logo-text');
        const menuTexts = document.querySelectorAll('.menu-text');

        toggleButton.addEventListener('click', () => {
            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.replace('w-64', 'w-16');
                mainContent.classList.replace('ml-64', 'ml-16');
                logoImg.classList.add('w-8', 'h-8', 'mt-2');
                logoText.classList.add('hidden');
                menuTexts.forEach(text => text.classList.add('hidden'));
            } else {
                sidebar.classList.replace('w-16', 'w-64');
                mainContent.classList.replace('ml-16', 'ml-64');
                logoImg.classList.remove('w-8', 'h-8', 'mt-2');
                logoText.classList.remove('hidden');
                menuTexts.forEach(text => text.classList.remove('hidden'));
            }
        });
    </script>
</body>
</html>
