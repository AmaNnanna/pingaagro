<!-- Quill CSS -->
<link href="<?= URLROOT ?>/vendor/quill/quill.snow.css" rel="stylesheet">

<!-- Topbar -->
<div class="admin-topbar">
    <h1 class="admin-topbar__title">Edit Post</h1>
    <div class="admin-topbar__actions">
        <?php if ($post->status === 'published'): ?>
            <a href="<?= URLROOT ?>/insights/post/<?= $post->slug ?>"
                target="_blank"
                class="btn-admin btn-admin--ghost">🌐 View Live</a>
        <?php endif; ?>
        <a href="<?= URLROOT ?>/admin/posts" class="btn-admin btn-admin--ghost">← Back to Posts</a>
    </div>
</div>

<div class="admin-content">

    <?php if (!empty($errors['general'])): ?>
        <div class="flash flash--error">⚠️ <?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <form action="<?= URLROOT ?>/admin/editpost/<?= $post->id ?>" method="POST" id="postForm">
        <?= Security::csrfField() ?>

        <div class="admin-form-grid">

            <!-- ── Main Column ──────────────────────────── -->
            <div>

                <div class="form-field <?= !empty($errors['title']) ? 'form-field--error' : '' ?>">
                    <label for="title">Post Title *</label>
                    <input type="text" id="title" name="title"
                        value="<?= htmlspecialchars($post->title) ?>"
                        placeholder="Enter a clear, compelling title…">
                    <?php if (!empty($errors['title'])): ?>
                        <span class="form-error"><?= htmlspecialchars($errors['title']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-field <?= !empty($errors['slug']) ? 'form-field--error' : '' ?>">
                    <label for="slug">Slug (URL) *</label>
                    <input type="text" id="slug" name="slug"
                        value="<?= htmlspecialchars($post->slug) ?>">
                    <span class="form-hint">
                        Preview: <?= URLROOT ?>/insights/post/<strong id="slugPreview"><?= htmlspecialchars($post->slug) ?></strong>
                    </span>
                    <?php if (!empty($errors['slug'])): ?>
                        <span class="form-error"><?= htmlspecialchars($errors['slug']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="excerpt">Excerpt</label>
                    <textarea id="excerpt" name="excerpt" rows="3"><?= htmlspecialchars($post->excerpt ?? '') ?></textarea>
                </div>

                <div class="form-field <?= !empty($errors['body']) ? 'form-field--error' : '' ?>">
                    <label>Post Content *</label>
                    <div id="editor"></div>
                    <textarea id="body" name="body" style="display:none;"><?= htmlspecialchars($post->body) ?></textarea>
                    <?php if (!empty($errors['body'])): ?>
                        <span class="form-error" style="margin-top:0.5rem;display:block;">
                            <?= htmlspecialchars($errors['body']) ?>
                        </span>
                    <?php endif; ?>
                </div>

            </div>

            <!-- ── Sidebar Column ────────────────────────── -->
            <div class="form-sidebar">

                <div class="sidebar-panel">
                    <h4>Publish</h4>
                    <div class="form-field">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="draft" <?= ($post->status === 'draft')     ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= ($post->status === 'published') ? 'selected' : '' ?>>Published</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author"
                            value="<?= htmlspecialchars($post->author ?? 'Pinga Agro Team') ?>">
                    </div>
                    <button type="submit" class="btn-admin btn-admin--primary"
                        style="width:100%;justify-content:center;margin-top:0.5rem;">
                        💾 Update Post
                    </button>
                </div>

                <div class="sidebar-panel">
                    <h4>Category</h4>
                    <div class="form-field">
                        <label for="category_id">Select Category</label>
                        <select id="category_id" name="category_id">
                            <option value="">— Uncategorised —</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat->id ?>"
                                    <?= (int)$post->category_id === (int)$cat->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="sidebar-panel">
                    <h4>Featured Image</h4>
                    <div class="form-field">
                        <label for="featured_image">Image Filename</label>
                        <input type="text" id="featured_image" name="featured_image"
                            value="<?= htmlspecialchars($post->featured_image ?? '') ?>"
                            placeholder="e.g. poultry-industry.jpg">
                        <span class="form-hint">Upload to <code>public/images/posts/</code></span>
                    </div>
                </div>

                <div class="sidebar-panel" style="border-color:#EF9A9A;">
                    <h4 style="color:#C62828;">Danger Zone</h4>
                    <form action="<?= URLROOT ?>/admin/deletepost/<?= $post->id ?>"
                        method="POST"
                        onsubmit="return confirm('Permanently delete this post? This cannot be undone.')">
                        <?= Security::csrfField() ?>
                        <button type="submit" class="btn-action btn-action--delete"
                            style="width:100%;justify-content:center;padding:0.6rem;">
                            🗑️ Delete This Post
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </form>

</div>

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>

<!-- Media Insert Modals (used by the post editor) -->
<div class="editor-modal-overlay" id="mediaModalOverlay"></div>

<div class="editor-modal" id="imageModal">
    <div class="editor-modal__header">
        <h4>Insert Image</h4>
        <button type="button" class="editor-modal__close" data-close-modal>&times;</button>
    </div>
    <div class="editor-modal__tabs">
        <button type="button" class="editor-modal__tab is-active" data-tab="upload">Upload New</button>
        <button type="button" class="editor-modal__tab" data-tab="gallery">Choose from Gallery</button>
    </div>
    <div class="editor-modal__body">
        <div class="editor-modal__pane is-active" data-pane="upload">
            <input type="file" id="imageUploadInput" accept="image/jpeg,image/png,image/webp,image/gif">
            <p class="form-hint">JPG, PNG, WebP, or GIF — max 5MB.</p>
            <p class="editor-modal__error" id="imageUploadError"></p>
        </div>
        <div class="editor-modal__pane" data-pane="gallery">
            <div class="editor-modal__gallery-grid" id="galleryPickerGrid">
                <p class="form-hint">Loading gallery…</p>
            </div>
        </div>
    </div>
</div>

<div class="editor-modal" id="videoModal">
    <div class="editor-modal__header">
        <h4>Insert Video</h4>
        <button type="button" class="editor-modal__close" data-close-modal>&times;</button>
    </div>
    <div class="editor-modal__tabs">
        <button type="button" class="editor-modal__tab is-active" data-tab="embed">Embed Link</button>
        <button type="button" class="editor-modal__tab" data-tab="upload">Upload File</button>
    </div>
    <div class="editor-modal__body">
        <div class="editor-modal__pane is-active" data-pane="embed">
            <label for="videoEmbedInput">YouTube or Vimeo URL</label>
            <input type="text" id="videoEmbedInput" placeholder="https://www.youtube.com/watch?v=…">
            <button type="button" class="btn-admin btn-admin--primary" id="videoEmbedSubmit" style="margin-top:0.75rem;">Insert</button>
            <p class="editor-modal__error" id="videoEmbedError"></p>
        </div>
        <div class="editor-modal__pane" data-pane="upload">
            <input type="file" id="videoUploadInput" accept="video/mp4,video/webm">
            <p class="form-hint">MP4 or WebM — max 50MB.</p>
            <p class="editor-modal__error" id="videoUploadError"></p>
        </div>
    </div>
</div>

<!-- Quill JS -->
<script src="<?= URLROOT ?>/vendor/quill/quill.min.js"></script>
<script>
    window.URLROOT = <?= json_encode(URLROOT) ?>;
</script>
<script src="<?= URLROOT ?>/js/post-editor.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{
                    header: [2, 3, false]
                }],
                ['bold', 'italic', 'underline'],
                ['blockquote'],
                [{
                    list: 'ordered'
                }, {
                    list: 'bullet'
                }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Load existing post content into editor
    quill.root.innerHTML = document.getElementById('body').value;

    document.getElementById('postForm').addEventListener('submit', function() {
        document.getElementById('body').value = quill.root.innerHTML;
    });

    // Hook up the image/video toolbar buttons to the media modals
    initPostMediaTools(quill);

    // Slug preview updater
    const slugInput = document.getElementById('slug');
    const slugPreview = document.getElementById('slugPreview');

    slugInput.addEventListener('input', function() {
        slugPreview.textContent = this.value || 'your-slug-here';
    });
</script>