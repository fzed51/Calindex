<?php
if( ini_get('date.timezone') == '' ){
    date_default_timezone_set('Europe/Paris');
}
echo "1<br>";
include __DIR__."\..\core\pattern\GetterSetter.php";
echo "2<br>";
include __DIR__."\..\App\Controler\Date.php";
echo "3<br>";
$d = new App\Controler\Date();
echo "4<br>";
$p = App\Controler\Date::lundi_paques($d->year);
echo "5<br>";

print ($d->format("le dd/mm/yyyy est un dddd.")."\n");
echo "6<br>";
print ($p->format("le dd/mm/yyyy est un dddd.")."\n");
echo "7<br>";
print ($d->format()."\n");
echo "8<br>";
die();
require (__DIR__.'/../bootstrap.php');
