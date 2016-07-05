<?php
$tipos = array();
$cur = $dbh->query("select * from configs;");
foreach( $cur as $row ){
    $tipos[$row['id']] = $row['type'];
}
$files = array();
if( !empty($_FILES) ){
    foreach( $_FILES['configs'] as $attr=>$values ){
        foreach( $values as $k=>$v ){
            $files[$k][$attr] = $v['valor'];
            if( $attr=='name' )
                $_REQUEST['configs'][$k]['valor'] = $v['valor'];
        }
    }
}
foreach( $files as $id=>$file ){
    $filePath = PATH."/html/assets/";
    if( !move_uploaded_file($file['tmp_name'],$filePath.$file['name']) ){
        unset($_REQUEST['configs'][$id]);
    }
}
if( isset($_REQUEST['grabar']) ){
    if( isset($_REQUEST['configs']) ){
        foreach( $_REQUEST['configs'] as $k=>$v ){
            $data = $v;
            $data['id'] = $k;
            $data['type'] = $tipos[$k];
            $data['grabar'] = 1;
            $conf = new Configuracion($dbh);
            $conf->setNew(false);
            $conf->setValues($data);
        }
        header("Location: /admin/configuraciones");
    }
}
$cur = $dbh->query("select * from configs;");
$view->set("configs", $cur);

$view->setTemplate("configs.html");
$content = $view->getView();
