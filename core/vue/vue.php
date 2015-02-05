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
    private $layout;
    private $ViewPath;

    public function __construct($name, array $options)
{
    $default = array(
        'Path' => '',
        'Layout' => ''
    );
    $options = array_merge($default, $options);

    extract($options, 'OPT_');

    $this->name = $name;
    if(isset($OPT_Path) && $OPT_Path != ''){
        $this->setPath($OPT_Path);
    }
    if(isset($OPT_Layout) && $OPT_Layout != ''){
        $this->setLayout($OPT_Layout);
    }
}

    public function render($data)
    {
        // TODO: Implement render() method.
    }

    private function getPath($path){
        // TODO: si path est absolu -> path; sinon -> ViewPath + path
        return $this->ViewPath.DS.$path;
    }

    public function setLayout($layout){
        $layout = $this->getPath($layout);
        if(file_exists($layout)){
            $this->layout = $layout;
        } else {
            throw new FileViewNotFount($layout);
        }
    }

    public function setPath($path){
        if(file_exists($path) && is_dir($path)){
            $this->ViewPath = $path;
        } else {
            throw new FileViewNotFount($path);
        }
    }
}