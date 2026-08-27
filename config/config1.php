<?php
// ── Environment ────────────────────────────────────────────
define('ENVIRONMENT', 'production');

// ── Session Security ─────────────────────────────────────────
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => ENVIRONMENT === 'production',
    'httponly' => true,
    'samesite' => 'Strict',
]);

ini_set('session.use_strict_mode',  1);
ini_set('session.use_only_cookies', 1);

// ── URLs ───────────────────────────────────────────────────
define('URLROOT', 'https://new.pingaagro.com');
define('SITENAME', 'Pinga Agro Investment Limited');
define('RC_NUMBER',  'RC 1322122');
define('PHONE',      ''); // awaiting from client
define('EMAIL',      ''); // awaiting from client
define('WHATSAPP',   ''); // awaiting from client
define('ADDRESS_1',  'Mile 2 Ahani, Oji River LGA, Enugu State');
define('ADDRESS_2',  'Akpugoeze-Ufuma Road, Ufuma, Anambra State');

// ── Database ───────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'pingaagr_axehrazdb');
define('DB_PASS', 'YlD7$#im!');
define('DB_NAME', 'pingaagr_axehrazdb');

// ── Video ───────────────────────────────────────────────────
define('YOUTUBE_EMBED_URL', 'https://www.youtube.com/embed/Rufv0ew0u_w');

// ── Email ──────────────────────────────────────────────────
define('ADMIN_EMAIL', 'info@pingaagro.com');
define('FROM_EMAIL',  'noreply@pingaagro.com');
define('FROM_NAME',   'Pinga Agro Ltd');

// ── Error Display ──────────────────────────────────────────
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ── Security Headers ────────────────────────────────────────
if (ENVIRONMENT === 'production') {

    header('X-Frame-Options: SAMEORIGIN');

    header('X-Content-Type-Options: nosniff');

    header('Referrer-Policy: strict-origin-when-cross-origin');

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

    header_remove('X-Powered-By');
}