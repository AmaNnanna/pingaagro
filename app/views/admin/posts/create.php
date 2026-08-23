<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

<!-- Topbar -->
<div class="admin-topbar">
    <h1 class="admin-topbar__title">New Post</h1>
    <div class="admin-topbar__actions">
        <a href="<?= URLROOT ?>/admin/posts" class="btn-admin btn-admin--ghost">← Back to Posts</a>
    </div>
</div>

<div class="admin-content">

    <?php if (!empty($errors['general'])): ?>
        <div class="flash flash--error">⚠️ <?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <form action="<?= URLROOT ?>/admin/newpost" method="POST" id="postForm">
        <?= Security::csrfField() ?>

        <div class="admin-form-grid">

            <!-- ── Main Column ──────────────────────────── -->
            <div>

                <!-- Title -->
                <div class="form-field <?= !empty($errors['title']) ? 'form-field--error' : '' ?>">
                    <label for="title">Post Title *</label>
                    <input type="text" id="title" name="title"
                        value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                        placeholder="Enter a clear, compelling title…">
                    <?php if (!empty($errors['title'])): ?>
                        <span class="form-error"><?= htmlspecialchars($errors['title']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Slug -->
                <div class="form-field <?= !empty($errors['slug']) ? 'form-field--error' : '' ?>">
                    <label for="slug">Slug (URL) *</label>
                    <input type="text" id="slug" name="slug"
                        value="<?= htmlspecialchars($old['slug'] ?? '') ?>"
                        placeholder="auto-generated-from-title">
                    <span class="form-hint">
                        Preview: <?= URLROOT ?>/insights/post/<strong id="slugPreview"><?= htmlspecialchars($old['slug'] ?? 'your-slug-here') ?></strong>
                    </span>
                    <?php if (!empty($errors['slug'])): ?>
                        <span class="form-error"><?= htmlspecialchars($errors['slug']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Excerpt -->
                <div class="form-field">
                    <label for="excerpt">Excerpt</label>
                    <textarea id="excerpt" name="excerpt" rows="3"
                        placeholder="A short summary shown in post listings and SEO descriptions…"><?= htmlspecialchars($old['excerpt'] ?? '') ?></textarea>
                    <span class="form-hint">Keep under 160 characters for best SEO results.</span>
                </div>

                <!-- Body (Quill) -->
                <div class="form-field <?= !empty($errors['body']) ? 'form-field--error' : '' ?>">
                    <label>Post Content *</label>
                    <div id="editor"><?= $old['body'] ?? '' ?></div>
                    <!-- Hidden textarea stores the HTML on submit -->
                    <textarea id="body" name="body" style="display:none;"><?= htmlspecialchars($old['body'] ?? '') ?></textarea>
                    <?php if (!empty($errors['body'])): ?>
                        <span class="form-error" style="margin-top:0.5rem;display:block;">
                            <?= htmlspecialchars($errors['body']) ?>
                        </span>
                    <?php endif; ?>
                </div>

            </div>

            <!-- ── Sidebar Column ────────────────────────── -->
            <div class="form-sidebar">

                <!-- Publish Panel -->
                <div class="sidebar-panel">
                    <h4>Publish</h4>
                    <div class="form-field">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="draft" <?= (($old['status'] ?? 'draft') === 'draft') ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= (($old['status'] ?? '') === 'published') ? 'selected' : '' ?>>Published</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author"
                            value="<?= htmlspecialchars($old['author'] ?? 'Pinga Agro Team') ?>">
                    </div>
                    <button type="submit" class="btn-admin btn-admin--primary"
                        style="width:100%;justify-content:center;margin-top:0.5rem;">
                        💾 Save Post
                    </button>
                </div>

                <!-- Category Panel -->
                <div class="sidebar-panel">
                    <h4>Category</h4>
                    <div class="form-field">
                        <label for="category_id">Select Category</label>
                        <select id="category_id" name="category_id">
                            <option value="">— Uncategorised —</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat->id ?>"
                                    <?= (int)($old['category_id'] ?? 0) === (int)$cat->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Featured Image Panel -->
                <div class="sidebar-panel">
                    <h4>Featured Image</h4>
                    <div class="form-field">
                        <label for="featured_image">Image Filename</label>
                        <input type="text" id="featured_image" name="featured_image"
                            value="<?= htmlspecialchars($old['featured_image'] ?? '') ?>"
                            placeholder="e.g. poultry-industry.jpg">
                        <span class="form-hint">
                            Upload image to <code>public/images/posts/</code> then enter the filename here.
                        </span>
                    </div>
                </div>

            </div>

        </div>

    </form>

</div>

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    // ── Quill Editor ───────────────────────────────────────────
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write your post content here…',
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
                ['link'],
                ['clean']
            ]
        }
    });

    // Populate the hidden textarea before form submission
    document.getElementById('postForm').addEventListener('submit', function() {
        document.getElementById('body').value = quill.root.innerHTML;
    });

    // ── Slug Auto-Generator ────────────────────────────────────
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const slugPreview = document.getElementById('slugPreview');
    let slugManuallyEdited = slugInput.value.trim() !== '';

    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }

    titleInput.addEventListener('input', function() {
        if (!slugManuallyEdited) {
            const slug = generateSlug(this.value);
            slugInput.value = slug;
            slugPreview.textContent = slug || 'your-slug-here';
        }
    });

    slugInput.addEventListener('input', function() {
        slugManuallyEdited = true;
        slugPreview.textContent = this.value || 'your-slug-here';
    });
</script>