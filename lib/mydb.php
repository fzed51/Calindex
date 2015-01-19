<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mydb
 *
 * @author fabien.sanchez
 */
class MyDB extends PDOConnect{

	static private $instance;
	
	private function __construct() {
		
		$info = new PDOSqLiteConnexion("../_db_/calindex.db");
		parent::__construct($info);
		self::$instance = $this;
		
	}
	
	static function getInstance(){
		if (is_null(self::$instance)){
			$db = new MyDB();
		}
		return self::$instance;
	}

}
