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
        $oDate3->add_day(4000, false);
        $tDate = new \DateTime();
        $tDate->setDate(2014, 2, 20);
        $tDate->modify('+ 4000 day');
        $this->testEgal($oDate3, $tDate->format("Ymd"), 'add_day 4000 jours');

        $oDate4 = new Date('20140220');
        $oDate4->add_day(366, false);
        $tDate = new \DateTime();
        $tDate->setDate(2014, 2, 20);
        $tDate->modify('+ 366 day');
        $this->testEgal($oDate4, $tDate->format("Ymd"), 'add_day 366 jours');
    }

    function test__sub_day() {
        $oDate = new Date('20140220');
        $oDate->sub_day(90);
        $tDate = new \DateTime();
        $tDate->setDate(2014, 02, 20);
        $tDate->modify('-90 day');
        $this->testEgal($oDate, $tDate->format('Ymd'), 'sub_day 90 jours');

        $oDate2 = new Date('20140220');
        $oDate2c = $oDate2->sub_day(90, true);
        $this->testEgal($oDate2, '20140220', 'sub_day avec clone, date d\'origine inchangée');
        $this->testEgal($oDate2c, $tDate->format('Ymd'), 'sub_day avec clone, control du clone');

        $oDate3 = new Date('20140220');
        $oDate3->add_day(4000, false);
        $tDate = new \DateTime();
        $tDate->setDate(2014, 2, 20);
        $tDate->modify('+ 4000 day');
        $this->testEgal($oDate3, $tDate->format("Ymd"), 'sub_day 4000 jours');
    }

    function test__add_month() {

        $oDate = new Date('20150131');
        $oDate->add_month(1);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('+ 1 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'add_month 1 mois avec jour qui déborde.');

        $oDatec1 = clone $oDate;
        $oDatec2 = $oDatec1->add_month(1, true);
        $this->testEgal($oDatec1, $tDate->format("Ymd"), 'add_month 1 mois avec clone, doit rester identique.');
        $tDate->modify('+ 1 month');
        $this->testEgal($oDatec2, $tDate->format("Ymd"), 'add_month 1 mois cloné.');


        $oDate = new Date('20150131');
        $oDate->add_month(2);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('+ 2 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'add_month 2 mois.');

        $oDate = new Date('20150131');
        $oDate->add_month(3);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('+ 3 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'add_month 3 mois avec jour qui déborde.');

        $oDate = new Date('20150131');
        $oDate->add_month(6);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('+ 6 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'add_month 6 mois.');

        $oDate = new Date('20150131');
        $oDate->add_month(12);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('+ 12 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'add_month 12 mois.');

        $oDate = new Date('20150131');
        $oDate->add_month(13);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('+ 13 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'add_month 13 mois.');
    }

    function test__sub_month() {

        $oDate = new Date('20150131');
        $oDate->sub_month(1);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('- 1 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'sub_month 1 mois.');

        $oDate = new Date('20150331');
        $oDate->sub_month(1);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 3, 31);
        $tDate->modify('- 1 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'sub_month 1 mois avec le jour qui déborde.');

        $oDate = new Date('20150131');
        $oDate->sub_month(2);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('- 2 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'sub_month 2 mois avec le jour qui déborde.');

        $oDate = new Date('20150131');
        $oDate->sub_month(3);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('- 3 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'sub_month 3 mois.');

        $oDate = new Date('20150131');
        $oDate->sub_month(6);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('- 6 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'sub_month 6 mois.');

        $oDate = new Date('20150131');
        $oDate->sub_month(12);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('- 12 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'sub_month 12 mois.');

        $oDate = new Date('20150131');
        $oDate->sub_month(13);
        $tDate = new \DateTime();
        $tDate->setDate(2015, 1, 31);
        $tDate->modify('- 13 month');
        $this->testEgal($oDate, $tDate->format("Ymd"), 'sub_month 13 mois.');
    }

    function test__static_make() {
        $this->testEgal(Date::make(2012, 1, 1), '20120101', 'création de la date 1er janvier 2012');
        $this->testEgal(Date::make(2014, 12, 24), '20141224', 'création de la date 24 décembre 2014');
        $this->testEgal(Date::make(2015, 3, 2), '20150302', 'création de la date 2 mars 2015');
    }

    function test__static_annee_bisextille() {
        $this->testEgal(Date::annee_bisextille(2010), false, '2010 n\'est pas une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2011), false, '2011 n\'est pas une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2012), true, '2012 est une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2013), false, '2013 n\'est pas une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2014), false, '2014 n\'est pas une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2015), false, '2015 n\'est pas une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2016), true, '2016 est une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2017), false, '2017 n\'est pas une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2018), false, '2018 n\'est pas une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2019), false, '2019 n\'est pas une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2020), true, '2020 est une année bissextile.');
        $this->testEgal(Date::annee_bisextille(2072), true, '2072 est une année bissextile.');
    }

    function test__static_nb_jours_mois() {

        $oDate = Date::nb_jours_mois(2010, 1);
    }

    function test__static_dimanche_paques() {
        $this->testEgal(Date::dimanche_paques(2015), '20150405', 'en 2015 paques est le 5 avril');
        $this->testEgal(Date::dimanche_paques(2016), '20160327', 'en 2016 paques est le 27 mars');
        $this->testEgal(Date::dimanche_paques(2017), '20170416', 'en 2017 paques est le 16 avril');
        $this->testEgal(Date::dimanche_paques(2018), '20180401', 'en 2018 paques est le 1er avril');
        $this->testEgal(Date::dimanche_paques(2019), '20190421', 'en 2019 paques est le 21 avril');
        $this->testEgal(Date::dimanche_paques(2020), '20200412', 'en 2020 paques est le 12 avril');
        $this->testEgal(Date::dimanche_paques(2021), '20210404', 'en 2021 paques est le 4 avril');
        $this->testEgal(Date::dimanche_paques(2022), '20220417', 'en 2022 paques est le 17 avril');
    }

}
