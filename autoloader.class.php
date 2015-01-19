<?php

/* 
 * Copyright 2014 Fabien "fzed51" Sanchez
 */

if(!defined('LIB')){
	define('LIB', __DIR__);
}
if(!defined('DS')){
	define('DS', '\\');
}

/**
 * -----------------------
 *   autoload
 * -----------------------
 * autoload est un autoloader psr-4
 *
 * @author fabien.sanchez
 * @copyright (c) 2014, Fabien "fzed51" SANCHEZ
 */
class autoloader {

	/**
	 * @access protected 
	 * @var string[string] $class_files chemin des classes
	 */
	protected $class_files = array();

	/**
	 * @access protected 
	 * @var string[] $log log de debbugage
	 */
	protected $log = array();

	/**
	 * @access protected 
	 * @var string[] $search_folders chemin dans les quel l'autoloader cherche les classes
	 */
	protected $search_folders = array();

	/**
	 * @access protected
	 * @var bool $registred indique si autoloader est enregistré
	 */
	protected $registred = false;

	/**
	 * @access protected
	 * @var string $extension extension des fichiers recherchés
	 */
	protected $extension = "";


	/**
	 * @access public
	 * @param array $option liste d'option pour la création
	 */
	public function __construct(array $option = []) {
		$defaut = [
			"register" => false,
			"extension" => ".class.php"
		];
		$options = array_merge($defaut, $option);
		if(isset($options['register']) && $options['register']) {
			$this->register();
		}
		if(isset($options['extension'])){
			$this->extension = $options['extension'];
		}
	}

	/**
	 * @access protected
	 * @param string $log Message du log
	 * @param bool $writeTime switch pour donner l'heure au début du message
	 */
	protected function log(/* string */ $log, /* bool */ $writeTime = false) {
		/* string */ $finalLog = "";
		if ($writeTime) {
			$time = new DateTime();
			$finalLog = $time->format("H:i") . " > ";
		} else {
			$finalLog = "     " . " > ";
		}
		$finalLog .= $log;
		\array_push($this->log, $finalLog);
	}

	/**
	 * @access public
	 * @param string $folder
	 * @return autoloader
	 */
	public function addFolder(/*string*/$folder, /*bool*/$FullPath=false) {
		if(!$FullPath){$folder = LIB . DS . $folder;}
		if(!is_dir($folder)){throw new Exception("Impossible d'ajouter le "
				. "dossier '$folder' à la bibliothèque de librairie!");}
		array_push($this->search_folders, $folder);
		return $this;
	}
	
	
	public function addParentFolder(){
		return $this->addFolder(__DIR__, true);
	}

	/**
	 * @access public
	 * @param string $className Nom de la classe a charger
	 * @return bool 
	 */
	public function loadClass(/* string */ $className) {
		/* string */ $filePath = "";
		if (!class_exists($className)) {
			$this->log("Chargement de la classe : $className", true);
			if (isset($this->class_files[$className])) {
				$filePath = $this->class_files[$className];
			} else {
				$filePath = $this->SearchClassInFolders($className);
			}
			if ($filePath != '') {
				$this->log("Classe chargé à partir du fichier $filePath");
				require $filePath;
			} else {
				$this->log("[ERROR] Impossible de charger la classe $className");
				return true;
			}
		}
	}

	/**
	 * @access protected
	 * @param string $className Nom de la class à chercher
	 * @return string
	 */
	protected function SearchClassInFolders(/*string*/ $className) {
		/* string */ $filePath = "";
		foreach ($this->search_folders as /* string */ $folder) {
			if (file_exists($folder . DS . strtolower($className) . '.class.php')) {
				$filePath = $folder . DS . strtolower($className) . '.class.php';
			}
		}
		return $filePath;
	}

	/**
	 * @access public
	 * @param bool $prepend enregistre l'autoloader en début de file
     * @return autoloader
	 */
	public function register(/* bool */ $prepend = false) {
		$this->registred = true;
		spl_autoload_register(array($this, 'loadClass'), true, $prepend);
        return $this;
	}

	/**
	 * @access public
     * @return autoloader
	 */
	public function unregister() {
		$this->registred = false;
		spl_autoload_unregister(array($this, 'loadClass'));
        return $this;
	}

	/**
	 * @access public
	 * @return string[]
	 */
	public function getLog() {
		return $this->log;
	}

	/**
	 * @access public
	 */
	public function __destruct() {
		if ($this->registred) {
			$this->unregister();
		}
	}

}
