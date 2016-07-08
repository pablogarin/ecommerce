<?php namespace Modelos;
class Oferta extends Model{
	public $insert = "INSERT INTO oferta VALUES(?,?,?,?,?,?,?);";
	public $update = "UPDATE oferta SET idProducto=?,precio=?,fechaInicio=?,fechaFin=?,orden=?,maxCantidad=? WHERE id=?;";
	public $delete = "DELETE FROM oferta WHERE id=?;";
	public $create = "
		CREATE TABLE oferta(
			id integer primary key autoincrement not null,
			idProducto integere references producto(id),
			precio float default 0,
			fechaInicio datetime,
			fechaFin datetime,
			orden float,
			maxCantidad int default 0 /* maxima cantidad de ofertas por compra... 0 => sin limites. */
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"oferta");
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
			"idProducto" => array(
				"nombre" => "idProducto",
				"null" => true
			),
			"precio" => array(
				"nombre" => "precio",
				"null" => true
			),
			"fechaInicio" => array(
				"nombre" => "fechaInicio",
				"null" => true
			),
			"fechaFin" => array(
				"nombre" => "fechaFin",
				"null" => true
			),
			"orden" => array(
				"nombre" => "orden",
				"null" => true
			),
			"maxCantidad" => array(
				"nombre" => "maxCantidad",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
