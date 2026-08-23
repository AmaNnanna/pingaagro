<?php

// ── Environment ────────────────────────────────────────────
define('ENVIRONMENT', 'development');

// ── Session Security ─────────────────────────────────────────
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => ENVIRONMENT === 'production',
    'httponly' => true,
    'samesite' => 'Strict',
]);

// Keep these two — they are not covered by session_set_cookie_params
ini_set('session.use_strict_mode',  1);
ini_set('session.use_only_cookies', 1);

// ── URLs ───────────────────────────────────────────────────
define('URLROOT', 'http://pingaagro.test');
define('SITENAME', 'Pinga Agro Investment Limited');

// ── Database ───────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pingaagro');

// ── Video ───────────────────────────────────────────────────
define('YOUTUBE_EMBED_URL', 'https://www.youtube.com/embed/Rufv0ew0u_w');

// ── Email ──────────────────────────────────────────────────
define('ADMIN_EMAIL', 'info@pingaagro.com');
define('FROM_EMAIL',  'noreply@pingaagro.com');
define('FROM_NAME',   'Pinga Agro Website');

// ── Error Display ──────────────────────────────────────────
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ── Security Headers ────────────────────────────────────────
// These headers tell the browser how to behave when rendering your pages.
// They are sent with every response.

if (ENVIRONMENT === 'production') {

    // Prevent your site being embedded in iframes — blocks clickjacking
    header('X-Frame-Options: SAMEORIGIN');

    // Prevent browsers guessing content type — blocks MIME sniffing attacks
    header('X-Content-Type-Options: nosniff');

    // Control referrer information sent to other sites
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // Force HTTPS for 1 year — browsers will refuse to load the site over HTTP
    // Only enable this when you are certain HTTPS is working correctly
    // header('Strict-Transport-Security: max-age=31536000; includeSubDomains');

    // Content Security Policy — tells the browser which sources are trusted
    // This is the most powerful XSS defence available
    header(
        "Content-Security-Policy: "
            . "default-src 'self'; "
            . "script-src 'self' 'unsafe-inline' https://cdn.quilljs.com https://fonts.googleapis.com; "
            . "style-src 'self' 'unsafe-inline' https://cdn.quilljs.com https://fonts.googleapis.com https://fonts.gstatic.com; "
            . "font-src 'self' https://fonts.gstatic.com; "
            . "img-src 'self' data:; "
            . "frame-src https://www.youtube.com; "
            . "connect-src 'self';"
    );

    // Remove PHP version from headers
    header_remove('X-Powered-By');
}
