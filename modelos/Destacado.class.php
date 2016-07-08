<?php namespace Modelos;
class Destacado extends Model{
	public $insert = "INSERT INTO destacado VALUES(?,?,?,?,?,?,?);";
	public $update = "UPDATE destacado SET titulo=?,activo=?,fechaInicio=?,fechaFin=?,mostrarHome=?,fechaCreacion=? WHERE id=?;";
	public $delete = "DELETE FROM destacado WHERE id=?;";
	public $create = "
		CREATE TABLE destacado(
			id integer primary key autoincrement not null,
			titulo varchar(120) not null,
			activo integer default 1, /* 1 si, 0 no */
			fechaInicio datetime,
			fechaFin datetime,
			mostrarHome integer, /* 1 si, 0 no */
			fechaCreacion datetime
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"destacado");
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
			"titulo" => array(
				"nombre"=>"titulo",
				"null" => false
			),
			"activo" => array(
				"nombre"=>"activo",
				"null" => false
			),
			"fechaInicio" => array(
				"nombre"=>"fechaInicio",
				"null" => false
			),
			"fechaFin" => array(
				"nombre"=>"fechaFin",
				"null" => false
			),
			"mostrarHome" => array(
				"nombre"=>"mostrarHome",
				"null" => false
			),
			"fechaCreacion" => array(
				"nombre"=>"fechaCreacion",
				"null" => false
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
