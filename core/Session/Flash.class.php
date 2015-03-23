<?php

namespace Core\Session;

class FlashException extends Exception {

}

class FlashUnknowException extends FlashException {

}

class Flash {

	use Core\Pattern\Singleton;

	const IDSESSION = "__SESSION__FLASH__";

	private $Session;
	private $layoutMaster;
	private $layoutFlash = [];
	private $defaultType;

	protected function __construct() {
		$this->Session = Session::getInstance();
		if (!isset($this->Session[self::IDSESSION]) || !is_array($this->Session[self::IDSESSION])) {
			$this->Session[self::IDSESSION] = [];
		}
	}

	protected function setLayout($layout) {
		$this->layoutMaster = $layout;
	}

	protected function setLayoutFlash($type, $layout) {
		$this->layoutFlash[$type] = $layout;
	}

	protected function setDefaultType($type) {
		if (!isset($this->layoutFlash[$type])) {
			throw new FlashUnknowException("Le type Flash $type n'existe pas.");
		}
		$this->defaultType = $type;
	}

	public function set($message, $type = '') {
		if (empty($type)) {
			$type = $this->defaultType;
		}
		array_push($this->Session[self::IDSESSION], ["type" => $type, "message" => $message]);
	}

	public function __toString() {
		$content = "";
		foreach ($this->Session[self::IDSESSION] as $flash) {
			$content .= str_replace('{$message}', $flash['message'], str_replace('{$type}', $flash['type'], $this->layoutFlash));
		}
		$toString = str_replace('{$content}', $content, $this->layoutMaster);
		return $toString;
	}

	public function render() {
		return $this->__toString();
	}

	public function affiche() {
		echo $this->__toString();
	}

}
