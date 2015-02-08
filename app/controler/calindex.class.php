<?php

namespace App\Controler;

use Calendrier;
use DateTime;
use Vue;

class Calindex {
	
	function index(){
		$now = new DateTime();
		$annee = (int) $now->format('Y');
		$mois = (int) $now->format('m');
		$this->affiche($annee, $mois);
	}
	
	private function premier_du_mois($annee, $mois, $modif = 0) {
		$date = new DateTime($annee.$mois.'01');
		$modif = (int)$modif;
		if($modif != 0){
			$date->modify("$modif month");
		}
		return $date;
	}
	
	function affiche($annee, $mois){
		$vue = new Vue(__DIR__.'/vue_3_mois.phtml');
		
		$oMoisAvant = new Calendrier($this->premier_du_mois($annee, $mois, -1));
		$oMois      = new Calendrier($this->premier_du_mois($annee, $mois));
		$oMoisApres = new Calendrier($this->premier_du_mois($annee, $mois, 1));
		
		$mois_precedant = $oMoisAvant->getData();
		$mois_en_cours  = $oMois->getData();
		$mois_suivant   = $oMoisApres->getData();
		
		$data = compact($mois_precedant, $mois_en_cours, $mois_suivant);
		die(print_r($data));
		$vue->affiche($data);		
	}

	function newEventPermanent($annee, $mois, $jour, $param=[]){
		$vue = new Vue(__DIR__.'nouveau_evenement_permanent.phtml');


	}
	
}
