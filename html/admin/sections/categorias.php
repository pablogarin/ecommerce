<?php

use Modelos\Categoria as Categoria;
if( isset($_REQUEST['foto']) ){
    $file = $_REQUEST['foto'];
    if( file_exists(PATH."/html/assets/tmp/$file") ){
        rename(PATH."/html/assets/tmp/$file", PATH."/html/assets/$file");
        $_POST['foto'] = $_REQUEST['foto'] = $_GET['foto'] = "/assets/$file";
    }
}

$Model = new Categoria($dbh);
$view->set("title", "Categor&iacute;a");
if( isset($_REQUEST['id']) ){
    $ID = $_REQUEST['id'];
    $modelData = ($dbh->query("SELECT * FROM categoria WHERE id=?",array($ID))[0]);
}
$backURL = "/admin/categorias";
$formTemplate = "form.html";
$listTemplate = "list.html";
$cols = array(
    "foto",
    "nombre",
    "padre",
    "activa",
    "orden"
);
$types = array(
    "activa" => "boolean"
);
$foreigns = array(
    "padre" => "select nombre from categoria where id=?;"
);
$view->set("cols", $cols);
