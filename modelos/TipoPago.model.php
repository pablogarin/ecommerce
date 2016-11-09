<?php namespace Modelos;
class TipoPago extends Model{
	public $insert = "INSERT INTO tipo_pago VALUES(?,?,?,?);";
	public $update = "UPDATE tipo_pago SET nombre=?,template=?,estado=? WHERE id=?;";
	public $delete = "DELETE FROM tipo_pago WHERE id=?;";
	public $create = "
		CREATE TABLE tipo_pago(
			id integer primary key autoincrement not null,
            nombre varchar(128) not null,
            template varchar(128) not null,
            estado integer
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"tipo_pago");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
		$this->validFields = array(
			"id" => array(
				"nombre"=>"id",
				"type" => "int",
				"null" => true
			),
			"nombre" => array(
				"nombre"=>"nombre",
                "label" => "Forma de Pago",
				"type" => "text",
				"null" => false
			),
			"template" => array(
				"nombre"=>"template",
                "label" => "Plantilla",
				"type" => "hidden",
				"null" => false
			),
			"estado" => array(
				"nombre"=>"estado",
                "label" => "¿Activo?",
				"type" => "boolean",
				"null" => true
            )
        );
	}
	function setForeign($elements){
		//TODO: 
	}
}
