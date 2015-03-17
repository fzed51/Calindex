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
        
        $oDate = new Date();
        $date = date('Ymd');
        
        $s = $s &&  $this->testEgal($oDate, $date, "__construct sans paramètres et __toString");
        
        return $s;
    }
    
}