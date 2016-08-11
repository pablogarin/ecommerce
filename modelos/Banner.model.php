<?php namespace Modelos;
class Banner extends Model{
	public $insert = "INSERT INTO banner VALUES(?,?,?,?,?,?,?,?,?);";
	public $update = "UPDATE banner SET nombre=?,idRecurso=?,url=?,target=?,tipo=?,estado=?,timestamp=?,orden=? WHERE id=?;";
	public $delete = "DELETE FROM banner WHERE id=?;";
	public $create = "
		CREATE TABLE banner(
			id integer primary key autoincrement not null,
			nombre varchar(120) not null,
			url varchar(255),
			target varchar(16),
			tipo varchar(120),
			estado varchar(255),
            timestamp timestamp,
			orden float default 0
            imagen varchar(255) not null
		);
	";
	function __construct($dbh,$values=null){
		parent::__construct($dbh,"banner");
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
				"null" => true
			),
			"url" => array(
				"nombre"=>"url",
				"null" => true
			),
			"target" => array(
				"nombre"=>"target",
				"null" => true
			),
			"tipo" => array(
				"nombre"=>"tipo",
				"null" => true
			),
			"estado" => array(
				"nombre"=>"estado",
				"null" => true
			),
			"timestamp" => array(
				"nombre"=>"timestamp",
				"null" => true
			),
			"orden" => array(
				"nombre"=>"orden",
				"null" => true
			),
			"idRecurso" => array(
				"nombre"=>"idRecurso",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
