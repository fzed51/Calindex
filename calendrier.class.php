<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calendrier
 *
 * @author fabien.sanchez
 */

class Calendrier {

	public $annee;
	public $mois;
	public $evenement_perpetuel;
	public $evenement_normal;
	public $jours_ferier;
			
	function __construct(Array $anneeMois) {
		$annee = 2000;
		$mois = 1;
		extract($anneeMois, EXTR_IF_EXISTS);
		$this->annee = $annee;
		$this->mois = $mois;
		$this->evenement_perpetuel = array();
		$this->evenement_normal = array();
	}
	
	function getData() {
		$this->make_evenement_perpetuel();
		$this->make_evenement_normal();
		$this->make_jours_ferier();
		$infos = $this->getInfos();
		$jours = $this->getJours();
		return compact($infos, $jours);
	}
	
	private function make_evenement_perpetuel() {
				
	}
	
	private function make_evenement_normal() {
				
	}
	
	private function make_jours_ferier() {
				
	}
	
	private function getInfos() {
		$strMois = [
			'janvier',
			'février',
			'mars',
			'avril',
			'mais',
			'juin',
			'juillet',
			'août',
			'septembre',
			'octobre',
			'novembre',
			'décembre'
		];
		$annee = $this->annee;
		$mois = $this->mois;
		$nom_mois = $strMois[$mois - 1];
		return compact($annee, $mois, $nom_mois);
	}
	
	private function getJours() {
		$jours = array();
		$oJour = new datetime();
		$oJour->setDate($this->annee, $this->mois, 1);
		$oJour->setTime(0,0,0);
		for(;(int)$oJour->format('m') != $this->mois; $oJour->modify('+1 day')){
			$jours[$oJour->format('Ymd')] = $this->getJour($oJour);
		}
	}
	
	private function getJour(datetime $ojour){
		$strJour = [ 'D','L','M','M','J','V','S' ];
		$jour = (int)$oJour->format('d');
		$numJour = (int)$oJour->modify('w');
		$abr_jour = $strJour[$numJour];
		$WE = ($numJour == 0 or $numJour == 6);
	}

}