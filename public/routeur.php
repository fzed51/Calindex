<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// router.php
if (php_sapi_name() == 'cli-server') {

	if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/public" . $_SERVER["REQUEST_URI"])) {
		return false;
	} else {
		require "./public/index.php";
	}

//	$path = pathinfo($_SERVER["SCRIPT_FILENAME"]);
//	if ($path["extension"] == "el") {
//		header("Content-Type: text/x-script.elisp");
//		readfile($_SERVER["SCRIPT_FILENAME"]);
//	} else {
//		return FALSE;
//	}
}