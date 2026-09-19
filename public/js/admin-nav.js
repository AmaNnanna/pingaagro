document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('adminHamburger');
    const sidebar   = document.getElementById('adminSidebar');
    const overlay   = document.getElementById('adminSidebarOverlay');

    if (!hamburger || !sidebar || !overlay) return;

    function openSidebar() {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-visible');
        hamburger.classList.add('is-active');
        hamburger.setAttribute('aria-expanded', 'true');
        document.body.classList.add('admin-no-scroll');
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        hamburger.classList.remove('is-active');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('admin-no-scroll');
    }

    hamburger.addEventListener('click', function () {
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSidebar();
    });

    // If the window is resized back up to desktop, clear the mobile state
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) closeSidebar();
    });
});