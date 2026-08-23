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
class Security {

    /**
     * Generate a CSRF token for the current session.
     * If one already exists, returns it — same token for the whole session.
     */
    public static function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Output a hidden CSRF input field.
     * Drop <?= Security::csrfField() ?> into any form.
     */
    public static function csrfField(): string {
        return '<input type="hidden" name="csrf_token" value="'
             . self::csrfToken()
             . '">';
    }

    /**
     * Verify the CSRF token from a POST request.
     * Call this at the top of every form-processing method.
     * Kills the request if the token is missing or wrong.
     */
    public static function verifyCsrf(): void {
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
    public static function escape(string $value): string {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Sanitise a string for database input.
     * Strips tags and trims whitespace.
     * Note: this is a supplement to prepared statements, not a replacement.
     */
    public static function sanitise(string $value): string {
        return trim(strip_tags($value));
    }
}