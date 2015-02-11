<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Pattern;

class PropertyException extends \Exception {
	protected  function get_class() {
		$backtrace = debug_backtrace();
		$class = $backtrace[2]['class'];
		return $class;
	}
}
class PropertyNotFoundException extends PropertyException {
	public function __construct($property, $code=null, $previous=null) {
		$class = $this->get_class();
		parent::__construct("La propriété '$property' n'existe pas dans '$class'", 
				$code, 
				$previous);
	}
}
class PropertyNotReadableException extends PropertyException {
	public function __construct($property, $code=null, $previous=null) {
		$class = $this->get_class();
		parent::__construct("La propriété '$property' de '$class' ne peut pas être lue", 
				$code, 
				$previous);
	}
}
class PropertyNotWritableException extends PropertyException {
	public function __construct($property, $code=null, $previous=null) {
		$class = $this->get_class();
		parent::__construct("La propriété '$property' de '$class' ne peut pas être modifiée", 
				$code, 
				$previous);
	}
}
/**
 * Description of GetterSetter
 *
 * @author fabien.sanchez
 */
trait GetterSetter {
	public function __get($name) {
		$methode = 'get'.ucfirst($name);
		if(method_exists($this, $methode)){
			call_user_method($methode, $this);
		} else {
			throw new PropertyNotFoundException($name);
		}
	}
	public function __set($name, $value) {
		$methode = 'set'.ucfirst($name);
		if(method_exists($this, $methode)){
			call_user_method($methode, $this, $value);
		} else {
			throw new PropertyNotFoundException($name);
		}
	}
}
