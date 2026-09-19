<div class="admin-topbar">
    <h1 class="admin-topbar__title">My Account</h1>
</div>

<div class="admin-content">

    <?php if (!empty($flash)): ?>
        <div class="flash flash--<?= $flash['type'] ?>">
            <?= $flash['type'] === 'success' ? '✅' : '⚠️' ?>
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
    <?php endif; ?>

    <div class="admin-card" style="max-width:420px;">
        <div class="admin-card-header">
            <h3>Change Password</h3>
        </div>

        <div class="admin-card-body" style="padding:1.25rem;">
            <p style="font-size:0.85rem;color:var(--a-text-muted);margin-bottom:1rem;">
                Signed in as <strong><?= htmlspecialchars($_SESSION['admin_name']  ?? '') ?></strong>
                (<?= htmlspecialchars($_SESSION['admin_email'] ?? '') ?>)
                &middot;
                <?= ($_SESSION['admin_role'] ?? 'admin') === 'super_admin' ? 'Super Admin' : 'Admin' ?>
            </p>

            <form action="<?= URLROOT ?>/admin/updatepassword" method="POST">
                <?= Security::csrfField() ?>

                <div class="form-field">
                    <label for="current_password">Current Password *</label>
                    <input type="password" id="current_password" name="current_password"
                           autocomplete="current-password" required>
                </div>

                <div class="form-field">
                    <label for="new_password">New Password *</label>
                    <input type="password" id="new_password" name="new_password"
                           minlength="8" autocomplete="new-password" required>
                    <span class="form-hint">At least 8 characters.</span>
                </div>

                <div class="form-field">
                    <label for="confirm_password">Confirm New Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password"
                           minlength="8" autocomplete="new-password" required>
                </div>

                <button type="submit" class="btn-admin btn-admin--primary"
                        style="width:100%;justify-content:center;margin-top:0.5rem;">
                    🔒 Update Password
                </button>
            </form>
        </div>
    </div>

</div>

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>