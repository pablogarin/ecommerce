<?php
include_once("Categoria.class.php");
include_once("MarcaControl.class.php");
include_once("includes/functions.php");
class ProductoControl{
	private $id, $data, $quantity;
		
	function __construct($id){
		if( $id==null || empty($id) ){
			Throw new Exception("Debe indicar una id real para el producto.");
			exit;
		}
		$this->setId($id);
        if( !$this->getData() ){
            throw new Exception("No se encontro el producto.");
        }
	}
	public function getData(){
		global $dbh;
		$this->data = array();
        $data = $dbh->query("SELECT * FROM producto WHERE id=?;",array($this->id));
		if( isset($data[0]) ){
			$data = $data[0];
			$this->data = $data;
			/* CATEGORIAS */
			if( $category = $dbh->query("SELECT * FROM producto_categoria WHERE idProducto=?;",array($this->id)) ){
				$tmp = $category[0];
				$category = new CategoriaControl($tmp['idCategoria']);
				$data['categoria'] = $category;
				$this->data = $data;
			}

			/* TIPO */
			$type = $data['tipo'];
			if( $tmp = $dbh->query("SELECT * FROM tipo WHERE id=?;",array($type)) ){
				$type = $tmp[0];
				$data['tipo'] = $type;
				$this->data = $data;
			}
			
			/* MARCA */
			$brand = $data['marca'];
            if( (int)$brand>0 ){
                $brand = new MarcaControl($brand);
                $data['marca'] = $brand->getData();
            }
			$this->data = $data;
			
			/* FOTO */
            /*
			$resource = $data['foto'];
			if( $tmp = $dbh->query("SELECT * FROM recurso WHERE id=?;",array($resource)) ){
				$resource = $tmp[0];
				$data['foto'] = $resource;
				$this->data = $data;
            }
             */

			/* CHECK DE STOCK */
			$stock = (int)$data['stock'];
			if( $stock<=0 ){
				$data['agotado'] = true;
			} else {
				$data['agotado'] = false;
			}
			$this->data = $data;
			
			/* URL */
			$PATH = $data['nombre'];
			$PATH = url_slug($PATH);
            $data['url'] = "/".$this->id."/$PATH";
			$data['PATH'] = PATH."$PATH/";
			$this->data = $data;
			
			/* BREADCRUMB */
            /*
			$breadcrumb = array();
			//$breadcrumb[] = array("PATH"=>PATH,"name"=>"Home");
			if( gettype($category)!=='array' ){
				//$breadcrumb[] = array("PATH"=>$category->getData()['padre']['PATH'],"name"=>$category->getData()['padre']['nombre']);
				$breadcrumb[] = array("PATH"=>$category->getData()['url'],"name"=>$category->getData()['nombre']);
			}
			$breadcrumb[] = array("PATH"=>"#","name"=>$data['nombre'],"active"=>true);
			$data['breadcrumb'] = $breadcrumb;
			$this->data = $data;
             */
			/* FINALMENTE LO GRABAMOS COMO PROPIEDAD DEL OBJETO */
			$this->data = $data;
			return $this->data;
        } else {
            return false;
        }
	}
	public function setId($id){
		if( !is_numeric($id) ){
			Throw new Exception("La id del producto debe ser numero.");
			exit;
		}
		$this->id = $id;
	}
	public function getTileView(){
		return $this->getView("producto-tile.html");
	}
	public function getListView(){
		return $this->getView("producto-list.html");
	}
	public function getView($template=null){

		if( $template==null ){
			$template = "producto.html";
		}
		$View = new View();
		$View->set("URL",PATH);

        global $configs;
        $View->set("configs",$configs);

		$this->getTotalPrice();
		foreach( $this->data as $k=>$v ){
			$View->set($k,$v);
		}
		
		$View->set("hasDiscount",$this->hasDiscount());
		if( $this->hasDiscount() ){
			$offer = array();
			$offer['before'] = $this->data['precioReferencia'];
			$offer['value'] = $this->getDiscount();
			$View->set("offer",$offer);
		}
		
        $View->setFolder(PATH."/templates");
		$View->setTemplate($template);
		return $View->getView();
	}
    public function getCrumbs(){
        $crumbs = array();

        $cat = $this->data['categoria'];
        $cat = $cat->getData();
        $crumbs[] = array(
            "link" => "/".$cat['url'],
            "value" => $cat['nombre']
        );
        $crumbs[] = array(
            "link" => false,
            "value" => $this->data['nombre']
        );
        return $crumbs;
    }
	public function filter($filters){
		global $dbh;
		$retval = true;
		if( !is_array($filters) ){
			Throw new Exception("El metodo 'filter' acepta un arreglo multidimensional de parametro.");
			exit;
		}
		if( !empty($filters['viniards']) ){
			$retval &= in_array($this->data['idViniard'],$filters['viniards']);
		}
		if( !empty($filters['filtros']) ){
			if( isset($this->inclusiveFilter) && $this->inclusiveFilter ){
				$isOK = true;
				foreach( $filters['filtros'] as $k=>$v ){
					$rows = $dbh->query("SELECT * FROM atributo_producto WHERE idProducto=? AND idAtributo=?;",array($this->id,$v));
					if( empty($rows[0]) ){
						$isOK &= false;
					}
				}
			} else {
				/*
				
				OBSERVACION: 
				
				NO TODOS LOS FILTROS SON IGUALES, Y NO TODOS SON EXCLUYENTES ENTRE SI.
				POR EJEMPLO, SI TENGO UN VINO, Y QUIERO FILTRAR LOS VINOS RESERVA Y LOS
				CABERNET SAUVIGNON O MERLOT, ME DEBE MOSTRAR LOS VINOS QUE CUMPLAN CON
				QUE SEAN RESERVA SI O SI, Y QUE SEAN O MERLOT O CABERNET SAUVIGNON.

				FIXME:	REVISITAR CODIGO => ESTOY SEGURO QUE SE PUEDE HACER MEJOR CON 
						MENOS LINEAS.
				
				*/
				$tmp = array();
				/* ordenamos los filtros por tipo para exluir entre filtros del mismo grupo */
				foreach( $filters['filtros'] as $k=>$v ){
					$cur = $dbh->query("SELECT * FROM atributo WHERE id=?;",array($v));
					if( !empty($cur[0]) && is_array($cur[0]) ){
						if( !isset($tmp[$cur[0]['tipo']]) ){
							$tmp[$cur[0]['tipo']] = array();
						}
						$tmp[$cur[0]['tipo']][] = $v; // grabamos la id del filtro en el grupo de tipo al que pertenece
					}
				}
				$allOK = true; // variable temporal 2, graba resultado del cruce de filtros.
				foreach( $tmp as $k=>$v ){
					$isOK = false;
					$rows = $dbh->query("SELECT * FROM atributo_producto WHERE idProducto=?;",array($this->id));
					foreach( $rows as $row ){
						// si el atributo del producto esta en la lista de filtros solicitados, le pasamos true y pasamos
						// al siguiente item del primer ciclo (continue).
						if( in_array($row['idAtributo'],$v) ){
							$isOK = true;
							continue;
						}
					}
					$allOK &= $isOK; // termino el segundo ciclo, acumulamos el resultado de filtros.
				}
				//	termino el primer ciclo, grabamos el resultado final en isOK ya
				//	que es la variable que se devuelve 
				$isOK = $allOK; 
			}
			$retval &= $isOK; // acumulamos los filtros para devlder verdadero solo a los productos que cumplan todos.
		}
		return $retval;
	}
	public function getRelated(){
		global $dbh;
		$retval = array();
		$tags = $this->data['tags'];
		$tags = explode(",",$tags);
		$cond = array();
		$order = array();
		$values = array();
		foreach( $tags as $k=>$v ){
			$v = trim($v);
			$v = array("$v","$v,%","%,$v,%","%,$v");
			$search = "tags like ? or tags like ? or tags like ? or tags like ?";
			$cond[] = $search;
			$order[] = "CASE WHEN $search THEN 0 ELSE 1 END";
			$values = array_merge($values,$v);
		}
		$query = "SELECT id FROM producto WHERE id!=?";
		$query.=" AND (".implode(" OR ",$cond).") ORDER BY ".implode(",",$order).";";
		$copy = $values;
		$values = array_merge($values,$copy);
		$values = array_merge(array($this->id),$values);
		$rows = $dbh->query($query,$values);
		foreach( $rows as $k=>$v ){
			$retval[] = new ProductoControl($v['id']);
		}
		/* RELACIONADOS */
		$this->data['productosRelacionados'] = $retval;
	
		return $retval;
	}
	public function detalle(){
		return $this->getView("producto-detail.html");
	}
	public function row(){
		return $this->getView("producto-row.html");
	}
	public function setQuantity($q){
		if( !is_numeric($q) ){
			Throw new Exception("La cantidad debe ser un numero.");
			exit;
		}
		$this->data['quantity'] = $q;
		$this->quantity = $q;
	}
	public function getTotalPrice(){
		$total = $this->quantity*$this->getPrice();
		$this->data['total'] = $total;
		return $total;
	}
	public function getTotalItems(){
		return $this->quantity;
	}
	public function getTitle(){
		return $this->data['nombre'];
	}
	public function getDiscount(){
		//TODO: obtener los descuentos o promociones del producto
		//return floor((((float)$this->data['precioReferencia']*100.0)/(float)$this->data['precio'])-100)."% dcto.";
        if( (int)$this->data['precioReferencia']>0 ){
            return 100-floor(((float)$this->getPrice()*100.0)/((float)$this->data['precioReferencia']))."%";
        } else {
            return 0;
        }
	}
	public function hasDiscount(){
		if( $this->getPrice()<$this->data['precioReferencia'] ){
			return true;
		}
		return false;
	}
	public function checkStock($quantity){
		$stock = (int)$this->data['stock'];
		return $stock>=$quantity;
	}
	public function dropStock($quantity){
		global $dbh;
		$stock = ((int)$this->data['stock'])-((int)$quantity);
		$res = $dbh->query("UPDATE producto SET stock=? WHERE id=?;",array($stock,$this->id));
		if( !empty($dbh->errorInfo()[2]) ){
			return false;
		}
		return true;
	}
	public function getName(){
		return $this->data['nombre'];
	}
	/*
	*	Trae el precio por tipo de cliente.
	*	Si no se pasa un valor, trae el precio de cliente por defecto.
	*	==============================================================
	*	@param String tipo = Tipo de cliente (Normal o Empleado).
	*	
	* */
	public function getPrice($tipo = "Normal"){
		global $dbh, $cli, $cart;
		$cur = $dbh->query("SELECT * FROM oferta WHERE idProducto=?;",array($this->id));
		if( isset($cur[0]) && is_array($cur[0]) ){
			$this->data['oferta'] = true;
			$this->data['precio'] = $cur[0]['precio'];
		}
		if( $tipo!='Normal' ){
			/*	MAPA
			*	CREATE TABLE precio_cliente(
			*		id integer primary key autoincrement not null,
			*		idProducto integer references producto(id),
			*		precio float not null,
			*		tipoCliente varchar(128) not null
			*	);
			* */
			$cur = $dbh->query("Select * from precio_cliente where idProducto=? and tipoCliente=?;",array($this->id, $tipo));
			if( isset($cur[0]) ){
				return $cur[0]['precio'];
			}
		}
		return $this->data['precio'];
	}
	public function getMobileDetailView(){
		return $this->getView("producto-mobileDetalle.html");
	}
}
?>
