<?php
/**
 * public/bootstrap-admin.php — ONE-TIME use.
 * Creates the first super admin. Refuses to run again once one exists.
 * DELETE THIS FILE after you've used it.
 */

define('BASEPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APPPATH',  BASEPATH . 'app' . DIRECTORY_SEPARATOR);

require_once BASEPATH . 'config/config.php';
require_once APPPATH . 'core/Database.php';

// Change this secret before using, or set BOOTSTRAP_SECRET in your .env
$secret = getenv('BOOTSTRAP_SECRET') ?: 'New-Super-Admin-Secret-2026';

if (($_GET['key'] ?? $_POST['key'] ?? '') !== $secret) {
    http_response_code(403);
    die('Forbidden. Pass the correct ?key=... to use this script.');
}

$pdo = Database::getInstance()->getPdo();

$existing = $pdo->query("SELECT COUNT(*) FROM admin_users WHERE role = 'super_admin'")->fetchColumn();

if ($existing > 0) {
    die('A super admin already exists. Use /admin/newadmin instead, and delete this file.');
}

$error   = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare(
            'INSERT INTO admin_users (name, email, password, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$name, $email, $hash, 'super_admin']);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bootstrap Super Admin</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 420px; margin: 4rem auto; padding: 0 1rem; }
        h1 { font-size: 1.25rem; }
        label { display: block; margin-top: 1rem; font-weight: 600; font-size: 0.9rem; }
        input { width: 100%; padding: 0.5rem; margin-top: 0.25rem; box-sizing: border-box; }
        button { margin-top: 1.5rem; padding: 0.6rem 1.2rem; cursor: pointer; }
        .error { color: #b91c1c; margin-top: 1rem; }
        .success { color: #15803d; margin-top: 1rem; }
    </style>
</head>
<body>
    <h1>Create the first Super Admin</h1>

    <?php if ($success): ?>
        <p class="success">
            ✅ Super admin created. You can now log in at
            <a href="<?= htmlspecialchars(URLROOT) ?>/admin/login">/admin/login</a>.
        </p>
        <p><strong>Now delete this file (public/bootstrap-admin.php) from the server.</strong></p>
    <?php else: ?>
        <?php if ($error): ?><p class="error">⚠️ <?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="POST">
            <input type="hidden" name="key" value="<?= htmlspecialchars($_GET['key'] ?? '') ?>">
            <label for="name">Full name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" minlength="8" required>

            <button type="submit">Create Super Admin</button>
        </form>
    <?php endif; ?>
</body>
</html>