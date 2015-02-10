<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Database;

/**
 *
 * @author fabien.sanchez
 */
interface iPDOConnexion {
	function getDNS();
	function getUser();
	function getPwd();
	function getOptions();
}
