<?php
include_once 'common.php';
include_once 'install.php';
include_once "ClienteControl.class.php";

ini_set('display_errors',1);

$view = new View();
$view->setFolder(PATH."/templates/");

if( isset($_REQUEST['p']) ){
    $page = $_REQUEST['p'];
} else {
    $page = null;
}

$view->set("cantidad",0);

$cur = $dbh->query("SELECT * FROM config;");
$configs = array();
if( isset($cur[0]) ){
    foreach( $cur as $row ){
        $configs[$row['llave']] = $row;
    }
}
define("URL", $configs['urlSitio']['valor']);
$view->set("url",URL);
$view->set("configs",$configs);

$cur = $dbh->query("SELECT * FROM texto;");
$textos = array();
if( isset($cur[0]) ){
    foreach( $cur as $row ){
        if( (int)$row['id']==-1 ){
            $view->set("presentacion", $row['cuerpo']);
        }
        $textos[$row['llave']] = $row;
    }
}
$view->set("textos",$textos);
/* BREADCRUMBS */
$crumbs = array();
/* FIN BREADCRUMBS */

/* CATEGORIAS */
$cats = CategoriaControl::getAll("-1");
if( isset($cats[0]) ){
    $view->set("categories", $cats);
    foreach( $cats as $i=>$value ){
        if( $value['link']==$page ){
            $crumbs[] = array(
                "link" => false,
                "value" => $value['nombre']
            );
            $subPage = $page;
            $page = "tienda";
            $view->set("submenuCurrent", $subPage);
        }
    }
}
if( isset($subPage) ){
    $page = $subPage;
}
/* FIN CATEGORIAS */
$view->set("current",$page);

/* CARRO DE COMPRAS */
$cart = null;
if( isset($_COOKIE[COOKIE_ID]) ){
	$cart = $_COOKIE[COOKIE_ID];
}
$cart = new CartControl($cart);
$view->set("CART",$cart->getSmallView());
/* FIN CARRO DE COMPRAS */

$checkout = false;
$sesion_activa = isset($_SESSION['cliente']) || isset($_COOKIE[USER_COOKIE_ID]);

if( isset($_SESSION['orden']) ){
    $orden  = $_SESSION['orden'];
    $cur = $dbh->query("SELECT * FROM venta WHERE id=?;",array($orden));
    if( isset($cur[0]) ){
        if( (int)$cur[0]['idEstado'] === 4 ){
            unset($_SESSION['orden']);
        }
    } else {
        unset($_SESSION['orden']);
    }
}

switch( $page ){
    case 'contacto':
        $view->set("title","Contacto");
        $template = "contacto.html";
        $crumbs[] = array(
            "link" => false,
            "value" => "Contacto"
        );
        break;
    case 'quienes-somos':
        $view->set("title",$textos['quienesSomos']['titulo']);
        $view->set("texto", $textos['quienesSomos']['cuerpo']);
        $template = "texto.html";
        $crumbs[] = array(
            "link" => false,
            "value" => $textos['quienesSomos']['titulo']
        );
        break;
    case 'como-comprar':
        $view->set("title",$textos['comoComprar']['titulo']);
        $view->set("texto", $textos['comoComprar']['cuerpo']);
        $template = "texto.html";
        $crumbs[] = array(
            "link" => false,
            "value" => $textos['comoComprar']['titulo']
        );
        break;
    case 'blog':
        $crumbs[] = array(
            "link" => false,
            "value" => "Blog"
        );
        $view->set("title","Blog");
        $template = "blog.html";
        $cur = $dbh->query("select * from blog where activo=1 order by fecha desc, id desc;");
        $ultimos = array();
        foreach( $cur as $k=>$v ){
            $v['url'] = "/blog/".$v['id']."/".url_slug($v['titulo']);
            $v['cuerpo'] = substr(strip_tags($v['cuerpo'],'<p><br>') ,0, 200)."...";
            $cur[$k] = $v;
            if( count($ultimos)<4 ){
                if( strlen($v['titulo']) > 20 ){
                    $v['titulo'] = substr($v['titulo'],0 ,20)."&hellip;";
                }
                $ultimos[] = $v;
            }
        }
        $view->set("blogs", $cur);
        $view->set("ultimos", $ultimos);
        break;
    case 'carro':
        $content = $cart->getView();
        $view->set("content", $content);
        break;
    case 'tienda':
        $view->set("title","Bazar");
        $template = "tienda.html";
        break;
    case 'identificacion':
        if( $cart->isEmpty() ){
            header("Location: /carro");
            exit;
        }
        $checkout = true;
        $view->setTemplate("identificacion.html");
        $back = "/carro";
        $view->set("remember", $sesion_activa);
        if( isset($_POST['grabar']) ){
            $clienteArray = array();
            foreach( $_POST as $name=>$value ){
                $clienteArray[$name] = $value;
            }
            if( isset($clienteArray) ){
                $view->set("user", $clienteArray);
            }
            if( isset($clienteArray['remember']) && $clienteArray['remember']=='on' ){
                $view->set("remember", true);
            } else {
                $view->set("remember", false);
            }
            if( !isset($cliente) ){
                $cur = $dbh->query("SELECT * FROM cliente WHERE correo=?;", array($clienteArray['correo']) );
                if( isset($cur[0]) ){
                    $id = $cur[0]['id'];
                    $upd = array(
                        $clienteArray['nombre'],
                        $clienteArray['apellido'],
                        $clienteArray['fono'],
                        $id
                    );
                    $dbh->query("UPDATE cliente SET nombre=?,apellido=?,fono=? WHERE id=?;", $upd);
                    $cliente = new ClienteControl( $id );
                    if( isset($clienteArray['remember']) ){
                        setcookie(USER_COOKIE_ID,$id,time()+3600*24*360,"/");
                    } else {
                        $_SESSION['cliente'] = $id;
                    }
                } else {
                    // cliente nuevo
                    try {
                        $cliente = ClienteControl::createUser($_POST);
                    }catch(\Exception $ex){
                        $view->set("error", $ex->getMessage());
                    }
                }
            }
        }
        if( (!isset($cliente)) && $sesion_activa ){//(isset($_SESSION['cliente']) || isset($_COOKIE[USER_COOKIE_ID])) ){
            $user = isset($_SESSION['cliente']) ? $_SESSION['cliente'] : $_COOKIE[USER_COOKIE_ID];
            $cliente = new ClienteControl($user);
        }
        if( isset($cliente) ){
            $view->set("user", $cliente->getData());
            $next = "/facturacion";
        } else {
            $view->set("status_message","Debe ingresar sus datos para continuar con la compra.");
            $next = false;
        }
        $nextMessage = "Datos de Despacho";
        $view->set("content", $view->getView());
        break;
    case 'facturacion':
        if( !$sesion_activa ){
            header("Location: /identificacion");
            exit;
        }
        $cur = $dbh->query("SELECT * FROM zona WHERE padre=313;");
        $comunas = array();
        if( !empty($cur) && isset($cur[0]) ){
            $view->set("comunas", $cur);
            foreach( $cur as $row ){
                $comunas[$row['id']] = $row['nombre'];
            }
        }
        $cur = $dbh->query("SELECT * FROM tipo_pago WHERE estado=1;");
        if( !empty($cur) && isset($cur[0]) ){
            $view->set("modos_pago", $cur);
        }
        if( isset($_POST['grabar']) ){
            if( !empty($_POST['direccion']) && !empty($_POST['comuna']) && !empty($_POST['fono']) ){
                if( isset($_SESSION['cliente']) ){
                    $id = $_SESSION['cliente'];
                } else {
                    $id = $_COOKIE[USER_COOKIE_ID];
                }
                $cliente = $dbh->query("SELECT * FROM cliente WHERE id=?;",array($id));
                $cliente = $cliente[0];
                $direccion = array(
                    "nombre" => $_POST['direccion'].", ".$comunas[$_POST['comuna']],
                    "receptorNombre" => $cliente['nombre'],
                    "receptorApellido" => $cliente['apellido'],
                    "idCliente" => $cliente['id'],
                    "direccion" => $_POST["direccion"],
                    "fono"      => $_POST["fono"],
                    "comuna"    => $_POST["comuna"]
                );
                $view->set("direccion", $direccion);
                $ins = $dbh->query("INSERT INTO direccion(nombre, receptorNombre, receptorApellido, idCliente, direccion, fono, idZona) VALUES(?,?,?,?,?,?,?);", array_values($direccion));
                $_SESSION['direccion'] = $ins;
            } else {
                $view->set("direccion", $_POST);
                $view->set("error", "Si desea ingresar una direcci&oacute;n debe llenar todos los campos.");
            }
        }
        if( isset($_SESSION['direccion']) ){
            $id = $_SESSION['direccion'];
            $cur = $dbh->query("SELECT * FROM direccion d LEFT JOIN costo_despacho cd ON d.idZona=cd.idZona WHERE d.id=?;",array($id));
            $costo = $cur[0]['costo'];
            $cur[0]['comuna'] = $cur[0]["idZona"];
            $view->set("costoEnvio", $costo);
            $view->set("direccion", $cur[0]);
        }
        $confirmar = true;
        if( isset($_SESSION['modo-pago']) ){
            $view->set("modopago",$_SESSION['modo-pago']);
        }
        if( isset($_GET['confirmar-orden']) ){
            if( !isset($_SESSION['modo-pago']) ){
                $confirmar = false;
                $view->set("error","Debe seleccionar un modo de pago");
            } else {
                header("Location: ".URL."/confirmar-orden");
            }
        }
        $checkout = true;
        $view->setTemplate("despacho.html");
        $back = "/identificacion";
        $next = "/facturacion?confirmar-orden=1";
        $nextMessage = "Confirmar Orden";
        $view->set("content", $view->getView());
        break;
    case 'confirmar-orden':
        if( !$sesion_activa ){
            header("Location: /identificacion");
            exit;
        }
        if( $cart->isEmpty() ){
            header("Location: /carro");
            exit;
        }
        if( !isset($_SESSION['orden']) ){
            $sale = new OrdenCompra();
        } else {
            $ID = $_SESSION['orden'];
            $sale = new OrdenCompra($ID);
        }
        $sale->setFromCart($cart);
        if( isset($_SESSION['direccion']) ){
            $id = $_SESSION['direccion'];
            $cur = $dbh->query("SELECT * FROM direccion d LEFT JOIN costo_despacho cd ON d.idZona=cd.idZona WHERE d.id=?;",array($id));
            $costo = $cur[0]['costo'];
            $sale->set("idDireccion", $id);
            $sale->set("costoDespacho",(float)$costo);
            $sale->syncToDB();
            $view->set("direccion", $cur[0]);
        }
        $sale->set("idTipoPago",$_SESSION['modo-pago']);
        $sale->syncToDB();
        $checkout = true;
        $back = "/facturacion";
        $next = "finalizar";
        $nextMessage = "Finalizar Compra";
        $view->set("idOrden", $sale->getID());
        $view->set("content", $sale->getDetailView());
        break;
    case 'comprar':
        if( !$sesion_activa ){
            header("Location: /identificacion");
            exit;
        }
        if( isset($_POST['orden']) ){
            $ID = $_POST['orden'];
            $sale = new OrdenCompra($ID);
        } else {
            header("Location: /confirmar-orden");
            exit;
        }
        $resultado = true;
        if( (int)$sale->getEstado()!=4 ){
            $resultado = $sale->acceptOrder();
        }
        if($resultado){
            // La orden quedo aceptada
            if( isset($_SESSION["direccion"]) ){
                unset($_SESSION["direccion"]);
            }
            $view->set("content", $sale->getSuccessView());
            // el carro aun tiene los productos pq se creo antes del switch
            $cart = new CartControl();
            $view->set("CART",$cart->getSmallView());
        } else {
            $view->setTemplate("compra-fallida.html");
            $view->set("errorCompra", $sale->getError());
            $view->set("content", $view->getView());
        }
        break;
    case 'exito':
        if( !$sesion_activa ){
            header("Location: /identificacion");
            exit;
        }
        if( isset($_POST['TBK_ID_SESION']) ){
            $ID = $_POST['TBK_ID_SESION'];
            $sale = new OrdenCompra($ID);
        } else {
            header("Location: /confirmar-orden");
            exit;
        }
        $resultado = true;
        if( (int)$sale->getEstado()!=5 ){
            $resultado = $sale->acceptOrder(5);
        }
        if($resultado){
            // La orden quedo aceptada
            if( isset($_SESSION["direccion"]) ){
                unset($_SESSION["direccion"]);
            }
            $view->set("content", $sale->getSuccessView());
            // el carro aun tiene los productos pq se creo antes del switch
            $cart = new CartControl();
            $view->set("CART",$cart->getSmallView());
        } else {
            $view->setTemplate("compra-fallida.html");
            $view->set("errorCompra", $sale->getError());
            $view->set("content", $view->getView());
        }
        break;
    case 'fracaso':
        if( !$sesion_activa ){
            header("Location: /identificacion");
            exit;
        }
        if( isset($_POST['TBK_ID_SESION']) ){
            $ID = $_POST['TBK_ID_SESION'];
            $sale = new OrdenCompra($ID);
        } else {
            header("Location: /confirmar-orden");
            exit;
        }
        $view->setTemplate("compra-fallida.html");
        $view->set("errorCompra", $sale->getError());
        $view->set("content", $view->getView());
        break;
    case 'webpay':
      require_once 'webpay.php';
      exit("webpay");
      break;
    case '':
    case null:
        include_once "Banner.class.php";
        $view->set("title","Home");
        $dbObj = new \Modelos\Banner($dbh);
        $dbData = $dbObj->query->all();
        $banners = array();
        foreach( $dbData as $row ){
            try {
                $banner = new Banner($row['id']);
                $banners[$banner->getID()] = $banner;
            } catch( Exception $ex ){
                echo $ex->getMessage();
                exit;
            }
        }
        $view->set("banners",$banners);
        $cur = $dbh->query("SELECT * FROM blog WHERE fecha=(SELECT MAX(fecha) FROM blog);");
        if( isset($cur[0]) ){
            $cur[0]['url'] = "/blog/".$cur[0]['id']."/".url_slug($cur[0]['titulo']);
            $cur[0]['cuerpo'] = substr(strip_tags($cur[0]['cuerpo'],'<p><br>') ,0, 200)."...";
            $view->set("blog",$cur[0]);
        }
        $template = "home.html";
        break;
    default:
        $error = true;
        if( isset($subPage) ){
            $allCats = CategoriaControl::getAll();
            foreach( $allCats as $cat ){
                if( $cat['link']==$subPage ){
                    $error = false;
                    $id = $cat['id'];
                    break;
                }
            }
            $cat = new CategoriaControl($id);
            $cat->getProducts();
            $view->set("content", $cat->getView());
        } else {
            if( $page != "" ){
                $tmp = explode("/",$page);
                $id = $tmp[0];
                if( is_numeric($id) ){
                    try {
                        $prd = new ProductoControl($id);
                        $prdCrumbs = $prd->getCrumbs();
                        $crumbs = array_merge($crumbs, $prdCrumbs);
                        $view->set("content", $prd->getView());
                        $error = false;
                    } catch(Exception $ex){
                        $error = true;
                        $view->set("errorMessage",$ex->getMessage());
                    }
                } else {
                    switch( $tmp[0] ){
                        case 'blog':
                            $IDBlog = $tmp[1];
                            $cur = $dbh->query("select * from blog where id=?;", array($IDBlog));
                            if( isset( $cur[0] ) ){
                                $error = false;
                                foreach( $cur[0] as $name=>$value){
                                    $view->set($name, $value);
                                }
                                $crumbs[] = array(
                                    "link" => "/blog",
                                    "value" => "Blog"
                                );
                                $crumbs[] = array(
                                    "link" => false,
                                    "value" => $cur[0]['titulo']
                                );
                                $cur = $dbh->query("select * from blog where activo=1 order by fecha desc, id desc limit 4;");
                                $ultimos = array();
                                foreach( $cur as $k=>$v ){
                                    $v['url'] = "/blog/".$v['id']."/".url_slug($v['titulo']);
                                    if( strlen($v['titulo']) > 20 ){
                                        $v['titulo'] = substr($v['titulo'],0 ,20)."&hellip;";
                                    }
                                    $ultimos[] = $v;
                                }
                                $view->set("ultimos", $ultimos);
                                $template = "blog.html";
                            } else {
                                $error = true;
                            }
                            break;
                    }
                }
            }
        }
        if( $error ){
            $view->set("title","Error");
            $template = "error.html";
        }
        break;
}
if( isset($back) ){
    $view->set("back", $back);
    $view->set("next", $next);
    $view->set("nextMessage", $nextMessage);
}
$view->set("crumbs", $crumbs);
if( isset($template) ){
    $view->setTemplate($template);
    $view->set("content",$view->getView());
}
if( $checkout ){
    $view->setTemplate("checkout.html");
    $view->set("content", $view->getView());
}

$view->setTemplate("layout.html");
print $view->getView();
?>
