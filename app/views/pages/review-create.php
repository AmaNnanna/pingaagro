<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= URLROOT ?>/">Home</a>
            <span>›</span>
            <a href="<?= URLROOT ?>/review">Reviews</a>
            <span>›</span>
            <span>Share Your Experience</span>
        </div>
        <h1>Share Your<br>
            <em style="font-style:italic;color:var(--gold);">Experience.</em>
        </h1>
        <p>Your honest feedback helps us improve, and helps others who are considering working with us.</p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width:860px;">

        <?php if ($success): ?>

            <div style="text-align:center;padding:var(--space-2xl) var(--space-lg);background:var(--green-light);border:1px solid var(--green-mid);border-radius:var(--radius-md);">
                <span style="font-size:3.5rem;display:block;margin-bottom:1rem;">🌟</span>
                <h2 style="color:var(--green-dark);margin-bottom:0.75rem;">Thank You!</h2>
                <p style="color:var(--text-muted);max-width:440px;margin:0 auto 2rem;line-height:1.8;">
                    Your review has been received and is awaiting approval. We'll publish it shortly.
                </p>
                <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                    <a href="<?= URLROOT ?>/" class="btn btn-green">Back to Home</a>
                    <a href="<?= URLROOT ?>/review" class="btn btn-outline-green">See All Reviews</a>
                </div>
            </div>

        <?php else: ?>

            <div class="review-form-layout">

                <!-- Form -->
                <div class="reveal">
                    <span class="eyebrow">Your Review</span>
                    <h2>Write a Review</h2>
                    <span class="gold-rule"></span>
                    <p style="margin-top:1rem;color:var(--text-muted);line-height:1.8;">
                        All reviews are moderated before being published. Please be genuine and specific — your feedback matters.
                    </p>

                    <?php if (!empty($errors['general'])): ?>
                        <div class="form-alert form-alert--error" style="margin-top:1.5rem;">
                            ⚠️ <?= htmlspecialchars($errors['general']) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= URLROOT ?>/review/submit"
                          method="POST"
                          enctype="multipart/form-data"
                          style="margin-top:2rem;">

                        <!-- Name & Designation -->
                        <div class="form-row">
                            <div class="form-group <?= !empty($errors['name']) ? 'form-group--error' : '' ?>">
                                <label for="name">Full Name <span class="required">*</span></label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       placeholder="e.g. Emeka Okafor"
                                       value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                                <?php if (!empty($errors['name'])): ?>
                                    <span class="form-error"><?= htmlspecialchars($errors['name']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="designation">
                                    Your Title / Role
                                    <span style="font-weight:400;color:var(--text-muted);">(optional)</span>
                                </label>
                                <input type="text"
                                       id="designation"
                                       name="designation"
                                       placeholder="e.g. MD, Sunrise Poultry Farm · Customer · Wholesaler"
                                       value="<?= htmlspecialchars($old['designation'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Review Text -->
                        <div class="form-group <?= !empty($errors['review']) ? 'form-group--error' : '' ?>">
                            <label for="review">Your Review <span class="required">*</span></label>
                            <textarea id="review"
                                      name="review"
                                      rows="6"
                                      placeholder="Tell us about your experience — the quality of the products, the service, or anything else you'd like to share…"><?= htmlspecialchars($old['review'] ?? '') ?></textarea>
                            <?php if (!empty($errors['review'])): ?>
                                <span class="form-error"><?= htmlspecialchars($errors['review']) ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Photo Upload -->
                        <div class="form-group <?= !empty($errors['image']) ? 'form-group--error' : '' ?>">
                            <label for="image">
                                Your Photo
                                <span style="font-weight:400;color:var(--text-muted);">(optional)</span>
                            </label>
                            <div class="file-upload-wrap">
                                <input type="file"
                                       id="image"
                                       name="image"
                                       accept="image/jpeg,image/png,image/webp"
                                       class="file-upload-input">
                                <label for="image" class="file-upload-label">
                                    <span class="file-upload-icon">📷</span>
                                    <span class="file-upload-text">Click to upload a photo</span>
                                    <span class="file-upload-hint">JPG, PNG or WebP — max 2MB</span>
                                </label>
                                <span class="file-upload-name" id="fileName">No file chosen</span>
                            </div>
                            <?php if (!empty($errors['image'])): ?>
                                <span class="form-error"><?= htmlspecialchars($errors['image']) ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit"
                                class="btn btn-primary"
                                style="width:100%;justify-content:center;padding:1rem;margin-top:0.5rem;">
                            Submit My Review
                        </button>

                    </form>
                </div>

                <!-- Side Info -->
                <div class="review-form-info reveal">
                    <div class="review-info-card">
                        <h4>What happens next?</h4>
                        <ol class="review-steps">
                            <li>
                                <span class="step-num">1</span>
                                <div>
                                    <strong>You submit your review</strong>
                                    <p>Takes less than 2 minutes.</p>
                                </div>
                            </li>
                            <li>
                                <span class="step-num">2</span>
                                <div>
                                    <strong>We review it</strong>
                                    <p>Our team reads every submission before publishing.</p>
                                </div>
                            </li>
                            <li>
                                <span class="step-num">3</span>
                                <div>
                                    <strong>It goes live</strong>
                                    <p>Approved reviews appear on our website and help others.</p>
                                </div>
                            </li>
                        </ol>
                    </div>
                    <div class="review-info-card review-info-card--green">
                        <h4 style="color:var(--gold);">Your Privacy</h4>
                        <p>We only publish the name and designation you provide. Your contact details are never shared or displayed.</p>
                    </div>
                </div>

            </div>

        <?php endif; ?>

    </div>
</section>

<script>
// Show selected filename in the upload label
document.getElementById('image').addEventListener('change', function () {
    const name = this.files[0] ? this.files[0].name : 'No file chosen';
    document.getElementById('fileName').textContent = name;
});
</script>