<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controler;

use Core\Pattern\GetterSetter;

/**
 * Description of Date
 *
 * @author fabien.sanchez
 */
class Date {
	
	
	
	use GetterSetter;
	
	private $year;

	private function set_year(/* int */$year) {
		$this->year = $year;
	}

	private function get_year() {
		return $this->year;
	}

	private $month;
	private function set_month(/*int*/$month) {
		$this->month = $month;
	}
	private function get_month() {
		return $this->year;
	}
	
	private $day;
	private function set_day(/*int*/$day) {
		$this->day = $day;
	}
	private function get_day() {
		return $this->year;
	}

	public function __construct(/*string*/$date = '') {
		if(strlen($date) > 4){
			if(strlen($date) > 6){
				$this->day = (int)substr($date, -2);
				$date = substr($date, 0, -2);
			} else {
				$this->setDay(1);
			}
			$this->month = (int)substr($date, -2);
			$date = substr($date, 0, -2);
		} else {
			$this->month = 1;
		}
		if(strlen($date)>0){
			
		}
	}
	
}
