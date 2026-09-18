<?php
require_once __DIR__ . '/../app/core/Env.php';
Env::load(__DIR__ . '/../.env');

define('ENVIRONMENT', getenv('APP_ENV') ?: 'development');

// ... session code stays the same ...

define('URLROOT',   getenv('URLROOT')   ?: 'http://pingaagro.test');
define('SITENAME',  'Pinga Agro Investment Limited');
define('RC_NUMBER', 'RC 1322122');
define('PHONE',     getenv('PHONE')     ?: '+234 701 197 2420');
define('EMAIL',     getenv('EMAIL')     ?: 'info@pingaagro.com');
define('WHATSAPP',  getenv('WHATSAPP')  ?: '');
define('ADDRESS_1', 'Mile 2 Ahani, Oji River LGA, Enugu State');
define('ADDRESS_2', 'Akpugoeze-Ufuma Road, Ufuma, Anambra State');

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'pingaagro');

define('YOUTUBE_EMBED_URL', 'https://www.youtube.com/embed/Rufv0ew0u_w');

define('ADMIN_EMAIL', getenv('ADMIN_EMAIL') ?: 'info@pingaagro.com');
define('FROM_EMAIL',  getenv('FROM_EMAIL')  ?: 'noreply@pingaagro.com');
define('FROM_NAME',   'Pinga Agro Ltd');

// rest of the file (error display + security headers) stays exactly as it is