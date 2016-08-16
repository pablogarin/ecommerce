<?php

if( isset($_POST['grabar']) ){
    $cuerpo = $_REQUEST['home'];
    $ins = $dbh->query("UPDATE texto SET cuerpo=? WHERE id=-1;", array($cuerpo));
}
if( isset($_REQUEST['grabar-banners']) ) {
    $success = true;
    foreach( $_REQUEST['banner'] as $k=>$v ){
        $data = array();
        $fileName = "";
        $skip = true;
        if( isset($v['id']) ){
            $ID = $v['id'];
            unset($v['id']);
            $query = " UPDATE banner SET ";
            $check = $dbh->query("SELECT * FROM banner WHERE id=?;",array($ID));
            if( isset($check[0]) ){
                $check = $check[0];
            }
            $checkEmptyValue = $check['nombre']==$v['nombre'] && $check['url']==$v['url'];
            foreach( $v as $name=>$value ){
                if( $name=='imagen' ){
                    if( empty($value) && $checkEmptyValue ){
                        continue;
                    }
                    if( $value=='DELETE' ){
                        $del = $dbh->query("DELETE FROM banner WHERE id=?;", array($ID));
                        continue;
                    }
                    $skip = false;
                    if( empty($value) ){
                        $fileName = false;
                        $value = $check['imagen'];
                    } else {
                        $fileName = $value;
                        $value = "/assets/".$value;
                    }
                }
                $data[$name] = $value;
                $query .= "$name=?,";
            }
            $query = rtrim($query, ",");
            $query .= " WHERE id=?;";
            $data['id'] = $ID;
        } else {
            $query = "INSERT INTO banner(";
            $plce_hldrs = "";
            foreach( $v as $name=>$value ){
                if( $name=='imagen' ){
                    if( empty($value) ){
                        continue;
                    }
                    if( $value=='DELETE' ){
                        continue;
                    }
                    $skip = false;
                    $fileName = $value;
                    $value = "/assets/".$value;
                }
                $data[$name] = $value;
                $query .= "$name,";
                $plce_hldrs .= "?,";
            }
            $query = rtrim($query, ",");
            $plce_hldrs = rtrim($plce_hldrs, ",");
            $query .= ") VALUES($plce_hldrs);";
        }
        if( $skip ){
            continue;
        }
        if( ($fileName !== false) && (file_exists(PATH."/html/assets/tmp/".$fileName)) ){
            $success &= rename(PATH."/html/assets/tmp/".$fileName, PATH."/html/assets/".$fileName);
        }
        if( $success ){
            $mod = $dbh->query($query, array_values($data) );
        }
    }
    header("Content-type: application/json; charset=utf-8");
    print json_encode(array("ok"=>$success));
    exit;
}
$cur = $dbh->query("SELECT * FROM banner;");
$banners = array(
    array("id"=>null,"imagen"=>null,"nombre"=>null,"url"=>null),
    array("id"=>null,"imagen"=>null,"nombre"=>null,"url"=>null),
    array("id"=>null,"imagen"=>null,"nombre"=>null,"url"=>null),
    array("id"=>null,"imagen"=>null,"nombre"=>null,"url"=>null)
);
foreach( $cur as $k=>$v ){
    $banners[$k] = $v;
}
$view->set("banners", $banners);
$cursor = $dbh->query("select * from texto where id=-1;");
$home = $cursor[0];
$view->set("homeLayout", $home['cuerpo']);
$template = "home.html";
$view->setTemplate($template);
$content = $view->getView();

?>
