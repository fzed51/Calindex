<?php

/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 05/02/2015
 * Time: 15:39
 */

namespace Core\Vue;

class ViewException extends \Exception {}
class FileViewNotFount extends ViewException {}

abstract class Vue implements VueInterface {

    private $name;
    protected $layout;
	protected $extension = '.phtml';


	final public function __construct(/*string*/$name) {
		$this->setName($name);
	}

	final public function render($data){
		$vue = $this->getVueFile();
		if($vue === ''){
			throw new FileViewNotFount($vue);
		}
		$content = $this->renderFile($vue, $data);
		$data['content'] = $content;
		$layout = $this->getLayoutFile();
		if($vue === ''){
			return $content;
		}
		return $this->renderFile($layout, $data);
	}
	
	final private function renderFile($__fileview, $data){
		extract($data);
		ob_start();
		require $__fileview;
		return ob_get_clean();
	}

	final public function setName($name) {
		$this->name = $name;
	}
	
    final public function setLayout($layout) {
        $this->layout = $layout;
    }
	
	final protected function getLayoutFile(){
		$path = ROOT_VUE . DS . 'layout' . DS;
		$file = $path . $this->layout . $this->extension;
		if (file_exists($file)){
			return $file;
		}
		return '';
	}
	
	final protected function getVueFile(){
		$path = ROOT_VUE . DS;
		$file = $path . DS . 
				str_replace('.', DS, $this->name) . 
				$this->extension;
		if (file_exists($file)){
			return $file;
		}
		return '';
	}

	final public function setPath($path) {
        if (file_exists($path) && is_dir($path)) {
            $this->ViewPath = $path;
        } else {
            throw new FileViewNotFount($path);
        }
    }

}
