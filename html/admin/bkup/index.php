<?php
include_once 'common.php';
include_once 'session.php';
include_once 'model.php';

// seccion actual
$current = $_SERVER['SCRIPT_URL'];
$current = str_replace("/admin/","",$current);
$current = str_replace("/","",$current);

// secciones del menu
$navs = array(
    'home' => array(
        'url' => 'home',
        'name' => 'Home',
        'current' => $current=='home'
    ),
    'productos' => array(
        'url' => 'productos',
        'name' => 'Productos',
        'current' => $current=='productos'
    ),
    'servicios' => array(
        'url' => 'servicios',
        'name' => 'Servicios',
        'current' => $current=='servicios'
    ),
    'textos' => array(
        'url' => 'textos',
        'name' => 'Textos',
        'current' => $current=='textos'
    ),
    'configuraciones' => array(
        'url' => 'configuraciones',
        'name' => 'Configuraciones',
        'current' => $current=='configuraciones'
    )
);
$view->set("navs",$navs);

switch( $current ){
    case 'productos':
        break;
    case 'servicios':
        break;
    case 'textos':
        break;
    case 'configuraciones':
        include_once 'configs.php';
        break;
}
if( isset($content) ){
    $view->set("CONTENT",$content);
}
$view->setTemplate("index.html");
print $view->getView();
?>
