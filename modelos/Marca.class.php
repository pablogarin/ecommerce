<?php
class Marca extends Model{
	public $insert = "INSERT INTO marca VALUES(?,?,?,?,?,?,?);";
	public $update = "UPDATE marca SET nombre=?,descripcion=?,foto=?,activo=?,orden=?,fotoProductos=? WHERE id=?;";
	public $delete = "DELETE FROM marca WHERE id=?;";
	public $create = "
		CREATE TABLE marca(
			id integer primary key autoincrement not null,
			nombre varchar(255) not null,
			descripcion text,
			foto integer references recurso(id),
			activo integer default 1, /* 1 si, 0 no */
			orden float,
			fotoProductos integer references recurso(id)
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"marca");
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
			"nombre" => array(
				"nombre"=>"nombre",
				"null" => false
			),
			"descripcion" => array(
				"nombre"=>"descripcion",
				"null" => true
			),
			"foto" => array(
				"nombre"=>"foto",
				"null" => true
			),
			"activo" => array(
				"nombre"=>"activo",
				"null" => true
			),
			"orden" => array(
				"nombre"=>"orden",
				"null" => true
			),
			"fotoProductos" => array(
				"nombre"=>"fotoProductos",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
