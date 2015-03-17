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
        $oDate2 = new Date('2014');
        $oDate3 = new Date('201402');
        $oDate4 = new Date('20140220');
        $date = date('Ymd');
        
        $s = $this->testEgal($oDate1, $date, "__construct sans paramètres et __toString") && $s;
        $s = $this->testEgal($oDate2, "20140101", "__construct avec l'année en paramètre") && $s;
        $s = $this->testEgal($oDate3, "20140201", "__construct avec l'année et le mois en paramètre") && $s;
        $s = $this->testEgal($oDate4, "20140220", "__construct avec une date en paramètre") && $s;
        
        return $s;
    }
    
}