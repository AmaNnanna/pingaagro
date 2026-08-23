<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= URLROOT ?>/">Home</a>
            <span>›</span>
            <span>Insights</span>
        </div>
        <h1>Perspectives on Poultry,<br>
            <em style="font-style:italic;color:var(--gold);">Agriculture & Impact.</em>
        </h1>
        <p>Thought leadership, practical guides, community stories, and industry analysis from the Pinga Agro team.</p>
    </div>
</section>

<!-- CATEGORY FILTER -->
<section class="section--sm section--tint">
    <div class="container">
        <div class="insights-categories reveal">
            <a href="<?= URLROOT ?>/insights"
               class="category-tag <?= !isset($activeCategory) ? 'category-tag--active' : '' ?>">
                All
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= URLROOT ?>/insights/category/<?= $cat->slug ?>"
                   class="category-tag <?= (isset($activeCategory) && $activeCategory === $cat->slug) ? 'category-tag--active' : '' ?>">
                    <?= htmlspecialchars($cat->name) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FEATURED POST -->
<?php if ($featured): ?>
<section class="section">
    <div class="container">
        <div class="insights-featured reveal">
            <div class="insights-featured__image">
                <?php if ($featured->featured_image): ?>
                    <img src="<?= URLROOT ?>/images/posts/<?= htmlspecialchars($featured->featured_image) ?>"
                         alt="<?= htmlspecialchars($featured->title) ?>">
                <?php else: ?>
                    <div class="insights-featured__img-placeholder">📰</div>
                <?php endif; ?>
            </div>
            <div class="insights-featured__content">
                <div class="insight-card__meta">
                    <?= htmlspecialchars($featured->category_name ?? 'General') ?>
                    &nbsp;·&nbsp;
                    <?= date('F Y', strtotime($featured->created_at)) ?>
                </div>
                <h2 style="font-size:var(--text-3xl);margin:0.5rem 0 1rem;">
                    <?= htmlspecialchars($featured->title) ?>
                </h2>
                <p><?= htmlspecialchars($featured->excerpt) ?></p>
                <div class="insights-featured__meta">
                    <span>By <?= htmlspecialchars($featured->author) ?></span>
                </div>
                <a href="<?= URLROOT ?>/insights/post/<?= htmlspecialchars($featured->slug) ?>"
                   class="btn btn-green" style="margin-top:1.5rem;">
                    Read Article
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- POSTS GRID -->
<section class="section section--tint">
    <div class="container">

        <?php if (!empty($remaining)): ?>
            <div class="section-header reveal">
                <span class="eyebrow">More Articles</span>
                <h2>From Our Team</h2>
                <span class="gold-rule"></span>
            </div>
            <div class="insights-grid">
                <?php foreach ($remaining as $post): ?>
                    <div class="insight-card reveal">
                        <div class="insight-card__image"
                             style="display:flex;align-items:center;justify-content:center;font-size:2.5rem;background:var(--green-light);min-height:180px;">
                            <?php if ($post->featured_image): ?>
                                <img src="<?= URLROOT ?>/images/posts/<?= htmlspecialchars($post->featured_image) ?>"
                                     alt="<?= htmlspecialchars($post->title) ?>">
                            <?php else: ?>
                                📰
                            <?php endif; ?>
                        </div>
                        <div class="insight-card__body">
                            <div class="insight-card__meta">
                                <?= htmlspecialchars($post->category_name ?? 'General') ?>
                                &nbsp;·&nbsp;
                                <?= date('M Y', strtotime($post->created_at)) ?>
                            </div>
                            <h3>
                                <a href="<?= URLROOT ?>/insights/post/<?= htmlspecialchars($post->slug) ?>">
                                    <?= htmlspecialchars($post->title) ?>
                                </a>
                            </h3>
                            <p><?= htmlspecialchars($post->excerpt) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php elseif (empty($featured)): ?>
            <!-- No posts at all -->
            <div style="text-align:center;padding:var(--space-3xl) 0;">
                <span style="font-size:3rem;">📝</span>
                <h3 style="margin:1rem 0 0.5rem;color:var(--green-dark);">No posts yet</h3>
                <p style="color:var(--text-muted);">Check back soon — we're working on something.</p>
            </div>
        <?php endif; ?>

    </div>
</section>