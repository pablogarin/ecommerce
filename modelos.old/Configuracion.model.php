<?php
class Configuracion extends Model{
	public $insert = "INSERT INTO configs VALUES(?,?,?);";
	public $update = "UPDATE configs SET nombre=?,valor=?,type=? WHERE id=?;";
	public $delete = "DELETE FROM configs WHERE id=?;";
	public $create = "
        CREATE TABLE configs(
            id integer primary key autoincrement not null,
            nombre text unique,
            valor text,
            type varchar(128) default 'text'
        );
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"configs");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
		$this->validFields = array(
            "id" => array(
                "nombre" => "id",
                "null" => true
            ),
            "nombre" => array(
                "nombre" => "nombre",
                "null" => true
            ),
            "valor" => array(
                "nombre" => "valor",
                "null" => true
            ),
            "type" => array(
                "nombre" => "type",
                "null" => true
            )
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
