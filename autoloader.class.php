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

class AutoloaderException extends Exception {}

class NotFoundClassException extends AutoloaderException {
	function __construct($className){
		parent::__construct("Impossible de charger la classe $className");
	}
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
class Autoloader {

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
	protected $extension = array();

	/**
	 * @access protected
	 * @var bool $throw Flag qui permet de déclancher une exception particulière en cas de
	 *    classe non trouvée
	 */
	protected $throw = True;

	protected $cached = False;

	/**
	 * @var string
	 */
	protected $cache_file_name = "";

	/**
	 * @access public
	 * @param array $option liste d'option pour la création
	 */
	function __construct(array $option = []) {
		$defaut = [
			"register" => false,
			"extension" => array(".class.php"),
			"throw" => True,
			"cached" => False
		];
		$options = array_merge($defaut, $option);
		$this->cache_file_name = LIB.DS.'cache_autoloader';
		if(isset($options['register']) && $options['register']) {
			$this->register();
		}
		if(isset($options['extension'])){
			if(is_array($options['extension'])){
				$this->extension = $options['extension'];
			} else {
				$this->extension = array($options['extension']);
			}
		}
		$this->throw = (bool)$options['throw'];
		$this->cached = (bool)$options['cached'];
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
	 * @return Autoloader
	 * @throw Exception
	 */
	function addFolder(/*string*/$folder, /*bool*/$FullPath=false) {
		if(!$FullPath){$folder = LIB . DS . $folder;}
		if(!is_dir($folder)){throw new Exception("Impossible d'ajouter le "
				. "dossier '$folder' à la bibliothèque de librairie!");}

		if(!in_array($folder, $this->search_folders)) {
			array_push($this->search_folders, $folder);
		}
		return $this;
	}

	/**
	 * @access public
	 * @param $extension
	 * @return Autoloader
	 */
	function addExtension (/*string*/$extension) {
		if($extension[0] != '.'){
			$extension = '.'.$extension;
		}
		if(!in_array($extension, $this->extension)) {
			array_push($this->extension, $extension);
		}
		return $this;
	}
	
	function addParentFolder(){
		return $this->addFolder(__DIR__, true);
	}

	/**
	 * @access public
	 * @param string $className Nom de la classe a charger
	 */
	function loadClass(/* string */ $className) {
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
				if($this->throw){
					throw new NotFoundClassException($className);
				}
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
		foreach ($this->search_folders as /*string*/ $folder) {
			foreach ($this->extension as /*string*/ $extension){
				if (file_exists($folder . DS . strtolower($className) . $extension )) {
					$filePath = $folder . DS . strtolower($className) . $extension ;
				}
			}
		}
		return $filePath;
	}

	/**
	 * @access public
	 * @param bool $prepend enregistre l'autoloader en début de file
     * @return Autoloader
	 */
	function register(/* bool */ $prepend = false) {
		$this->registred = true;
		spl_autoload_register(array($this, 'loadClass'), true, $prepend);
        return $this;
	}

	/**
	 * @access public
	 * @param $actived
	 * @return Autoloader
	 */
	function activeCache(/*bool*/$actived){
		$this->cached = (bool)$actived;
		return $this;
	}

	/**
	 * @access public
     * @return autoloader
	 */
	function unregister() {
		$this->registred = false;
		spl_autoload_unregister(array($this, 'loadClass'));
        return $this;
	}

	/**
	 * @access protected
	 */
	protected function loadCache(){
		if(file_exists($this->cache_file_name)){
			$content = file_get_contents($this->cache_file_name);
			$this->class_files = unserialize($content);
		}
	}

	/**
	 * @access protected
	 */
	protected function saveCache(){
		file_put_contents($this->cache_file_name, serialize($this->class_files));
	}

	/**
	 * @access public
	 * @return string[]
	 */
	function getLog() {
		return $this->log;
	}

	/**
	 * @access public
	 */
	function __destruct() {
		if($this->cached){
			$this->saveCache();
		}
		if ($this->registred) {
			$this->unregister();
		}
	}

}
