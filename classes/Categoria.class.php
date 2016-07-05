<?php
/*
      ESTA CLASE ES CONTROLADORA
***************************************
**** NO CONFUNDIR CON CLASE MODELO ****
***************************************
*/
class CategoriaControl{
	private $id;
	private $data;
	private $products;
	private $minPrice, $maxPrice;
	
	function __construct($id){
		if( $this->setId($id) === false ){
			Throw new Exception('Debe indicar la id de la categoria.');
			exit;
		}
		$this->getData();
	}
	public function getId(){
		return $this->id;
	}
	public function setId($id){
		global $Sql;
		if( !is_numeric($id) ){
			return false;
		}
		$this->id = $id;
	}
	public function getData(){
		include_once 'inc/classes/SeoUrl.class.inc';
		global $Sql;
		if( $row = $Sql->q_read("SELECT * FROM categoria WHERE id=?;",array($this->id)) ){
			$this->data['subcategoria'] = true;
			foreach( $row[0] as $k=>$v ){
				if( ($k=='padre') && ($v=='-1') ){
					$this->data['subcategoria'] = false;
				}
				if( $k=='foto' ){
					$row = $Sql->q_read("SELECT * FROM recurso WHERE id=?;",array($v));
					$v = @$row[0]['url'];
				}
				$this->data[$k] = $v;
			}
			$this->data['url'] = url.SeoUrl::seo_friendly($this->data['nombre'])."/";
			$row = $Sql->q_read("SELECT * FROM categoria WHERE id=? and id>0;",array($this->data['padre']));
			if( isset($row[0]) ){
				$this->data['padre'] = $row[0];
				$this->data['padre']['url'] = url.SeoUrl::seo_friendly($this->data['padre']['nombre'])."/";
			}
			/* TRAER LAS SUBCATEGORIAS QUE LE PERTENECEN */
			if( !$this->data['subcategoria'] ){
				$group = $Sql->q_read("SELECT id FROM categoria WHERE padre=?;",array($this->id));
				$categorias = array();
				foreach( $group as $id ){
					$id = $id['id'];
					$SubCat = new CategoriaControl($id);
					$categorias[] = (array)$SubCat->data;
				}
				$this->data['subcategorias'] = $categorias;
			}
			
			/* FILTROS */
			$this->data['filtros'] = array();
			$filtros = $Sql->q_read("SELECT * FROM atributo WHERE idCategoria=? AND esFiltro=1;",array($this->id));
			if( $this->data['subcategoria'] ){
				$tmp = $Sql->q_read("SELECT * FROM atributo WHERE idCategoria=? AND esFiltro=1;",array($this->data['padre']['id']));
				if( $tmp!==false && is_array($tmp) ){
					$filtros = array_merge($filtros,$tmp);
				}
			} else {
			}
			if( $filtros ){
				foreach( $filtros as $k=>$v ){
					$this->data['filtros'][$v['tipo']][$v['id']] = $v;
				}
			}
		}
		return $this->data;
	}
	public function getProducts($limit = 8, $offset = 0){
		/* TRAER SUS PRODUCTOS */
		include_once("common.php");
		include_once("inc/model.php");
		include_once("ProductoControl.class.php");
		$this->data['productos'] = array();
		$order = false;
		$this->orderBy = "";
		if( isset($_REQUEST['orderBy']) && !empty($_REQUEST['orderBy']) ){
			$order = $_REQUEST['orderBy'];
			$this->orderBy = $order;
			switch($order){
				case 'idMarca':
					$order = "marca";
					break;
				case 'precio':
					$order = "precio";
					break;
			}
		}
		$prodList = Producto::getAll($this->id,$order);
		foreach( $prodList as $k=>$v ){
			$obj = new ProductoControl($v['id']);
			if( empty($this->min) ){
				$this->min = (int)$obj->getPrice();
			} else {
				$this->min > (int)$obj->getPrice() ? $this->min = (int)$obj->getPrice() : $this->min = $this->min;
			}
			if( empty($this->max) ){
				$this->max = (int)$obj->getPrice();
			} else {
				$this->max < (int)$obj->getPrice() ? $this->max = (int)$obj->getPrice() : $this->max = $this->max;
			}
			$this->data['productos'][$v['id']] = $obj;
		}
		
		/* FILTROS */
		/*
		$this->data['filters']['viniards'] = array();
		if( isset($_REQUEST['viniard']) ){
			foreach( $_REQUEST['viniard'] as $k=>$v ){
				$this->data['filters']['viniards'][] = $v;
			}
		}
		//*/
		$this->data['filters']['filtros'] = array();
		if( isset($_REQUEST['filtro']) ){
			foreach( $_REQUEST['filtro'] as $k=>$v ){
				$this->data['filters']['filtros'][] = $v;
			}
		}
		$this->data['priceRange'] = array(
			'min' => 0,
			'max' => 0
		);
		if( isset($_REQUEST['priceRange']) && !empty($_REQUEST['priceRange']) ){
			$priceRange = $_REQUEST['priceRange'];
			$this->data['priceRange'] = $priceRange;
		}
		
		/* APLICAR FILTROS A LOS PRODUCTOS */
		foreach( $this->data['productos'] as $id=>$obj ){
			if( !$obj->filter($this->data['filters']) ){
				unset($this->data['productos'][$id]);
			}
			if( isset($priceRange) ){
				if( ( (int)$priceRange['min']>(int)$obj->getPrice() ) || ( (int)$priceRange['max']<(int)$obj->getPrice() ) ){
					unset($this->data['productos'][$id]);
				}
			}
		}
	}
	public function getView(){
		global $Sql, $_REQUEST;
		$View = new View();
		
		// pasar datos a la vista
		if( !empty($this->min) ){
			$catPrice = array(); // rango de precios de la categoria
			/*
			if( $this->min+5000>=$this->max || $this->min==$this->max ){
				$this->min = 0;
			}
			//*/
			$catPrice['min'] = 0;//$this->min;
			$catPrice['max'] = ceil($this->max/100)*100; // es mas ordenado que termine en numero cerrado
			$View->set("catPrice",$catPrice);
			if( empty($this->data['priceRange']['max']) )
				$this->data['priceRange']['max'] = $catPrice['max'];
		}

		$priceRange = $this->data['priceRange']; 
		$View->set('priceRange',$priceRange);	

		$View->set("URL",url);
		
		// espcificar layout
		$cur = $Sql->q_read("SELECT * FROM categoria WHERE padre=?;",array($this->id));
		if( empty($cur) ){
			$this->data['subcategoria'] = true;
		}
		
		foreach( $this->data as $k=>$v ){
			$View->set($k,$v);
		}
		// PAGINATION
		$View->set('orderBy',$this->orderBy);
		$viewType = 'grid';
		if( isset($_REQUEST['view']) ){
			$viewType = $_REQUEST['view'];
		}
		$View->set('view',$viewType);
		
		$porpagina = 8; // elementos por pagina
		if( $viewType=='list' ){
			$porpagina = 4;
		}

		// agrupamos los productos en arreglos con largo igual a los elementos por pagina
		$productos = $this->data['productos'];
		$c = 0;
		$p = 1; // las paginas empiezan a contar desde la 1
		$tmp = array();
		foreach( $productos as $id=>$producto ){
			$c++;
			$tmp[$p][$id] = $producto;
			if( $c==$porpagina ){
				$p++;
				$c = 0;
			}
		}
		
		$page = 1;
		if( isset($_REQUEST['page']) ){
			$page = (int)$_REQUEST['page'];
		}
		$View->set('page',$page);
		if( !isset($tmp[$page]) ){
			$tmp[$page] = array();
		}
		$View->set("productos",$tmp[$page]);
		
		$total = ceil(count($productos)/$porpagina);
		$View->set('pages',$total);
		
		$View->setTemplate("categoria.html");
		return $View->getView();
	}
	public function getTitle(){
		return $this->data['nombre'];
	}
}
?>
