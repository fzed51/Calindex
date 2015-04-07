<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controler\ICal;

use App\Controler\Date;
use Exception;
use stdClass;

/**
 * Description of IcsParser
 *
 * @author fzed51
 */
class IcsParser {

	/**
	 * $data contien le contenu du fichier ics
	 * @var array
	 */
	private $data = [];

	/**
	 * $read_point position de lecture dans data
	 * @var int
	 */
	private $read_point = 0;

	/**
	 * 	Résultat du parse
	 * @var stdClass
	 */
	private $data_parsed = null;

	/**
	 * __construct
	 * @param type $filename
	 */
	public function __construct(/* string */$filename) {
		$data_string = file_get_contents($filename);
		$this->data = explode("\n", $data_string);
		$this->parseIcs();
	}

	/**
	 * readData
	 * Lit la ligne suivante de data
	 * @return boolean|string
	 */
	private function readData() {
		if ($this->read_point < count($this->data)) {
			$line = $this->data[$this->read_point];
			$this->read_point++;
		} else {
			$line = FALSE;
		}
		return $line;
	}

	/**
	 * parseIcs
	 * méthode de parse principale
	 * @throws Exception
	 */
	private function parseIcs() {
		$line = '';
		while ('BEGIN:VCALENDAR' != trim($line = $this->readData())) {
			if ($line === FALSE) {
				throw new Exception("le fichier parser n'est pas valide\nLa balise 'BEGIN:VCALENDAR' était attendu.");
			}
			$line = $this->readData();
		}
		$this->data_parsed = $this->parseSubElement('VCALENDAR');
	}

	/**
	 *
	 * @param stdClass $elementSuperieur
	 * @param string $lastType
	 * @return stdClass
	 */
	private function parseSubElement(/* string */ $lastType) {
		$line = '';
		$subElement = new stdClass();
		$lastKey = '__ERROR__';
		$subElement->__sub = [];
		while (false !== trim($line = $this->readData())) {
			$line = rtrim($line);
			if (1 === preg_match("/([^;:]+)(?:;([^:]*))?:(.+)/", $line, $output_array)) {
				$key = $output_array[1];
				$lastKey = $key;
				$opt = $output_array[2];
				$val = $output_array[3];
				switch ($key) {
					case 'BEGIN':
						$lastType = $val;
						array_push($subElement->__sub, $this->parseSubElement($lastType));
						break;
					case 'END':
						return $subElement;
					default :
						switch ($opt) {
							case 'VALUE=DATE':
								$subElement->$key = new Date($val);
								break;
							default :
								$subElement->$key = $val;
						}
				}
			} else {
				if ($line[0] === ' ') {
					$subElement->$lastKey .= trim($line);
				}
			}
		}
		throw new Exception('Le sous element ne se termine pas');
	}

	function getParse() {
		return $this->data_parsed;
	}

}
