<div class="admin-topbar">
    <h1 class="admin-topbar__title">Admins</h1>
    <div class="admin-topbar__actions">
        <span style="font-size:0.85rem;color:var(--a-text-muted);">
            <?= count($admins) ?> account<?= count($admins) !== 1 ? 's' : '' ?>
        </span>
    </div>
</div>

<div class="admin-content">

    <?php if (!empty($flash)): ?>
        <div class="flash flash--<?= $flash['type'] ?>">
            <?= $flash['type'] === 'success' ? '✅' : '⚠️' ?>
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:flex-start;">

        <!-- Admins Table -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3><?= count($admins) ?> Admin Account<?= count($admins) !== 1 ? 's' : '' ?></h3>
            </div>

            <?php if (!empty($admins)): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $a): ?>
                            <tr>
                                <td>
                                    <div style="font-weight:600;color:var(--a-text-dark);">
                                        <?= htmlspecialchars($a->name) ?>
                                        <?php if ((int) $a->id === (int) ($_SESSION['admin_id'] ?? 0)): ?>
                                            <span style="font-size:0.7rem;color:var(--a-text-muted);">(you)</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td style="font-size:0.85rem;"><?= htmlspecialchars($a->email) ?></td>
                                <td>
                                    <span class="badge badge--<?= $a->role ?>">
                                        <?= $a->role === 'super_admin' ? 'Super Admin' : 'Admin' ?>
                                    </span>
                                </td>
                                <td style="font-size:0.8rem;color:var(--a-text-muted);white-space:nowrap;">
                                    <?= date('d M Y', strtotime($a->created_at)) ?>
                                </td>
                                <td>
                                    <?php if ((int) $a->id !== (int) ($_SESSION['admin_id'] ?? 0)): ?>
                                        <form action="<?= URLROOT ?>/admin/deleteadmin/<?= $a->id ?>"
                                              method="POST"
                                              onsubmit="return confirm('Remove this admin account? This cannot be undone.')">
                                            <?= Security::csrfField() ?>
                                            <button type="submit" class="btn-action btn-action--delete">Remove</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="font-size:0.75rem;color:var(--a-text-muted);">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div class="icon">👤</div>
                    <h4>No admins yet</h4>
                </div>
            <?php endif; ?>
        </div>

        <!-- Create Admin Form -->
        <div class="sidebar-panel" style="position:sticky;top:calc(var(--navbar-h) + 2rem);">
            <h4>Add New Admin</h4>

            <form action="<?= URLROOT ?>/admin/newadmin" method="POST">
                <?= Security::csrfField() ?>

                <div class="form-field">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name"
                           value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                </div>

                <div class="form-field">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                </div>

                <div class="form-field">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password"
                           minlength="8" autocomplete="new-password" required>
                    <span class="form-hint">At least 8 characters.</span>
                </div>

                <div class="form-field">
                    <label for="role">Role *</label>
                    <select id="role" name="role">
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                    <span class="form-hint">Super admins can create and remove other admins.</span>
                </div>

                <button type="submit" class="btn-admin btn-admin--primary"
                        style="width:100%;justify-content:center;margin-top:0.5rem;">
                    ➕ Create Admin
                </button>
            </form>
        </div>

    </div>

</div>

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>