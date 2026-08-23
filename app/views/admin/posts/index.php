<!-- Topbar -->
<div class="admin-topbar">
    <h1 class="admin-topbar__title">All Posts</h1>
    <div class="admin-topbar__actions">
        <a href="<?= URLROOT ?>/admin/newpost" class="btn-admin btn-admin--primary">
            ✏️ New Post
        </a>
    </div>
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
            <h3><?= count($posts) ?> Post<?= count($posts) !== 1 ? 's' : '' ?></h3>
        </div>

        <?php if (!empty($posts)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td class="td-title">
                                <?= htmlspecialchars($post->title) ?>
                                <div style="font-size:0.75rem;color:var(--a-text-muted);margin-top:2px;">
                                    /insights/post/<?= htmlspecialchars($post->slug) ?>
                                </div>
                            </td>
                            <td style="font-size:0.85rem;">
                                <?= htmlspecialchars($post->category_name ?? '—') ?>
                            </td>
                            <td>
                                <span class="badge badge--<?= $post->status ?>">
                                    <?= ucfirst($post->status) ?>
                                </span>
                            </td>
                            <td style="font-size:0.8rem;color:var(--a-text-muted);">
                                <?= date('d M Y', strtotime($post->created_at)) ?>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= URLROOT ?>/admin/editpost/<?= $post->id ?>"
                                        class="btn-action btn-action--edit">Edit</a>

                                    <form action="<?= URLROOT ?>/admin/deletepost/<?= $post->id ?>"
                                        method="POST"
                                        onsubmit="return confirm('Delete \'<?= htmlspecialchars(addslashes($post->title)) ?>\'? This cannot be undone.')">
                                        <?= Security::csrfField() ?>
                                        <button type="submit" class="btn-action btn-action--delete">Delete</button>
                                    </form>

                                    <?php if ($post->status === 'published'): ?>
                                        <a href="<?= URLROOT ?>/insights/post/<?= $post->slug ?>"
                                            target="_blank"
                                            class="btn-action btn-action--read">View</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <div class="empty-state" style="padding:3rem;">
                <div class="icon">📝</div>
                <h4>No posts yet</h4>
                <p>Create your first Insight post to get started.</p>
                <a href="<?= URLROOT ?>/admin/newpost"
                    class="btn-admin btn-admin--primary"
                    style="margin-top:1rem;display:inline-flex;">
                    ✏️ Write First Post
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>