<?php

/**
 * General app configuration
 */

// General project php settings
error_reporting(E_ALL);

// Adding routes to config file
require_once __DIR__ . '/routes.php';

// Folder structure
define('APP_ROOT', __DIR__ . '/..');
define('CONTROLLERS', APP_ROOT . '/controllers');
define('MODELS', APP_ROOT . '/models');
define('VIEWS', APP_ROOT . '/view');
define('LAYOUTS', VIEWS . '/layouts');

define('DEFAULT_LAYOUT', 'default');

// DB
define('DB_HOST', 'localhost');
define('DB_DATABASE', 'testerdb');
define('DB_USERNAME', 'testeruser');
define('DB_PASSWORD', 'testerpass');