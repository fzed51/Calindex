<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Securite;

use Core\Helper\Html\Form;
use Core\Session\Session;

/**
 * Description of Csrf
 *
 * @author fzed51
 */
class Csrf {

	const IDSESSION = "__SECURITE__CSRF__";

	private $session;
	private $jeton;

	public function __construct() {
		$this->session = Session::getInstance();
		$this->generate();
	}

	public function generate($force = false) {
		if (!$force && isset($this->session[self::IDSESSION])) {
			$this->jeton = $this->session[self::IDSESSION];
		} else {
			$this->jeton = hash('sha256', uniqid() . '-' . self::class . '-' . self::IDSESSION . '-' . (string) time());
			$this->session[self::IDSESSION] = $this->jeton;
		}
	}

	public function getAttrb() {
		return 'csrf=' . $this->jeton;
	}

	public function getInput() {
		$form = new Form();
		return $form->hidden('csrf', $this->jeton);
	}

	function check($redirect = true, $csrfTest = null) {
		if (is_null($csrfTest) and ( isset($_POST['csrf']) xor isset($_GET['csrf']))) {
			$csrfTest = isset($_POST['csrf']) ? $_POST['csrf'] : $_GET['csrf'];
		}
		if ($redirect) {
			if ($this->jeton === $csrfTest) {

			}
		}
	}

}
