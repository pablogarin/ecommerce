<?php
$Model = new Texto($dbh);
$view->set("title", "Textos");
if( isset($_REQUEST['id']) ){
    $ID = $_REQUEST['id'];
    $modelData = ($dbh->query("SELECT * FROM texto WHERE id=?",array($ID))[0]);
    $view->set("title", $modelData['titulo']);
}
$backURL = "/admin/textos";
$formTemplate = "form.html";
$listTemplate = "list.html";
$cols = array(
    "llave",
    "titulo",
    "cuerpo"
);
/*
$types = array(
    "activa" => "boolean"
);
$foreigns = array(
);
// */
$view->set("cols", $cols);
