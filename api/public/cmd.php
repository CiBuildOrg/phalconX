<?php
ini_set('xdebug.var_display_max_depth', 5);
ini_set('xdebug.var_display_max_data', 10000);
ini_set('xdebug.var_display_max_children', 256);

/**
 * Application Environments.
 */
define('ENV', getenv('ENVIRONMENT') ?? 'production');
define('MODE', getenv('MODE') ?? 'normal');

if (ENV === 'development') {
    ini_set('display_errors', true);
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_ALL);
}

/**
 * Pathes.
 */
define('DS', DIRECTORY_SEPARATOR);
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(dirname(__FILE__)));
}

/**
 * Detect sub domain for routing
 */
define('SUBDOMAIN', '');
require_once ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/app/engine/Config.php';
require_once ROOT_PATH . '/app/engine/Init.php';
require_once ROOT_PATH . '/app/engine/App.php';
require_once ROOT_PATH . '/app/engine/Cli.php';

$application = new Engine\Cli();
$application->run(MODE);
$application->getOutput();
