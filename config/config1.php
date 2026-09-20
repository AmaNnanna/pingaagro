<?php

require_once __DIR__ . '/../app/core/Env.php';
Env::load(__DIR__ . '/../.env');

// ── Environment ────────────────────────────────────────────
define('ENVIRONMENT', getenv('APP_ENV'));

// ── Error Display ──────────────────────────────────────────
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

$logDir = BASEPATH . 'logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

ini_set('log_errors', 1);
ini_set('error_log', $logDir . '/error_log');

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
define('URLROOT', getenv('URLROOT'));
define('SITENAME', 'Pinga Agro Investment Limited');
define('RC_NUMBER',  'RC 1322122');
define('PHONE',    getenv('PHONE'));
define('EMAIL',    getenv('EMAIL'));
define('WHATSAPP', getenv('WHATSAPP'));
define('ADDRESS_1',  'Mile 2 Ahani, Oji River LGA, Enugu State');
define('ADDRESS_2',  'Akpugoeze-Ufuma Road, Ufuma, Anambra State');

// ── Database ───────────────────────────────────────────────
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));

// ── Video ───────────────────────────────────────────────────
define('YOUTUBE_EMBED_URL', 'https://www.youtube.com/embed/Rufv0ew0u_w');

// ── Email ──────────────────────────────────────────────────
define('ADMIN_EMAIL', getenv('ADMIN_EMAIL'));
define('FROM_EMAIL', getenv('FROM_EMAIL'));
define('FROM_NAME',   'Pinga Agro Ltd');

// ── Security Headers ────────────────────────────────────────
if (ENVIRONMENT === 'production') {

    header('X-Frame-Options: SAMEORIGIN');

    header('X-Content-Type-Options: nosniff');

    header('Referrer-Policy: strict-origin-when-cross-origin');

    header(
        "Content-Security-Policy: "
            . "default-src 'self'; "
            . "script-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.gstatic.com; "
            . "font-src 'self' https://fonts.gstatic.com; "
            . "img-src 'self' data:; "
            . "frame-src https://www.youtube.com https://player.vimeo.com; "
            . "connect-src 'self';"
    );

    header_remove('X-Powered-By');
}
