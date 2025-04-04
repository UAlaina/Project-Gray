document.getElementById('profileIcon').addEventListener('click', function () {
    const dropdownMenu = document.getElementById('dropdownMenu');
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
});

window.addEventListener('click', function (event) {
    if (!event.target.closest('.profile-icon')) {
        document.getElementById('dropdownMenu').style.display = 'none';
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const darkModeButton = document.querySelector(".dark-mode");
    const body = document.body;

    darkModeButton.addEventListener("click", function () {
        body.classList.toggle("dark-mode-active");

        if (body.classList.contains("dark-mode-active")) {
            darkModeButton.textContent = "Light Mode";
        } else {
            darkModeButton.textContent = "Dark Mode";
        }
    });
});
