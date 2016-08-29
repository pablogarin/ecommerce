<?php
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
/*
CREATE TABLE venta(
    id integer primary key autoincrement not null,
    numero varchar(120) not null,
    esFactura integer default 0,
    fecha datetime default CURRENT_TIMESTAMP,
    costoDespacho float default 0,
    total float default 0,
    idCliente integer not null references cliente(id),
    idEstado integer not null references estado(id),
    idDireccion integer not null references direccion(id),
    idEmpresa integer references empresa(id),
    tipoTransaccionTBK varchar(120) default 'TR_NORMAL',
    codigoAutorizacionTBK varchar(120)
);
*/
class OrdenCompra{
	private $id, $data, $nuevo, $fields, $error;
	public function __construct($id=null,$strict=true){
		$this->fields = array(
			'numero',
			'esFactura',
			'fecha',
			'costoDespacho',
			'total',
			'idCliente',
			'idEstado',
			'idDireccion',
			'idEmpresa',
			'tipoTransaccionTBK',
			'codigoAutorizacionTBK',
			'idCarro',
			'notificada',
			'sync'
		);
		if( $id==null ){
			$this->nuevo = true;
		} else {
			$this->nuevo = false;
			$this->setID($id);
			$this->getData($strict);
		}
	}
	public function setID($id){
		if( !is_numeric($id) ){
			Throw new Exception("La id de OrdenCompra::setID debe ser un numero");
			exit;
		}
		$this->id = $id;
		$_SESSION['orden'] = $id;
	}
	public function isNew(){
		return $this->nuevo;
	}
	public function getData($strict = true){
		global $dbh;
		$data = array();
		$data = $dbh->query("SELECT * FROM venta  WHERE id=?;",array($this->id));
		if( $data!==false && !empty($data) ){
			$data = $data[0];
			
		//	if( $strict && (int)$data['idEstado']==4 ){
		//		unset($_SESSION['orden']);
		//		$this->nuevo = true;
		//		return false;
		//	} else {
            $this->data = $data;
            
            /* PRODUCTOS */
            $this->getProducts();
            
            /* CLIENTE */
            $cur = $dbh->query("SELECT * FROM cliente WHERE id=?;",array($this->data['idCliente']));
            $this->data['cliente'] = $cur[0];

            if( !empty($this->data['idDireccion']) ){
                $cur = $dbh->query("SELECT * FROM direccion WHERE id=?;", array($this->data['idDireccion']));
                if( isset($cur[0]) ){
                    $this->data['direccion'] = $cur[0];
                }
            }
            
            /* ESTADO */
            $cur = $dbh->query("SELECT * FROM estado WHERE id=?;",array($this->data['idEstado']));
            if( isset($cur[0]) ){
                $this->data['estado'] = $cur[0]['descripcion'];
            }

            /* CUPONES */
            /* 
                DEFINICION:
                    - PUEDE HABER MAS DE CUPON POR COMPRA
                    - CADA CUPON LE HACE UN DESCUENTO DISTINTO A CADA PRODUCTO
                    - EL MAYOR DESCUENTO NO NECESARIAMENTE SALE DEL CUPON, PUEDE HABER OFERTA
                POR LO TANTO HAY QUE ASEGURAR QUE EL DESCUENTO APLICADO SEA EL MEJOR, EN OTRAS
                PALABRAS, EL QUE DE EL MENOR PRECIO
             */
            include_once 'Cupon.class.php';
            $cur = $dbh->query("SELECT * FROM cupon_venta WHERE idVenta=?;",array($this->data['id']));
            $descuentos = array();
            $giftcards = array();
            $cupones = array();
            if( isset($cur[0]) && is_array($cur[0]) ){
                foreach( $cur as $k=>$v ){
                    $obj = new CuponController($v['idCupon']);
                    $this->data['cupones'][] = $obj;
                    $d = $obj->getData();
                    if( !empty($d['giftcard']) ){
                        $cursor = $dbh->query("Select * from giftcard where id=?;",array($d['giftcard']));
                        if( isset($cursor[0]) ){
                            $giftcards[$cursor[0]['codigo']] = $cursor[0]['monto'];
                        }
                    } else {
                        foreach( $this->data['productos'] as $id=>$prd ){
                            $pData = $prd->getData();
                            $totalDcto = ($prd->getTotalItems()*$pData['precio'])*((int)@$d['descuentos'][$pData['id']]/100);
                            $totalBruto = $prd->getTotalItems()*$pData['precio'];
                            $cupones[$v['idCupon']][$pData['id']] = $totalDcto; // si por algun motivo no se aplica ni uno de los descuentos de un cupon lo debemos quitar de la lista
                            if( $prd->getTotalPrice()>($totalBruto-$totalDcto) ){
                                if( isset($descuentos[$pData['id']]) ){ 
                                    if( $descuentos[$pData['id']] < $totalDcto ){
                                        $descuentos[$pData['id']] = $totalDcto;
                                    } else {
                                        unset($cupones[$v['idCupon']][$pData['id']]);
                                        if( empty($cupones[$v['idCupon']]) ){
                                            unset($cupones[$v['idCupon']]);
                                        }
                                    }
                                } else {
                                    $descuentos[$pData['id']] = $totalDcto;
                                }
                            } else {
                                unset($cupones[$v['idCupon']][$pData['id']]);
                                if( empty($cupones[$v['idCupon']]) ){
                                    unset($cupones[$v['idCupon']]);
                                }
                            }
                        }
                    }
                }
            }
            $subtotal = 0;
            if( isset($this->data['productos']) && is_array($this->data['productos']) ){
                foreach( $this->data['productos'] as $id=>$prd ){
                    $pData = $prd->getData();
                    $totalBruto = $prd->getTotalItems()*$pData['precio'];
                    $subtotal += $totalBruto;
                }
            }
            $this->data['subtotal'] = $subtotal;
            $this->data['giftcards'] = $giftcards;
            $tmp = array();
            foreach( $cupones as $id=>$det){
                $cup = $dbh->query("SELECT * FROM cupon WHERE id=?;",array($id));
                if( isset($cup[0]) && is_array($cup[0]) ){
                    $data = $cup[0];
                    $desc = 0;
                    foreach( $det as $prd=>$dcto ){
                        $desc+=$dcto;
                    }
                    $data['descuento'] = $desc;
                    $tmp[] = $data;
                }
            }
            $this->data['descuentos'] = $tmp;
            
            return $this->data;
		//	}
		}
		return false;
	}
	public function getProducts(){
		include_once 'ProductoControl.class.php';
		global $dbh;
		$data = array();
		$productos = $dbh->query("SELECT * FROM venta_detalle WHERE idVenta=?;",array($this->id));
		if( $productos!==false && !empty($productos) ){
			foreach( $productos as $prd ){
				$PrdObj = new ProductoControl($prd['idProducto']);
				$PrdObj->setQuantity($prd['cantidad']);
				$this->data['productos'][] = $PrdObj;
			}
		}
	}
	public function set($key,$value){
		$this->data[$key] = $value;
	}
    public function getID(){
        return $this->id;
    }
	public function getNumero(){
		global $dbh;
		$n = (int)time();
        $cur = $dbh->query("SELECT * FROM venta WHERE numero=?;",array($n));
		if( !empty($cur) ){
			return $this->getNumero();
		}
		return $n;
	}
	/*
	CREATE TABLE venta_detalle(
		id integer primary key autoincrement not null,
		idVenta integer not null references venta(id),
		idProducto integer not null references producto(id),
		cantidad integer default 1,
		precio float not null,
		descuento float default 0,
		incluyeIVA integer default 1,
		paraRegalo integer default 0
	);
	*/
	public function setFromCart($cart){
		global $dbh;
		date_default_timezone_set('Chile/Continental');
		$cartData = $cart->getData();
		$cartData['productos'] = $cart->getProducts();
        $idCliente = "";
        if( isset($_SESSION['cliente']) or isset($_COOKIE[USER_COOKIE_ID]) ){
            $idCliente = isset($_SESSION['cliente']) ? $_SESSION['cliente'] : $_COOKIE[USER_COOKIE_ID];
        } else {
            $idCliente = $this->data['idCliente'];
        }
		//*
		$data = array(
			'numero' => $this->getNumero(),
            'esFactura' => "0",
			'fecha' => date('Y-m-d H:i:s'),
			'costoDespacho' => 0,
			'total' => $cartData['total'],
			'idCliente' => $idCliente,
			'idEstado' => 1,
			'tipoTransaccionTBK' => 'TR_NORMAL',
			'idCarro' => $_COOKIE[COOKIE_ID]
		);
        // redundancia...
		if( !$this->nuevo ){
			unset($data['numero']);
		}
		$tmp = $data;
		$data = array();
		$fields = array('numero','esFactura','fecha','costoDespacho','total','idCliente','idEstado','idDireccion','idEmpresa','tipoTransaccionTBK','codigoAutorizacionTBK','idCarro','notificada');
		foreach( $fields as $name ){
			if( isset($tmp[$name]) ){
				$data[$name] = $tmp[$name];
			} else {
				if( isset($this->data[$name]) ){
					$data[$name] = $this->data[$name];
				} else {
					$data[$name] = null;
				}
			}
		}
		if( $this->nuevo ){
			$query = "INSERT INTO venta(numero,esFactura,fecha,costoDespacho,total,idCliente,idEstado,idDireccion,idEmpresa,tipoTransaccionTBK,codigoAutorizacionTBK,idCarro,notificada) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);";
		} else {
			$query = "UPDATE venta SET numero=?,esFactura=?,fecha=?,costoDespacho=?,total=?,idCliente=?,idEstado=?,idDireccion=?,idEmpresa=?,tipoTransaccionTBK=?,codigoAutorizacionTBK=?,idCarro=?,notificada=? WHERE id=?;";
			$data['id'] = $this->id;
		}
		$res = $dbh->query($query,array_values($data));
		error_log($res);
		error_log(print_r($data,1));
		if( is_numeric($res) ){
			if( $this->nuevo ){
				$this->setID($res);
			}
			$del = $dbh->query("DELETE FROM venta_detalle WHERE idVenta=?;",array($this->id));
			foreach( $cartData['productos'] as $obj ){
				$prdData = $obj->getData();
				$data = array(
					'idVenta' => $this->id,
					'idProducto' => $prdData['id'],
					'cantidad' => $obj->getTotalItems(),
					'precio' => $prdData['precio'],
					'descuento' => $obj->getDiscount()
				);
				$query = "INSERT INTO venta_detalle(idVenta,idProducto,cantidad,precio,descuento) values(?,?,?,?,?);";
				$res = $dbh->query($query,array_values($data));
				if( $res===false ){
					return false;
				}
			}
			if( isset($cartData['cupones']) && !empty($cartData['cupones']) && is_array($cartData['cupones']) ){
				$dbh->query("DELETE FROM cupon_venta WHERE idVenta=?;",array($this->id));
				foreach( $cartData['cupones'] as $k=>$v ){
					$data = array(
						"idCupon" => $v['id'],
						"idVenta" => $this->id
					);
					$res = $dbh->query("INSERT INTO cupon_venta(idCupon,idVenta) VALUES(?,?);",array_values($data));
					if( !is_numeric($res) || $res==0 ){
						return false;
					}
				}
			}
            $this->getData();
			return true;
		}
		return false;
	}
	public function getSuccessView(){
		return $this->getView("venta-exitosa.html",false);
	}
	public function getDetailView(){
		return $this->getView("orden-detalle.html");
	}
	public function getView($template=null){
        global $view, $dbh;
		if( $template==null ){
			$template = "pago.html";
		}
        $view->setFolder(PATH."/templates");
		$view->set("URL",URL);
		foreach( $this->data as $k=>$v ){
			$view->set($k,$v);
		}
        $totalBruto = 0;
		foreach( $this->data['productos'] as $obj ){
			$obData = $obj->getData();
			$productos[$obData['id']] = $obj;
			$totalBruto += $obData['precio']*$obj->getTotalItems();
		}
        $config = array();
        $cur = $dbh->query("select * from config;");
        foreach( $cur as $row ){
            $config[$row['llave']] = $row;
        }
        foreach( $config as $k=>$v ){
            $view->set($k,$v);
        }
        $view->set("totalBruto",$totalBruto);
		$view->setTemplate($template);
		return $view->getView();
	}
	public function syncToDB(){
		global $dbh;
		$data = array();
		$fields = array('numero','esFactura','fecha','costoDespacho','total','idCliente','idEstado','idDireccion','idEmpresa','tipoTransaccionTBK','codigoAutorizacionTBK','idCarro','notificada=?');
		foreach( $fields as $key ){
			if( isset($this->data[$key]) ){
				$data[$key] = $this->data[$key];
			} else {
				$data[$key] = null;
			}
		}
		$data['id'] = $this->id;
		$query = "UPDATE venta SET numero=?, esFactura=?, fecha=?, costoDespacho=?, total=?, idCliente=?, idEstado=?, idDireccion=?, idEmpresa=?, tipoTransaccionTBK=?, codigoAutorizacionTBK=?, idCarro=?, notificada=? WHERE id=?;";
		$res = $dbh->query($query,array_values($data));
		if( !empty($dbh->errorInfo()[2]) ){
			return false;
		}
		return true;
	}
	public function checkStock(){
		$retval = true;
		if( is_array($this->data['productos']) ){
			foreach( $this->data['productos'] as $k=>$v ){
				$q = $v->getTotalItems();
				$retval &= $v->checkStock($q);
			}
		}
		return $retval;
	}
	public function dropStock(){
		$retval = true;
		if( is_array($this->data['productos']) ){
			foreach( $this->data['productos'] as $k=>$v ){
				$q = $v->getTotalItems();
				$retval &= $v->dropStock($q);
			}
		}
		return $retval;
	}
    public function setError($string = "Error en la venta")
    {
        if( gettype($string) !== 'string' ){
            $this->setError("Se trato de ingresar un error en un formato invalido.\nREF:".__FILE__);
        }
        $this->error = $string;
    }
    public function getError()
    {
        return $this->error;
    }
	public function acceptOrder(){
		include_once 'CartControl.class.php';
		global $dbh;
		$retval = true;
        if( !$this->checkStock() ){
            $this->setError("No hay suficientes productos en Stock para finalizar la compra");
            return false;
        }
		//*
        if( $this->dropStock() ){
            $this->set("idEstado",4);
            if( $this->syncToDB() ){
                // $this->sendMail('aceptada');
                /*
                $this->checkAndCreateGiftcards();
                $this->consumeGiftcards();
                //*/
                unset($_SESSION['orden']);
                $idCarro = $this->data['idCarro'];
                $cart = new CartControl($idCarro);
                $cart->destroy();
                // descontar stock de productos.
            } else {
                error_log("Orden no aceptada. errorInfo = ".print_r($dbh->dbh->errorInfo(),1));
                $retval = false;
            }
            //*/
        }

		return $retval;
	}
	public function dispatchOrder(){
		global $dbh;
		$retval = true;
		
		$this->set("idEstado",7);
		if( $this->syncToDB() ){
			$this->sendMail('despacho');
		} else {
			error_log("Orden no enviada. errorInfo = ".print_r($dbh->dbh->errorInfo(),1));
			$retval = false;
		}

		return $retval;
	}
	public function sendMail($type){
		global $View, $dbh;
		$descuentos = 0;
		$totalBruto = 0;
		$View->set("logo",getLogoBase64());
		$View->setPath("templates");

		$productos = array();
		$cur = $dbh->query("Select * from cupon_venta cv left join cupon c on c.id=cv.idCupon where idVenta=?;",array($this->id));
		foreach( $this->data['productos'] as $obj ){
			$obData = $obj->getData();
			$productos[$obData['id']] = $obj;
			$totalBruto += $obData['precio']*$obj->getTotalItems();
		}
		$View->set("totalBruto",$totalBruto);
		
		if( isset($cur[0]) ){
			foreach( $cur as $cup ){
				if( !empty($cup['giftcard']) ){
					$sc = $dbh->query("Select * from giftcard where id=?;",array($cup['giftcard']));
					if( isset($sc[0]) ){
						$descuentos += $sc[0]['monto'];
					}
				} else {
					$sc = $dbh->query("Select p.id as idProd, ((cp.descuento/100)*p.precio) as descuento from cupon_producto cp left join producto p on cp.idProducto=p.id where cp.idCupon=? and cp.idProducto in (".join(',',array_keys($productos)).");",array($cup['idCupon']));
					if( isset($sc[0]) ){
						foreach( $sc as $dcto ){
							$descuentos += $mnt = (int)$dcto['descuento']*(int)$productos[$dcto['idProd']]->getTotalItems();
						}
					}
				}
			}
		}
		
		$attachments = null;
		switch( $type ){
			case 'aceptada':
				$cur = $dbh->query("Select * from giftcard where idVenta=?;",array($this->id));
				if( isset($cur[0]) ){
					$attachments = array();
					foreach( $cur as $val ){
						$attachments[$val['codigo'].".pdf"] = "/var/www/dev/sdb.cl/assets/".$val['archivo'];
					}
				}
				if( $this->getData(false)['notificada']=='1' ){
					return true;
				} else {
					$this->set("notificada","1");
					$this->syncToDB();
				}
				$title = "Compra exitosa";
				$View->setTemplate("mail-venta-exitosa.html");
				break;
			case 'despacho':
				$title = "Compra enviada";
				$View->setTemplate("mail-despacho.html");
				break;
		}
		$tmp = $this->getData(false);
		foreach( $tmp as $k=>$v ){
			$View->set($k,$v);
		}
		// la variable descuentos ya existe, pero no la usamos aca... la sobreescribimos con el descuento.
		$View->set('descuentos', $descuentos);

		$body = $View->getView();
		sendEmail($this->getData(false)['cliente']['correo'], $title, $body, $attachments);
		return $body;
	}
	private function checkAndCreateGiftcards(){
        /*
		global $dbh;
		include "giftcard.php";
		
		$attachments = array();
		
		foreach( $this->data['productos']  as $prd ){
			$prdData = $prd->getData();
			if( $prdData['tipo']=='G' ){
				$codigo = generaCodigo();
				$continue = false;
				while( !$continue ){
					$cur = $dbh->query("select * from giftcard where codigo=?;",array($codigo));
					if( isset($cur[0]['codigo']) ){
						$codigo = generaCodigo();
					} else {
						$continue = true;
					}
				}
				$attachments[] = $file = generaGiftcard( $prdData['precio'],$codigo,$this->data );
			}
		}
		$this->data['attachments'] = $attachments;
        //*/
	}
	private function consumeGiftcards(){
		global $dbh;
		$cur = $dbh->query("Select * from cupon where id in (Select idCupon from cupon_venta where idVenta=?);",array($this->id));
		if( isset($cur[0]) ){
			foreach( $cur as $k=>$v ){
				if( !empty($v['giftcard']) ){
					$mod = $dbh->query("update giftcard set estado='U', fechaUso=? where id=?;",$d = array(date("Y-m-d H:i:s"), $this->id));
					error_log("Detalles de modificacion de giftcard: ".date("Y-m-d H:i:s")." - Datos: ".var_dump($d,1)."; Resultado: ".var_dump($mod,1)); // guardamos el resultado en el log de errores: /tmp/php-error.log
				}
				$mod = $dbh->query("update cupon set activo=0 where id=?;",$d = array($v['id']));
				error_log("Detalles de modificacion de cupon: ".date("Y-m-d H:i:s")." - Datos: ".var_dump($d,1)."; Resultado: ".var_dump($mod,1)); // guardamos el resultado en el log de errores: /tmp/php-error.log
			}
		}
	}
    public function getEstado($id = true){
        global $dbh;
        if( $id ){
            return $this->data['idEstado'];
        } else {
            $cur = $dbh->query("SELECT * FROM estado WHERE id=?;", array($this->data['idEstado']));
            if( isset($cur[0]) ){
                return $cur[0]['id'];
            }
            return "Ingresada";
        }
    }
}
?>
