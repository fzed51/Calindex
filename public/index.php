<?php

// require (__DIR__.'/../bootstrap.php');

require __dir__.'/../core/Pattern/GetterSetter.php';

class test {

	use \Core\Pattern\GetterSetter;

	private $test;

	private function set_test($value) {
		$this->test = $value;
	}

	private function get_test() {
		return $this->test;
	}

	function __construct() {
		
	}

}

$test = new test();

$test->test = 10;
echo $test->test;

$test->test2;