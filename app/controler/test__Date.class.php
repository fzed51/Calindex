<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controler;

class test__Date extends \Core\Test {
    
    function test____construct() {
        $s = true;
        
        $oDate1 = new Date();
        $date = date('Ymd');
        $s = $this->testEgal($oDate1, $date, "__construct sans paramètres et __toString") && $s;
		
        $oDate2 = new Date('2014');
        $s = $this->testEgal($oDate2, "20140101", "__construct avec l'année en paramètre") && $s;
		
		
        $oDate3 = new Date('201402');
        $s = $this->testEgal($oDate3, "20140201", "__construct avec l'année et le mois en paramètre") && $s;
		
        $oDate4 = new Date('20140220');
        $s = $this->testEgal($oDate4, "20140220", "__construct avec une date en paramètre") && $s;
        
        return $s;
    }

    function test__add_day(){
		$s = true;

        $oDate = new Date('20140220');
        $oDate->add_day(90);
        $s = $this->testEgal($oDate,   '20140521', 'add_day 90 jours') && $s;
		
		$oDate2 = new Date('20140220');
        $oDate2c = $oDate2->add_day(90, true);
		$s = $this->testEgal($oDate2,  '20140220', 'add_day avec clone, date d\'origine inchangée') && $s;
		$s = $this->testEgal($oDate2c, '20140521', 'add_day avec clone, control du clone') && $s;
		
		$oDate3 = new Date('20140220');
        $oDate3->add_day(4000);
		$s = $this->testEgal($oDate3,  '20250202', 'add_day 4000 jours') && $s;

        return $s; 
    }
    
}