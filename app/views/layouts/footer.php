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
<script src="<?= URLROOT ?>/js/chatbot.js"></script>

<!-- ── Page-specific JS ──────────────────────────────────── -->
<?php if ($currentUrl === ''): ?>
    <script src="<?= URLROOT ?>/js/carousel.js"></script>

<?php elseif (strpos($currentUrl, 'review/create') === 0): ?>
    <script src="<?= URLROOT ?>/js/review.js"></script>
<?php endif; ?>

<!-- ═════ CHAT WIDGET ════════ -->
<div class="chat-widget" id="chatWidget">

    <!-- Trigger Button -->
    <button class="chat-trigger" id="chatTrigger" aria-label="Open chat">
        <span class="chat-trigger__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
        </span>
        <span class="chat-trigger__label">Chat with us</span>
    </button>

    <!-- Chat Panel -->
    <div class="chat-panel" id="chatPanel" role="dialog" aria-label="Chat with Pinga Agro">

        <!-- Panel Header -->
        <div class="chat-panel__header">
            <div class="chat-panel__brand">
                <img src="<?= URLROOT ?>/images/logo.png" alt="Pinga Agro">
                <div>
                    <strong>Pinga Agro</strong>
                    <span>We typically reply within 24 hours</span>
                </div>
            </div>
            <button class="chat-panel__close" id="chatClose" aria-label="Close chat">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <!-- Panel Body -->
        <div class="chat-panel__body" id="chatBody">
            <!--
                ═══════════════════════════════════════════════
                INTEGRATION POINT
                ═══════════════════════════════════════════════
                When you choose a chat provider, replace the
                placeholder content below with their embed code.

                Example for Tawk.to:
                <iframe src="https://tawk.to/chat/YOUR_ID/default" ...></iframe>

                Example for Tidio:
                <script src="//code.tidio.co/YOUR_KEY.js"></script>

                Example for WhatsApp:
                <a href="https://wa.me/YOUR_NUMBER">...</a>
                ═══════════════════════════════════════════════
            -->

            <!-- Placeholder — remove when provider is connected -->
            <div class="chat-placeholder">
                <div class="chat-placeholder__avatar">
                    <img src="<?= URLROOT ?>/images/logo.png" alt="Pinga Agro">
                </div>
                <div class="chat-placeholder__bubble">
                    <p>👋 Hello! Welcome to Pinga Agro Investment Limited.</p>
                    <p>How can we help you today?</p>
                </div>
                <div class="chat-placeholder__options">
                    <a href="<?= URLROOT ?>/contact?subject=product"
                        class="chat-option">🥚 Product Enquiry</a>
                    <a href="<?= URLROOT ?>/contact?subject=investor"
                        class="chat-option">💼 Investment</a>
                    <a href="<?= URLROOT ?>/contact?subject=farmer"
                        class="chat-option">🌾 Farmer Support</a>
                    <a href="<?= URLROOT ?>/contact?subject=general"
                        class="chat-option">✉️ General Enquiry</a>
                </div>
            </div>

        </div>

        <!-- Panel Footer -->
        <div class="chat-panel__footer">
            <a href="<?= URLROOT ?>/contact" class="chat-panel__footer-link">
                Or send us a message →
            </a>
        </div>

    </div>
</div>

</body>

</html>