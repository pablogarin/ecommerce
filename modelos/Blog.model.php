<?php namespace Modelos;
class Blog extends Model{
	public $insert = "INSERT INTO blog VALUES(?,?,?,?,?,?,?);";
	public $update = "UPDATE blog SET titulo=?,fecha=?,foto=?,cuerpo=?,activo=?,autor=? WHERE id=?;";
	public $delete = "DELETE FROM blog WHERE id=?;";
	public $create = "
		CREATE TABLE blog(
			id integer primary key autoincrement not null,
			titulo varchar(255) not null,
            fecha datetime not null,
            foto varchar(255) not null,
			cuerpo text not null,
			activo integer default 1, /* 1si, 0 no */
			autor integer references usuario(id) on delete cascade
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"blog");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
		$this->validFields = array(
			"id" => array(
				"nombre"=>"id",
                "type"=>"hidden",
				"null" => true
			),
			"titulo" => array(
				"nombre" => "titulo",
                "label" => "Titulo",
				"type" => "text",
				"null" => false
			),
			"fecha" => array(
				"nombre" => "fecha",
                "label" => "Fecha",
				"type" => "date",
				"null" => false
			),
			"foto" => array(
				"nombre" => "foto",
                "label" => "Foto",
				"type" => "thumb",
				"null" => false
			),
			"cuerpo" => array(
				"nombre"=>"cuerpo",
                "label" => "Cuerpo del blog",
				"type" => "ckeditor",
				"null" => false
			),
			"activo" => array(
				"nombre"=>"activo",
                "label" => "¿Activo?",
				"type" => "boolean",
				"null" => true
			),
			"autor" => array(
				"nombre"=>"autor",
                "type"=>"hidden",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
