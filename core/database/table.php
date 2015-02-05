<?php

namespace Core\Database;

class ExceptionTable extends \Exception {}
class ExceptionFildUnknow extends ExceptionTable {
	public function __construct($field) {
		parent::__construct("Le champ <$field> est inconnu !");
	}
}

class Table {

}
