<?php
$Model = new Producto($dbh);
$view->set("title", "Productos");
if( isset($_REQUEST['id']) ){
    $ID = $_REQUEST['id'];
    $modelData = ($dbh->query("SELECT * FROM producto WHERE id=?",array($ID))[0]);
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
    "nombre",
    "precio"
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
