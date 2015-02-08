<?php

use App\App;
use Core\Autoloader;

date_default_timezone_set ('Europe/Paris');

define ('DS', DIRECTORY_SEPARATOR);
define ('WS', '/');
define ('ROOT', __DIR__);
define ('WEBROOT', 'localhost');

require ROOT.DS.'core'.DS.'autoloader.class.php';
(new Autoloader())
    ->addExtension('.php')
    ->addExtension('.class.php')
    ->addFolder(ROOT, true)
    ->register();

(new App('Mon site'))
    ->run();