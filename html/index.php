<?php
include_once 'common.php';
include_once 'install.php';

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
    case '':
    case null:
    default:
        $view->set("title","Home");
        $cur = $dbh->query("select * from banner;");
        if( isset($cur[0]) ){
            $view->set("banners",$cur);
        }
        $template = "home.html";
        break;
}
if( isset($template) ){
    $view->setTemplate($template);
    $view->set("content",$view->getView());
}

$view->setTemplate("layout.html");
print $view->getView();
?>
