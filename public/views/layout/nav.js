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

// Toggle dropdown visibility
function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden', 'opacity-0', 'scale-95');
        dropdown.classList.add('opacity-100', 'scale-100');
    } else {
        dropdown.classList.add('opacity-0', 'scale-95');
        dropdown.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 300); // Matches the transition duration
    }
}

// Close the dropdown if the user clicks outside
window.addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdownMenu');
    const menuButton = document.getElementById('menuButton');

    // Check if the click is outside the dropdown or the menu button
    if (!dropdown.contains(event.target) && !menuButton.contains(event.target)) {
        // Close the dropdown if clicked outside
        if (!dropdown.classList.contains('hidden')) {
            dropdown.classList.add('opacity-0', 'scale-95');
            dropdown.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 300); // Match the transition duration
        }
    }
});
