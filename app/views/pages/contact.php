<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= URLROOT ?>/">Home</a>
            <span>›</span>
            <span>Contact Us</span>
        </div>
        <h1>Let's Start a<br>
            <em style="font-style:italic;color:var(--gold);">Conversation.</em>
        </h1>
        <p>Whether you're a farmer, an investor, a government body, or simply curious — we want to hear from you.</p>
    </div>
</section>

<!-- CONTACT BODY -->
<section class="section">
    <div class="container">
        <div class="contact-layout">

            <!-- FORM SIDE -->
            <div class="contact-form-wrap reveal">
                <span class="eyebrow">Send Us a Message</span>
                <h2>How Can We Help?</h2>
                <span class="gold-rule"></span>

                <?php if ($success): ?>
                    <!-- SUCCESS MESSAGE -->
                    <div class="form-success">
                        <span class="form-success__icon">✅</span>
                        <h3>Message Received!</h3>
                        <p>Thank you for reaching out. A member of our team will get back to you within 24–48 hours.</p>
                        <a href="<?= URLROOT ?>/" class="btn btn-green" style="margin-top:1.5rem;">
                            Back to Home
                        </a>
                    </div>

                <?php else: ?>

                    <!-- GENERAL ERROR -->
                    <?php if (!empty($errors['general'])): ?>
                        <div class="form-alert form-alert--error">
                            <?= htmlspecialchars($errors['general']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- FORM -->
                    <form class="contact-form" action="<?= URLROOT ?>/contact/submit" method="POST" style="margin-top:2rem;">

                        <div class="form-row">
                            <div class="form-group <?= !empty($errors['fullname']) ? 'form-group--error' : '' ?>">
                                <label for="fullname">Full Name <span class="required">*</span></label>
                                <input type="text" id="fullname" name="fullname"
                                       placeholder="Your full name"
                                       value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
                                <?php if (!empty($errors['fullname'])): ?>
                                    <span class="form-error"><?= htmlspecialchars($errors['fullname']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-group <?= !empty($errors['email']) ? 'form-group--error' : '' ?>">
                                <label for="email">Email Address <span class="required">*</span></label>
                                <input type="email" id="email" name="email"
                                       placeholder="your@email.com"
                                       value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                                <?php if (!empty($errors['email'])): ?>
                                    <span class="form-error"><?= htmlspecialchars($errors['email']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone"
                                       placeholder="+234 000 000 0000"
                                       value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                            </div>
                            <div class="form-group <?= !empty($errors['subject']) ? 'form-group--error' : '' ?>">
                                <label for="subject">I am reaching out as a… <span class="required">*</span></label>
                                <select id="subject" name="subject">
                                    <option value="" disabled <?= empty($old['subject']) ? 'selected' : '' ?>>Select one</option>
                                    <?php
                                    $subjects = [
                                        'general'    => 'General Enquiry',
                                        'farmer'     => 'Farmer / Seeking Support',
                                        'investor'   => 'Investor / Business Partner',
                                        'government' => 'Government / Policy',
                                        'media'      => 'Media / Press',
                                        'product'    => 'Product Enquiry',
                                    ];
                                    foreach ($subjects as $val => $label):
                                    ?>
                                        <option value="<?= $val ?>" <?= (isset($old['subject']) && $old['subject'] === $val) ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (!empty($errors['subject'])): ?>
                                    <span class="form-error"><?= htmlspecialchars($errors['subject']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group <?= !empty($errors['message']) ? 'form-group--error' : '' ?>">
                            <label for="message">Your Message <span class="required">*</span></label>
                            <textarea id="message" name="message" rows="6"
                                      placeholder="Tell us what's on your mind…"><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                            <?php if (!empty($errors['message'])): ?>
                                <span class="form-error"><?= htmlspecialchars($errors['message']) ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary"
                                style="width:100%;justify-content:center;padding:1rem;">
                            Send Message
                        </button>

                    </form>
                <?php endif; ?>
            </div>

            <!-- INFO SIDE -->
            <div class="contact-info reveal">
                <span class="eyebrow">Our Details</span>
                <h2>Find Us</h2>
                <span class="gold-rule"></span>

                <div class="contact-info__items">
                    <div class="contact-info__item">
                        <div class="contact-info__icon">📍</div>
                        <div>
                            <h4>Location</h4>
                            <p>Oji River LGA,<br>Enugu State, Nigeria</p>
                        </div>
                    </div>
                    <div class="contact-info__item">
                        <div class="contact-info__icon">📞</div>
                        <div>
                            <h4>Phone</h4>
                            <p>+234 000 000 0000</p>
                        </div>
                    </div>
                    <div class="contact-info__item">
                        <div class="contact-info__icon">✉️</div>
                        <div>
                            <h4>Email</h4>
                            <p>info@pingaagro.com</p>
                        </div>
                    </div>
                    <div class="contact-info__item">
                        <div class="contact-info__icon">💬</div>
                        <div>
                            <h4>WhatsApp</h4>
                            <p>+234 000 000 0000</p>
                        </div>
                    </div>
                </div>

                <div class="contact-response">
                    <h4 style="color:var(--green-dark);margin-bottom:0.75rem;">When to Expect a Reply</h4>
                    <ul class="response-list">
                        <li><span class="dot dot--green"></span> General enquiries — within 24 hours</li>
                        <li><span class="dot dot--gold"></span> Investment discussions — within 48 hours</li>
                        <li><span class="dot dot--green"></span> Product enquiries — within 12 hours</li>
                        <li><span class="dot dot--gold"></span> Government / Policy — within 48 hours</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MAP -->
<div class="map-placeholder">
    <div class="map-placeholder__inner">
        <span>📍</span>
        <p>Oji River LGA, Enugu State, Nigeria</p>
        <small>Interactive map will be embedded here</small>
    </div>
</div>