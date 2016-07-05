<?php
class Texto extends Model{
	public $insert = "INSERT INTO texto VALUES(?,?,?,?,?);";
	public $update = "UPDATE texto SET titulo=?,cuerpo=?,llave=?,activo=? WHERE id=?;";
	public $delete = "DELETE FROM texto WHERE id=?;";
	public $create = "
        CREATE TABLE texto(
            id integer primary key autoincrement not null,
            titulo varchar(255) not null,
            cuerpo text not null,
            llave varchar(120),
            activo integer default 1
        );
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"texto");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
		$this->validFields = array(
			"id" => array(
				"nombre"=>"id",
				"null" => true
			),
			"titulo" => array(
				"nombre"=>"titulo",
				"null" => false
			),
			"cuerpo" => array(
				"nombre"=>"cuerpo",
				"null" => false
			),
			"llave" => array(
				"nombre"=>"llave",
				"null" => true
			),
			"activo" => array(
				"nombre"=>"activo",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
