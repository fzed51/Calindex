<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of evenementpermanent
 *
 * @author fabien.sanchez
 */
class EvenementPermanent extends Evenements {
	
	static private $table_name = 'events_permanents';
	static private $pk_name = 'id';
	
	static private $champs = [
		'id',
		'mois',
		'jour', 
		'annee',
		'libelle',
		'modified',
		'created'
	];
	
	static private $notNull = [
		'id',
		'mois',
		'jour', 
		'annee',
		'libelle'
	];
	
	function __construct(array $data) {
		$clearData = $this->clearField($data);
		$this->data = $data;
	}

	static function getFromMonth($month) {
		$dbo = MyDB::getInstance();
		
	}
}
