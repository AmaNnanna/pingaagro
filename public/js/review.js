/**
 * review.js — Review Submission Form
 * Shows selected filename after file upload input changes
 * Loaded on review/create page only
 */
document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('image');
    const fileName   = document.getElementById('fileName');

    if (imageInput && fileName) {
        imageInput.addEventListener('change', function () {
            fileName.textContent = this.files[0]
                ? this.files[0].name
                : 'No file chosen';
        });
    }

});