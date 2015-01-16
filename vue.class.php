<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class ExceptionVue extends Exception {}
class ExceptionVueInnexistante extends ExceptionVue{}

/**
 * Description of Vue
 *
 * @author fabien.sanchez
 */
class Vue {
	
	public $file = "";
			
	function __construct($file) {
		if(file_exists($file)){
			$this->file = $file;
		}  else {
			throw new ExceptionVueInnexistante();
		}
	}
	
	function affiche($data) {
		extract($data);
		include $this->file;
	}
	
}
