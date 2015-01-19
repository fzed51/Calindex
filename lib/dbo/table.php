<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DBO;

class ExceptionTable extends \Exception {}
class ExceptionFildUnknow extends ExceptionTable {
	public function __construct($field) {
		parent::__construct("Le champ <$field> est inconnu !");
	}
}

/**
 * Description of table
 *
 * @author fabien.sanchez
 */
class Table implements \ArrayAccess{	
	
	static private $table_name = 'table';
	static private $pk_name = 'id';	
	static private $champs = [];
	static private $notNull = [];
	public $data;
	
	protected function clearField(array $data) {
		$dataOut = [];
		foreach (static::$champs as $champ) {
			if(isset($data[$champ])){
				$dataOut[$champ] = $data[$champ];
			}
		}
		return $dataOut;
	}
	
	protected function controlNotNul($data) {
		$out = true;
		foreach (static::$notNull as $champ) {
			$out = $out && isset($data[$champ]) && !empty($data[$champ]);
		}
		return $out;
	}

	protected function fieldExists($field, $throw = true) {
		if(in_array($field, static::$champs)){
			return true;
		} elseif ($throw) {
			throw new ExceptionFildUnknow($field);
		} 
	}


	public function offsetExists($offset) {
		if($this->fieldExists($offset)){
			return isset($this->data[$offset]);
		}
	}

	public function offsetGet($offset) {
		if($this->fieldExists($offset)){
			if($this->offsetExists($offset)){
				return $this->data[$offset];
			} else {
				return null;
			}
		}
	}

	public function offsetSet($offset, $value) {
		if($this->fieldExists($offset)){
			$this->data[$offset] = $value;
		}
	}

	public function offsetUnset($offset) {
		if($this->fieldExists($offset)){
			unset($this->data[$offset]);
		}
	}

}
