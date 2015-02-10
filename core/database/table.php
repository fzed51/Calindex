<?php

namespace Core\Database;

class ExceptionTable extends \Exception {}
class ExceptionFildUnknow extends ExceptionTable {
	public function __construct($field) {
		parent::__construct("Le champ <$field> est inconnu !");
	}
}

class Table {
	protected $table;
	protected $db;
	public function __construct(PDOConnect $db) {
		$this->db = $db;		
		if(is_null($this->table)){
			$parts = explode('\\', get_class($this));
			$class_name = end($parts);
			$this->table = strtolower(str_replace('Table', '', $class_name));	
		}
	}
		
}
