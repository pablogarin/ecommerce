<?php
/*
CREATE TABLE direccion(
	id integer primary key autoincrement not null,
	nombre varchar(255) not null,
	receptorNombre varchar(255) not null,
	receptorApellido varchar(255) not null,
	nombreEmpresa varchar(255),
	facturacion integer default 0, 
	principal integer default 0, 
	idCliente  integer not null references cliente(id),
	direccion text not null,
	fono varchar(16), 
	cel varchar(16),
	idZona integer not null references zona(id)
);
*/
class DireccionControl{
	private $id, $data;
	public function __construct($id){
		if( $id==null || empty($id) ){
			Throw new Exception("Se debe indicar la id de la direccion");
			exit;
		}
		$this->setID($id);
		$this->getData(false);
	}
	public function setID($id){
		if( !is_numeric($id) ){
			Throw new Exception("La id debe ser un valida (numerica)");
			exit;
		}
		$this->id = $id;
	}
	public function getData($strict = true){
		global $Sql;
		$data = $Sql->q_read("SELECT * FROM direccion WHERE id=?;",array($this->id));
		if( $data!==false ){
			$data = $data[0];
			// hay que comprobar que sea el usuario que corresponde
			if( isset($_COOKIE[USER_COOKIE_ID]) ){
				$curUser = $_COOKIE[USER_COOKIE_ID];
				/*
				if( $strict and (int)$data['idCliente']!==(int)$curUser ){
					header("Location: " . url . "");
					exit;
				}
				//*/
				$this->data = $data;
				/* ZONA */
				$tmp = $Sql->q_read("SELECT c.nombre as comuna, p.nombre as ciudad, r.nombre as region FROM zona c LEFT JOIN zona p ON c.padre=p.id LEFT JOIN zona r ON p.padre=r.id WHERE c.id=?;",array($this->data['idZona']));
				$this->data = array_merge($this->data,$tmp[0]);
				
				return $this->data;
			}
		}
		return false;
	}
	public static function saveAddress($data){
		global $Sql;
		$acceptedFields = array(
			'nombre',
			'receptorNombre',
			'receptorApellido',
			'nombreEmpresa',
			'facturacion',
			'principal',
			'idCliente',
			'direccion',
			'fono',
			'cel',
			'idZona',
		);
		$requiredFields = array(
			'nombre',
			'receptorNombre',
			'receptorApellido',
			'idCliente',
			'direccion',
			'fono',
			'idZona',
		);
		if( !is_array($data) ){
			Throw new Exception("Los datos para 'DireccionControl::saveAddress(data)' deben ser un arreglo asociativo.");
			exit;
		}
		foreach( $data as $k=>$v ){
			if( !in_array($k,$acceptedFields) ){
				unset($data[$k]);
			}
			if( empty($v) ){
				unset($data[$k]);
			}
		}
		foreach( $requiredFields as $k ){
			if( empty($data[$k]) ){
				return false;
			}
		}
		// orden correcto de los elementos
		$tmp = $data;
		$data = array();
		foreach( $acceptedFields as $k ){
			if( empty($tmp[$k]) ){
				$data[$k] = null;
			} else {
				$data[$k] = $tmp[$k];
			}
		}
		$res = $Sql->q_mod("INSERT INTO direccion(nombre,receptorNombre,receptorApellido,nombreEmpresa,facturacion,principal,idCliente,direccion,fono,cel,idZona) VALUES(?,?,?,?,?,?,?,?,?,?,?);",array_values($data));
		if( !empty($Sql->dbh->errorInfo()[2]) ){
			return $Sql->dbh->errorInfo()[2];
		}
		if( $res!==false ){
			return $res;
		}
		return false;
	}
}
?>
