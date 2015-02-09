<?php

/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 02/02/2015
 * Time: 10:28
 */

namespace Core;

use Core\Helper\Config;
use Core\Database\PDOConnect;
use Core\Database\PDOSqLiteConnexion;

abstract class AppAbstract {

	/**
	 * @var string $appName Nom de l'applicatino
	 */
	private $appName;
	private $dbConnect;

	public function setAppName($name) {
		$this->appName = $name;
	}

	public function SetConfig($configFile) {
		$configFile = ROOT . DS . 'config' . DS . $configFile . '.conf.php';
		Config::initializ($configFile);
	}

	public function GetDB() {
		$connexion = NULL;
		if (isset($this->dbConnect)) {
			switch (strtolower(Config::get('DB_PROVIDER'))) {
				case 'sqlite':
					$connexion = new PDOSqLiteConnexion(
							Config::get('DB_FILE')
					);
					break;
				case 'mysql':
					$connexion = new PDOSqLiteConnexion(
							Config::get('DB_NAME'), Config::get('DB_USER'), Config::get('DB_PASSWORD'), Config::get('DB_HOST')
					);
					break;
			}
			$this->dbConnect = new PDOConnect($connexion);
		}
		return $this->dbConnect;
	}
	
	public function GetTable($table) {
		$db = $this->GetDB();
		$class = '\App\Table\\' . ucfirst($table) . 'Table';
		return new $class($db);
	}

	abstract function run();
}
