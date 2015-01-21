<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pdoconnect
 *
 * @author fabien.sanchez
 */
class PDOConnect {
		
	static private $instance;
			
	function __construct(PDOConnexion $connexion) {
		if(is_null(self::$instance) ) {
				parent::__construct(
						$connexion->getDNS(), 
						$connexion->getUser(),
						$connexion->getPwd(),
						$connexion->getOptions());
			} else {
			self::$instance = $this;
		}
	}
	
	/**
	 * @static
	 * @return instance
	 */
	static function getInstance(){
		if (is_null(self::$instance)){
			self::$instance = new MyDB();
		}
		return self::$instance;
	}
	
	
	
}