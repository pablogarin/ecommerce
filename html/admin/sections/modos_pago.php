<?php

use Modelos\TipoPago as TipoPago;

$Model = new TipoPago($dbh);
$view->set("title", "Modos de Pago");
$orden = "";
if( isset($_REQUEST['orden']) ){
    $orden = $_REQUEST['orden'];
    $Model->order = preg_replace('/[^a-zA-Z0-9]/i','',$orden);
}
if( isset($_REQUEST['id']) ){
    $ID = $_REQUEST['id'];
    $modelData = ($dbh->query("SELECT * FROM tipo_pago WHERE id=?",array($ID))[0]);
}
$backURL = "/admin/modos-pago";
$formTemplate = "form.html";
$listTemplate = "list.html";
$cols = array(
    "nombre",
    "estado"
);
$orderFields = array(
);
/*
$types = array(
    "activa" => "boolean"
);
$foreigns = array(
);
//*/
$view->set("cols", $cols);
