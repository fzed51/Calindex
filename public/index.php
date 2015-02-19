<?php
include __DIR__."\..\core\pattern\GetterSetter.php";
include __DIR__."\..\App\Controler\Date.php";
$d = new App\Controler\Date();
$p = App\Controler\Date::lundi_paques($d->year);

print $d->format("le dd/mm/yyyy est un dddd.")."\n";
print $p->format("le dd/mm/yyyy est un dddd.")."\n";

die();
require (__DIR__.'/../bootstrap.php');
