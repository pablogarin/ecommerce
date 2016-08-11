<?php namespace Modelos;
class CostoDespacho extends Model{
	public $insert = "INSERT INTO costo_despacho VALUES(?,?,?);";
	public $update = "UPDATE costo_despacho SET idZona=?,costo=? WHERE id=?;";
	public $delete = "DELETE FROM costo_despacho WHERE id=?;";
	public $create = "
		CREATE TABLE costo_despacho(
			id integer primary key autoincrement not null,
            idZona int,
            costo float
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"costo_despacho");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
        global $dbh;
        $cur = $dbh->query("SELECT * FROM zona where padre=313;");
        $zones = array();
        foreach( $cur as $row ){
            $zones[$row['id']] = $row['nombre'];
        }
		$this->validFields = array(
			"id" => array(
				"nombre"=>"id",
				"type" => "int",
				"null" => true
			),
			"idZona" => array(
				"nombre"=>"idZona",
                "label" => "Comuna",
				"type" => "select",
                "data" => $zones,
				"null" => false
			),
			"costo" => array(
				"nombre"=>"costo",
                "label" => "Costo de Env&iacute;o",
				"type" => "money",
				"null" => true
            )
        );
	}
	function setForeign($elements){
		//TODO: 
	}
}
