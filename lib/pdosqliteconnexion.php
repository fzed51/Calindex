<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pdosqliteconnexion
 *
 * @author fabien.sanchez
 */
class PDOSqLiteConnexion extends PDOConnexion{


	function __construct($path) {
		if(file_exists($path)){
			$this->setDNS("sqlite:" . $path);
		}
	}


	
}
