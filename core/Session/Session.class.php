<?php

namespace Core\Session;

class SessionException extends \Exception {

}

class SessionHeadSentException extends SessionException {

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
class Session extends \Core\Helper\Collection {

	Use \Core\Pattern\Singleton;

	public function __construct() {
		$file = '';
		$line = 0;
		if (headers_sent($file, $line)) {
			session_start();
		} else {
			throw new SessionHeadSentException($file, $line);
		}
	}

}
