<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calindex
 *
 * @author fabien.sanchez
 */
class Calindex {
	
	function index(){
		$now = new DateTime();
		$annee = (int) $now->format('Y');
		$mois = (int) $now->format('m');
		$this->affiche($annee, $mois);
	}
	
	private function annee_mois($annee, $mois, $modif = 0) {
		$modif = (int)$modif;
		if($modif != 0){
			$date = new DateTime($annee.$mois.'1');
			$date->modify("$modif month");
			$annee = (int)$date->format('Y');
			$mois  = (int)$date->format('m');
		}
		return compact($annee, $mois);
	}
	
	function affiche($annee, $mois){
		$vue = new Vue(__DIR__.'/vue_3_mois.php');
		
		$oMoisAvant = new Calendrier($this->annee_mois($annee, $mois, -1));
		$oMois      = new Calendrier($this->annee_mois($annee, $mois));
		$oMoisApres = new Calendrier($this->annee_mois($annee, $mois, 1));
		
		$mois_precedant = $oMoisAvant->getData();
		$mois_en_cours  = $oMois->getData();
		$mois_suivant   = $oMoisApres->getData();
		
		$data = compact($mois_precedant, $mois_en_cours, $mois_suivant);
		
		$vue->affiche($data);		
	}

	function newEventPermanent($annee, $mois, $jour, $param=[]){
		$vue = new Vue(__DIR__.'nouveau_evenement_permanent.php');


	}
	
}
