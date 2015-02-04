<?php
/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 02/02/2015
 * Time: 10:28
 */

namespace Core;


use Core\Database\PDOConnect;
use Core\Database\PDOSqLiteConnexion;

abstract class AppAbstract {
    /**
     * @var string $appName Nom de l'applicatino
     */
    private $appName;

    private static $Connect;


    /**
     * @param $appName
     */
    function __construct($appName, $configFile = NULL){

        if(is_null($configFile)){
            $configFile = ROOT.DS.'config'.DS.'default.conf.php';
        }

        $this->appName = $appName;
        if ($configFile != '') {
            self::SetConfig($configFile);
        }

    }

    public static function SetConfig($configFile)
    {
        Config::initializ($configFile);
    }

    public static function GetDB()
    {
        $connexion = NULL;
        if(isset(self::$Connect)){
            switch(strtolower(Config::get('provider'))){
                case 'sqlite':
                    $connexion = new PDOConnect(
                        new PDOSqLiteConnexion(
                            Config::get('DB_FILE')
                        )
                    );
                    break;
                case 'mysql':
                    $connexion = new PDOConnect(
                        new PDOSqLiteConnexion(
                            Config::get('DB_NAME'),
                            Config::get('DB_USER'),
                            Config::get('DB_PASSWORD'),
                            Config::get('DB_HOST')
                        )
                    );
                    break;
            }
        }
    }

    abstract function run();

}