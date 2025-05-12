// document.addEventListener("DOMContentLoaded", function() {
//     const form = document.querySelector("form");
//     const password = document.getElementById("password");
//     const confirmPassword = document.getElementById("confirm_password");
//     const email = document.getElementById("email");
//     const phone = document.getElementById("phone");
    
//     function validatePassword() {
//         if (password.value !== confirmPassword.value) {
//             confirmPassword.setCustomValidity("Passwords don't match");
//             return false;
//         } else {
//             confirmPassword.setCustomValidity("");
//             return true;
//         }
//     }
    
//     function validateEmail() {
//         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//         if (!emailRegex.test(email.value)) {
//             email.setCustomValidity("Please enter a valid email address");
//             return false;
//         } else {
//             email.setCustomValidity("");
//             return true;
//         }
//     }
    
//     function validatePhone() {
//         const phoneRegex = /^\d{10,15}$/;
//         if (!phoneRegex.test(phone.value.replace(/\D/g, ''))) {
//             phone.setCustomValidity("Please enter a valid phone number (10-15 digits)");
//             return false;
//         } else {
//             phone.setCustomValidity("");
//             return true;
//         }
//     }
    
//     if (password && confirmPassword) {
//         password.addEventListener("change", validatePassword);
//         confirmPassword.addEventListener("keyup", validatePassword);
//     }
    
//     if (email) {
//         email.addEventListener("blur", validateEmail);
//     }
    
//     if (phone) {
//         phone.addEventListener("blur", validatePhone);
//     }
    
//     if (form) {
//         form.addEventListener("submit", function(event) {
//             let isValid = true;
            
//             if (password.value !== "") {
//                 isValid = validatePassword() && isValid;
//             }
            
//             isValid = validateEmail() && isValid;
//             isValid = validatePhone() && isValid;
            
//             if (!isValid) {
//                 event.preventDefault();
//             }
//         });
//     }
    
//     const deleteBtn = document.getElementById("deleteAccountBtn");
//     const confirmationModal = document.getElementById("confirmationModal");
//     const confirmDelete = document.getElementById("confirmDelete");
//     const cancelDelete = document.getElementById("cancelDelete");
//     const deleteForm = document.getElementById("deleteAccountForm");

//     if (deleteBtn) {
//         deleteBtn.addEventListener("click", function() {
//             confirmationModal.style.display = "block";
//         });
//     }

//     if (cancelDelete) {
//         cancelDelete.addEventListener("click", function() {
//             confirmationModal.style.display = "none";
//         });
//     }

//     if (confirmDelete) {
//         confirmDelete.addEventListener("click", function() {
//             deleteForm.submit();
//         });
//     }

//     window.addEventListener("click", function(event) {
//         if (event.target === confirmationModal) {
//             confirmationModal.style.display = "none";
//         }
//     });
    
//     const body = document.body;
//     const darkModeButton = document.getElementById("darkModeBtn");
    
//     if (body.classList.contains("dark-mode-active")) {
//         document.querySelector(".form-container").classList.add("dark-mode");
//     }
    
//     if (darkModeButton) {
//         darkModeButton.addEventListener("click", function() {
//             body.classList.toggle("dark-mode-active");
//             document.querySelector(".form-container").classList.toggle("dark-mode");
//         });
//     }

//     const textareas = document.querySelectorAll('textarea');
//     textareas.forEach(textarea => {
//         function autoResize() {
//             this.style.height = 'auto';
//             this.style.height = this.scrollHeight + 'px';
//         }
        
//         textarea.addEventListener('input', autoResize);
//         autoResize.call(textarea);
//     });
// });


document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
    const email = document.getElementById("email");
    const phone = document.getElementById("phone");
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords don't match");
            return false;
        } else {
            confirmPassword.setCustomValidity("");
            return true;
        }
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