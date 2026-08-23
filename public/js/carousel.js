/**
 * carousel.js — Reviews Carousel
 * Auto-scrolling carousel with dots, arrows, touch + swipe support
 * Loaded on homepage only
 */
document.addEventListener('DOMContentLoaded', function () {

    const track    = document.getElementById('carouselTrack');
    const dotsWrap = document.getElementById('carouselDots');
    const prevBtn  = document.getElementById('prevBtn');
    const nextBtn  = document.getElementById('nextBtn');

    if (!track) return;

    const slides      = track.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length;
    let current       = 0;
    let autoPlayTimer = null;

    function visibleCount() {
        if (window.innerWidth >= 900) return 3;
        if (window.innerWidth >= 600) return 2;
        return 1;
    }

    function maxIndex() {
        return Math.max(0, totalSlides - visibleCount());
    }

    function buildDots() {
        dotsWrap.innerHTML = '';
        const count = maxIndex() + 1;
        for (let i = 0; i < count; i++) {
            const dot = document.createElement('button');
            dot.className = 'carousel-dot' + (i === current ? ' active' : '');
            dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
            dot.addEventListener('click', function () { goTo(i); });
            dotsWrap.appendChild(dot);
        }
    }

    function goTo(index) {
        current = Math.max(0, Math.min(index, maxIndex()));
        const slideWidthPercent = 100 / visibleCount();
        track.style.transform = 'translateX(-' + (current * slideWidthPercent) + '%)';
        dotsWrap.querySelectorAll('.carousel-dot').forEach(function (dot, i) {
            dot.classList.toggle('active', i === current);
        });
    }

    function next() { goTo(current + 1 > maxIndex() ? 0 : current + 1); }
    function prev() { goTo(current - 1 < 0 ? maxIndex() : current - 1); }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayTimer = setInterval(next, 5000);
    }
    function stopAutoPlay() {
        if (autoPlayTimer) clearInterval(autoPlayTimer);
    }

    nextBtn.addEventListener('click', function () { next(); startAutoPlay(); });
    prevBtn.addEventListener('click', function () { prev(); startAutoPlay(); });

    track.addEventListener('mouseenter', stopAutoPlay);
    track.addEventListener('mouseleave', startAutoPlay);

    window.addEventListener('resize', function () { buildDots(); goTo(current); });

    // Swipe support
    let touchStartX = 0;
    track.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoPlay();
    }, { passive: true });
    track.addEventListener('touchend', function (e) {
        const diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 50) { diff > 0 ? next() : prev(); }
        startAutoPlay();
    }, { passive: true });

    buildDots();
    goTo(0);
    startAutoPlay();

});