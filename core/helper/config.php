<?php
/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 04/02/2015
 * Time: 11:29
 */

namespace Core\Helper;

class ConfigException extends \Exception {};

class ConfigNotFoundException extends ConfigException {};

class Config {

    static private $config;

    public static function initializ($configFile){
        if(file_exists($configFile)){
            self::$config = require($configFile);
        } else {
            throw new ConfigNotFoundException($configFile);
        }
    }

    public static function get($param, $default = NULL){
        if (isset(self::$config[$param])){
            return self::$config[$param];
        }
    }

}