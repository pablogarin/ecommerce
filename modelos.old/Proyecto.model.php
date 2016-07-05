<?php
class Proyecto extends Model{
	public $insert = "INSERT INTO proyecto VALUES(?,?,?,?,?,?,?);";
	public $update = "UPDATE proyecto SET titulo=?,fecha=?,foto=?,texto=?,activo=?,orden=? WHERE id=?;";
	public $delete = "DELETE FROM proyecto WHERE id=?;";
	public $create = "
        CREATE TABLE proyecto(
            id integer primary key autoincrement not null,
            titulo varchar(255) not null,
            fecha datetime default CURRENT_TIMESTAMP,
            foto varchar(128),
            texto text,
            activo integer default 1,
            orden float
        );
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"proyecto");
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
            "titulo" => array(
                "nombre" => "titulo",
                "null" => true
            ),
            "fecha" => array(
                "nombre" => "fecha",
                "null" => true
            ),
            "foto" => array(
                "nombre" => "foto",
                "null" => true
            ),
            "texto" => array(
                "nombre" => "texto",
                "null" => true
            ),
            "activo" => array(
                "nombre" => "activo",
                "null" => true
            ),
            "orden" => array(
                "nombre" => "orden",
                "null" => true
            )
		);
	}
	function setForeign($elements){
		//TODO: 
        print_r($elements);
        exit;
	}
}
