<div class="admin-topbar">
    <h1 class="admin-topbar__title">Reviews</h1>
</div>

<div class="admin-content">

    <?php if (!empty($flash)): ?>
        <div class="flash flash--<?= $flash['type'] ?>">
            <?= $flash['type'] === 'success' ? '✅' : '⚠️' ?>
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
    <?php endif; ?>

    <div class="admin-card">
        <div class="admin-card-header">
            <h3><?= count($reviews) ?> Review<?= count($reviews) !== 1 ? 's' : '' ?></h3>
        </div>

        <?php if (!empty($reviews)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Review</th>
                        <th>Photo</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $r): ?>
                        <tr>
                            <td style="font-weight:600;color:var(--a-text-dark);">
                                <?= htmlspecialchars($r->name) ?>
                            </td>
                            <td style="font-size:0.8rem;color:var(--a-text-muted);">
                                <?= htmlspecialchars($r->designation ?? '—') ?>
                            </td>
                            <td>
                                <div class="message-preview" title="<?= htmlspecialchars($r->review) ?>">
                                    <?= htmlspecialchars($r->review) ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($r->image): ?>
                                    <img src="<?= URLROOT ?>/images/reviews/<?= htmlspecialchars($r->image) ?>"
                                         style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                                <?php else: ?>
                                    <span style="color:var(--a-text-muted);font-size:0.8rem;">None</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:0.8rem;color:var(--a-text-muted);">
                                <?= date('d M Y', strtotime($r->created_at)) ?>
                            </td>
                            <td>
                                <span class="badge badge--<?= $r->status === 'approved' ? 'published' : ($r->status === 'rejected' ? 'draft' : 'unread') ?>">
                                    <?= ucfirst($r->status) ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <?php if ($r->status !== 'approved'): ?>
                                        <a href="<?= URLROOT ?>/admin/approvereview/<?= $r->id ?>"
                                           class="btn-action btn-action--edit">Approve</a>
                                    <?php endif; ?>
                                    <?php if ($r->status !== 'rejected'): ?>
                                        <a href="<?= URLROOT ?>/admin/rejectreview/<?= $r->id ?>"
                                           class="btn-action btn-action--delete">Reject</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <div class="icon">⭐</div>
                <h4>No reviews yet</h4>
                <p>Customer reviews will appear here once submitted.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>