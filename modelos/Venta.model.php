<?php namespace Modelos;
class Venta extends Model{
	public $insert = "INSERT INTO venta VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    public $update = "UPDATE venta SET numero=?,esFactura=?,fecha=?,costoDespacho=?,total=?,idCliente=?,idEstado=?,idDireccion=?,idEmpresa=?,tipoTransaccionTBK=?,codigoAutorizacionTBK=?,idCarro=?,descuento=?,notificada=?,sync=?,cod_venta_SAP=?, idTipoPago=? WHERE id=?;";
	public $delete = "DELETE FROM venta WHERE id=?;";
	public $create = "
		CREATE TABLE venta(
            id integer primary key AUTO_INCREMENT not null,
            numero varchar(120) not null,
            esFactura integer default 0, /* 1 si, 0 no */
            fecha timestamp default CURRENT_TIMESTAMP,
            costoDespacho float default 0,
            total float default 0,
            idCliente integer not null references cliente(id),
            idEstado integer not null references estado(id),
            idDireccion integer not null references direccion(id),
            idEmpresa integer references empresa(id),
            tipoTransaccionTBK varchar(120) default 'TR_NORMAL',
            codigoAutorizacionTBK varchar(120),
            idCarro integer not null references carro(id), 
            descuento float default 0, 
            notificada integer default 0, 
            sync integer default 0, 
            cod_venta_SAP text,
            idTipoPago integer not null references tipo_pago(id)
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"venta");
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
			"numero" => array(
				"nombre"=>"numero",
                "label" => "Numero de Venta",
                "type"=>"text",
				"null" => true
			),
			"esFactura" => array(
				"nombre" => "esFactura",
                "label" => "Es Factura",
				"type" => "hidden",
				"null" => false
			),
			"fecha" => array(
				"nombre"=>"fecha",
                "label"=>"Fecha",
                "type"=>"text",
				"null" => true
			),
			"costoDespacho" => array(
				"nombre"=>"costoDespacho",
                "label"=>"Costo Despacho",
                "type"=>"money",
				"null" => true
			),
			"total" => array(
				"nombre"=>"total",
                "label"=>"Total Bruto",
                "type"=>"money",
				"null" => true
			),
			"idCliente" => array(
				"nombre"=>"idCliente",
                "label"=>"Correo del Cliente",
                "type"=>"text",
				"null" => true
			),
			"idEstado" => array(
				"nombre"=>"idEstado",
                "label"=>"Estado de la Compra",
                "type"=>"label",
                "data"=>array(
                    "Ingresada" => "label-warning",
                    "Anulada" => "label-danger",
                    "Aceptada" => "label-success",
                    "Pagada" => "label-info"
                ),
				"null" => true
			),
			"idDireccion" => array(
				"nombre"=>"idDireccion",
                "type"=>"hidden",
				"null" => true
			),
			"idEmpresa" => array(
				"nombre"=>"idEmpresa",
                "type"=>"hidden",
				"null" => true
			),
			"tipoTransaccionTBK" => array(
				"nombre"=>"tipoTransaccionTBK",
                "type"=>"hidden",
				"null" => true
			),
			"codigoAutorizacionTBK" => array(
				"nombre"=>"codigoAutorizacionTBK",
                "type"=>"hidden",
				"null" => true
			),
			"idCarro" => array(
				"nombre"=>"idCarro",
                "type"=>"hidden",
				"null" => true
			),
			"descuento" => array(
				"nombre"=>"descuento",
                "type"=>"hidden",
				"null" => true
			),
			"notificada" => array(
				"nombre"=>"notificada",
                "type"=>"hidden",
				"null" => true
			),
			"sync" => array(
				"nombre"=>"sync",
                "type"=>"hidden",
				"null" => true
			),
			"cod_venta_SAP" => array(
				"nombre"=>"cod_venta_SAP",
                "type"=>"hidden",
				"null" => true
			),
			"idTipoPago" => array(
				"nombre"=>"idTipoPago",
                "type"=>"hidden",
				"null" => true
			)
		);
	}
	function setForeign($elements){
		//TODO: 
	}
}
