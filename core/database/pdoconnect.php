<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Database;

/**
 * Description of pdoconnect
 *
 * @author fabien.sanchez
 */
class PDOConnect Extends \PDO{
		
	static private $instance;
			
	function __construct(iPDOConnexion $connexion) {
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

}