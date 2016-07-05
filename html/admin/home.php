<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
if( isset($_GET['cliente']) || isset($_POST['id']) ){
    $id = (int)@$_GET['cliente'];
    if( $id==0 ){
        $id = (int)$_POST['id'];
    }
    $cur = $dbh->query("select * from cliente where id=?;",array($id));
    if( isset($cur[0]) ){
        foreach( $cur[0] as $key=>$value ){
            $view->set($key,$value);
        }
    }
}
// NO DEJA SUBIR FOTO ACA.
/*
if( isset($_FILES['logoupload']) ){
    $file = $_FILES['logoupload'];
    $logo = date("YmdHis")."-".$file['name'];
    $filePath = PATH."/html/assets/$logo";
    print_r($filePath);
    if( !move_uploaded_file($file['tmp_name'], $filePath) ){
        echo "error";
        print_r($_FILES);
        $view->set("error","No se pudo subir la imagen.");
    } else {
        $_REQUEST['logo'] = $logo;
        echo $logo;
    }
}
//*/
if( isset( $_REQUEST['grabar'] ) ){
    if( isset($_REQUEST['banners']) ){
        foreach( $_REQUEST['banners'] as $value ){
            $data = array();
            $ban = new Banner($dbh);
            $ban->setNew(true);
            $data['grabar'] = 1;
            $data['foto'] = $value;
            $ban->setValues($data);
        }
    }
    if( isset($_REQUEST['grabar']['cliente']) ){
        $cliente = new Cliente($dbh);
        $cliente->setNew(!isset($_REQUEST['id']));
        $_REQUEST['grabar'] = 1;
        $cliente->setValues($_REQUEST);
    }
    header("Location: /admin/home");
}
if( isset($_REQUEST['eliminar']) ){
    if( isset($_REQUEST['eliminar']['banner']) ){
        $dbh->query("delete from banner where id=?;",array($_REQUEST['eliminar']['banner']));
    }
    if( isset($_REQUEST['eliminar']['frase']) ){
        $dbh->query("delete from frase where id=?;",array($_REQUEST['eliminar']['frase']));
    }
}
$cur = $dbh->query("select * from banner;");
if( isset($cur[0]) ){
    $view->set("banners",$cur);
}
$cur = $dbh->query("select * from cliente;");
if( isset($cur[0]) ){
    $view->set("clientes",$cur);
}

$view->setTemplate("home.html");
$content = $view->getView();
