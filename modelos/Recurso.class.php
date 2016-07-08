<?php namespace Modelos;
class Recurso extends Model{
	public $insert = "INSERT INTO recurso VALUES(?,?,?,?,?,?);";
	public $update = "UPDATE recurso SET nombre=?,mime=?,url=?,activo=?,ultimaModificacion=? WHERE id=?;";
	public $delete = "DELETE FROM recurso WHERE id=?;";
	public $create = "
		CREATE TABLE recurso(
			id integer primary key autoincrement not null,
			nombre varchar(255) not null,
			mime varchar(120) not null,
			url varchar(255),
			activo integer default 1, /* 1 si, 0 no */
			utlimaModificacion datetime
		);
	";
	function __construct($Sql,$file){
		parent::__construct($Sql,"recurso");
		if( $file["error"]!=0 ){
			$error = compile_error("<p>Ocurrió un error al tratar de subir el archivo</p>");
			Throw new Exception($error);
		}
		if( move_uploaded_file($file['tmp_name'],PROJECT_FOLDER."assets/".$file['name']) ){
			$name = $file['name'];
			$mime = $file['type'];
			$url = url."assets/$name";
			$values = array(
				"nombre" => $name,
				"mime" => $mime,
				"url" => $url
			);
			$values['id'] = $this->insertValue($values);
			$this->setValues($values);
		} else {
			exit("Error!!");
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
			"mime" => array(
				"nombre"=>"mime",
				"null" => true
			),
			"url" => array(
				"nombre"=>"url",
				"null" => true
			),
			"activo" => array(
				"nombre"=>"descripcion",
				"null" => true
			),
			"ultimaModificacion" => array(
				"nombre"=>"ultimaModificacion",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO:
	}
}
