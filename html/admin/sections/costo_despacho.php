<?php

use Modelos\CostoDespacho as CostoDespacho;

$Model = new CostoDespacho($dbh);
$view->set("title", "Costos Despacho");
$orden = "";
if( isset($_REQUEST['orden']) ){
    $orden = $_REQUEST['orden'];
    $Model->order = preg_replace('/[^a-zA-Z0-9]/i','',$orden);
}
if( isset($_REQUEST['id']) ){
    $ID = $_REQUEST['id'];
    $modelData = ($dbh->query("SELECT * FROM costo_despacho WHERE id=?",array($ID))[0]);
}
$backURL = "/admin/costos-despacho";
$formTemplate = "form.html";
$listTemplate = "list.html";
$cols = array(
    "idZona",
    "costo"
);
$orderFields = array(
);
/*
$types = array(
    "activa" => "boolean"
);
//*/
$foreigns = array(
    "idZona" => "select nombre from zona where id=?;"
);
$view->set("cols", $cols);
