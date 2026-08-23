/**
 * app.js — Core UI
 * Navbar scroll effect + mobile menu toggle
 * Loaded on every page
 */
document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile Menu Toggle ─────────────────────────────────
    const toggle     = document.getElementById('navToggle');
    const mobileMenu = document.getElementById('mobileMenu');

    if (toggle && mobileMenu) {
        toggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('open');
            toggle.classList.toggle('active');
        });
    }

    // ── Navbar shadow on scroll ────────────────────────────
    const navbar = document.getElementById('navbar');

    if (navbar) {
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });
    }

});