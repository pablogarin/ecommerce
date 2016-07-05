<?php
class Banner extends Model{
	public $insert = "INSERT INTO banner VALUES(?,?,?,?);";
	public $update = "UPDATE banner SET foto=?,nombre=?,activo=? WHERE id=?;";
	public $delete = "DELETE FROM banner WHERE id=?;";
	public $create = "
        CREATE TABLE banner(
            id integer primary key autoincrement not null,
            foto text,
            nombre text,
            activo integer default 1
        );
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"banner");
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
            "foto" => array(
                "nombre" => "foto",
                "null" => true
            ),
            "nombre" => array(
                "nombre" => "nombre",
                "null" => true
            ),
            "activo" => array(
                "nombre" => "activo",
                "null" => true
            ),
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
