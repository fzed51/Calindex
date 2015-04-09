<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of iCal
 *
 * @author fabien.sanchez
 */
class iCal extends iCalContains {

	function getEventAt(\App\Controler\Date $date) {
		$events = [];
		/**
		 * @var Event Description
		 */
		foreach ($this->__sub as $event) {
			if ($event instanceof Event) {
				if ($date->compare($event->DTSTART) >= 0 && $date->compare($event->DTEND)) {
					$events[] = $event;
				}
			}
		}

		return $events;
	}

}
