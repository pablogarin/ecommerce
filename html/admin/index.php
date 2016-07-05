<?php
include_once 'common.php';
include_once 'session.php';
include_once 'model.php';

// seccion actual
$current = $_SERVER['SCRIPT_URL'];
$current = str_replace("/admin/","",$current);
$current = str_replace("/","",$current);

if( empty($current) ){
    header("Location: /admin/dashboard");
    exit;
}

// secciones del menu
include_once 'menubar.php';
$view->set("navs",$navs);
//*
if( isset($_FILES) ){
    foreach( $_FILES  as $file ){
        $name = $file['name'];
        $filepath = PATH."/html/assets/".$name;
        if( !move_uploaded_file($file['tmp_name'],$filepath) ){
            error_log("No se pudo subir el archivo '".$name."'");
        }
    }
}
//*/
switch( $current ){
    case 'dashboard':
        include_once 'dashboard.php';
        break;
    case 'categorias':
        include_once 'categorias.php';
        break;
    case 'productos':
        include_once 'productos.php';
        break;
    case 'configuraciones':
        include_once 'config.php';
        break;
    default:
        $view->setTemplate("error.html");
        $content = $view->getView();
        break;
}
if( isset($Model) ){
    $fields = $Model->getValidFields();
    $fields = array_merge($fields, $Model->getForeignFields());
    if( isset($orderFields) && is_array($orderFields) ){
        $tmp = array();
        foreach( $orderFields as $name ){
            $tmp[$name] = $fields[$name];
            unset($fields[$name]);
        }
        $fields = array_merge($tmp, $fields);
    }
    $view->set("fields", $fields);
    if( isset($_REQUEST['action']) ){
        $view->set("action", $_REQUEST['action']);
        switch( $_REQUEST['action'] ){
        case 'edit':
            if( isset($_REQUEST['id']) ){
                $ID = $_REQUEST['id'];
                // $data = $Model->query->byField(array("id"=>$ID)); // hay q arreglarlo
                $view->set("data", $modelData);
                $Model->setNew(false);
            } else {
                header("Location: $backURL");
                exit;
            }
            break;
        case 'del':
            if( isset($_REQUEST['id']) ){
                if( is_array($_REQUEST['id']) ){
                    foreach( $_REQUEST['id'] as $ID ){
                        $ID = $_REQUEST['id'];
                        $Model->delete($ID);
                    }
                } else {
                    $ID = $_REQUEST['id'];
                    $Model->delete($ID);
                }
            }
            header("Location: $backURL");
            exit;
            break;
        case 'new':
            $Model->setNew(true);
            break;
        }
        if( isset($_REQUEST['grabar']) ){
            $Model->setValues($_POST);
        }
        $view->setTemplate( $formTemplate );
    } else {
        $data = $Model->query->all();
        foreach( $data as $key => $value ){
            if( (int)$value['id']<0 ){
                unset($data[$key]);
                continue;
            }
            if( isset($foreigns) ){
                foreach( $foreigns as $name => $cmd ){
                    $cur = $dbh->query($cmd, array($value[$name]));
                    $data[$key][$name] = array_values($cur[0])[0];
                }
            }
            if( isset($types) ){
                foreach( $types as $name => $type ){
                    switch($type){
                    case 'boolean':
                        $data[$key][$name] = $value[$name]==1?"<span class='label label-success'>Si</span>":"<span class='label label-danger'>No</span>";
                        break;
                    }
                }
            }
        }
        $view->set("data", $data);
        $view->setTemplate( $listTemplate );
    }

    $content = $view->getView();
}

if( isset($content) ){
    $view->set("CONTENT",$content);
}
$view->setTemplate("index.html");
print $view->getView();
?>
