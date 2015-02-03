<?php

/*
 *
 */

define ('DS', DIRECTORY_SEPARATOR);
define ('WS', '/');
define ('ROOT', __DIR__);
define ('WEBROOT', 'localhost');

require ROOT.DS.'core'.DS.'autoloader.class.php';
(new \Core\Autoloader())
    ->addExtension('.php')
    ->addExtension('.class.php')
    ->addFolder(ROOT, true)
    ->register();

(new \App\App('Mon site'))
    ->run();