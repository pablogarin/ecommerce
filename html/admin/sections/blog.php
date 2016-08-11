<?php

use Modelos\Blog as Blog;

$Model = new Blog($dbh);
$view->set("title", "Entradas del Blog");
if( isset($_REQUEST['id']) ){
    $ID = $_REQUEST['id'];
    $modelData = ($dbh->query("SELECT * FROM blog WHERE id=?",array($ID))[0]);
    $view->set("title", $modelData['titulo']);
}
$backURL = "/admin/blog";
$formTemplate = "blog.html";
$listTemplate = "list.html";
$cols = array(
    "titulo",
    "foto"
);
/*
$types = array(
    "activa" => "boolean"
);
$foreigns = array(
);
// */
$view->set("cols", $cols);
