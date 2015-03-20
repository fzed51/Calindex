<?php

use App\App;
use Core\Autoloader;

date_default_timezone_set('Europe/Paris');

define('DS', DIRECTORY_SEPARATOR);
define('WS', '/');
define('ROOT', __DIR__ . DS);
define('ROOT_VUE', ROOT . 'app' . DS . 'vue');
$directory = basename(ROOT);
$tabUrl = explode($directory, filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL));
if (count($tabUrl) > 1) {
    define('WEBROOT', $tabUrl[0] . $directory . WS);
} else {
    define('WEBROOT', WS);
}

require ROOT . DS . 'core' . DS . 'autoloader.class.php';
$autoloader = new Autoloader();
$autoloader->activeCache(true)
        ->addExtension('.php')
        ->addExtension('.class.php')
        ->addFolder(ROOT, true)
        ->addFolder(ROOT . DS . 'lib', true)
        ->register();

(new App('Mon site'))
        ->run();

// utile pour être sur de passer dans le destructeur de l'autoloader.
unset($autoloader);
