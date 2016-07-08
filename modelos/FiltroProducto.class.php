<?php namespace Modelos;
class FiltroProducto extends Model{
	public $insert = "INSERT INTO atributo_producto VALUES(?,?,?,?);";
	public $update = "UPDATE atributo_producto SET idProducto=?, idAtributo=?, valor=? WHERE id=?;";
	public $delete = "DELETE FROM atributo_producto WHERE id=?;";
	public $create = "
		CREATE TABLE atributo_producto(
			id integer primary key autoincrement not null,
			idProducto integer not null references producto(id),
			idAtributo integer not null references atributo(id),
			valor varchar(255) not null /* esto es el valor... ejemplo Atributo: color, VALOR: 'rojo' */
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"atributo_producto");
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
			"idAtributo" => array(
				"nombre"=>"idAtributo",
				"null" => true
			),
			"valor" => array(
				"nombre"=>"valor",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
