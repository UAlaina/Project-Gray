document.addEventListener("DOMContentLoaded", function () {
    const profileIcon = document.getElementById('profileIcon');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const darkModeButton = document.getElementById("darkModeBtn");
    const searchInput = document.getElementById("search");
    const cards = document.querySelectorAll(".patient-card");
    const noResultsMsg = document.getElementById("noNursesMsg");
    const body = document.body;

    profileIcon.addEventListener('click', function (event) {
        event.stopPropagation();
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function (event) {
        if (!event.target.closest('.profile-icon')) {
            dropdownMenu.style.display = 'none';
        }
    });

    darkModeButton.addEventListener("click", function () {
        body.classList.toggle("dark-mode-active");
        darkModeButton.textContent = body.classList.contains("dark-mode-active") ? "Light Mode" : "Dark Mode";
    });

    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
        }
    });

    searchInput.addEventListener("input", function () {
        const query = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.dataset.name?.toLowerCase();
            if (name && name.includes(query)) {
                card.style.display = "block";
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });

        if (noResultsMsg) {
            noResultsMsg.style.display = visibleCount === 0 ? "block" : "none";
        }
    });
});
