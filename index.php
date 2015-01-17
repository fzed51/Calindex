<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require './autoloader.class.php';
(new \autoloader())->addParentFolder()->register();

$param = array_merge($_GET, $_COOKIE, $_POST);

$app = new \Calindex();

if (isset($param['annee'], $param['mois'])){
	$annee = (int)$param['annee'];
	$mois  = (int)$param['mois'];
	if($mois < 1 || $mois > 12){
		$app->index();
	}else{
		$app->affiche($annee, $mois);
	}
}else{
	$app->index();
}