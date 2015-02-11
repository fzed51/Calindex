<?php

namespace App\Controler;

use \DateTime;

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

	function __construct(DateTime $premierJour) {
		$this->annee = $premierJour->format('Y');
		$this->mois =  $premierJour->format('m');
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
			$feries[] = DateTime::createFromFormat('Ymd', "{$annee}0101");
			$feries[] = DateTime::createFromFormat('Ymd', "{$annee}0501");
			$feries[] = DateTime::createFromFormat('Ymd', "{$annee}0508");
			$feries[] = DateTime::createFromFormat('Ymd', "{$annee}0714");
			$feries[] = DateTime::createFromFormat('Ymd', "{$annee}0815");
			$feries[] = DateTime::createFromFormat('Ymd', "{$annee}1101");
			$feries[] = DateTime::createFromFormat('Ymd', "{$annee}1111");
			$feries[] = DateTime::createFromFormat('Ymd', "{$annee}1224");
			$feries[] = self::get_LundiPaques($annee);
			$feries[] = self::get_lascension($annee);
			$feries[] = self::get_pentecote($annee);
			$this->jours_ferier = $feries;
		}
	}

	static private function divmod($div, $quo) {
		return [(int)($div / $quo), $div % $quo];
	}

	/**
	 * @static
	 * @param int $annee année du dimanche de pâques recherché
	 * @return DateTime
	 */
	static private function get_DimanchePaques($annee) {
		$n = $annee % 19;
		list($c, $u) = self::divmod($annee, 100);
		list($s, $t) = self::divmod($c, 4);
		$p = (int) (($c + 8) / 25);
		$q = (int) (($c - $p + 1) / 3);
		$e = ( 19 * $n + $c - $s - $q + 15) % 30;
		list($b, $d) = self::divmod($u, 4);
		$l = (32 + 2 * $t + 2 * $b - $e - $d) % 7;
		$h = (int) (($n + 11 * $e + 22 * $l) / 451);
		list($m, $j) = self::divmod($e + $l - 7 * $h + 114, 31);
		$j = $j + 1;
		return DateTime::createFromFormat('Y m d', "$annee $m $j");
	}

	/**
	 * @static
	 * @param int $annee
	 * @return DateTime
	 */
	static private function get_LundiPaques($annee) {
		/* @var $paques DateTime */
		$paques = self::get_DimanchePaques($annee);
		return $paques->modify('+1 day');
	}

	/**
	 * @static
	 * @param int $annee
	 * @return DateTime
	 */
	static private function get_lascension($annee) {
		/* @var $paques DateTime */
		$paques = self::get_DimanchePaques($annee);
		return $paques->modify('+39 day');
	}

	/**
	 * @static
	 * @param int $annee
	 * @return DateTime
	 */
	static private function get_pentecote($annee) {
		/* @var $paques DateTime */
		$paques = self::get_DimanchePaques($annee);
		return $paques->modify('+50 day');
	}

	private function make_vacances() {
		
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
		return compact('annee', 'mois', 'nom_mois');
	}

	private function getJours() {
		$jours = array();
		$oJour = DateTime::createFromFormat('Y m d', "{$this->annee} {$this->mois} 01");
		for (; (int) $oJour->format('m') != $this->mois; 
				$oJour->modify('+1 day')) {
			$jours[$oJour->format('Ymd')] = $this->getJour($oJour);
		}
		return $jours;
	}

	private function getJour(DateTime $ojour) {
		$strJour = [ 'D', 'L', 'M', 'M', 'J', 'V', 'S'];
		$jour = (int) $oJour->format('d');
		$numJour = (int) $oJour->modify('w');
		$abr_jour = $strJour[$numJour];
		$WE = ($numJour == 0 or $numJour == 6);
		$ferier = false;
		$eventPermanent = [];
		$eventNormal = [];
		$vacancesZA = false;
		$vacancesZB = false;
		$vacancesZC = false;
		return compact('jour', 'numJour', 'abr_jour', 'WE', 'ferier', 
				'eventPermanent', 'eventNormal', 'vacancesZA', 'vacancesZB', 
				'vacancesZC');
	}

}
