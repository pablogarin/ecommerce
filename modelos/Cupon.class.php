<?php namespace Modelos;
class Cupon extends Model{
	public $insert = "INSERT INTO cupon VALUES(?,?,?,?,?,?,?);";
	public $update = "UPDATE cupon SET titulo=?,codigo=?,fechaInicio=?,fechaFin=?,activo=?,giftcard=? WHERE id=?;";
	public $delete = "DELETE FROM cupon WHERE id=?;";
	public $create = "
		CREATE TABLE cupon(
			id integer primary key autoincrement not null,
			titulo varchar(120) not null,
			codigo varchar(120) not null UNIQUE,
			fechaInicio datetime default CURRENT_TIMESTAMP,
			fechaFin datetime not null,
			activo integer default 1,
			giftcard integer references giftcard(id)
		);
	";
	function __construct($Sql,$values=null){
		parent::__construct($Sql,"cupon");
		if($values!=null){
			$this->setValues($values);
		}
	}
	function setValidFields(){
		$this->validFields = array(
			'id' => array(
				"nombre" => 'id',
				"null"=> true
			),
			'titulo' => array(
				"nombre" => 'titulo',
				"null"=> false
			),
			'codigo' => array(
				"nombre" => 'codigo',
				"null"=> false
			),
			'fechaInicio' => array(
				"nombre" => 'fechaInicio',
				"null"=> true
			),
			'fechaFin' => array(
				"nombre" => 'fechaFin',
				"null"=> false
			),
			'activo' => array(
				"nombre" => 'activo',
				"null"=> true
			),
			'giftcard' => array(
				"nombre" => 'giftcard',
				"null"=> true
			)
		);
	}
/*
CREATE TABLE cupon_producto(
	id integer primary key autoincrement not null,
	idCupon integer references cupon(id),
	idProducto integer references producto(id),
	descuento float default 0
);
//*/
	function setForeign($elements){
		global $Sql;
		$res = $Sql->q_mod("DELETE FROM cupon_producto WHERE idCupon=?;",array($this->data['id']));
		foreach( $elements['productos'] as $k=>$v ){
			$tmp = array();
			foreach( $v as $key=>$value ){
				$key = str_replace("'","",$key);
				$tmp[$key] = $value;
			}
			$v = $tmp;
			if( empty($v['product']) ){
				continue;
			}
			$data = array(
				"idCupon" => $this->data['id'],
				"idProducto" => $v['product'],
				"descuento" => $v['dcto']
			);
			$res = $Sql->q_mod("INSERT INTO cupon_producto(idCupon,idProducto,descuento) VALUES(?,?,?)",array_values($data));
		}
	}
}
