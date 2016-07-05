<?php
class ElementoSlider extends Model{
	public $insert = "INSERT INTO elemento_slider_categoria VALUES(?,?,?,?);";
	public $update = "UPDATE elemento_slider_categoria SET idCategoria=?,activo=?,orden=? WHERE id=?;";
	public $delete = "DELETE FROM elemento_slider_categoria WHERE id=?;";
	public $create = "
		CREATE TABLE elemento_slider_categoria(
			id integer primary key autoincrement not null,
			idSlider integer not null references slider_categoria(id),
			idRecurso integer not null references recurso(id),
			orden float
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"elemento_elemento_slider_categoria");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValues($values=null){
		parent::setValues($values);
		
	}
	function setValidFields(){
		$this->validFields = array(
			"id" => array(
				"nombre"=>"id",
				"null" => true
			),
			"idSlider" => array(
				"nombre"=>"idSlider",
				"null" => false
			),
			"idRecurso" => array(
				"nombre"=>"idRecurso",
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
