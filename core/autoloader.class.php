<?php
namespace Core;

use DateTime;
use Exception;

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
	private $className;
	public function __construct ($className, $code=NULL, $previous=NULL) {
		$this->className = $className;
		parent::__construct("Impossible de charger la classe $className", 
				$code, $previous);
	}
}

class NotFoundFolder extends AutoloaderException {
	private $folder;
	public function __construct ($folder, $code=NULL, $previous=NULL) {
		$this->folder = $folder;
		parent::__construct("Impossible d'ajouter le dossier '$folder' à la "
				. "bibliothèque de librairie!", $code, $previous);
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
	 *
	 * @var string[string] 
	 */
	protected $scanned_file = array();


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
		if(isset($options['extension'])){
			if(is_array($options['extension'])){
				$this->extension = $options['extension'];
			} else {
				$this->extension = array($options['extension']);
			}
		}
		$this->throw = (bool)$options['throw'];
		$this->cached = (bool)$options['cached'];
		if(isset($options['register']) && $options['register']) {
			$this->register();
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
		array_push($this->log, $finalLog);
	}

	/***
	 * @param string $folder
	 * @param bool $FullPath
	 * @return $this
	 * @throws NotFoundFolder
	 */
	function addFolder(/*string*/$folder, /*bool*/$FullPath=false) {
		if(!$FullPath){$folder = LIB . DS . $folder;}
		if(!is_dir($folder)){
			$this->log("[ERROR] Impossible de trouver le dossier $folder");
			throw new NotFoundFolder($folder);
		}

		if(!in_array($folder, $this->search_folders)) {
			$this->scanned_file = array_merge(
					$this->scanned_file, 
					$this->scanFolder($folder)
					);
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
	 * @param $className
	 * @throws NotFoundClassException
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
	 * @param $className
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
	
	protected function scanFolder ($folder){
		$liste = array();
		$skipItem = array('.','..','.git');
		if(is_dir($folder)){
			$local = scandir($folder);
			foreach ($local as $item) {
				if(!in_array($item, $skipItem)){
					$fullItem = $folder.DS.$item;
					if(is_dir($item)){
						$liste = array_merge($liste, $this->scanFolder($fullItem));
					} else {
						$liste[strtolower($fullItem)] = $fullItem;
					}
				}
			}
		}else{
			throw new AutoloaderException("le dossier '$folder' n'existe pas!");
		}
		return $liste;
	}

	/**
	 * @access public
	 * @param bool $prepend enregistre l'autoloader en début de file
     * @return Autoloader
	 */
	function register(/* bool */ $prepend = false) {
		$this->registred = true;
		$this->loadCache();
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
		$this->loadCache();
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
		if($this->cached){
			if(file_exists($this->cache_file_name)){
				$content = file_get_contents($this->cache_file_name);
				$temp = unserialize($content);
				if( is_array($temp)){
					$this->class_files = array_merge($temp, $this->class_files);
				}
			}
		}
	}

	/**
	 * @access protected
	 */
	protected function saveCache(){
		if($this->cached){
			file_put_contents($this->cache_file_name, serialize($this->class_files));
		}
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
		$this->saveCache();
		if ($this->registred) {
			$this->unregister();
		}
	}

}
