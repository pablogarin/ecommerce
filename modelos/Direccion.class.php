<?php
class direccion extends Model{
	public $insert = "INSERT INTO direccion VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
	public $update = "UPDATE direccion SET nombre=?,receptorNombre=?,receptorApellido=?,nombreEmpresa=?,facturacion=?,principal=?,idCliente=?,direccion=?,fono=?,cel=?,idZona=?,cod_destinatario_SAP=?,retiro=? WHERE id=?;";
	public $delete = "DELETE FROM direccion WHERE id=?;";
	public $create = "
        CREATE TABLE direccion(
            id integer primary key autoincrement not null,
            nombre varchar(255) not null,
            receptorNombre varchar(255) not null,
            receptorApellido varchar(255) not null,
            nombreEmpresa varchar(255),
            facturacion integer default 0, /* 1 si, 0 no */
            principal integer default 0, /* 1 si, 0 no; ¿Es la direccion principal del usuario? */
            idCliente  integer not null references cliente(id),
            direccion text not null,
            fono varchar(16), /* +56 9 9999 9999 y 99999999 son el mismo fono y ambos son validos */
            cel varchar(16),
            idZona integer not null references zona(id),
            cod_destinatario_SAP text, 
            retiro default 0
        );
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"direccion");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
		$this->validFields = array(
            "id" => array(
                "nombre" => "id",
                "null" => true
            ),
            "nombre" => array(
                "nombre" => "nombre",
                "null" => true
            ),
            "receptorNombre" => array(
                "nombre" => "receptorNombre",
                "null" => true
            ),
            "receptorApellido" => array(
                "nombre" => "receptorApellido",
                "null" => true
            ),
            "nombreEmpresa" => array(
                "nombre" => "nombreEmpresa",
                "null" => true
            ),
            "facturacion" => array(
                "nombre" => "facturacion",
                "null" => true
            ),
            "principal" => array(
                "nombre" => "principal",
                "null" => true
            ),
            "idCliente" => array(
                "nombre" => "idCliente",
                "null" => true
            ),
            "direccion" => array(
                "nombre" => "direccion",
                "null" => true
            ),
            "fono" => array(
                "nombre" => "fono",
                "null" => true
            ),
            "cel" => array(
                "nombre" => "cel",
                "null" => true
            ),
            "idZona" => array(
                "nombre" => "idZona",
                "null" => true
            ),
            "cod_destinatario_SAP" => array(
                "nombre" => "cod_destinatario_SAP",
                "null" => true
            ),
            "retiro" => array(
                "nombre" => "retiro",
                "null" => true
            )
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
