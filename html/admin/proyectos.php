<?php
if( isset( $_REQUEST['grabar'] ) ){
    $obj = new Proyecto($dbh);
    $obj->setNew(!isset($_REQUEST['id']));
    if( empty($_REQUEST['fecha']) ){
        $_REQUEST['fecha'] = date("Y-m-d H:i:s");
    }
    $obj->setValues($_REQUEST);
    if( isset($_REQUEST['galeria']) ){
        if( isset($_REQUEST['galeria']['new']) ){
            foreach( $_REQUEST['galeria']['new'] as $row ){
                if( !empty($row['foto']) ){
                    $data = array(
                        $obj->data['id'],
                        $row['foto'],
                        $row['orden']
                    );
                    $res = $dbh->query("INSERT INTO galeria(proyecto,foto,orden) VALUES(?,?,?)",$data);
                }
            }
            unset($_REQUEST['galeria']['new']);
        }
        foreach( $_REQUEST['galeria'] as $id=>$row ){
            $data = array($row['foto'],$row['orden'],$id);
            $res = $dbh->query("UPDATE galeria SET foto=?, orden=? WHERE id=?;",$data);
        }
    }
    if( isset($dbh->errorInfo()[2]) ){
        print_r($dbh->errorInfo()[2]);
    } else {
        header("Location: /admin/proyectos");
    }
    exit(0);
}
if( isset($_REQUEST['eliminar']) ){
    $dbh->query("delete from proyecto where id=?;",array($_REQUEST['eliminar']));
    header("Location: /admin/proyectos");
    exit(0);
}
if( isset($_REQUEST['edit']) ){
    $id = $_REQUEST['edit'];
    $cur = $dbh->query("select * from proyecto where id=?;",array($id));
    if( isset($cur[0]) ){
        foreach( $cur[0] as $llave=>$valor ){
            $view->set($llave,$valor);
        }
    }
    $cur = $dbh->query("SELECT * FROM galeria WHERE proyecto=?;",array($id));
    if( isset($cur[0]) ){
        $view->set("galeria",$cur);
    }
}
$cur = $dbh->query("select * from proyecto;");
if( isset($cur[0]) ){
    $view->set("proyectos",$cur);
}

$view->setTemplate("proyectos.html");
$content = $view->getView();


