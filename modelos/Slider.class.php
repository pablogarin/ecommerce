<?php
class Slider extends Model{
	public $insert = "INSERT INTO slider_categoria VALUES(?,?,?,?);";
	public $update = "UPDATE slider_categoria SET idCategoria=?,activo=?,orden=? WHERE id=?;";
	public $delete = "DELETE FROM slider_categoria WHERE id=?;";
	public $create = "
		CREATE TABLE slider_categoria(
			id integer primary key autoincrement not null,
			idCategoria integer not null references categoria(id),
			activo integer default 1, /* 1 si, 0 no */
			orden float
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"slider_categoria");
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
			"idCategoria" => array(
				"nombre"=>"idCategoria",
				"null" => true
			),
			"activo" => array(
				"nombre"=>"activo",
				"null" => true
			),
			"orden" => array(
				"nombre"=>"orden",
				"null" => true
			)
		);
	}
/*
CREATE TABLE elemento_slider_categoria(
    id integer primary key autoincrement not null,
    idSlider integer not null references slider_categoria(id),
    idRecurso integer not null references recurso(id),
    orden float default 0
);
*/
	function setForeign($elements){
		if( !is_array($elements['fotos']) ){
			Throw new Exception("Los elementos de '" . get_class($this) . "' deben ser un arreglo con la informacion a grabar.");
		} else {
			$this->Sql->q_mod("DELETE FROM elemento_slider_categoria WHERE idSlider=?;",array($this->data['id']));
			// ES UN POCO INNECESARIO ORDENAR POR LLAVE, PERO ES MEJOR
			//ksort($elements);
			foreach( $elements['fotos'] as $order=>$resourceId ){
				$data = array(
					"idSlider"  => $this->data['id'],
					"idRecurso" => $resourceId,
					"orden"		=> $order
				);
				$Element = new ElementoSlider($this->Sql,$data);
				$Element->insertValue();
			}
		}
	}
}
