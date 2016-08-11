<?php namespace Modelos;
class Producto extends Model{
	public $insert = "INSERT INTO producto VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
	public $update = "UPDATE producto SET nombre=?,tipo=?,resumen=?,descripcion=?,SKU=?,color=?,tags=?,stock=?,marca=?,foto=?,archivo=?,precio=?,precioReferencia=?,iva=?,activo=?,disponible=?,pack=?,modificado=?,orden=?,minimo=?,entrega=? WHERE id=?;";
	public $delete = "DELETE FROM producto WHERE id=?;";
	public $create = "CREATE TABLE producto(
		id integer primary key autoincrement not null,
		nombre varchar(120) not null,
		tipo integer references tipo(id),
        resumen varchar(128) not null,
		descripcion text,
		SKU varchar(120) UNIQUE not null,
        color text,
		tags text,
		stock integer default 0,
		marca integer  not null references marca(id),
		foto integer  not null references recurso(id),
		archivo integer not null references recurso(id),
		precio float default 0,
		precioReferencia float default 0,
		iva integer default 1, /* INCLUYE IVA: 1 si, 0 no */
		activo integer default 1, /* 1 si, 0 no */
		disponible integer default 1, /* 1 si, 0 no */
		pack integer default 0, /* 1 si, 0 no */
		modificado datetime default CURRENT_TIMESTAMP,
        orden float default 0.0,
        minimo int default 1,
        entrega text
	);";
	function __construct($dbh,$values=null){
		parent::__construct($dbh,"producto");
		if( $values!=null && gettype($values)=='array' ){
			foreach( $values as $k=>$v ){
				if( in_array($k,array_keys($this->validFields),false) ){ // validamos que sea un campo de la tabla
					$this->data[$k] = $v;
				}
			}
		}
	}
	function setValidFields(){
        global $dbh;
		$this->validFields = array(
			"id" => array(
				"nombre"=>"id",
				"null" => true,
			),			
			"nombre" => array(
				"nombre"=>"nombre",
                "label" =>"Nombre del Producto",
                "type" => "text",
				"null" => false,
			),		
			"tipo" => array(
				"nombre"=>"tipo",
                "label" =>"Tipo",
                "type" => "select",
                "data" => array(
                    "N" => "Normal",
                    "G" => "Giftcard"
                ),
				"null" => true,
			),		
			"resumen" => array(
				"nombre"=>"resumen",
                "label" =>"Resumen del Producto",
                "type" => "ckeditor",
				"null" => true,
			),	
			"descripcion" => array(
				"nombre"=>"descripcion",
                "label" =>"Descripci&oacute;n",
                "type" => "ckeditor",
				"null" => true,
			),	
			"SKU" => array(
				"nombre"=>"SKU",
                "label" =>"SKU",
                "type" => "text",
				"null" => false,
			),			
			"color" => array(
				"nombre"=>"color",
				"null" => true,
			),			
			"tags" => array(
				"nombre"=>"tags",
                "label" =>"Tags (Separador por coma)",
                "type" => "text",
				"null" => true,
			),		
			"stock" => array(
				"nombre"=>"stock",
                "label" =>"Stock",
                "type" => "text",
				"null" => true,
			),		
			"marca" => array(
				"nombre"=>"marca",
                "label" =>"Marca",
                "type" => "text",
				"null" => true,
			),		
			"foto" => array(
				"nombre"=>"foto",
                "label" =>"Foto",
                "type" => "thumb",
				"null" => true,
			),		
			"archivo" => array(
				"nombre"=>"archivo",
				"null" => true,
			),		
			"precio" => array(
				"nombre"=>"precio",
                "label" =>"Precio",
                "type" => "money",
				"null" => true,
			),		
			"precioReferencia" => array(
				"nombre"=> "precioReferencia",
                "label" => "Precio de Referencia",
                "type" => "text",
				"null" => true,
			),		
			"iva" => array(
				"nombre"=>"iva",
				"null" => true,
			),			
			"activo" => array(
				"nombre"=>"activo",
                "label" =>"¿Activo?",
                "type" => "boolean",
				"null" => true,
			),		
			"disponible" => array(
				"nombre"=>"disponible",
                "label" =>"Disponible para la Venta",
                "type" => "boolean",
				"null" => true,
			),	
			"pack" => array(
				"nombre"=>"pack",
				"null" => true,
			),		
			"modificado" => array(
				"nombre"=>"modificado",
				"null" => true,
			),		
			"orden" => array(
				"nombre"=>"orden",
                "label" =>"Orden",
                "type" => "text",
				"null" => true,
			),		
			"minimo" => array(
				"nombre"=>"minimo",
				"null" => true,
			),		
			"entrega" => array(
				"nombre"=>"entrega",
				"null" => true,
			)
		);
        $cur = $dbh->query("select * from categoria;");
        $cats = array();
        foreach( $cur as $row ){
            $cats[$row['id']] = $row['nombre'];
        }
        $this->foreignFields = array(
			"categoria" => array(
				"nombre"=>"categoria[]",
                "label" =>"Categor&iacute;as",
                "type" => "multiselect",
                "data" => $cats,
				"null" => true,
			),		
        );
	}
	// metodo personalizado para traer los datos.
	public static function getAll($catId=null,$order=false, $limit=false, $offset=false){
		global $dbh;
		if( $catId==null ){
            $query = "SELECT * FROM producto";
            if( $limit!==false && $offset!==false ){
                $query.=" LIMIT $offset,$limit";
            }
            $query.=";";
			$rows = $dbh->query($query);
			return $rows;
		} else {
			$query = "SELECT producto.* FROM producto_categoria left join producto on producto.id=producto_categoria.idProducto WHERE producto_categoria.idCategoria=? AND producto.id AND producto.activo=1 is not null";
			$data = array($catId);
			$query .= " GROUP BY producto.id";
			if( $order!==false ){
				$query.=" ORDER BY producto.$order";
			}
            if( $limit!==false && $offset!==false ){
                $query.=" LIMIT $offset,$limit";
            }
			$rows = $dbh->query($query,$data);
			foreach( $rows as $id=>$row ){
				// BUSCAMOS TODAS LAS CATEGORIAS A LAS QUE PERTENECE
				$row['foreign'] = array();
				$row['foreign']['categoria'] = array();
				$catQuery = $dbh->query("SELECT * FROM producto_categoria WHERE idProducto=?;",array($row['id']));
				if( is_array($catQuery) ){
					// el arreglo contenedor debe tener el mismo nombre del campo en el que se editara.
					foreach( $catQuery as $k=>$v ){
						$row['foreign']['categoria'][] = $v['idCategoria'];
					}
					$rows[$id] = $row;
				}
			}
			return $rows;
		}
	}
	// metodo personalizado para editar los datos
	public static function getData($id=null){
		global $dbh;
		if( $id==null ){
			return false;
		}

		$data = $dbh->query("SELECT * FROM producto WHERE id=?;",array($id));
		$data = $data[0];

		$data['foreign'] = array();
		$data['foreign']['categoria'] = array();
		$data['foreign']['filtro'] = array();
		$cats = $dbh->query("SELECT idCategoria FROM producto_categoria WHERE idProducto=?;",array($id));
		foreach( $cats as $cat ){
			$data['foreign']['categoria'][] = $cat['idCategoria'];
		}
		$filts = $dbh->query("SELECT idAtributo FROM atributo_producto WHERE idProducto=?;",array($id));
		foreach( $filts as $fil ){
			$data['foreign']['filtro'][] = $fil['idAtributo'];
		}

		return $data;
	}
	function setForeign($elements){
		global $dbh;
		if( isset($elements['categoria']) ){
			$dbh->query("DELETE FROM producto_categoria WHERE idProducto=?;",array($this->data['id']));
			foreach( $elements['categoria'] as $k=>$v ){
				if($v>0){
					$prodCat = new ProductoCategoria($dbh);
					$data = array(
						"idProducto"	=> $this->data['id'],
						"idCategoria"	=> $v,
					);
					$prodCat->insertValue($data);
				}
			}
		}
		if( isset($elements['filtro']) ){
			$dbh->query("DELETE FROM atributo_producto WHERE idProducto=?;",array($this->data['id']));
			foreach( $elements['filtro'] as $k=>$v ){
				if($v>0){
					$filtroProd = new FiltroProducto($dbh);
					$data = array(
						"idProducto"	=> $_POST['id'],//$this->data['id'],
						"idAtributo"	=> $v,
						"valor"			=> "Filtro de producto"
					);
					$filtroProd->insertValue($data);
				}
			}
		}
	}
}
