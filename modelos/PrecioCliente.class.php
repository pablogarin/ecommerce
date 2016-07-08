<?php namespace Modelos;
class PrecioCliente extends Model{
	public $insert = "INSERT INTO precio_cliente VALUES(?,?,?,?);";
	public $update = "UPDATE precio_cliente SET idProducto,precio,tipoCliente WHERE id=?;";
	public $delete = "DELETE FROM precio_cliente WHERE id=?;";
	public $create = "
		CREATE TABLE precio_cliente(
			id integer primary key autoincrement not null,
			idProducto integer references producto(id),
			precio float not null,
			tipoCliente varchar(128) not null
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"precio_cliente");
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
			"precio" => array(
				"nombre"=>"precio",
				"null" => true
			),
			"tipoCliente" => array(
				"nombre"=>"tipoCliente",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
