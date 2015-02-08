<?php
/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 05/02/2015
 * Time: 15:40
 */

namespace Core\Vue;


interface VueInterface {
    public function render($data);
}