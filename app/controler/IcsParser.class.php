<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controler;

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
	 * @var array
	 */
	private $data_parsed = [];

	/**
	 * __construct
	 * @param type $filename
	 */
	public function __construct(/* string */$filename) {
		$data_string = file_get_contents($filename);
		$this->data = explode("\n", $data_string);
		$this->parseIcs();
	}

	private function readData() {
		if ($this->read_point < count($this->data)) {
			$line = $this->data[$this->read_point];
			$this->read_point++;
		} else {
			$line = FALSE;
		}
		return $line
	}

	/**
	 * parseIcs
	 * méthode de parse principale
	 */
	private function parseIcs() {

		$line = '';
		$ics = new \stdClass();
		while (FALSE !== ($line = $this->readData())) {
			$line = rtrim($line);
			switch ($line) {
				case 'BEGIN:VEVENT':
					break;
				case 'END:VEVENT':
					break;
				default :
			}
		}
	}

}
