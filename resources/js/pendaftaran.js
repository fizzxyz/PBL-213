import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Form validation and animations
document
    .getElementById("registerForm")
    .addEventListener("submit", function (e) {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById(
            "password_confirmation"
        ).value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert("Password dan konfirmasi password tidak cocok!");
            return false;
        }

        // Add loading animation to button
        const submitBtn = this.querySelector(".register-btn");
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML =
            '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Creating Account...';
        submitBtn.disabled = true;

        // Simulate form submission delay (remove in production)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });

// Add focus animations to form inputs
const inputs = document.querySelectorAll("input");
inputs.forEach((input) => {
    input.addEventListener("focus", function () {
        this.parentElement.style.transform = "scale(1.02)";
    });

    input.addEventListener("blur", function () {
        this.parentElement.style.transform = "scale(1)";
    });
});

// Phone number formatting
document.getElementById("phone").addEventListener("input", function (e) {
    let value = e.target.value.replace(/\D/g, "");
    if (value.startsWith("0")) {
        value = "+62" + value.substring(1);
    } else if (!value.startsWith("+62") && value.length > 0) {
        value = "+62" + value;
    }
    e.target.value = value;
});
