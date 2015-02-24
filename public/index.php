<?php
if( ini_get('date.timezone') == '' ){
    date_default_timezone_set('Europe/Paris');
}
include __DIR__."\..\core\pattern\GetterSetter.php";
include __DIR__."\..\App\Controler\Date.php";
$d = new App\Controler\Date();
$p = App\Controler\Date::lundi_paques($d->year);

print ($d->format("le dd/mm/yyyy est un dddd.")."<br>");
print ($p->format("le dd/mm/yyyy est un dddd.")."<br>");
print ($d->format()."<br>");
die();
require (__DIR__.'/../bootstrap.php');
