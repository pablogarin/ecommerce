<?php
class Galeria extends Model{
	public $insert = "INSERT INTO galeria VALUES(?,?,?,?,?,?);";
	public $update = "UPDATE galeria SET nombre=?,foto=?,descripcion=?,fecha=?,activo=? WHERE id=?;";
	public $delete = "DELETE FROM galeria WHERE id=?;";
	public $create = "
        CREATE TABLE galeria(
            id integer primary key autoincrement not null,
            foto varchar(128) not null,
            proyecto integer references proyecto(id),
            activo integer default 1,
            orden float
        );
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"galeria");
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
            "foto" => array(
                "nombre" => "foto",
                "null" => true
            ),
            "descripcion" => array(
                "nombre" => "descripcion",
                "null" => true
            ),
            "fecha" => array(
                "nombre" => "fecha",
                "null" => true
            ),
            "activo" => array(
                "nombre" => "activo",
                "null" => true
            )
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
