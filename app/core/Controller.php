<?php
class Controller {

    // How long admin sessions last without activity — 5 minutes
    private const SESSION_TIMEOUT = 300;

    protected function model(string $model) {
        $file = APPPATH . 'models/' . $model . '.php';
        if (file_exists($file)) {
            require_once $file;
            return new $model();
        }
        die("Model '{$model}' not found.");
    }

    protected function view(string $view, array $data = [], string $layout = 'main') {
        $file = APPPATH . 'views/' . $view . '.php';

        if (!file_exists($file)) {
            die("View '{$view}' not found.");
        }

        extract($data);

        switch ($layout) {
            case 'main':
                require_once APPPATH . 'views/layouts/header.php';
                require_once $file;
                require_once APPPATH . 'views/layouts/footer.php';
                break;
            case 'admin':
                require_once APPPATH . 'views/admin/layouts/header.php';
                require_once $file;
                require_once APPPATH . 'views/admin/layouts/footer.php';
                break;
            case 'none':
                require_once $file;
                break;
        }
    }

    protected function redirect(string $url): void {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Check if the admin session has timed out.
     * Called inside requireAuth() in AdminController.
     * If the admin has been inactive for SESSION_TIMEOUT seconds,
     * their session is destroyed and they are sent to the login page.
     */
    protected function checkSessionTimeout(): void {
        if (!isset($_SESSION['last_activity'])) {
            $_SESSION['last_activity'] = time();
            return;
        }

        if (time() - $_SESSION['last_activity'] > self::SESSION_TIMEOUT) {
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id(true);
            $this->redirect(URLROOT . '/admin/login?reason=timeout');
        }

        // Update last activity on every valid request
        $_SESSION['last_activity'] = time();
    }
}