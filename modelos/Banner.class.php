<?php
class Banner extends Model{
	public $insert = "INSERT INTO banner VALUES(?,?,?,?,?,?,?,?,?);";
	public $update = "UPDATE banner SET nombre=?,idRecurso=?,url=?,target=?,tipo=?,estado=?,datetime=?,orden=? WHERE id=?;";
	public $delete = "DELETE FROM banner WHERE id=?;";
	public $create = "
		CREATE TABLE banner(
			id integer primary key autoincrement not null,
			nombre varchar(120) not null,
			idRecurso integer not null references recurso(id),
			url varchar(255),
			target varchar(16),
			tipo varchar(120),
			estado varchar(255),
			datetime datetime,
			orden float default 0
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
				"nombre"=>"id",
				"null" => true
			),
			"nombre" => array(
				"nombre"=>"nombre",
				"null" => true
			),
			"idRecurso" => array(
				"nombre"=>"idRecurso",
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
			"datetime" => array(
				"nombre"=>"datetime",
				"null" => true
			),
			"orden" => array(
				"nombre"=>"orden",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
