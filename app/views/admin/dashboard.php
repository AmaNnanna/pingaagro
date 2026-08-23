<!-- Topbar -->
<div class="admin-topbar">
    <h1 class="admin-topbar__title">Dashboard</h1>
    <div class="admin-topbar__actions">
        <a href="<?= URLROOT ?>/admin/newpost" class="btn-admin btn-admin--primary">
            ✏️ New Post
        </a>
    </div>
</div>

<div class="admin-content">

    <!-- Flash -->
    <?php if (!empty($flash)): ?>
        <div class="flash flash--<?= $flash['type'] ?>">
            <?= $flash['type'] === 'success' ? '✅' : '⚠️' ?>
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
    <?php endif; ?>

    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--green">📝</div>
            <div>
                <div class="stat-card__number"><?= $stats['published'] ?></div>
                <div class="stat-card__label">Published Posts</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--gold">📄</div>
            <div>
                <div class="stat-card__number"><?= $stats['drafts'] ?></div>
                <div class="stat-card__label">Draft Posts</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--gold">⭐</div>
            <div>
                <div class="stat-card__number"><?= $stats['reviews_pending'] ?></div>
                <div class="stat-card__label">Pending Reviews</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--green">📬</div>
            <div>
                <div class="stat-card__number"><?= $stats['contacts_total'] ?></div>
                <div class="stat-card__label">Total Enquiries</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--gold">🔔</div>
            <div>
                <div class="stat-card__number"><?= $stats['contacts_unread'] ?></div>
                <div class="stat-card__label">Unread Messages</div>
            </div>
        </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">

        <!-- Recent Posts -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Recent Posts</h3>
                <a href="<?= URLROOT ?>/admin/posts" class="btn-admin btn-admin--ghost" style="font-size:0.8rem;">View All</a>
            </div>
            <div>
                <?php if (!empty($recentPosts)): ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPosts as $p): ?>
                                <tr>
                                    <td class="td-title">
                                        <a href="<?= URLROOT ?>/admin/editpost/<?= $p->id ?>"
                                            style="color:var(--a-green-dark);">
                                            <?= htmlspecialchars($p->title) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge--<?= $p->status ?>">
                                            <?= ucfirst($p->status) ?>
                                        </span>
                                    </td>
                                    <td style="color:var(--a-text-muted);font-size:0.8rem;">
                                        <?= date('d M Y', strtotime($p->created_at)) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="icon">📝</div>
                        <h4>No posts yet</h4>
                        <p>Create your first post to get started.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Contacts -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Recent Enquiries</h3>
                <a href="<?= URLROOT ?>/admin/contacts" class="btn-admin btn-admin--ghost" style="font-size:0.8rem;">View All</a>
            </div>
            <div>
                <?php if (!empty($recentContacts)): ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentContacts as $c): ?>
                                <tr>
                                    <td>
                                        <div style="font-weight:600;color:var(--a-text-dark);">
                                            <?= htmlspecialchars($c->fullname) ?>
                                        </div>
                                        <div style="font-size:0.75rem;color:var(--a-text-muted);">
                                            <?= htmlspecialchars($c->email) ?>
                                        </div>
                                    </td>
                                    <td style="font-size:0.8rem;">
                                        <?= htmlspecialchars(ucfirst($c->subject ?? 'General')) ?>
                                    </td>
                                    <td>
                                        <span class="badge badge--<?= $c->status ?>">
                                            <?= ucfirst($c->status) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="icon">📬</div>
                        <h4>No enquiries yet</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div><!-- /.dashboard-grid -->

</div><!-- /.admin-content -->

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>