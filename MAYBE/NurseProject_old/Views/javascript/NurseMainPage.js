document.addEventListener("DOMContentLoaded", function () {
    const profileIcon = document.getElementById('profileIcon');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const darkModeButton = document.getElementById("darkModeBtn");
    const searchInput = document.getElementById("search");
    const cards = document.querySelectorAll(".patient-card");
    const noResultsMsg = document.getElementById("noNursesMsg");
    const body = document.body;
    
    // Reviews modal elements and functionality
    const reviewsBtn = document.getElementById('reviewsBtn');
    const reviewsModal = document.getElementById('reviewsModal');
    const closeBtn = document.querySelector('.close');
    
    // Check if we have all the elements needed for the reviews modal
    if (reviewsBtn && reviewsModal && closeBtn) {
        // Show modal when reviews button is clicked
        reviewsBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default link behavior
            reviewsModal.style.display = 'block';
        });
        
        // Close modal when X is clicked
        closeBtn.addEventListener('click', function() {
            reviewsModal.style.display = 'none';
        });
        
        // Close modal when clicking outside the modal content
        window.addEventListener('click', function(event) {
            if (event.target == reviewsModal) {
                reviewsModal.style.display = 'none';
            }
        });
    } else {
        console.error("Reviews modal elements not found");
    }

    // Profile dropdown functionality
    if (profileIcon && dropdownMenu) {
        profileIcon.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        window.addEventListener('click', function (event) {
            if (!event.target.closest('.profile-icon')) {
                dropdownMenu.style.display = 'none';
            }
        });
    }

    // Dark mode toggle
    if (darkModeButton) {
        darkModeButton.addEventListener("click", function () {
            body.classList.toggle("dark-mode-active");
            darkModeButton.textContent = body.classList.contains("dark-mode-active") ? "Light Mode" : "Dark Mode";
        });
    }

    // Search functionality
    if (searchInput) {
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

        searchInput.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
        });
    }
    
    // Patient card click event - supports both URL formats
    const patientCards = document.querySelectorAll(".patient-card");
    patientCards.forEach(card => {
        card.addEventListener("click", () => {
            const name = card.getAttribute("data-name");
            if (name) {
                // Detect if we're using modern routing or traditional query parameters
                const usingModernRouting = document.querySelector('a[href*="/NurseProject/"]') !== null;
                
                if (usingModernRouting) {
                    window.location.href = `/NurseProject/nurse/viewProfile/${name}`;
                } else {
                    window.location.href = `index.php?controller=nurse&action=viewProfile&name=${name}`;
                }
            }
        });
    });
});