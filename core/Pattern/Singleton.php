<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Pattern;

/**
 * Description of Singleton
 *
 * @author fabien.sanchez
 */
trait Singleton {

	private static $__instance = null;

	public static function getInstance() {
		if (self::$__instance === null) {
			$call = get_called_class();
			self::$__instance = new $call();
		}
		return self::$__instance;
	}

	public function __clone() {
		throw new \RuntimeException('Cannot clonse Singletone objects');
	}

	public function __sleep() {
		throw new \RuntimeException('Cannot serialize Singletone objects');
	}

	public function __invoke() {
		return self::getInstance();
	}

}
