<?php

namespace App\Controler;

use App\Vue\Vue;
use App\Controler\Date;

class Calindex {

	function index() {
		$now = new Date();
		$this->affiche($now->year, $now->month);
	}

	private function premier_du_mois($annee, $mois, $modif = 0) {
		$date = Date::make($annee, $mois, 1);
		$modif = (int) $modif;
		if ($modif != 0) {
			$date->add_month($modif);
		}
		return $date;
	}

	function affiche($annee, $mois) {
		$vue = new Vue('vue_3_mois');

		$oMoisAvant = new Calendrier($this->premier_du_mois($annee, $mois, -1));
		$oMois = new Calendrier($this->premier_du_mois($annee, $mois));
		$oMoisApres = new Calendrier($this->premier_du_mois($annee, $mois, 1));

		$mois_precedant = $oMoisAvant->getData();
		$mois_en_cours = $oMois->getData();
		$mois_suivant = $oMoisApres->getData();

		$data = compact('mois_precedant', 'mois_en_cours', 'mois_suivant');
		echo $vue->render($data);
	}

	function newEventPermanent($annee, $mois, $jour, $param = []) {
		$vue = new Vue('nouveau_evenement_permanent');
	}

}
