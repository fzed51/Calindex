<?php

namespace App\Controler;

use App\Controler\Date;

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

	function __construct(Date $premierJour) {
		$this->annee = $premierJour->year;
		$this->mois = $premierJour->month;
		$this->evenement_perpetuel = array();
		$this->evenement_normal = array();
	}

	function getData() {
		$this->make_evenement_perpetuel();
		$this->make_evenement_normal();
		$this->make_jours_ferier();
		$this->make_vacances();
		$infos = $this->getInfos();
		$jours = $this->getJours();
		return compact('infos', 'jours');
	}

	private function make_evenement_perpetuel() {
		//$events = EvenementPermanent::getMonth($this->mois);
	}

	private function make_evenement_normal() {

	}

	private function make_jours_ferier() {
		if (count($this->jours_ferier) == 0) {
			$annee = $this->annee;
			$feries = [];
			$feries[] = Date::make($annee, 1, 1);
			$feries[] = Date::make($annee, 5, 1);
			$feries[] = Date::make($annee, 5, 8);
			$feries[] = Date::make($annee, 7, 14);
			$feries[] = Date::make($annee, 8, 15);
			$feries[] = Date::make($annee, 11, 1);
			$feries[] = Date::make($annee, 11, 11);
			$feries[] = Date::make($annee, 12, 24);
			$feries[] = Date::lundi_paques($annee);
			$feries[] = Date::ascension($annee);
			$feries[] = Date::pentecote($annee);
			$this->jours_ferier = $feries;
		}
	}

	private function est_jours_ferier($oJour) {
		foreach ($this->jours_ferier as $ferier) {

			if ($oJour->compare($ferier) == 0) {
				return true;
			}
		}
		return false;
	}

	private function make_vacances() {
		$fichier_cache_calendrier = ROOT_TMP . 'cache.calendrier_vacances.ics';
		if (!is_file($fichier_cache_calendrier) || (time() - filemtime($fichier_cache_calendrier)) > (4 * 7 * 24 * 60 * 60)) {
			$url = \Core\Helper\Config::get('CALENDRIER_VACANCES', 'http://www.education.gouv.fr/download.php?file=http%3A%2F%2Fcache.media.education.gouv.fr%2Fics%2FCalendrier_Scolaire_Zones_A_B_C.ics&submit=');
			$content = file_get_contents($url);
			file_put_contents($fichier_cache_calendrier, $content);
		} else {
			file_get_contents($fichier_cache_calendrier);
		}
	}

	private function getInfos() {
		$annee = $this->annee;
		$mois = $this->mois;
		$date = Date::make($annee, $mois, 1);
		$nom_mois = $date->format('mmmm');
		return compact('annee', 'mois', 'nom_mois');
	}

	private function getJours() {
		$jours = array();
		for ($oJour = Date::make($this->annee, $this->mois, 1); $oJour->month == $this->mois; $oJour->add_day(1)) {
			$jours[$oJour->format()] = $this->getJour($oJour);
		}
		return $jours;
	}

	private function getJour(Date $oJour) {
		$now = new Date();
		$jour = $oJour->day;
		$numJour = (int) $oJour->format('j');
		$abr_jour = $oJour->format('ddd');
		$WE = ($numJour == 6 or $numJour == 7);
		$aujourdhui = ($oJour->compare($now)) == 0;
		$ferier = $this->est_jours_ferier($oJour);
		$eventPermanent = [];
		$eventNormal = [];
		$vacancesZA = false;
		$vacancesZB = false;
		$vacancesZC = false;
		return compact('jour', 'numJour', 'abr_jour', 'WE', 'aujourdhui', 'ferier', 'eventPermanent', 'eventNormal', 'vacancesZA', 'vacancesZB', 'vacancesZC');
	}

}
