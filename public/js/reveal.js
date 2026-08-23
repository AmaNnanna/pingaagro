/**
 * reveal.js — Scroll Reveal Animations
 * Any element with class="reveal" fades in on scroll
 * Loaded on every page
 */
document.addEventListener('DOMContentLoaded', function () {

    const revealEls = document.querySelectorAll('.reveal');

    if (!revealEls.length) return;

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        revealEls.forEach(function (el) { observer.observe(el); });

    } else {
        // Fallback for older browsers
        revealEls.forEach(function (el) { el.classList.add('visible'); });
    }

});