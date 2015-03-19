<?php

namespace Core\Session;

class SessionException extends \Exception {

}

class HeadSendBeforSessionException extends SessionException {

	public function __construct($fileHeaderSend = '', $lineHeaderSend = -1, $code = null, $previous = null) {
		$fichier = '';
		$ligne = '';
		if ($fileHeaderSend == '') {
			$fichier = 'un fichier inconnue';
		} else {
			$fichier = "le fichier '$fileHeaderSend'";
		}
		if ($lineHeaderSend > 0) {
			$ligne = " à la ligne $lineHeaderSend";
		}
		$message = "Impossible d'initialiser une session.\nHeader envoyer dans {$fichier}{$ligne}.";
		parent::__construct($message, $code, $previous);
	}

}

/**
 * Description of Session
 *
 * @author fabien.sanchez
 */
class Session implements ArrayAccess, Countable {

	Use \Core\Pattern\Singleton;

	public function __construct() {
		$file = '';
		$line = 0;
		if (!headers_sent($file, $line)) {
			session_start();
		} else {
			throw new HeadSendBeforSessionException($file, $line);
		}
	}

	public function __get($key) {
		return $this->get($key);
	}

	public function __set($key, $value) {
		$this->set($key, $value);
	}

	public function offsetExists($key) {
		return isset($_SESSION[$key]);
	}

	public function offsetGet($key) {
		return $this->get($key);
	}

	public function offsetSet($key, $value) {
		$this->set($key, $value);
	}

	public function offsetUnset($key) {
		unset($_SESSION[$key]);
	}

	public function count() {
		return count($_SESSION);
	}

	public function raz() {
		$_SESSION = array();
	}

	public function get($key, $default = null) {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return $default;
		}
	}

	private function set($key, $value) {
		$_SERVER[$key] = $value;
	}

}
