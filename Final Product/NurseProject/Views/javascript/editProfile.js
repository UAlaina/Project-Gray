document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
    const email = document.getElementById("email");
    const phone = document.getElementById("phone");
    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const dobField = document.getElementById("DOB");

    function validatePassword() {
        let isValid = true;

        if (password.value.length > 0 && password.value.length < 8) {
            password.setCustomValidity("Password must be at least 8 characters.");
            isValid = false;
        } else {
            password.setCustomValidity("");
        }

        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords don't match");
            isValid = false;
        } else {
            confirmPassword.setCustomValidity("");
        }

        return isValid;
    }

    function validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            email.setCustomValidity("Please enter a valid email address");
            return false;
        } else {
            email.setCustomValidity("");
            return true;
        }
    }

    function validatePhone() {
        if (phone) {
            const phoneRegex = /^\d{10,15}$/;
            if (!phoneRegex.test(phone.value.replace(/\D/g, ''))) {
                phone.setCustomValidity("Please enter a valid phone number (10-15 digits)");
                return false;
            } else {
                phone.setCustomValidity("");
                return true;
            }
        }
        return true;
    }

    function validateName(nameField) {
        const nameRegex = /^[A-Za-z\s'-]+$/;
        if (!nameRegex.test(nameField.value)) {
            nameField.setCustomValidity("Name must only contain letters, spaces, apostrophes, or dashes.");
            return false;
        } else {
            nameField.setCustomValidity("");
            return true;
        }
    }

    function validateDOB() {
        if (!dobField || !dobField.value) return true;

        const dob = new Date(dobField.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        if (age < 18) {
            dobField.setCustomValidity("You must be at least 18 years old.");
            return false;
        } else {
            dobField.setCustomValidity("");
            return true;
        }
    }

    if (password && confirmPassword) {
        password.addEventListener("change", validatePassword);
        confirmPassword.addEventListener("keyup", validatePassword);
    }

    if (email) {
        email.addEventListener("blur", validateEmail);
    }

    if (phone) {
        phone.addEventListener("blur", validatePhone);
    }

    if (firstName) {
        firstName.addEventListener("blur", function () {
            validateName(firstName);
        });
    }

    if (lastName) {
        lastName.addEventListener("blur", function () {
            validateName(lastName);
        });
    }

    if (dobField) {
        dobField.addEventListener("blur", validateDOB);
    }

    if (form) {
        form.addEventListener("submit", function(event) {
            let isValid = true;

            if (password && password.value !== "") {
                isValid = validatePassword() && isValid;
            }

            if (email) {
                isValid = validateEmail() && isValid;
            }

            if (phone) {
                isValid = validatePhone() && isValid;
            }

            if (firstName) {
                isValid = validateName(firstName) && isValid;
            }

            if (lastName) {
                isValid = validateName(lastName) && isValid;
            }

            if (dobField) {
                isValid = validateDOB() && isValid;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    const deleteBtn = document.getElementById("deleteAccountBtn");
    const confirmationModal = document.getElementById("confirmationModal");
    const confirmDelete = document.getElementById("confirmDelete");
    const cancelDelete = document.getElementById("cancelDelete");
    const deleteForm = document.getElementById("deleteAccountForm");

    if (deleteBtn) {
        deleteBtn.addEventListener("click", function(e) {
            e.preventDefault();
            confirmationModal.style.display = "block";
        });
    }

    if (cancelDelete) {
        cancelDelete.addEventListener("click", function() {
            confirmationModal.style.display = "none";
        });
    }

    if (confirmDelete && deleteForm) {
        confirmDelete.addEventListener("click", function() {
            deleteForm.submit();
        });
    }

    window.addEventListener("click", function(event) {
        if (event.target === confirmationModal) {
            confirmationModal.style.display = "none";
        }
    });

    const body = document.body;
    const darkModeButton = document.getElementById("darkModeBtn");

    if (body.classList.contains("dark-mode-active")) {
        document.querySelector(".form-container").classList.add("dark-mode");
    }

    if (darkModeButton) {
        darkModeButton.addEventListener("click", function() {
            body.classList.toggle("dark-mode-active");
            document.querySelector(".form-container").classList.toggle("dark-mode");
        });
    }

    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        function autoResize() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        }

        textarea.addEventListener('input', autoResize);
        autoResize.call(textarea);
    });
});