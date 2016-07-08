<?php
include_once 'common.php';
include_once 'install.php';

use Controllers\Bazar as Bazar;

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
$view->set("url",$configs['urlSitio']['valor']);
$view->set("configs",$configs);

$cur = $dbh->query("SELECT * FROM texto;");
$textos = array();
if( isset($cur[0]) ){
    foreach( $cur as $row ){
        $textos[$row['llave']] = $row;
    }
}
$view->set("textos",$textos);

$view->set("current",$page);

/* CARRO DE COMPRAS */
$cart = null;
if( isset($_COOKIE[COOKIE_ID]) ){
	$cart = $_COOKIE[COOKIE_ID];
}
$cart = new CartControl($cart);
$view->set("CART",$cart->getSmallView());
/* FIN CARRO DE COMPRAS */

switch( $page ){
    case 'contacto':
        $view->set("title","Contacto");
        $template = "contacto.html";
        break;
    case 'quienes-somos':
        $view->set("title",$textos['quienesSomos']['titulo']);
        $view->set("texto", $textos['quienesSomos']['cuerpo']);
        $template = "texto.html";
        break;
    case 'como-comprar':
        $view->set("title",$textos['comoComprar']['titulo']);
        $view->set("texto", $textos['comoComprar']['cuerpo']);
        $template = "texto.html";
        break;
    case 'bazar':
        $ctrl = new Bazar();
        $view->set("title","Bazar");
        $template = "bazar.html";
        break;
    case '':
    case null:
        $view->set("title","Home");
        $cur = $dbh->query("select * from banner;");
        if( isset($cur[0]) ){
            $view->set("banners",$cur);
        }
        $template = "home.html";
        break;
    default:
        $view->set("title","Error");
        $template = "error.html";
        break;
}
if( isset($template) ){
    $view->setTemplate($template);
    $view->set("content",$view->getView());
}

$view->setTemplate("layout.html");
print $view->getView();
?>
