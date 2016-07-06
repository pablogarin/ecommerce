<?php
if( isset( $_REQUEST['grabar'] ) ){
    $obj = new Texto($dbh);
    $obj->setNew(!isset($_REQUEST['id']));
    $obj->setValues($_REQUEST);
    header("Location: /admin/textos");
}
if( isset($_REQUEST['eliminar']) ){
    $dbh->query("delete from texto where id=?;",array($_REQUEST['eliminar']));
    header("Location: /admin/textos");
}
if( isset($_REQUEST['edit']) ){
    $id = $_REQUEST['edit'];
    $cur = $dbh->query("select * from texto where id=?;",array($id));
    if( isset($cur[0]) ){
        foreach( $cur[0] as $llave=>$valor ){
            $view->set($llave,$valor);
        }
    }
}
$cur = $dbh->query("select * from texto;");
if( isset($cur[0]) ){
    $view->set("textos",$cur);
}

$view->setTemplate("textos.html");
$content = $view->getView();


