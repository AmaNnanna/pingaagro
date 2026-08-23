<?php
// ── Environment ────────────────────────────────────────────
define('ENVIRONMENT', 'server'); // Change to 'development' for local development

// ── URLs ───────────────────────────────────────────────────
define('URLROOT', 'https://new.pingaagro.com');
define('SITENAME', 'Pinga Agro Investment Limited');

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
define('FROM_NAME',   'Pinga Agro Website');

// ── Error Display ──────────────────────────────────────────
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}