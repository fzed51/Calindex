<?php
include __DIR__."\..\core\pattern\GetterSetter.php";
include __DIR__."\..\App\Controler\Date.php";
$d = new App\Controler\Date();
$p = App\Controler\Date::lundi_paques($d->year);
var_dump($d);
var_dump($p);
print $p."\n";
print "le $d est un ".$d->format()."\n";
print "le $p est un ".$p->format()."\n";

die();
require (__DIR__.'/../bootstrap.php');
