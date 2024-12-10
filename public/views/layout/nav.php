<!-- header -->
<header class="flex items-center justify-between py-4 bg-orange-500 shadow-4xl px-7 md:hidden">
    <!-- Logo Section -->
    <div class="flex items-center space-x-2">
        <img src="../assets/images/logo-w.png" alt="Logo" class="w-auto h-12">
        <div
            class="mt-1 font-serif text-xl font-bold text-white transition-all duration-500 bg-orange-500 whitespace-nowrap ">
            SlotMein</div>
    </div>

    <div class="relative flex items-center">
    <button 
        id="menuButton" 
        class="text-white cursor-pointer hover:bg-gray-300 p-2 rounded"
        onclick="toggleDropdown()"
    >
        <span class="text-2xl fas fa-bars"></span>
    </button>
    <div 
        id="dropdownMenu" 
        class="absolute right-0 mt-40 w-48 bg-white rounded-lg shadow-lg hidden opacity-0 transform scale-95 transition-all duration-300"
    >
        <ul class="list-none">
            <li id="dashboard-nav">
                <a href="dashboard.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-orange-400">
                    <span class="material-icons">&#xe871;</span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li id="account-nav">
                <a href="account.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-orange-400">
                    <span class="material-icons">&#xe853;</span>
                    <span class="menu-text">Account</span>
                </a>
            </li>
            <li id="help-nav">
                <a href="help.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-orange-400">
                    <span class="material-icons">&#xe8fd;</span>
                    <span class="menu-text">Help</span>
                </a>
            </li>
            <li id="logout-nav">
                <a href="log_out.php" class="flex items-center px-4 py-3 space-x-4 text-lg  hover:bg-orange-400">
                    <span class="material-icons">&#xe879;</span>
                    <span class="menu-text">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</div>


</header>




<!-- Sidebar -->
<div class="fixed hidden w-64 h-screen transition-all duration-500 bg-white shadow-lg md:block" id="sidebar">
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
            <a href="dashboard.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-orange-400">
                <span class="material-icons">&#xe871;</span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li id="account-nav">
            <a href="account.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-orange-400">
                <span class="material-icons">&#xe853;</span>
                <span class="menu-text">Account</span>
            </a>
        </li>
        <li id="help-nav">
            <a href="help.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-orange-400">
                <span class="material-icons">&#xe8fd;</span>
                <span class="menu-text">Help</span>
            </a>

        </li>
        <li id="logout-nav">
                <a href="log_out.php" class="flex items-center px-4 py-3 space-x-4 text-lg hover:bg-orange-400">
                    <span class="material-icons">&#xe879;</span>
                    <span class="menu-text">Log Out</span>
                </a>
        </li>
    </ul>
</div>


