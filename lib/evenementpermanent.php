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
	
	/** 
	 * @var string $table_name  nom de la table
	 */
	static private $table_name = 'events_permanents';
	/** 
	 * @var string $pk_name  clé primaire de la table
	 */
	static private $pk_name = 'id';
	/** 
	 * @var string[] $champs Liste de champ 
	 */
	static private $champs = [
		'id',
		'mois',
		'jour', 
		'annee',
		'libelle',
		'modified',
		'created'
	];
	/** 
	 * @var string[] $notNull Liste des champs non null  
	 */
	static private $notNull = [
		'id',
		'mois',
		'jour', 
		'annee',
		'libelle'
	];
	
	/**
	 * @param array $data [(int)$annee, (int)$mois]
	 */
	function __construct(array $data) {
		$this->data = $this->clearField($data);
	}

	/**
	 * @param int $mois
	 * @return EvenementPermanent[]
	 */
	static function getMonth( /*int*/$mois ) {
		/** 
		 * @var EvenementPermanent[] $events 
		 */
		$events = [];
		$dbo = MyDB::getInstance();
		$sql = "Select * from " . self::$table_name . " where mois = :month";
		$req = $dbo->prepare($sql, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED]);
		$rep = $req->execute([':month'=> $mois ]);
		foreach ($rep as $row) {
			array_push($events, new EvenementPermanent($row));			
		}
		return $events;
	}
}
