<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= URLROOT ?>/">Home</a>
            <span>›</span>
            <span>Reviews</span>
        </div>
        <h1>What People Say<br>
            <em style="font-style:italic;color:var(--gold);">About Pinga Agro.</em>
        </h1>
        <p>Honest feedback from farmers, partners, wholesalers, and customers who have experienced the Pinga standard firsthand.</p>
    </div>
</section>

<section class="section section--tint">
    <div class="container">

        <!-- CTA to submit a review -->
        <div class="reviews-page-header reveal">
            <p><?= count($reviews) ?> published review<?= count($reviews) !== 1 ? 's' : '' ?></p>
            <a href="<?= URLROOT ?>/review/create" class="btn btn-primary">
                ✍️ Share Your Experience
            </a>
        </div>

        <?php if (!empty($reviews)): ?>
            <div class="reviews-page-grid">
                <?php foreach ($reviews as $review): ?>
                    <div class="review-card reveal">
                        <div class="review-card__quote">❝</div>
                        <p class="review-card__text">
                            <?= htmlspecialchars($review->review) ?>
                        </p>
                        <div class="review-card__author">
                            <div class="review-card__avatar">
                                <?php if ($review->image): ?>
                                    <img src="<?= URLROOT ?>/images/reviews/<?= htmlspecialchars($review->image) ?>"
                                         alt="<?= htmlspecialchars($review->name) ?>">
                                <?php else: ?>
                                    <span><?= strtoupper(substr($review->name, 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <strong><?= htmlspecialchars($review->name) ?></strong>
                                <?php if ($review->designation): ?>
                                    <span><?= htmlspecialchars($review->designation) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div style="text-align:center;padding:var(--space-3xl) 0;">
                <span style="font-size:3rem;display:block;margin-bottom:1rem;">⭐</span>
                <h3 style="color:var(--green-dark);margin-bottom:0.5rem;">No reviews yet</h3>
                <p style="color:var(--text-muted);margin-bottom:2rem;">Be the first to share your experience with Pinga Agro.</p>
                <a href="<?= URLROOT ?>/review/create" class="btn btn-primary">Write the First Review</a>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Bottom CTA -->
<section class="section section--dark" style="padding:var(--space-2xl) 0;">
    <div class="container" style="text-align:center;">
        <h3 style="color:var(--white);margin-bottom:0.75rem;">Have you worked with us?</h3>
        <p style="color:rgba(255,255,255,0.72);margin-bottom:1.5rem;max-width:480px;margin-left:auto;margin-right:auto;">
            Your experience helps other farmers and partners make informed decisions. We'd love to hear from you.
        </p>
        <a href="<?= URLROOT ?>/review/create" class="btn btn-primary">Share Your Experience</a>
    </div>
</section>