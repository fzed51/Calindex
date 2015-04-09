<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class iCalException extends \Exception {

}

/**
 *
 * @author fzed51
 */
abstract class iCalContains {

	public $__sub = [];

	final function add($sub) {
		if ($sub instanceof iCalContains) {
			array_push($this->__sub, $sub);
		} else {
			throw new iCalException("Vous tantez d'ajouter un élément non valable à une classe iCal");
		}
	}

}
