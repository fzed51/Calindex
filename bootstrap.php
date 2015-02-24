<?php

use App\App;
use Core\Autoloader;

date_default_timezone_set ('Europe/Paris');

define ('DS', DIRECTORY_SEPARATOR);
define ('WS', '/');
define ('ROOT', __DIR__);
define ('ROOT_VUE', ROOT . DS . 'app' . DS . 'vue');
define ('WEBROOT', 'localhost');

require ROOT.DS.'core'.DS.'autoloader.class.php';
$autoloader = new Autoloader();
$autoloader->activeCache(true)
    ->addExtension('.php')
    ->addExtension('.class.php')
    ->addFolder(ROOT, true)
    ->addFolder(ROOT.DS.'lib', true)
    ->register();

(new App('Mon site'))
    ->run();

unset($autoloader);