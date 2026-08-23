<?php

/**
 * App — The Router
 *
 * Reads the URL and figures out which Controller and method to call.
 *
 * URL pattern:   domain.com/controller/method/param
 *
 * Examples:
 *   /                  → HomeController → index()
 *   /about             → AboutController → index()
 *   /blog/post/5       → BlogController → post('5')
 */
class App
{

    private $controller = 'HomeController'; // Default: load home if no URL
    private $method     = 'index';          // Default: call index() method
    private $params     = [];               // Any extra URL segments

    public function __construct()
    {
        $url = $this->parseUrl();

        // ── Step 1: Find the Controller ───────────────────────
        if (!empty($url[0])) {
            // Turn 'about' into 'AboutController'
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';
            $controllerFile = APPPATH . 'controllers/' . $controllerName . '.php';

            if (file_exists($controllerFile)) {
                $this->controller = $controllerName;
            }
            unset($url[0]);
        }

        // Load and create an instance of the controller
        require_once APPPATH . 'controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // ── Step 2: Find the Method ───────────────────────────
        if (!empty($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
            }
            unset($url[1]);
        }

        // ── Step 3: Collect remaining URL segments as params ──
        $this->params = !empty($url) ? array_values($url) : [];

        // ── Step 4: CSRF check for all POST requests ──────────────
        // This runs automatically for EVERY POST request in the application.
        // No need to call Security::verifyCsrf() in any individual controller.
        // The only exception is the file upload which uses multipart/form-data
        // — CSRF tokens work fine with enctype="multipart/form-data" too.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Security::verifyCsrf();
        }

        // ── Step 5: Call controller->method(params) ───────────────
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Reads the URL from the query string set by .htaccess
     * Cleans it and splits it into an array.
     * e.g. "about/team" becomes ['about', 'team']
     */
    private function parseUrl(): array
    {
        if (!empty($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
