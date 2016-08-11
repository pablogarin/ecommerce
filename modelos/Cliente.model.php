<?php namespace Modelos;
class Cliente extends Model{
	public $insert = "INSERT INTO cliente VALUES(?,?,?,?,?);";
	public $update = "UPDATE cliente SET correo=?,nombre=?,apellido=?,fono=? WHERE id=?;";
	public $delete = "DELETE FROM cliente WHERE id=?;";
	public $create = "
		CREATE TABLE cliente(
			id integer primary key auto_increment not null,
			correo varchar(255) not null,
			nombre varchar(255) not null,
			apellido varchar(255) not null,
			fono varchar(128)
		);
	";
	function __construct($dbh,$values=null){
		parent::__construct($dbh,"cliente");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
		$this->validFields = array(
			"id" => array(
				"nombre" => "id",
                "type" => "int",
				"null" => true
			),
			"correo" => array(
				"nombre" => "correo",
                "type" => "mail",
                "label" => "E-Mail",
				"null" => false
			),
			"nombre" => array(
				"nombre" => "nombre",
                "type" => "text",
                "label" => "Nombre",
				"null" => false
			),
			"apellido" => array(
				"nombre" => "apellido",
                "type" => "text",
                "label" => "Apellido",
				"null" => false
			),
			"fono" => array(
				"nombre" => "fono",
                "type" => "text",
                "label" => "Tel&eacute;fono",
				"null" => false
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
