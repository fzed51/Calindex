<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controler;

/**
 * Description of IcsParser
 *
 * @author fzed51
 */
class test__IcsParser extends \Core\Test {

	function test__parseIcs() {
		$data = "BEGIN:VCALENDAR
METHOD:PUBLISH
PRODID:-//education.gouv.fr//NONSGML iCalcreator 2.6//
VERSION:2.0
X-WR-CALNAME:Calendrier Scolaire - Zones A B C
X-WR-CALDESC:Calendrier Scolaire - Zones A B C
X-WR-TIMEZONE:Europe/Paris
BEGIN:VEVENT
UID:66_73_80@education.gouv.fr
DTSTAMP:20140516T145118Z
DESCRIPTION:Rentrée scolaire des enseignants
DTSTART;VALUE=DATE:20080901
LOCATION:Aix-Marseille\, Amiens\, Besançon\, Bordeaux\, Caen\, Clermont-Fe
 rrand\, Créteil\, Dijon\, Grenoble\, Lille\, Limoges\, Lyon\, Montpellier
 \, Nancy-Metz\, Nantes\, Nice\, Orléans-Tours\, Paris\, Poitiers\, Reims\
 , Rennes\, Rouen\, Strasbourg\, Toulouse\, Versailles
SUMMARY:Rentrée scolaire des enseignants - Zones A B C
TRANSP:TRANSPARENT
END:VEVENT
BEGIN:VEVENT
UID:67_74_81@education.gouv.fr
DTSTAMP:20140516T145118Z
DESCRIPTION:Rentrée scolaire des élèves
DTSTART;VALUE=DATE:20080902
LOCATION:Aix-Marseille\, Amiens\, Besançon\, Bordeaux\, Caen\, Clermont-Fe
 rrand\, Créteil\, Dijon\, Grenoble\, Lille\, Limoges\, Lyon\, Montpellier
 \, Nancy-Metz\, Nantes\, Nice\, Orléans-Tours\, Paris\, Poitiers\, Reims\
 , Rennes\, Rouen\, Strasbourg\, Toulouse\, Versailles
SUMMARY:Rentrée scolaire des élèves - Zones A B C
TRANSP:TRANSPARENT
END:VEVENT
BEGIN:VEVENT
UID:68_75_82@education.gouv.fr
DTSTAMP:20140516T145118Z
DESCRIPTION:Vacances de la Toussaint
DTSTART;VALUE=DATE:20081025
DTEND;VALUE=DATE:20081106
LOCATION:Aix-Marseille\, Amiens\, Besançon\, Bordeaux\, Caen\, Clermont-Fe
 rrand\, Créteil\, Dijon\, Grenoble\, Lille\, Limoges\, Lyon\, Montpellier
 \, Nancy-Metz\, Nantes\, Nice\, Orléans-Tours\, Paris\, Poitiers\, Reims\
 , Rennes\, Rouen\, Strasbourg\, Toulouse\, Versailles
SUMMARY:Vacances de la Toussaint - Zones A B C
TRANSP:TRANSPARENT
END:VEVENT
BEGIN:VEVENT
UID:69_76_83@education.gouv.fr
DTSTAMP:20140516T145118Z
DESCRIPTION:Vacances de Noël
DTSTART;VALUE=DATE:20081220
DTEND;VALUE=DATE:20090105
LOCATION:Aix-Marseille\, Amiens\, Besançon\, Bordeaux\, Caen\, Clermont-Fe
 rrand\, Créteil\, Dijon\, Grenoble\, Lille\, Limoges\, Lyon\, Montpellier
 \, Nancy-Metz\, Nantes\, Nice\, Orléans-Tours\, Paris\, Poitiers\, Reims\
 , Rennes\, Rouen\, Strasbourg\, Toulouse\, Versailles
SUMMARY:Vacances de Noël - Zones A B C
TRANSP:TRANSPARENT
END:VEVENT
BEGIN:VEVENT
UID:70@education.gouv.fr
DTSTAMP:20140516T145118Z
DESCRIPTION:Vacances d'hiver
DTSTART;VALUE=DATE:20090207
DTEND;VALUE=DATE:20090223
LOCATION:Caen\, Clermont-Ferrand\, Grenoble\, Lyon\, Montpellier\, Nancy-Me
 tz\, Nantes\, Rennes\, Toulouse
SUMMARY:Vacances d'hiver - Zone A
TRANSP:TRANSPARENT
END:VEVENT
BEGIN:VEVENT
UID:84@education.gouv.fr
DTSTAMP:20140516T145118Z
DESCRIPTION:Vacances d'hiver
DTSTART;VALUE=DATE:20090214
DTEND;VALUE=DATE:20090302
LOCATION:Bordeaux\, Créteil\, Paris\, Versailles
SUMMARY:Vacances d'hiver - Zone C
TRANSP:TRANSPARENT
END:VEVENT
BEGIN:VEVENT
UID:77@education.gouv.fr
DTSTAMP:20140516T145118Z
DESCRIPTION:Vacances d'hiver
DTSTART;VALUE=DATE:20090221
DTEND;VALUE=DATE:20090309
LOCATION:Aix-Marseille\, Amiens\, Besançon\, Dijon\, Lille\, Limoges\, Nic
 e\, Orléans-Tours\, Poitiers\, Reims\, Rouen\, Strasbourg
SUMMARY:Vacances d'hiver - Zone B
TRANSP:TRANSPARENT
END:VEVENT
BEGIN:VEVENT
UID:71@education.gouv.fr
DTSTAMP:20140516T145118Z
DESCRIPTION:Vacances de printemps
DTSTART;VALUE=DATE:20090404
DTEND;VALUE=DATE:20090420
LOCATION:Caen\, Clermont-Ferrand\, Grenoble\, Lyon\, Montpellier\, Nancy-Me
 tz\, Nantes\, Rennes\, Toulouse
SUMMARY:Vacances de printemps - Zone A
TRANSP:TRANSPARENT
END:VEVENT
END:VCALENDAR";
		$flename = ROOT_TMP . 'cache.test_calendrier_vacances.ics';
		file_put_contents($flename, $data);
		$parser = new IcsParser($flename);
		$calendar = $parser->getParse();

		$this->testEgal($calendar->VERSION, '2.0', 'La version du calendrier est 2.0');
	}

}
