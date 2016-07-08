<?php namespace Modelos;
class Filtro extends Model{
	public $insert = "INSERT INTO atributo VALUES(?,?,?,?,?,?,?);";
	public $update = "UPDATE atributo SET nombre=?,tipo=?,descripcion=?,idCategoria=?,esFiltro=?,esGrupo=? WHERE id=?;";
	public $delete = "DELETE FROM atributo WHERE id=?;";
	public $create = "
		CREATE TABLE atributo(
			id integer primary key autoincrement not null,
			nombre varchar(255) not null,
			tipo varchar(255) not null,
			idCategoria integer not null references categoria(id),
			descripcion text,
			esFiltro integer default 0, /* 1 si, 0 no */
			esGrupo integer default 0
		);
	";
	function __construct($Sql){
		parent::__construct($Sql,"atributo");
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
			"tipo" => array(
				"nombre"=>"tipo",
				"null" => false
			),
			"descripcion" => array(
				"nombre"=>"descripcion",
				"null" => true
			),
			"idCategoria" => array(
				"nombre"=>"idCategoria",
				"null" => false
			),
			"esFiltro" => array(
				"nombre"=>"esFiltro",
				"null" => true
			),
			"esGrupo" => array(
				"nombre"=>"esGrupo",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO:
	}
}
