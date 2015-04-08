<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// router.php
if (php_sapi_name() == 'cli-server') {
	$fullNamePublic = $_SERVER["DOCUMENT_ROOT"] . "/public" . $_SERVER["REQUEST_URI"];
	if (is_file($fullNamePublic)) {
		$path = pathinfo($fullNamePublic);
		switch ($path["extension"]) {
			case 'ico':
				header("Content-Type: image/x-icon");
				break;
			case 'css':
				header("Content-Type: text/css");
				break;
			case 'js':
				header("Content-Type: application/javascript");
				break;
			case 'json':
				header("Content-Type: application/json");
				break;
			case 'xml':
				header("Content-Type: application/xml");
				break;
			case 'jpg':
				header("Content-Type: image/jpeg");
				break;
			case 'png':
				header("Content-Type: image/png");
				break;
			case 'gif':
				header("Content-Type: image/gif");
				break;
			case 'svg':
				header("Content-Type: image/svg+xml");
				break;
			default:
				return FALSE;
		}
		readfile($fullNamePublic);
	} else {
		require "./public/index.php";
	}
}