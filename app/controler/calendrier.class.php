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
            $feries[] = Date::make($annee, 01, 01);
            $feries[] = Date::make($annee, 05, 01);
            $feries[] = Date::make($annee, 05, 08);
            $feries[] = Date::make($annee, 07, 14);
            $feries[] = Date::make($annee, 08, 15);
            $feries[] = Date::make($annee, 11, 01);
            $feries[] = Date::make($annee, 11, 11);
            $feries[] = Date::make($annee, 12, 24);
            $feries[] = Date::lundi_paques($annee);
            $feries[] = Date::ascension($annee);
            $feries[] = Date::pentecote($annee);
            $this->jours_ferier = $feries;
        }
    }

    private function make_vacances() {
        
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
        for ($oJour = Date::make($this->annee, $this->mois, 1); $oJour->month != $this->mois; $oJour->add_day(1)) {
            $jours[$oJour->format()] = $this->getJour($oJour);
        }
        return $jours;
    }

    private function getJour(Date $oJour) {
        $jour = $oJour->day;
        // @todo :  modifier la ligne suivante après avoir modifier la 
        //          classe Date pour récupérer le numéro du jour.
        $numJour = (int) $oJour->modify('w');
        $abr_jour = $oJour->format('ddd');
        $WE = ($numJour == 0 or $numJour == 6);
        $ferier = false;
        $eventPermanent = [];
        $eventNormal = [];
        $vacancesZA = false;
        $vacancesZB = false;
        $vacancesZC = false;
        return compact('jour', 'numJour', 'abr_jour', 'WE', 'ferier', 'eventPermanent', 'eventNormal', 'vacancesZA', 'vacancesZB', 'vacancesZC');
    }

}
