<?php
class Categoria extends Model{
	public $insert = "INSERT INTO categoria VALUES(?,?,?,?,?,?,?);";
	public $update = "UPDATE categoria SET nombre=?, padre=?, activa=?, foto=?, banner=?, orden=? where id=?";
	public $delete = "DELETE FROM categoria WHERE id=?;";
	public $create = "
		CREATE TABLE categoria(
			id integer primary key autoincrement not null,
			nombre varchar(128) not null,
			padre integer not null default -1 references categoria(id),
			activa integer default 1, /* 1 si, 0 no */
			foto integer references recurso(id),
			banner integer references recurso(id),
			orden float
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"categoria");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
        global $dbh;
        $cur = $dbh->query("SELECT * FROM categoria;");
        $cats = array();
        foreach( $cur as $row ){
            $cats[$row['id']] = $row['nombre'];
        }
		$this->validFields = array(
			"id" => array(
				"nombre" => "id",
				"type" => "int",
				"null" => true
			),		
			"nombre" => array(
				"nombre" => "nombre",
                "label" => "Nombre de la Categor&iacute;a",
				"type" => "text",
				"null" => false
			),	
			"padre" => array(
				"nombre" => "padre",
                "label" => "Categor&iacute;a a la que pertenece",
				"null" => true,
				"type" => "select",
                "data" => $cats,
				"length" => 128
			),	
			"activa" => array(
				"nombre" => "activa",
                "label" => "¿Activa?",
				"type" => "boolean",
				"null" => true
			),	
			"foto" => array(
				"nombre" => "foto",
                "label" => "Foto",
				"type" => "file",
				"null" => true
			),	
			"banner" => array(
				"nombre" => "banner",
				"null" => true
			),	
			"orden" => array(
				"nombre" => "orden",
                "label" => "Orden",
				"type" => "text",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: implement
	}
}
