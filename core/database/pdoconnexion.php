<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Database;

/**
 * Description of pdoconnexion
 *
 * @author fabien.sanchez
 */
abstract class PDOConnexion implements PDOConnexionInterface {
	
	private $dns     = NULL;
	private $user    = NULL;
	private $pwd     = NULL;
	private $options = array();
			
	final function getDNS(){
		return $this->dns;
	}
	final function getUser(){
		return $this->user;
	}
	final function getPwd(){
		return $this->pwd;
	}
	final function getOptions(){
		return $this->options;	
	}
	
	protected function setDNS(/*string*/$dns){
		$this->dns = $dns;
	}
	protected function SetUser(/*string*/$user) {
		$this->user = $user;
	}
	protected function SetPwd(/*string*/$pwd) {
		$this->pwd = $pwd;
	}
	protected function SetOptions(array $options) {
		foreach ($options as $key => $value) {
			$this->AddOption($key, $value);
		}
	}
	protected function AddOption($option, $valeur) {
		$this->options[$option] = $valeur;
	}
	
}

  
