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

trait Singleton
{
    private static $__instance = null;

    public static function getInstance()
    {
        if( self::$__instance === null ){
            self::$__instance = new self();
        }
        return self::$__instance;
    }
}
