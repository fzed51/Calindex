<?php
/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 02/02/2015
 * Time: 10:28
 */

namespace Core;


abstract class AppAbstract {
    /**
     * @var string $appName Nom de l'applicatino
     */
    private $appName;

    /**
     * @param $appName
     */
    function __construct($appName){

        $this->appName = $appName;

    }

    abstract function run();

}