<!-- header -->
<header class="flex items-center justify-between py-4 bg-orange-500 shadow-4xl px-7 md:hidden">
    <!-- Logo Section -->
    <div class="flex items-center space-x-2">
        <img src="../assets/images/logo-w.png" alt="Logo" class="w-auto h-12">
        <div
            class="mt-1 font-serif text-xl font-bold text-white transition-all duration-500 bg-orange-500 whitespace-nowrap ">
            SlotMein</div>
    </div>

    <!-- Menu Icon (Three Dots) -->
    <div class="relative flex items-center">
        <button class="text-white shadow-lg cursor-pointer hover:bg-gray-300">
            <span class="text-2xl fas fa-ellipsis-v "></span>
        </button>
    </div>


    <!-- Dropdown menu -->
    <div class="absolute right-0 hidden w-48 mt-2 bg-white border border-gray-300 rounded-lg shadow-lg">
        <ul>
            <li class="px-4 py-2 hover:bg-gray-200">Option 1</li>
            <li class="px-4 py-2 hover:bg-gray-200">Option 2</li>
            <li class="px-4 py-2 hover:bg-gray-200">Option 3</li>
        </ul>
    </div>
    </div>
</header>




<!-- Sidebar -->
<div class="fixed w-64 h-screen transition-all duration-500 bg-white shadow-lg" id="sidebar">
    <div class="flex items-center px-4 py-4">
        <button id="toggle-sidebar" class="mr-4 text-2xl bg-transparent border-none cursor-pointer">
            <span class="material-icons">menu</span>
        </button>
        <div class="flex items-center space-x-3 overflow-hidden">
            <img src="../assets/images/logo.png" alt="SlotMein Logo"
                class="object-contain w-12 h-12 transition-all duration-500" id="logo-img">
            <h2 class="mt-1 font-serif text-2xl font-bold transition-all duration-500 whitespace-nowrap" id="logo-text">
                SlotMein</h2>
        </div>
    </div>
    <hr class="my-4 border-t border-gray-300">
    <ul class="list-none">
        <li id="dashboard-nav">
            <a href="dashboard.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                <span class="material-icons">&#xe871;</span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li id="account-nav">
            <a href="account.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                <span class="material-icons">&#xe853;</span>
                <span class="menu-text">Account</span>
            </a>
        </li>
        <li id="help-nav">
            <a href="help.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-gray-300">
                <span class="material-icons">&#xe8fd;</span>
                <span class="menu-text">Help</span>
            </a>
        </li>
    </ul>
</div>