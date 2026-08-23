<!-- POST HEADER -->
<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= URLROOT ?>/">Home</a>
            <span>›</span>
            <a href="<?= URLROOT ?>/insights">Insights</a>
            <span>›</span>
            <span><?= htmlspecialchars($post->category_name ?? 'Article') ?></span>
        </div>
        <h1 style="max-width:780px;"><?= htmlspecialchars($post->title) ?></h1>
        <div style="display:flex;align-items:center;gap:1rem;margin-top:1.5rem;flex-wrap:wrap;">
            <span style="color:var(--gold);font-weight:600;font-size:var(--text-sm);">
                <?= htmlspecialchars($post->category_name ?? 'General') ?>
            </span>
            <span style="color:rgba(255,255,255,0.4);">·</span>
            <span style="color:rgba(255,255,255,0.65);font-size:var(--text-sm);">
                By <?= htmlspecialchars($post->author) ?>
            </span>
            <span style="color:rgba(255,255,255,0.4);">·</span>
            <span style="color:rgba(255,255,255,0.65);font-size:var(--text-sm);">
                <?= date('F j, Y', strtotime($post->created_at)) ?>
            </span>
        </div>
    </div>
</section>

<!-- POST BODY -->
<section class="section">
    <div class="container">
        <div class="post-layout">

            <!-- Article -->
            <article class="post-body reveal">

                <!-- Featured Image -->
                <?php if ($post->featured_image): ?>
                    <div class="post-body__hero-image">
                        <img src="<?= URLROOT ?>/images/posts/<?= htmlspecialchars($post->featured_image) ?>"
                             alt="<?= htmlspecialchars($post->title) ?>">
                    </div>
                <?php endif; ?>

                <!-- Excerpt -->
                <?php if ($post->excerpt): ?>
                    <p class="post-body__excerpt">
                        <?= htmlspecialchars($post->excerpt) ?>
                    </p>
                <?php endif; ?>

                <!-- Body Content -->
                <div class="post-body__content">
                    <?= $post->body /* HTML stored in DB — rendered directly */ ?>
                </div>

                <!-- Post Footer -->
                <div class="post-body__footer">
                    <a href="<?= URLROOT ?>/insights"
                       class="btn btn-outline-green">
                        ← Back to Insights
                    </a>
                    <div class="post-body__share">
                        <span>Share:</span>
                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post->title) ?>&url=<?= urlencode(URLROOT . '/insights/post/' . $post->slug) ?>"
                           target="_blank" rel="noopener" class="share-link">Twitter / X</a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(URLROOT . '/insights/post/' . $post->slug) ?>"
                           target="_blank" rel="noopener" class="share-link">LinkedIn</a>
                        <a href="https://wa.me/?text=<?= urlencode($post->title . ' ' . URLROOT . '/insights/post/' . $post->slug) ?>"
                           target="_blank" rel="noopener" class="share-link">WhatsApp</a>
                    </div>
                </div>

            </article>

            <!-- Sidebar -->
            <aside class="post-sidebar reveal">

                <div class="sidebar-widget">
                    <h4 class="sidebar-widget__title">About Pinga Agro</h4>
                    <p>Pinga Agro Investment Limited is a leading poultry operation in Southeast Nigeria, committed to quality, community, and the future of Nigerian agriculture.</p>
                    <a href="<?= URLROOT ?>/about" class="btn btn-green" style="margin-top:1rem;width:100%;justify-content:center;">
                        Learn More
                    </a>
                </div>

                <div class="sidebar-widget">
                    <h4 class="sidebar-widget__title">Our Products</h4>
                    <ul class="sidebar-links">
                        <li><a href="<?= URLROOT ?>/products#eggs">→ Eggs</a></li>
                        <li><a href="<?= URLROOT ?>/products#broilers">→ Broilers</a></li>
                        <li><a href="<?= URLROOT ?>/products#layers">→ Layers</a></li>
                    </ul>
                </div>

                <div class="sidebar-widget sidebar-widget--cta">
                    <h4>Have a Question?</h4>
                    <p>Our team is happy to discuss farming, investment, or anything else on your mind.</p>
                    <a href="<?= URLROOT ?>/contact" class="btn btn-primary" style="margin-top:1rem;width:100%;justify-content:center;">
                        Contact Us
                    </a>
                </div>

            </aside>

        </div>
    </div>
</section>