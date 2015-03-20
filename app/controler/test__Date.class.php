<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controler;

class test__Date extends \Core\Test {

	function test____construct() {
		$oDate1 = new Date();
		$date = date('Ymd');
		$this->testEgal($oDate1, $date, "__construct sans paramètres et __toString");

		$oDate2 = new Date('2014');
		$this->testEgal($oDate2, "20140101", "__construct avec l'année en paramètre");

		$oDate3 = new Date('201402');
		$this->testEgal($oDate3, "20140201", "__construct avec l'année et le mois en paramètre");

		$oDate4 = new Date('20140220');
		$this->testEgal($oDate4, "20140220", "__construct avec une date en paramètre");
	}

	function test__add_day() {
		$oDate = new Date('20140220');
		$oDate->add_day(90);
		$this->testEgal($oDate, '20140521', 'add_day 90 jours');

		$oDate2 = new Date('20140220');
		$oDate2c = $oDate2->add_day(90, true);
		$this->testEgal($oDate2, '20140220', 'add_day avec clone, date d\'origine inchangée');
		$this->testEgal($oDate2c, '20140521', 'add_day avec clone, control du clone');

		$oDate3 = new Date('20140220');
		$oDate3->add_day(4000, false, true);
		$tDate = new \DateTime();
		$tDate->setDate(2014, 5, 20);
		$tDate->modify('+ 4000 day');
		$this->testEgal($oDate3, $tDate->format("Ymd"), 'add_day 4000 jours');
	}

	function test__add_month() {

		$oDate = new Date('20150131');
		$oDate->add_month(1);
		$tDate = new \DateTime();
		$tDate->setDate(2015, 1, 31);
		$tDate->modify('+ 1 month');
		$this->testEgal($oDate, $tDate->format("Ymd"), 'add_month resultat non valide. doit être arrangé.');

		$oDate = new Date('20150131');
		$oDate->add_month(2);
		$tDate = new \DateTime();
		$tDate->setDate(2015, 1, 31);
		$tDate->modify('+ 2 month');
		$this->testEgal($oDate, $tDate->format("Ymd"), 'add_month resultat non valide. doit être arrangé.');

		$oDate = new Date('20150131');
		$oDate->add_month(3);
		$tDate = new \DateTime();
		$tDate->setDate(2015, 1, 31);
		$tDate->modify('+ 3 month');
		$this->testEgal($oDate, $tDate->format("Ymd"), 'add_month resultat non valide. doit être arrangé.');

		$oDate = new Date('20150131');
		$oDate->add_month(6);
		$tDate = new \DateTime();
		$tDate->setDate(2015, 1, 31);
		$tDate->modify('+ 6 month');
		$this->testEgal($oDate, $tDate->format("Ymd"), 'add_month resultat non valide. doit être arrangé.');

		$oDate = new Date('20150131');
		$oDate->add_month(12);
		$tDate = new \DateTime();
		$tDate->setDate(2015, 1, 31);
		$tDate->modify('+ 12 month');
		$this->testEgal($oDate, $tDate->format("Ymd"), 'add_month resultat non valide. doit être arrangé.');

		$oDate = new Date('20150131');
		$oDate->add_month(18);
		$tDate = new \DateTime();
		$tDate->setDate(2015, 1, 31);
		$tDate->modify('+ 18 month');
		$this->testEgal($oDate, $tDate->format("Ymd"), 'add_month resultat non valide. doit être arrangé.');

		$oDate = new Date('20150131');
		$oDate->add_month(24);
		$tDate = new \DateTime();
		$tDate->setDate(2015, 1, 31);
		$tDate->modify('+ 24 month');
		$this->testEgal($oDate, $tDate->format("Ymd"), 'add_month resultat non valide. doit être arrangé.');
	}

}
