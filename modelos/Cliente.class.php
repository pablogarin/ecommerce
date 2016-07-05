<?php
class Cliente extends Model{
	public $insert = "INSERT INTO cliente VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
	public $update = "UPDATE cliente SET usuario=?,contrasena=?,rut=?,nombre=?,apellido=?,correo=?,fechaNacimiento=?,genero=?,fono=?,esEmpresa=?,razon=?,rutEmpresa=?,giro=?,cod_cliente_SAP WHERE id=?;";
	public $delete = "DELETE FROM cliente WHERE id=?;";
	public $create = "
		CREATE TABLE cliente(
			id integer primary key autoincrement not null,
			usuario varchar(128) not null,
			contrasena varchar(128) not null,
			rut varchar(16),
			nombre varchar(255) not null,
			apellido varchar(255) not null,
			correo varchar(255) not null,
			fechaNacimiento date,
			genero char(1), /* M masculino, F femenino */
			fono varchar(128),
			esEmpresa integer default 0, /* 1 si, 0 no */
			razon varchar(255),
			rutEmpresa varchar(16),
			giro varchar(128),
			cod_cliente_SAP text
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"cliente");
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
			"usuario" => array(
				"nombre" => "usuario",
				"null" => true
			),
			"contrasena" => array(
				"nombre" => "contrasena",
				"null" => true
			),
			"rut" => array(
				"nombre" => "rut",
				"null" => true
			),
			"nombre" => array(
				"nombre" => "nombre",
				"null" => true
			),
			"apellido" => array(
				"nombre" => "apellido",
				"null" => true
			),
			"correo" => array(
				"nombre" => "correo",
				"null" => true
			),
			"fechaNacimiento" => array(
				"nombre" => "fechaNacimiento",
				"null" => true
			),
			"genero" => array(
				"nombre" => "genero",
				"null" => true
			),
			"fono" => array(
				"nombre" => "fono",
				"null" => true
			),
			"esEmpresa" => array(
				"nombre" => "esEmpresa",
				"null" => true
			),
			"razon" => array(
				"nombre" => "razon",
				"null" => true
			),
			"rutEmpresa" => array(
				"nombre" => "rutEmpresa",
				"null" => true
			),
			"giro" => array(
				"nombre" => "giro",
				"null" => true
			),
			"cod_cliente_SAP" => array(
				"nombre" => "cod_cliente_SAP",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
