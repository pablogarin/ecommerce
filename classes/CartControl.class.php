<?php
/*
*
* CREATE TABLE carro(
*     id integer primary key autoincrement not null,
*     cliente integer references cliente(id),
*     fechaModificacion datetime,
*     total float,
*     despacho float
* );
* CREATE TABLE producto_carro(
*     id integer primary key autoincrement not null,
*     idCarro integer not null references carro(id),
*     idProducto integer not null references producto(id),
*     cantidad integer
* );
*
*/
include_once("ProductoControl.class.php");
class CartControl{
	private $id;
	private $data;
	
	function __construct($id=null,$values=null){
		if( $id==null ){
			$this->setNewCart();
		} else {
			$this->setID($id);
			$this->getData();
		}
		if( $values!=null ){
			$this->setData($values);
		}
	}
	function setID( $id ){
		if( !is_numeric($id) ){
			Throw new Exception("La id del carro debe ser numerica");
			exit;
		}
		$this->id = $id;
	}
	function setNewCart(){
		global $dbh;
		$this->data = array();
		$id = $dbh->query("INSERT INTO carro(id,total,despacho) VALUES(null,0,0);");
		if( !$id || !is_numeric($id) ){
			print_r($dbh->dbh->errorInfo());
			exit;
		}
		$this->id = $id;
		setcookie(COOKIE_ID,$id,time()+3600*24*360,"/"); //3600=segundos, 24=horas, 360=dias
	}
	function destroy(){
		global $dbh;
		$dbh->query("DELETE FROM carro WHERE id=?;",array($this->id));
		$dbh->query("DELETE FROM producto_carro WHERE idCarro=?;",array($this->id));
		unset($_COOKIE[COOKIE_ID]);
		setcookie(COOKIE_ID,$this->id,1,'/'); // PARA BORRAR LA COOKIE LE DECIMOS QUE DURA HASTA 01-01-1970 00:00:01
	}
	
	function setData($values){
		if( !is_array($values) ){
			Throw new Exception("Debe indicar los elementos del carro en un arreglo para usar el metodo 'CartControl::setData(array)'");
			exit;
		}
		$this->data = $values;
	}
	function getData(){
		global $dbh;
		$retval = array();
		if( $data = $dbh->query("SELECT * FROM carro WHERE id=?;",array($this->id)) ){
			$data = $data[0];
			$this->data = $data;
			
			$this->data['productos'] = array();
			if( $rows = $dbh->query("SELECT * FROM producto_carro WHERE idCarro=? order by idProducto;",array($this->id)) ){
				foreach( $rows as $row ){
					$this->setProduct($row['idProducto'],$row['cantidad']);
				}
			}
			$this->getTotal();
			return $this->data;
		} else {
			$this->destroy();
		}
	}
	/*  setProduct
	*	define la cantidad de un producto en el carro
	*	@return Boolean agregado con exito
	*	=============================================
	*	@param Integer $id = id del producto
	*	@param Integer $quantity = cantidad a agregar
	* */
	function setProduct($id,$quantity){
		global $dbh;
		if( $quantity>0 ){
			$obj = new ProductoControl($id);
			if( $obj->checkStock($quantity) ){
				// precio empleado
				if( isset($_SESSION['empleado']) && isset($_SESSION['descuento']) && $_SESSION['descuento'] ){
					$dbh->query("DELETE FROM producto_carro WHERE idProducto=? AND idCarro=?;",array($id,$this->id));
					$descuento = 0;
					$cur = $dbh->query("select p.nombre,p.precio-pc.precio as descuento from producto p left join precio_cliente pc on p.id=pc.idProducto where p.id=?;",array($id));
					if( isset($cur[0]) ){
						$descuento = $cur[0]['descuento'];
					}
					$cur = $dbh->query("INSERT INTO producto_carro(idProducto,idCarro,cantidad,descuento) VALUES(?,?,?,?);",array($id,$this->id,$quantity,$descuento));
					$this->data['productos'][$id] = $quantity;
					$totalItems = 0;
					foreach( $this->data['productos'] as $prd=>$cant ){
						$totalItems += (int)$cant;
					}
					$_SESSION['descuento'] = $totalItems<=18;
				} else {
					// original
					$dbh->query("DELETE FROM producto_carro WHERE idProducto=? AND idCarro=?;",array($id,$this->id));
					$dbh->query("INSERT INTO producto_carro(idProducto,idCarro,cantidad) VALUES(?,?,?);",array($id,$this->id,$quantity));
					$this->data['productos'][$id] = $quantity;
				}
				return true;
			}
			return false;
		} else {
			$this->unsetProduct($id);
			return true; // no es accion negativa
		}
	}
	/*  addProduct
	*	aumenta la cantidad de un producto en el carro
	*	@return Boolean agregado con exito
	*	=============================================
	*	@param Integer $id = id del producto
	*	@param Integer $quantity = cantidad a agregar. Si es nulo, aumenta en 1
	* */
	function addProduct($id,$quantity=null){
		if( $quantity==null ){
			$quantity=1;
		}
		if( isset($this->data['productos'][$id]) ){
			return $this->setProduct($id,(int)$this->data['productos'][$id]+(int)$quantity);
		} else {
			return $this->setProduct($id,(int)$quantity);
		}
	}
	/*  delProduct
	*	disminuye la cantidad de un producto en el carro en 1 (uno)
	*	@return Boolean disminuido con exito
	*	=============================================
	*	@param Integer $id = id del producto
	* */
	function delProduct($id){
		if( isset($this->data['productos'][$id]) ){
			return $this->setProduct($id,(int)$this->data['productos'][$id]-1);
		}
		if( (int)$this->data['productos'][$id]===0 ){
			$this->unsetProduct($id);
			return true;
		}
	}
	/*  unsetProduct
	*	elimina un producto en el carro en su totalidad
	*	@return Boolean eliminado con exito
	*	=============================================
	*	@param Integer $id = id del producto
	* */
	function unsetProduct($id){
		global $dbh;
		$dbh->query("DELETE FROM producto_carro WHERE idProducto=? AND idCarro=?;",array($id,$this->id));
		unset($this->data['productos'][$id]);
	}
	function getProducts(){
		$retval = array();
		if( (isset($this->data['productos'])) && (!empty($this->data['productos'])) ){
			foreach( $this->data['productos'] as $id=>$cantidad ){
				$obj = new ProductoControl($id);
				$obj->setQuantity($cantidad);
				$retval[] = $obj;
			}
		}
		return $retval;
	}
	function getTotal(){
		global $dbh;
		$total = 0;
		$items = 0;
		foreach( $this->getProducts() as $PrdObj){
			$total += $PrdObj->getTotalPrice();
			$items += $PrdObj->getTotalItems();
		}
		$this->data['total'] = $this->data['totalBruto'] = $total;
		$this->data['totalItems'] = $items;
		if( count($items)>1 ){
			$this->data['items'] = "1 artículo";
		} else {
			$this->data['items'] = $items." artículos";
		}
		$this->data['total'] -= $this->getDiscounts();
	}
	public function getSmallView(){
		return $this->getView("carro-small.html");
	}
	public function getView($template=null){
		if( $template==null ){
			$template = "carro.html";
		}
		$View = new View();
        $View->setFolder(PATH."/templates");
		//$View->set("URL",url);
		
		$this->getTotal();
        
        $descuentos = 0;
        if( isset($this->data['cupones']) ){
            foreach( $this->data['cupones'] as $cupon ){
                $descuentos += $cupon['total'];
            }
        }
        $this->data['descuentos'] = $descuentos;
		foreach( $this->data as $k=>$v ){
			$View->set($k,$v);
		}
		$View->set("productos",$this->getProducts());

		$View->setTemplate($template);
		return $View->getView();
	}
	public function getTotalItems(){
		if( !isset($this->data['totalItems']) ){
			$this->getTotal();
		}
		return $this->data['totalItems'];
	}
	public function isEmpty(){
		return empty($this->data['productos']);
	}
	private function getDiscounts(){
		global $dbh;
		$descuentoTotal = 0; // @return
		$natural = false;
		$cupon = false;
		$giftcard = false;
		$empleado = false;

		// Los descuentos visuales son para mostrar la referencia de descuento. Solo en los casos de naturales y empleado son distintos a los practicos
		/*	Son tantos casos distintos que dependen entre si que creamos una matriz.
		*	Primero grabamos los descuentos, y luego verificamos cada situacion para definir los descuentos correctos.
		* */
		$descuentos = array(
			"visual" => array(
				"naturales" => array(),
				"cupones" => array(),
				"giftcards" => array(),
				"empleado" => array()
			),
			"practico" => array(
				"naturales" => array(),
				"cupones" => array(),
				"giftcards" => array(),
				"empleado" => array()
			)
		);
		$productoCarro = array();
		$cupones = array();
		$productos = array();
		if( isset($this->data['productos']) ){
			$productos = $this->data['productos'];
		}
		// instanceamos los productos y grabamos los objetos en un array para evitar instancear de nuevo.
		$cantidadEmpleado = 0;
		foreach( $productos as $id=>$cant ){
			$obj = new ProductoControl($id);
			$obj->setQuantity($cant);
			$productos[$id] = $obj;
			$oData = $obj->getData();

			// NATURALES
			$desc = ($oData['precioReferencia']-$oData['precio'])*$cant;
			if( $desc>0 ){
				// hay naturales
				$natural = true;
			}
			$descuentos['visual']['naturales'][$id] = $desc;
			$descuentos['practico']['naturales'][$id] = $desc;
			if( isset($_SESSION['empleado']) && isset($_SESSION['descuento']) && $_SESSION['descuento'] ){
				// es empleado
				$empleado = true;
				$q = (int)$obj->getTotalItems();
				// para hacer el descuento, primero tenemos que saber si la cantidad d productos es 18 o mas.
				// si son mas de 18, debemos considerar la diferencia entre el total de productos y la
				// cantidad actual para hacer descuento a 18 productos.
				if( $q>18 ){
					$q = 18-(int)$cantidadEmpleado;
					if( $q<0 ){
						$q = 0;
					}
				}
				if( $cantidadEmpleado<18 ){
					$desc = ($obj->getPrice()-$obj->getPrice("Empleado"))*$q; // necesitamos el monto descontado, no es valor de venta.
					$descuentos['visual']['empleado'][$id] = $desc;
					$descuentos['practico']['empleado'][$id] = $desc;
				}
				$cantidadEmpleado += $q;
			}
		}
		// CUPONES Y GIFTCARDS
		if( isset($_SESSION['cupones']) ){
			$now = date("Y-m-d H:i:s");
			foreach( $_SESSION['cupones'] as $key=>$value){
				// hay que validar que el cupon siga activo, si no, no se debe reconocer ese descuento.
				$cur = $dbh->query("SELECT * FROM cupon WHERE id=? AND '$now'<fechaFin and activo=1;",array($key));
				if( isset($cur[0]) && is_array($cur[0]) ){
					$curCupon = $cur[0];
					if( isset($curCupon['giftcard']) ){
						// GIFTCARDS
						$sc = $dbh->query("Select * from giftcard where id=?;",array($curCupon['giftcard']));
						if( isset($sc[0]) ){
							// hay giftcard
							$giftcard = true;
							$desc = $sc[0]['monto'];
							$descuentos['visual']['giftcards'][] = $desc;
							$descuentos['practico']['giftcards'][] = $desc;
							$curCupon['total'] = $desc;
							$curCupon['titulo'] = "Gifcard c&oacute;digo ".$curCupon['titulo'];
						}
					} else {
						// CUPONES
						$sc = $dbh->query("Select * from cupon_producto where idCupon=? and idProducto in (".join(',',array_keys($productos)).");",array($curCupon['id']));
						if( isset($sc[0]) ){
							// hay cupon
							$cupon = true;
							foreach( $sc as $prodCup ){
								$obj = $productos[$prodCup['idProducto']];
								$oData = $obj->getData();
								$desc = ($oData['precio']*($prodCup['descuento']/100))*$obj->getTotalItems();
								$descuentos['visual']['cupones'][$prodCup['idProducto']] = $desc;
								$descuentos['practico']['cupones'][$prodCup['idProducto']] = $desc;
								$curCupon['total'] = $desc;
							}
						}
					}
					$cupones[$curCupon['id']] = $curCupon;
				}
			}
		}
		$this->data["cupones"] = $cupones;
		// hay que navegar por todos los descuentos, exluir los q se excluye entre si, y dejar los mejores descuentos para el cliente.
		foreach( $descuentos as $tipo=>$detalles ){
			if( $cupon ){
				if( $tipo=='practico' ){
					foreach( $detalles['cupones'] as $idPrd=>$dcto ){
						if( $empleado ){
							if( $dcto>$descuentos['practico']['empleado'][$idPrd] && $dcto>$descuentos['practico']['naturales'][$idPrd] ){
								$descuentoTotal+=(float)$dcto;
								unset($descuentos['practico']['empleado'][$idPrd]);
								unset($detalles['empleado'][$idPrd]);
								unset($descuentos['practico']['naturales'][$idPrd]);
								unset($detalles['naturales'][$idPrd]);
							}
						} else {
							if( $dcto>$descuentos['practico']['naturales'][$idPrd] ){
								$descuentoTotal+=(float)$dcto;
								unset($descuentos['practico']['naturales'][$idPrd]);
								unset($detalles['naturales'][$idPrd]);
							}
						}
					}
				}
				if( $tipo=='visual' ){
					foreach( $detalles['cupones'] as $idPrd=>$dcto ){
						//TODO:
					}
				}
			}
			if( $empleado ){
				if( $tipo=='practico' ){
					$this->data['descuentoEmpleado'] = 0;
					foreach( $detalles['empleado'] as $prdId=>$dcto){
						if( $dcto>$descuentos['practico']['naturales'][$prdId] ){
							$descuentoTotal+=(float)$dcto;
							// del arreglo general y de la copia local del loop
							unset($descuentos['practico']['naturales'][$prdId]);
							unset($detalles['naturales'][$prdId]);
							$this->data['descuentoEmpleado'] += (float)$dcto;
						}
					}
				}
				if( $tipo=='visual' ){
					foreach( $detalles['empleado'] as $prdId=>$dcto){
						//TODO:
					}
				}
			}
			if( $giftcard ){
				if( $tipo=='practico' ){
					foreach( $detalles['giftcards'] as $idGC=>$dcto ){
						$descuentoTotal+=(float)$dcto;
					}
				}
				if( $tipo=='visual' ){
					foreach( $detalles['giftcards'] as $idGC=>$dcto ){
						//TODO:
					}
				}
			}
			if( $tipo=='practico' ){
				$descuentos = 0;
				foreach( $detalles['naturales'] as $idPrd=>$dcto ){
					$descuentoTotal+=(float)$dcto;
					$descuentos += (float)$dcto;
				}
				if( $descuentos>0 ){
					$this->data['descuentos'] = $descuentos;
				}
			}
		}
		return $descuentoTotal;

		// ANTIGUA IMPLEMENTACION; NO BORRAR SE ESTA PROBANDO NUEVAS OPCIONES QUE FUNCIONEN MEJOR.
		/*
		// precio empleado
		$empleado = false;
		$descuento = 0;
		$descuentosEmpleado = array();
		$cupones = array();
		if( isset($_SESSION['empleado']) ){
			$empleado = true;
			$cur = $dbh->query("select * from producto_carro where idCarro=?;",array($this->id));
			if( isset($cur[0]) ){
				$cant = 0;
				foreach( $cur as $prd ){
					$q = (int)$prd['cantidad'];
					if( $q>18 ){
						$q = 18-(int)$cant;
						if( $q<0 ){
							$q = 0;
						}
					}
					if( $cant<18 ){
						$d = $prd['descuento']*$q;
						$descuento += $d;
						$descuentosEmpleado[$prd['idProducto']] = array("descuento" => $d, "cantidad" => $q);
					}
					$cant += $q;
				}
			}
		}
		// aplicar cupones
		if( isset($_SESSION['cupones']) ){
			$now = date("Y-m-d H:i:s");
			foreach( $_SESSION['cupones'] as $key=>$value){
				$cur = $dbh->query("SELECT * FROM cupon WHERE id=? AND '$now'<fechaFin and activo=1;",array($key));
				if( isset($cur[0]) && is_array($cur[0]) ){
					$cupon = $cur[0];
					if( !empty($cupon['giftcard']) ){
						$cur = $dbh->query("Select * from giftcard where id=?;",array($cupon['giftcard']));
						if( isset($cur[0]) ){
							$gc = $cur[0];
							// $cupon['total'] = $descuento = (int)$gc['monto'];
							$cupon['total'] = (int)$gc['monto'];
							$descuento .= $cupon['total'];
							echo $descuento;
						}
					} else {
						$idCupon = $cur[0]['id'];
						$scur = $dbh->query("SELECT * FROM cupon_producto WHERE idCupon=?;",array($idCupon));
						$tmp = array();
						if( !isset($scur[0]) || !is_array($scur[0]) ){
							continue;
						}
						foreach( $scur as $prdDesc ){
							$tmp[$prdDesc['idProducto']] = $prdDesc['descuento'];
						}
						foreach( $this->getProducts() as $k=>$v ){
							$dcto = @$tmp[$v->getData()['id']];
							$dcto = (int)$dcto;
							if( $empleado ){
								// DESCUENTO A PARTIR DEL PRECIO DE EMPLEADO
								$pd = $v->getData();
								$totalDcto = ($dcto/100)*$pd['precioReferencia']*$v->getTotalItems();
								if( $totalDcto<$descuentosEmpleado[$pd['id']]['descuento'] ){
									$totalDcto = $descuentosEmpleado[$pd['id']]['descuento'];
								} else {
									$descuento -= $descuentosEmpleado[$pd['id']]['descuento'];// $totalDcto;
								}
							} else {
								// DESCUENTO A PARTIR DEL PRECIO DE REFERENCIA
								$totalDcto = ($dcto/100)*$v->getData()['precioReferencia']*$v->getTotalItems();
							}
							// DEJAR EL MEJOR PRECIO PARA EL CLIENTE
							$precRef = $v->getData()['precioReferencia']*$v->getTotalItems();
							if( ($precRef-$totalDcto)<$v->getTotalPrice() ){
								$descuento += $totalDcto;
								$cupon['total'] = $totalDcto;
							}
						}
					}
					//print $descuento;exit;
					$cupones[] = $cupon;
				}
			}
			// exit;
			$this->data["cupones"] = $cupones;
		}
		$this->data['descuento'] = $descuento;
		$this->data['total'] = $this->data['total']-$descuento;
		if( $this->data['total']<0 ){
			$this->data['total'] = 0;
			$this->data['warning'] = "Tiene excedente de descuento. Si no lo usa, ese monto se perder&aacute;. <a href='".url."' class='btn btn-simple'>Seguir Comprando</a>";
		}
		//*/
	}
}
?>
