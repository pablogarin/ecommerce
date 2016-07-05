<?php
class ProductoDestacado extends Model{
	public $insert = "INSERT INTO producto_destacado VALUES(?,?,?,?,?);";
	public $update = "UPDATE producto_destacado SET idProducto=?,idDestacado=?,orden=?,activo=? WHERE id=?;";
	public $delete = "DELETE FROM producto_destacado WHERE id=?;";
	public $create = "
		CREATE TABLE producto_producto_destacado(
			id integer primary key autoincrement not null,
			idProducto integer not null references producto(id),
			idDestacado integer not null references producto_destacado(id),
			orden float,
			activo integer /* 1 si, 0 no */
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"producto_destacado");
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
			"idProducto" => array(
				"nombre"=>"idProducto",
				"null" => false
			),
			"idDestacado" => array(
				"nombre"=>"idDestacado",
				"null" => false
			),
			"orden" => array(
				"nombre"=>"orden",
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
