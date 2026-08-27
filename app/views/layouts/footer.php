<!-- ══════════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════════ -->
<footer class="footer">
    <div class="container">
        <div class="footer__grid">

            <!-- Brand Column -->
            <div class="footer__brand">
                <img src="<?= URLROOT ?>/images/logo.png" alt="Pinga Agro Investment Limited">
                <p>Building the future of poultry farming in Southeast Nigeria — with quality at our core, community at our heart, and the continent in our sights.</p>
                <span class="footer__tagline">"Another Name for Quality"</span>

                <!-- Social Links -->
                <div class="footer__socials">
                    <a href="#" class="footer__social-link" aria-label="Facebook">f</a>
                    <a href="#" class="footer__social-link" aria-label="Twitter">𝕏</a>
                    <a href="#" class="footer__social-link" aria-label="Instagram">in</a>
                    <a href="#" class="footer__social-link" aria-label="LinkedIn">Li</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer__col">
                <h5>Company</h5>
                <ul>
                    <li><a href="<?= URLROOT ?>/about">About Us</a></li>
                    <li><a href="<?= URLROOT ?>/farm">Our Farm</a></li>
                    <li><a href="<?= URLROOT ?>/initiatives">Initiatives</a></li>
                    <li><a href="<?= URLROOT ?>/insights">Insights</a></li>
                    <li><a href="<?= URLROOT ?>/contact">Contact</a></li>
                </ul>
            </div>

            <!-- Engage -->
            <div class="footer__col">
                <h5>Engage</h5>
                <ul>
                    <li><a href="<?= URLROOT ?>/farmers">For Farmers</a></li>
                    <li><a href="<?= URLROOT ?>/investors">For Investors</a></li>
                    <li><a href="<?= URLROOT ?>/contact">For Government</a></li>
                    <li><a href="<?= URLROOT ?>/initiatives">Community</a></li>
                    <li><a href="<?= URLROOT ?>/review">Share a Review</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer__col">
                <h5>Contact</h5>
                <div class="footer__contact-item">
                    <span class="icon">📍</span>
                    <span>Mile 2 Ahani, Oji River LGA, Enugu State</span>
                </div>
                <div class="footer__contact-item">
                    <span class="icon">📍</span>
                    <span>Akpugoeze-Ufuma Road, Ufuma, Anambra State</span>
                </div>
                <div class="footer__contact-item">
                    <span class="icon">📞</span>
                    <span><?= PHONE ?: 'Contact us by email' ?></span>
                </div>
                <div class="footer__contact-item">
                    <span class="icon">✉️</span>
                    <span><?= EMAIL ?: 'info@pingaagro.com' ?></span>
                </div>
            </div>

        </div><!-- /.footer__grid -->

        <!-- Bottom Bar -->
        <div class="footer__bottom">
            <p>&copy; <?= date('Y') ?> Pinga Agro Investment Limited (<?= RC_NUMBER ?>). All rights reserved.</p>
            <div class="footer__bottom-links">
                <a href="<?= URLROOT ?>/privacy">Privacy Policy</a>
                <a href="<?= URLROOT ?>/terms">Terms of Use</a>
            </div>
        </div>

    </div><!-- /.container -->
</footer>
<!-- ══ END FOOTER ══════════════════════════════════════════ -->


<?php $currentUrl = isset($_GET['url']) ? trim($_GET['url'], '/') : ''; ?>

<!-- ── Core JS (every page) ──────────────────────────────── -->
<script src="<?= URLROOT ?>/js/main.js"></script>
<script src="<?= URLROOT ?>/js/reveal.js"></script>

<!-- ── Page-specific JS ──────────────────────────────────── -->
<?php if ($currentUrl === ''): ?>
    <script src="<?= URLROOT ?>/js/carousel.js"></script>

<?php elseif (strpos($currentUrl, 'review/create') === 0): ?>
    <script src="<?= URLROOT ?>/js/review.js"></script>
<?php endif; ?>

</body>

</html>