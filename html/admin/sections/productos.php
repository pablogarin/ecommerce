<?php

use Modelos\Producto as Producto;
if( isset($_REQUEST['foto']) ){
    $file = $_REQUEST['foto'];
    if( file_exists(PATH."/html/assets/tmp/$file") ){
        rename(PATH."/html/assets/tmp/$file", PATH."/html/assets/$file");
        $_POST['foto'] = $_REQUEST['foto'] = $_GET['foto'] = "/assets/$file";
    }
}

$Model = new Producto($dbh);
$view->set("title", "Productos");
$orden = "";
if( isset($_REQUEST['orden']) ){
    $orden = $_REQUEST['orden'];
    $Model->order = preg_replace('/[^a-zA-Z0-9]/i','',$orden);
}
if( isset($_REQUEST['id']) ){
    $ID = $_REQUEST['id'];
    $modelData = ($dbh->query("SELECT * FROM producto WHERE id=?",array($ID))[0]);
    $hiddens['foto'] = $modelData['foto'];
    $modelData['categoria'] = array();
    $cur = $dbh->query("SELECT categoria.id, categoria.nombre FROM producto_categoria LEFT JOIN categoria ON producto_categoria.idCategoria=categoria.id WHERE idProducto=?",array($ID));
    foreach( $cur as $row ){
        $modelData['categoria'][$row['id']] = $row['nombre'];
    }
}
$backURL = "/admin/productos";
$formTemplate = "form.html";
$listTemplate = "list.html";
$cols = array(
    "foto",
    "nombre",
    "SKU",
    "precio",
    "stock"
);
$orderFields = array(
    "foto",
    "nombre",
    "SKU",
    "categoria",
    "tipo",
    "descripcion",
    "precio",
    "precioReferencia"
);
/*
$types = array(
    "activa" => "boolean"
);
$foreigns = array(
    "padre" => "select nombre from categoria where id=?;"
);
//*/
$view->set("cols", $cols);
