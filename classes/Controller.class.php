<?php namespace Controllers;
/*
* Clase Abstracta de Controller
//*/
abstract class Controller extends stdClass
{
    protected $template, $data, ;
    function __construct($template, $data = array()){
        $this->template = $template;
        $this->data = (array)$data;
    }
    public function getView(){
        global $view;
        foreach( $this->data as $name=>$value ){
            $view->set($name, $value);
        }
        $view->setTemplate($this->template);
        return $view->getView();
    }
}
require 'Bazar.controller.php';

?>
