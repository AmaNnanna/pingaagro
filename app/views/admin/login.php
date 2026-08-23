<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= URLROOT ?>/css/admin.css">
</head>

<body>

    <div class="admin-login-page">
        <div class="login-card">

            <div class="login-card__logo">
                <img src="<?= URLROOT ?>/images/logo.png" alt="Pinga Agro">
                <p>Admin Panel</p>
            </div>

            <?php if (isset($_GET['reason']) && $_GET['reason'] === 'timeout'): ?>
                <div class="login-error">
                    ⏱️ Your session expired due to inactivity. Please log in again.
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="login-error">⚠️ <?= Security::escape($error) ?></div>
            <?php endif; ?>

            <?php if ($locked): ?>
                <div class="login-error">
                    🔒 Too many failed attempts. Please wait
                    <strong><?= $waitMins ?> minute<?= $waitMins !== 1 ? 's' : '' ?></strong>
                    before trying again.
                </div>
            <?php else: ?>

                <form action="<?= URLROOT ?>/admin/login" method="POST">
                    <div class="form-field">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                            placeholder="admin@pingaagro.com"
                            autocomplete="email" required>
                    </div>
                    <div class="form-field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"
                            placeholder="••••••••••"
                            autocomplete="current-password" required>
                    </div>
                    <button type="submit" class="login-btn">Sign In to Admin Panel</button>
                </form>

            <?php endif; ?>



            <p style="text-align:center;margin-top:1.5rem;font-size:0.75rem;color:#aaa;">
                <a href="<?= URLROOT ?>/" style="color:#aaa;">← Return to website</a>
            </p>

        </div>
    </div>

</body>

</html>