<?php

/**
 * Security — CSRF Protection & Input Helpers
 *
 * CSRF (Cross-Site Request Forgery) protection works by:
 * 1. Generating a unique random token per session
 * 2. Embedding it as a hidden field in every form
 * 3. Verifying it matches on every POST request
 * 4. An attacker cannot know the token so forged requests fail
 */
class Security
{

    /**
     * Generate a CSRF token for the current session.
     * If one already exists, returns it — same token for the whole session.
     */
    public static function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Output a hidden CSRF input field.
     * Drop <?= Security::csrfField() ?> into any form.
     */
    public static function csrfField(): string
    {
        return '<input type="hidden" name="csrf_token" value="'
            . self::csrfToken()
            . '">';
    }

    /**
     * Verify the CSRF token from a POST request.
     * Call this at the top of every form-processing method.
     * Kills the request if the token is missing or wrong.
     */
    public static function verifyCsrf(): void
    {
        $submitted = $_POST['csrf_token'] ?? '';
        $expected  = $_SESSION['csrf_token'] ?? '';

        // hash_equals prevents timing attacks
        if (empty($submitted) || !hash_equals($expected, $submitted)) {
            http_response_code(403);
            die('Invalid request. Please go back and try again.');
        }
    }

    /**
     * Sanitise a string for safe output.
     * Wrapper around htmlspecialchars with sensible defaults.
     */
    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Sanitise a string for database input.
     * Strips tags and trims whitespace.
     * Note: this is a supplement to prepared statements, not a replacement.
     */
    public static function sanitise(string $value): string
    {
        return trim(strip_tags($value));
    }

    /**
     * Remove any characters an attacker could use to inject extra
     * mail headers (CR/LF). Use this on any user-submitted value
     * that gets placed into a mail() header, e.g. a Reply-To name.
     */
    public static function stripNewlines(string $value): string
    {
        return str_replace(["\r", "\n"], '', $value);
    }

    /**
     * Sanitise rich-text HTML (from the Quill post editor) down to
     * exactly the tags/attributes our editor can actually produce.
     * Anything else — <script>, event handler attributes, javascript:
     * links, arbitrary iframes — is stripped before it ever reaches
     * the database. The Quill toolbar only controls what buttons are
     * shown; it is not a security boundary, so this is the real check.
     */
    public static function sanitizeHtml(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        $allowedTags   = ['p', 'br', 'h2', 'h3', 'strong', 'em', 'u', 'blockquote', 'ol', 'ul', 'li', 'a', 'img', 'video', 'iframe'];
        $stripEntirely = ['script', 'style', 'object', 'embed', 'form', 'input', 'svg', 'math', 'noscript', 'template'];

        $allowedAttrs = [
            'a'      => ['href'],
            'img'    => ['src', 'alt'],
            'video'  => ['src'],
            'iframe' => ['src'],
        ];

        $allowedIframeHosts = ['https://www.youtube.com/embed/', 'https://player.vimeo.com/video/'];

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(
            '<?xml encoding="utf-8" ?><div>' . $html . '</div>',
            LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED
        );
        libxml_clear_errors();

        $root = $dom->documentElement;
        if (!$root) {
            return '';
        }

        self::cleanNode($root, $allowedTags, $stripEntirely, $allowedAttrs, $allowedIframeHosts);

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }
        return $output;
    }

    private static function cleanNode(DOMNode $node, array $allowedTags, array $stripEntirely, array $allowedAttrs, array $allowedIframeHosts): void
    {
        $children = iterator_to_array($node->childNodes);

        foreach ($children as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                continue;
            }
            if ($child->nodeType !== XML_ELEMENT_NODE) {
                $node->removeChild($child);
                continue;
            }

            $tag = strtolower($child->nodeName);

            if (!in_array($tag, $allowedTags, true)) {
                if (in_array($tag, $stripEntirely, true)) {
                    // Dangerous or meaningless tag — remove it and its content.
                    $node->removeChild($child);
                } else {
                    // Unknown formatting wrapper (e.g. a stray <div>/<span>) —
                    // keep the text/children, just drop the wrapping tag.
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);
                }
                continue;
            }

            if ($child->hasAttributes()) {
                $keep = $allowedAttrs[$tag] ?? [];
                foreach (iterator_to_array($child->attributes) as $attr) {
                    if (!in_array(strtolower($attr->name), $keep, true)) {
                        $child->removeAttribute($attr->name);
                    }
                }
            }

            if ($tag === 'a' && $child->hasAttribute('href')) {
                $href = $child->getAttribute('href');
                if (!preg_match('#^(https?://|/)#i', $href)) {
                    $child->removeAttribute('href');
                } else {
                    $child->setAttribute('target', '_blank');
                    $child->setAttribute('rel', 'noopener noreferrer');
                }
            }

            if ($tag === 'img' && $child->hasAttribute('src')) {
                $src = $child->getAttribute('src');
                if (!preg_match('#^https?://#i', $src)) {
                    $node->removeChild($child);
                    continue;
                }
            }

            if ($tag === 'video' && $child->hasAttribute('src')) {
                $src = $child->getAttribute('src');
                if (!preg_match('#^https?://#i', $src)) {
                    $node->removeChild($child);
                    continue;
                }
                $child->setAttribute('controls', 'controls');
            }

            if ($tag === 'iframe') {
                $src = $child->getAttribute('src');
                $ok  = false;
                foreach ($allowedIframeHosts as $host) {
                    if (str_starts_with((string) $src, $host)) {
                        $ok = true;
                        break;
                    }
                }
                if (!$ok) {
                    $node->removeChild($child);
                    continue;
                }
            }

            self::cleanNode($child, $allowedTags, $stripEntirely, $allowedAttrs, $allowedIframeHosts);
        }
    }
}
