<?php namespace Modelos;
class ProductoCategoria extends Model{
	public $insert = "INSERT INTO producto_categoria VALUES(?,?,?,?,?);";
	public $update = "UPDATE producto_categoria SET idProducto=?,idCategoria=?,orden=?,prioridad=? WHERE id=?;";
	public $delete = "DELETE FROM producto_categoria WHERE id=?;";
	public $create = "
		CREATE TABLE producto_categoria(
			id integer primary key autoincrement not null,
			idProducto integer references producto(id),
			idCategoria integer references categoria(id),
			orden float,
			prioridad float
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"producto_categoria");
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
				"null" => true
			),
			"idCategoria" => array(
				"nombre"=>"idCategoria",
				"null" => true
			),
			"orden" => array(
				"nombre"=>"orden",
				"null" => true
			),
			"prioridad" => array(
				"nombre"=>"prioridad",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
