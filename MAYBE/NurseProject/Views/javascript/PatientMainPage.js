document.addEventListener("DOMContentLoaded", function () {
    const profileIcon = document.getElementById('profileIcon');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const darkModeButton = document.getElementById("darkModeBtn");
    const searchInput = document.getElementById("search");
    const cards = document.querySelectorAll(".nurse-card");
    const noResultsMsg = document.getElementById("noNursesMsg");
    const body = document.body;

    const reviewsBtn = document.getElementById('reviewsBtn');
    const reviewsModal = document.getElementById('reviewsModal');
    const closeBtn = document.querySelector('.close');

    if (reviewsBtn && reviewsModal && closeBtn) {
        reviewsBtn.addEventListener('click', function() {
            reviewsModal.style.display = 'block';
        });
        
        closeBtn.addEventListener('click', function() {
            reviewsModal.style.display = 'none';
        });
        
        window.addEventListener('click', function(event) {
            if (event.target == reviewsModal) {
                reviewsModal.style.display = 'none';
            }
        });
    }

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

    const nurseCards = document.querySelectorAll(".nurse-card");
    nurseCards.forEach(card => {
        card.addEventListener("click", () => {
            const name = card.getAttribute("data-name");
            if (name) {
                window.location.href = `/NurseProject/patient/viewProfile/${name}`;
            }
        });
    });
});
