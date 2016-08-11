<?php
/*
CREATE TABLE cliente(
    id integer primary key autoincrement not null,
    usuario varchar(128) not null,
    contrasena varchar(128) not null,
    rut varchar(16) not null,
    nombre varchar(255) not null,
    apellido varchar(255) not null,
    correo varchar(255) not null,
    fechaNacimiento date,
    genero char(1),
    fono varchar(128)
);
*/
class ClienteControl{
	private $id, $data, $validFields;
	function __construct($id){
		if( $id==null || empty($id) ){
			Throw new Exception("Se debe indicar la id del cliente.");
			exit;
		}
		$this->setID($id);
		$this->validFields = array("nombre","apellido","correo","contrasena","fechaNacimiento");
		$this->getData();
	}

	/* setID
	* Asigna la ID del cliente 
	* ======================================================
	* @param Integer $id id de la base de datos que corresponde a un cliente.
	*
	* */
	public function setID($id){
		if( !is_numeric($id) ){
			Throw new Exception("La id del cliente debe ser numerica");
			exit;
		}
		$this->id = $id;
	}

	/* getData
	* Devuelve los datos de un cliente
	* @return Array $data datos del usuario
	* ======================================================
	*
	* */
	public function getData(){
		global $dbh;
		$this->data = array();
		$data = $dbh->query("SELECT * FROM cliente WHERE id=?;",array($this->id));
		if( $data!==false && !empty($data) ){
			$data = $data[0];
			$this->data = $data;
			return $this->data;
		}
		return false;
	}

	/* getAddresses
	* Devuelve todas las direcciones de un cliente
	* @return Array $direcciones listado de direcciones del cliente
	* ======================================================
	*
	* */
	public function getAddresses(){
		/* DIRECCIONES */
		global $dbh;
		$data = $dbh->query("SELECT * FROM direccion WHERE idCliente=?;",array($this->id));
		if( $data!==false ){
			foreach( $data as $k=>$v ){
				$zona = $v['idZona'];
				$tmp = $dbh->query("SELECT c.nombre as comuna, p.nombre as ciudad, r.nombre as region FROM zona c LEFT JOIN zona p ON c.padre=p.id LEFT JOIN zona r ON p.padre=r.id WHERE c.id=?;",array($zona));
				$data[$k] = array_merge($data[$k],$tmp[0]);
			}
			$this->data['direcciones'] = $data;
			return $data;
		} else {
			return false;
		}
	}

	/* addAddress
	* Agrega una direccion nueva
	* @return bool direccion actualizada con exito
	* ======================================================
	* @param Array $data["nombre","receptorNombre","receptorApellido","nombreEmpresa","facturacion","principal","idCliente","direccion","fono","cel","idZona"]
	*
	* */
	public function addAddress($data){
		global $dbh;
		$fields = array(
			"nombre",
			"receptorNombre",
			"receptorApellido",
			"nombreEmpresa",
			"facturacion",
			"principal",
			"idCliente",
			"direccion",
			"fono",
			"cel",
			"idZona"
		);
		$query = "INSERT INTO direccion(nombre,receptorNombre,receptorApellido,nombreEmpresa,facturacion,principal,idCliente,direccion,fono,cel,idZona) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
		$update = array();
		if( $data!=null && is_array($data) ){
			foreach( $fields as $field ){
				if( $field == 'idCliente' ){
					$update[$field] = $this->id;
					continue;
				}
				$update[$field] = null;
				if( isset($data[$field]) && !empty($data[$field]) ){
					$update[$field] = $data[$field];
				} else {
					//$update[$field] = $old[$field];
				}
			}
			$res = $dbh->query($query,$update);
			return $res;
		}
		return false;
	}

	/* updateAddress
	* Actualiza una direccion especifica
	* @return bool direccion actualizada con exito
	* ======================================================
	* @param Array $data["nombre","receptorNombre","receptorApellido","nombreEmpresa","facturacion","principal","idCliente","direccion","fono","cel","idZona","id"]
	*
	* */
	public function updateAddress($data){
		global $dbh;
		$fields = array(
			"nombre",
			"receptorNombre",
			"receptorApellido",
			"nombreEmpresa",
			"facturacion",
			"principal",
			"idCliente",
			"direccion",
			"fono",
			"cel",
			"idZona",
			"id"
		);
		$query = "UPDATE direccion SET nombre=?,receptorNombre=?,receptorApellido=?,nombreEmpresa=?,facturacion=?,principal=?,idCliente=?,direccion=?,fono=?,cel=?,idZona=? WHERE id=?;";
		$update = array();
		if( $data!=null && is_array($data) ){
			if( isset($data['id']) && is_numeric($data['id']) ){
				$id = $data['id'];
				$old = $dbh->query("SELECT * FROM direccion WHERE id=?;",array($id));
				$old = $old[0];
			} else {
				Throw new Exception("En el metodo ClienteControl::updateAddress(data), el parametro debe ser un arreglo y debe contener la id de la direccion a actualizar.");
				exit;
			}
			foreach( $fields as $field ){
				$update[$field] = null;
				if( $field == 'idCliente' ){
					$update[$field] = $this->id;
					continue;
				}
				if( isset($data[$field]) && !empty($data[$field]) ){
					$update[$field] = $data[$field];
				} else {
					$update[$field] = $old[$field];
				}
			}
			$res = $dbh->query($query,$update);
			return $res;
		}
		return false;
	}

	/* login
	* Inicia sesion de usuario
	* @return bool login exitoso
	* ======================================================
	* @param String $user usuario del cliente
	* @param String $password clave del usuario 
	*
	* */
	public static function login($user,$password){
		global $dbh;
		if( empty($user) || empty($password) ){
			return false;
		}
		$client = $dbh->query("SELECT * FROM cliente WHERE correo=? AND contrasena=?;",array($user,$password));
		if( isset($client[0]) ){
			$client = $client[0];
			setcookie(USER_COOKIE_ID,$client['id'],time()+3600*24*360,"/"); //3600=segundos, 24=horas, 360=dias
			return true;
		} else {
			return false;
		}
	}

	/* logout
	* Cierra la sesion activa 
	* ======================================================
	*
	* */
	public function logout(){
		setcookie(USER_COOKIE_ID,$this->id,1,"/");
		session_destroy();
		header("Location: ".url);
	}

	/** createUser
	* Crea un nuevo usuario y deja la sesion activa
	* @return Integer id de cliente
	* ======================================================
	* @param Array $data["nombre","apellido","correo","rut","contrasena","fechaNacimiento","esEmpresa","razon","rutEmpresa","giro"]
	*
	**/
	public static function createUser($data){
        global $dbh;
		if( !is_array($data) ){
			Throw new Exception("Los datos de usuario deben ser un arreglo.");
			exit;
		}
        $remember = (isset($data['remember']) && strtolower($data['remember'])=='on');
        $model = new \Modelos\Cliente($dbh);
        $model->setNew(true);
        $dataModel = $model->getValidFields();
        foreach( $dataModel as $name=>$format ){
            if( isset($data[$name]) ){
                $value = $data[$name];
                switch( $format['type'] ){
                    case 'mail':
                        if( !filter_var($value, FILTER_VALIDATE_EMAIL) ){
                            throw new \Exception("E-Mail inv&aacute;lido.");
                        }
                        break;
                    case 'text':
                        break;
                }
            }
        }
        $id = $model->setValues($data);
        if( is_numeric($id) && (int)$id>0 ){
            if( $remember ){
                setcookie(USER_COOKIE_ID,$id,time()+3600*24*360,"/"); //3600=segundos, 24=horas, 360=dias
            } else {
                $_SESSION['cliente'] = $id;
            }
            $cli = new ClienteControl($id);
            // $cli->sendMail("registro");
            return $cli;
        }
        throw new \Exception("No se pudo crear el cliente en la base de datos.");
	}
	public function sendMail($type){
		global $view;
		$view->set("logo",getLogoBase64());
		$view->setFolder(PATH."/templates");
		switch( $type ){
			case 'registro':
				$title = "Registro exitoso";
				$view->setTemplate("mail-registro.html");
				break;
			case 'clave':
				$title = "Cambio de clave";
				$view->setTemplate("mail-cambio-clave.html");
				break;
            case 'recuperar':
				$title = "Cambio de clave";
				$view->setTemplate("mail-recupera-clave.html");
                break;
		}
		foreach( $this->data as $k=>$v ){
			$view->set($k,$v);
		}
		$body = $view->getView();
		sendEmail($this->data['correo'], $title, $body);
	}
	public function getMainAddress(){
		$ad = $this->getAddresses();
		foreach( $ad as $dir ){
			if( $dir['principal']==1 ){
				return $dir;
			}
		}
		return $ad[0];
	}
/*
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
//*/
	public function setMainAddress($data){
		global $dbh;
		$fields = array(
			"nombre",
			"receptorNombre",
			"receptorApellido",
			"nombreEmpresa",
			"facturacion",
			"principal",
			"idCliente",
			"direccion",
			"fono",
			"cel",
			"idZona",
			"id"
		);
		$query = "UPDATE direccion SET nombre=?,receptorNombre=?,receptorApellido=?,nombreEmpresa=?,facturacion=?,principal=?,idCliente=?,direccion=?,fono=?,cel=?,idZona=? WHERE id=?;";
		$update = array();
		$old = $this->getMainAddress();
		if( $data!=null && is_array($data) ){
			foreach( $fields as $field ){
				$update[$field] = null;
				if( isset($data[$field]) && !empty($data[$field]) ){
					$update[$field] = $data[$field];
				} else {
					$update[$field] = $old[$field];
				}
			}
			$res = $dbh->query($query,$update);
			return $res;
		}
		return false;
	}
	public function getMainBilling(){
		$ad = $this->getAddresses();
		foreach( $ad as $dir ){
			if( $dir['principal']==1 && $dir['facturacion'] ){
				return $dir;
			}
		}
		return $ad[0];
	}
	public function getView($template="tu-cuenta.html"){
		global $dbh;
		$View = new View();
		$View->set("URL",url);
		foreach( $this->data as $k=>$v ){
			$View->set($k,$v);
		}
		$View->set("direccion",$this->getMainAddress());
		$View->set("facturacion",$this->getMainBilling());
		$direcciones = $this->getAddresses();
		foreach( $direcciones as $i=>$direccion ){
			if( $direccion['id']==($this->getMainAddress()['id']) ){
				unset($direcciones[$i]);
			}
		}
		/* REGIONES */
		if( $data = $dbh->query("SELECT * FROM zona WHERE padre=(SELECT id FROM zona WHERE codigo='CL');") ){
			$View->set("regiones",$data);
		}
		$View->set("direcciones",$direcciones);
		$cur = $dbh->query("SELECT id FROM venta WHERE idCliente=?;",array($this->id));
		$compras = array();
		foreach( $cur as $sale ){
			$ord = new OrdenCompra($sale['id']);
			$compras[] =$ord->getData(false); 
		}
		$View->set("compras",$compras);
		
		$View->setTemplate($template);
		return $View->getView();
		
	}
/*
id integer primary key autoincrement not null,
usuario varchar(128) not null,
contrasena varchar(128) not null,
rut varchar(16),
nombre varchar(255) not null,
apellido varchar(255) not null,
correo varchar(255) not null,
fechaNacimiento date,
genero char(1), 
fono varchar(128),
esEmpresa integer default 0, 
razon varchar(255),
rutEmpresa varchar(16),
giro varchar(128)
//*/
	public function syncToDB($data=null){
		global $dbh;
		// ojo con el orden ...
		$fields = array(
			"usuario",
			"contrasena",
			"rut",
			"nombre",
			"apellido",
			"correo",
			"fechaNacimiento",
			"genero",
			"fono",
			"esEmpresa",
			"razon",
			"rutEmpresa",
			"giro",
			"id"
		);
		// ... por esto
		$query = "UPDATE cliente SET usuario=?,contrasena=?,rut=?,nombre=?,apellido=?,correo=?,fechaNacimiento=?,genero=?,fono=?,esEmpresa=?,razon=?,rutEmpresa=?,giro=? WHERE id=?;";
		$update = array();
		if( $data!=null && is_array($data) ){
			foreach( $fields as $field ){
				$update[$field] = null;
				if( isset($data[$field]) && (!empty($data[$field]) || $data[$field]=='' || $data[$field]=='0') ){
					$update[$field] = $data[$field];
				} else {
					if( isset($this->data[$field]) && !empty($this->data[$field]) ){
						$update[$field] = $this->data[$field];
					}
				}
			}
		} else {
			foreach( $fields as $field ){
				$update[$field] = null;
				if( isset($this->data[$field]) && !empty($this->data[$field]) ){
					$update[$field] = $this->data[$field];
				}
			}
		}
		if( is_array($update['fechaNacimiento']) ){
			$update['fechaNacimiento'] = $update['fechaNacimiento']['year']."-".$update['fechaNacimiento']['month']."-".$update['fechaNacimiento']['day'];
		}
		$res = $dbh->query($query,array_values($update));
		return $res;
	}

	/* setID
	* Asigna la ID del cliente 
	* @return Array $data datos del usuario
	* ======================================================
	* @param Integer $id id de la base de datos que corresponde a un cliente.
	*
	* */
	public function setPassword($old,$new){
		global $dbh;
		if( $old==null || $new==null ){
			Throw new Exception("El metodo ClienteControl::setPassword() recibe 2 parametros.");
			exit;
		}
		if( $old!=$this->data['contrasena'] ){
			return false;
		} else {
			$res = $this->syncToDB(array("contrasena"=>$new));
			if( is_numeric($res) ){
				return true;
			} else {
				return false;
			}
		}
	}
}
?>
