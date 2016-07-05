<?php
class cliente extends Model{
	public $insert = "INSERT INTO cliente VALUES(?,?,?,?,?,?);";
	public $update = "UPDATE cliente SET nombre=?,logo=?,activo=?,orden=?,url=? WHERE id=?;";
	public $delete = "DELETE FROM cliente WHERE id=?;";
	public $create = "
        CREATE TABLE cliente(
            id integer primary key autoincrement not null,
            nombre varchar(255) not null,
            logo varchar(128),
            activo integer default(1),
            orden float default 0.0,
            url text
        );
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"cliente");
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
            "logo" => array(
                "nombre" => "logo",
                "null" => true
            ),
            "activo" => array(
                "nombre" => "activo",
                "null" => true
            ),
            "orden" => array(
                "nombre" => "orden",
                "null" => true
            ),
            "url" => array(
                "nombre" => "url",
                "null" => true
            )
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
