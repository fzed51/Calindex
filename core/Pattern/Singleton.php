<?php

namespace Core\Pattern;

/**
 * Description of Singleton
 *
 * @author fabien.sanchez
 */
trait Singleton {

	private static $__instance = null;

	public static function getInstance() {
		if (static::$__instance === null) {
			$call = get_called_class();
			static::$__instance = new $call();
		}
		return static::$__instance;
	}

	final public function __clone(){
	    throw new \RuntimeException(
	        sprintf(
	            'Cloning of %s instances is not alllowed',
	             get_class($this)
	        )
	    );
	}

	public function __sleep() {
		throw new \RuntimeException(
			sprintf(
	            'Serializing of %s instances is not alllowed',
	             get_class($this)
	        )
		);
	}

	public function __invoke() {
		return static::getInstance();
	}

}
