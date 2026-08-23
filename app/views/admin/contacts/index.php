<!-- Topbar -->
<div class="admin-topbar">
    <h1 class="admin-topbar__title">Contact Submissions</h1>
    <div class="admin-topbar__actions">
        <span style="font-size:0.85rem;color:var(--a-text-muted);">
            <?= count(array_filter((array)$contacts, fn($c) => $c->status === 'unread')) ?> unread
        </span>
    </div>
</div>

<div class="admin-content">

    <div class="admin-card">
        <div class="admin-card-header">
            <h3><?= count($contacts) ?> Submission<?= count($contacts) !== 1 ? 's' : '' ?></h3>
        </div>

        <?php if (!empty($contacts)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Type</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $c): ?>
                        <tr style="<?= $c->status === 'unread' ? 'background:#FAFFFE;' : '' ?>">
                            <td>
                                <div style="font-weight:600;color:var(--a-text-dark);">
                                    <?= htmlspecialchars($c->fullname) ?>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:0.8rem;">
                                    <a href="mailto:<?= htmlspecialchars($c->email) ?>"
                                       style="color:var(--a-green-dark);">
                                        <?= htmlspecialchars($c->email) ?>
                                    </a>
                                </div>
                                <?php if (!empty($c->phone)): ?>
                                    <div style="font-size:0.75rem;color:var(--a-text-muted);">
                                        <?= htmlspecialchars($c->phone) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:0.85rem;">
                                <?= htmlspecialchars(ucfirst($c->subject ?? 'General')) ?>
                            </td>
                            <td>
                                <div class="message-preview" title="<?= htmlspecialchars($c->message) ?>">
                                    <?= htmlspecialchars($c->message) ?>
                                </div>
                            </td>
                            <td style="font-size:0.8rem;color:var(--a-text-muted);white-space:nowrap;">
                                <?= date('d M Y', strtotime($c->created_at)) ?><br>
                                <span style="font-size:0.72rem;"><?= date('H:i', strtotime($c->created_at)) ?></span>
                            </td>
                            <td>
                                <span class="badge badge--<?= $c->status ?>">
                                    <?= ucfirst($c->status) ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="mailto:<?= htmlspecialchars($c->email) ?>?subject=Re: Your enquiry to Pinga Agro"
                                       class="btn-action btn-action--edit">Reply</a>
                                    <?php if ($c->status === 'unread'): ?>
                                        <a href="<?= URLROOT ?>/admin/readcontact/<?= $c->id ?>"
                                           class="btn-action btn-action--read">Mark Read</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <div class="empty-state">
                <div class="icon">📬</div>
                <h4>No submissions yet</h4>
                <p>Contact form submissions will appear here.</p>
            </div>
        <?php endif; ?>

    </div>

</div>

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>