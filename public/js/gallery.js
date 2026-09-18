/**
 * gallery.js — Dynamic Gallery Load More
 * Fetches the next batch of images from the server
 * and appends them to the gallery grid.
 */
document.addEventListener('DOMContentLoaded', function () {

    const btn     = document.getElementById('loadMoreBtn');
    const gallery = document.getElementById('farmGallery');
    const wrapper = document.getElementById('galleryLoadMore');

    if (!btn || !gallery) return;

    btn.addEventListener('click', function () {
        const offset = parseInt(btn.dataset.offset);
        const total  = parseInt(btn.dataset.total);
        const url    = btn.dataset.url + '?offset=' + offset;

        // Show loading state
        btn.textContent = 'Loading…';
        btn.disabled    = true;

        fetch(url)
            .then(function (res) { return res.json(); })
            .then(function (images) {

                images.forEach(function (img) {

                    // Build new gallery item
                    const item     = document.createElement('div');
                    item.className = 'farm-gallery__item reveal';

                    const image    = document.createElement('img');
                    image.src      = btn.dataset.url.replace('/about/loadmore', '')
                                   + '/images/gallery/' + img.filename;
                    image.alt      = img.caption || 'Pinga Agro';
                    image.loading  = 'lazy';

                    item.appendChild(image);

                    // Add overlay if caption or location exists
                    if (img.caption || img.location) {
                        const overlay  = document.createElement('div');
                        overlay.className = 'farm-gallery__overlay';
                        const span     = document.createElement('span');
                        span.textContent = img.caption || img.location;
                        overlay.appendChild(span);
                        item.appendChild(overlay);
                    }

                    gallery.appendChild(item);

                    // Trigger reveal animation on new items
                    setTimeout(function () {
                        item.classList.add('visible');
                    }, 100);
                });

                // Update offset
                const newOffset = offset + images.length;
                btn.dataset.offset = newOffset;

                // Update count label
                const shown = Math.min(newOffset, total);
                btn.innerHTML = 'Load More Photos <span class="gallery-count">Showing '
                              + shown + ' of ' + total + '</span>';
                btn.disabled = false;

                // Hide button if all images are loaded
                if (newOffset >= total) {
                    wrapper.style.display = 'none';
                }
            })
            .catch(function () {
                btn.textContent = 'Something went wrong. Try again.';
                btn.disabled    = false;
            });
    });

});