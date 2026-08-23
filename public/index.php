<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('BASEPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APPPATH',  BASEPATH . 'app' . DIRECTORY_SEPARATOR);

require_once BASEPATH . 'config/config.php';

session_start();

require_once APPPATH . 'core/Database.php';
require_once APPPATH . 'core/Model.php';
require_once APPPATH . 'core/Security.php';
require_once APPPATH . 'core/Controller.php';
require_once APPPATH . 'core/App.php';

new App();

