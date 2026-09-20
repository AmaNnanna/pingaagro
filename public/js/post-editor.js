/**
 * post-editor.js
 * Wires the Quill "image" and "video" toolbar buttons to custom modals:
 *   - Image: upload a new file, or pick one already in the Gallery.
 *   - Video: paste a YouTube/Vimeo link (embeds as iframe), or upload
 *     an MP4/WebM file directly (embeds as a self-hosted <video> tag).
 *
 * Used by app/views/admin/posts/create.php and edit.php.
 * Requires window.URLROOT to be set before this file loads.
 * Call initPostMediaTools(quill) once your Quill instance exists.
 */

// ── Custom Blot: self-hosted <video> tag ───────────────────────
// Quill's built-in 'video' format only supports iframe embeds. We
// register a second format, 'videoFile', for real <video src="…">
// uploads so self-hosted files don't have to be faked as iframes.
(function registerVideoFileBlot() {
    const BlockEmbed = Quill.import('blots/block/embed');

    class VideoFileBlot extends BlockEmbed {
        static create(url) {
            const node = super.create();
            node.setAttribute('src', url);
            node.setAttribute('controls', true);
            node.setAttribute('class', 'post-content-video');
            return node;
        }
        static value(node) {
            return node.getAttribute('src');
        }
    }
    VideoFileBlot.blotName = 'videoFile';
    VideoFileBlot.tagName  = 'video';

    Quill.register(VideoFileBlot);
})();

function initPostMediaTools(quill) {
    const overlay    = document.getElementById('mediaModalOverlay');
    const imageModal = document.getElementById('imageModal');
    const videoModal = document.getElementById('videoModal');
    const csrfToken   = document.querySelector('#postForm input[name="csrf_token"]').value;

    let savedRange = null; // where the cursor was when the modal opened

    function openModal(modal) {
        savedRange = quill.getSelection(true);
        overlay.classList.add('is-visible');
        modal.classList.add('is-visible');
    }

    function closeModals() {
        overlay.classList.remove('is-visible');
        imageModal.classList.remove('is-visible');
        videoModal.classList.remove('is-visible');
    }

    overlay.addEventListener('click', closeModals);
    document.querySelectorAll('[data-close-modal]').forEach(function (btn) {
        btn.addEventListener('click', closeModals);
    });

    // Tab switching inside each modal
    document.querySelectorAll('.editor-modal').forEach(function (modal) {
        modal.querySelectorAll('.editor-modal__tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                modal.querySelectorAll('.editor-modal__tab').forEach(t => t.classList.remove('is-active'));
                modal.querySelectorAll('.editor-modal__pane').forEach(p => p.classList.remove('is-active'));
                tab.classList.add('is-active');
                modal.querySelector('[data-pane="' + tab.dataset.tab + '"]').classList.add('is-active');
            });
        });
    });

    function insertAtSavedRange(format, value) {
        const index = savedRange ? savedRange.index : quill.getLength();
        quill.insertEmbed(index, format, value, 'user');
        quill.setSelection(index + 1, 0, 'user');
        closeModals();
    }

    // ── Toolbar buttons open the modals instead of Quill's default ──
    quill.getModule('toolbar').addHandler('image', function () {
        document.getElementById('imageUploadError').textContent = '';
        openModal(imageModal);
        loadGalleryPicker();
    });

    quill.getModule('toolbar').addHandler('video', function () {
        document.getElementById('videoEmbedError').textContent = '';
        document.getElementById('videoUploadError').textContent = '';
        openModal(videoModal);
    });

    // ── Image: upload new file ──────────────────────────────────
    document.getElementById('imageUploadInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const input   = this;
        const errorEl = document.getElementById('imageUploadError');
        errorEl.textContent = '';

        const formData = new FormData();
        formData.append('image', file);
        formData.append('csrf_token', csrfToken);

        fetch(window.URLROOT + '/admin/uploadposteditorimage', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.url) {
                    insertAtSavedRange('image', data.url);
                } else {
                    errorEl.textContent = data.error || 'Upload failed.';
                }
            })
            .catch(() => { errorEl.textContent = 'Upload failed. Please try again.'; })
            .finally(() => { input.value = ''; });
    });

    // ── Image: choose from Gallery ───────────────────────────────
    let galleryLoaded = false;
    function loadGalleryPicker() {
        if (galleryLoaded) return;
        const grid = document.getElementById('galleryPickerGrid');

        fetch(window.URLROOT + '/admin/galleryjson')
            .then(res => res.json())
            .then(images => {
                if (!images.length) {
                    grid.innerHTML = '<p class="form-hint">No gallery images yet.</p>';
                    return;
                }
                grid.innerHTML = '';
                images.forEach(function (img) {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'editor-modal__gallery-item';
                    item.innerHTML = '<img src="' + img.url + '" alt="' + img.caption + '" loading="lazy">';
                    item.addEventListener('click', function () {
                        insertAtSavedRange('image', img.url);
                    });
                    grid.appendChild(item);
                });
                galleryLoaded = true;
            })
            .catch(() => {
                grid.innerHTML = '<p class="form-hint">Could not load gallery images.</p>';
            });
    }

    // ── Video: embed link (YouTube/Vimeo) ────────────────────────
    document.getElementById('videoEmbedSubmit').addEventListener('click', function () {
        const input    = document.getElementById('videoEmbedInput');
        const errorEl  = document.getElementById('videoEmbedError');
        const embedUrl = getEmbedUrl(input.value.trim());

        if (!embedUrl) {
            errorEl.textContent = 'Enter a valid YouTube or Vimeo link.';
            return;
        }

        insertAtSavedRange('video', embedUrl);
        input.value = '';
    });

    function getEmbedUrl(url) {
        let m = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/);
        if (m) return 'https://www.youtube.com/embed/' + m[1];

        m = url.match(/vimeo\.com\/(\d+)/);
        if (m) return 'https://player.vimeo.com/video/' + m[1];

        return null;
    }

    // ── Video: upload file ────────────────────────────────────────
    document.getElementById('videoUploadInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const input   = this;
        const errorEl = document.getElementById('videoUploadError');
        errorEl.textContent = '';

        const formData = new FormData();
        formData.append('video', file);
        formData.append('csrf_token', csrfToken);

        fetch(window.URLROOT + '/admin/uploadpostvideo', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.url) {
                    insertAtSavedRange('videoFile', data.url);
                } else {
                    errorEl.textContent = data.error || 'Upload failed.';
                }
            })
            .catch(() => { errorEl.textContent = 'Upload failed. Please try again.'; })
            .finally(() => { input.value = ''; });
    });
}