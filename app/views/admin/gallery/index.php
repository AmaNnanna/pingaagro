<div class="admin-topbar">
    <h1 class="admin-topbar__title">Farm Gallery</h1>
    <div class="admin-topbar__actions">
        <span style="font-size:0.85rem;color:var(--a-text-muted);">
            <?= count($images) ?> image<?= count($images) !== 1 ? 's' : '' ?> uploaded
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

        <!-- Gallery Grid -->
        <div>
            <?php if (!empty($images)): ?>
                <div class="admin-gallery-grid">
                    <?php foreach ($images as $img): ?>
                        <div class="admin-gallery-item">
                            <div class="admin-gallery-item__img">
                                <img src="<?= URLROOT ?>/images/gallery/<?= htmlspecialchars($img->filename) ?>"
                                     alt="<?= htmlspecialchars($img->caption ?: $img->filename) ?>"
                                     loading="lazy">
                            </div>
                            <div class="admin-gallery-item__info">
                                <span class="admin-gallery-item__caption">
                                    <?= htmlspecialchars($img->caption ?: '—') ?>
                                </span>
                                <span class="admin-gallery-item__location">
                                    <?= htmlspecialchars($img->location ?: '') ?>
                                </span>
                                <span class="admin-gallery-item__filename">
                                    <?= htmlspecialchars($img->filename) ?>
                                </span>
                            </div>
                            <form action="<?= URLROOT ?>/admin/deleteimage/<?= $img->id ?>"
                                  method="POST"
                                  onsubmit="return confirm('Delete this image? This cannot be undone.')">
                                <?= Security::csrfField() ?>
                                <button type="submit" class="admin-gallery-item__delete"
                                        aria-label="Delete image">
                                    🗑
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="icon">📷</div>
                    <h4>No images yet</h4>
                    <p>Upload your first farm photo using the form.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Upload Form -->
        <div class="sidebar-panel" style="position:sticky;top:calc(var(--navbar-h) + 2rem);">
            <h4>Upload New Image</h4>

            <form action="<?= URLROOT ?>/admin/uploadimage"
                  method="POST"
                  enctype="multipart/form-data">
                <?= Security::csrfField() ?>

                <div class="form-field">
                    <label>Image File *</label>
                    <div class="file-upload-area" id="dropArea">
                        <input type="file" name="image" id="galleryImage"
                               accept="image/jpeg,image/png,image/webp"
                               required>
                        <label for="galleryImage" class="file-upload-area__label">
                            <span style="font-size:2rem;display:block;margin-bottom:0.5rem;">📷</span>
                            <strong>Click to select</strong> or drag and drop
                            <small>JPG, PNG, WebP — max 1MB</small>
                            <small id="selectedFile" style="color:var(--a-green-dark);margin-top:0.25rem;"></small>
                        </label>
                    </div>
                    <span class="form-hint">The original filename is preserved (special characters replaced with hyphens)</span>
                </div>

                <div class="form-field">
                    <label for="caption">Caption</label>
                    <input type="text" id="caption" name="caption"
                           placeholder="e.g. Team at the Oji River farm">
                    <span class="form-hint">Shown on hover. Leave blank to show no label.</span>
                </div>

                <div class="form-field">
                    <label for="location">Location Tag</label>
                    <input type="text" id="location" name="location"
                           placeholder="e.g. Oji River Farm">
                </div>

                <div class="form-field">
                    <label for="sort_order">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order"
                           value="0" min="0">
                    <span class="form-hint">Lower numbers appear first. Use 0 for newest-first ordering.</span>
                </div>

                <button type="submit" class="btn-admin btn-admin--primary"
                        style="width:100%;justify-content:center;margin-top:0.5rem;">
                    📤 Upload Image
                </button>

            </form>
        </div>

    </div>

</div>

<footer class="admin-footer">
    &copy; <?= date('Y') ?> Pinga Agro Investment Limited — Admin Panel
</footer>

<script>
// Show selected filename
document.getElementById('galleryImage').addEventListener('change', function () {
    const label = document.getElementById('selectedFile');
    label.textContent = this.files[0] ? '✓ ' + this.files[0].name : '';
});
</script>