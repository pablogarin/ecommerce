<?php namespace Controllers;

class Bazar extends Controller
{
    function __construct()
    {
        parent::__construct("home-tienda.html",$this->getData());
    }
    function getData(){
        if( !is_array($this->data) ){
            $this->data = array();
        }
        return $this->data;
    }
        
}
