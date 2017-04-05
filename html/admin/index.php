<?php
include_once 'common.php';
include_once 'session.php';
include_once 'model.php';

// seccion actual
if( isset($_SERVER['SCRIPT_URL']) ) {
	$current = $_SERVER['SCRIPT_URL'];
	$current = str_replace("/admin/","",$current);
	$current = str_replace("/","",$current);
} elseif( isset($_SERVER['REQUEST_URI']) ) {
	$current = $_SERVER['REQUEST_URI'];
	$current = str_replace("/admin/","",$current);
	$current = str_replace("/","",$current);
	$current = explode("?", $current);
	$current = $current[0];
}

if( empty($current) ){
    header("Location: /admin/dashboard");
    exit;
}

// secciones del menu
include_once 'menubar.php';
$view->set("navs",$navs);
//*
if( isset($_FILES) ){
    foreach( $_FILES  as $nominare => $file ){
        if( $file['error']==0 ) {
            $name = date("YmdHis").$file['name'];
            $name = url_slug($name);
            $filepath = PATH."/html/assets/".$name;
            if( !move_uploaded_file($file['tmp_name'],$filepath) ){
                error_log("No se pudo subir el archivo '".$name."'");
                exit;
            } else {
                $_POST[$nominare] = $_GET[$nominare] = $_REQUEST[$nominare] = "/assets/".$name;
            }
        }
    }
}
$hiddens = array();
//*/
switch( $current ){
    case 'dashboard':
        include_once 'dashboard.php';
        break;
    case 'pedidos':
        include_once 'pedidos.php';
        break;
    case 'modos-pago':
        include_once 'modos_pago.php';
        break;
    case 'costos-despacho':
        include_once 'costo_despacho.php';
        break;
    case 'categorias':
        include_once 'categorias.php';
        break;
    case 'productos':
        include_once 'productos.php';
        break;
    case 'home':
        include_once 'home.php';
        break;
    case 'blog':
        include_once 'blog.php';
        break;
    case 'textos':
        include_once 'textos.php';
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
    $view->set("back", $backURL);
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
    $view->set("hiddens", $hiddens);
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
            if( isset($_POST['fecha']) ){
                $meses = array(
                    "01" => "enero",
                    "02" => "febrero",
                    "03" => "marzo",
                    "04" => "abril",
                    "05" => "mayo",
                    "06" => "junio",
                    "07" => "julio",
                    "08" => "agosto",
                    "09" => "septiembre",
                    "10" => "octubre",
                    "11" => "noviembre",
                    "12" => "diciembre",
                );
                $fecha = $_POST['fecha'];
                $fecha = str_replace(" de ","-", $fecha);
                $fecha = str_replace($meses, array_keys($meses), $fecha);
                $_POST['fecha'] = date("Y-m-d H:i:s",strtotime($fecha));
            }
            $Model->setValues($_POST);
        }
        $view->setTemplate( $formTemplate );
    } else {
        if( !isset($Model->order) ){
            $Model->order = null;
        }
        $data = $Model->query->all($Model->order);

        if( isset($_REQUEST['excel']) ){
            $excel = array();
            $header = array();
            $columns = $Model->getValidFields();
            foreach( $columns as $k=>$v ){
                if( $v['type'] == 'boolean' ){
                    if( $data!=null && is_array($data) ){
                        foreach( $data as $id=>$row ){
                            $data[$id][$v['nombre']] = $row[$v['nombre']] == '1' ? 'Si' : 'No'; // expresiones booleanas en espaN?ol;
                        }
                    }
                }
                /*
                if( isset($v['label']) ){
                    $excel[0][] = $v['nombre'];
                    $header[] = html_entity_decode($v['label']);
                }
                **/
                //*
                if( !in_array($v['type'],array('hidden','index')) ){
                    $excel[0][] = $v['nombre'];
                    $header[] = html_entity_decode($v['label']);
                }
                //*/
            }
            foreach( $data as $k=>$v ){
                $line = array();
                foreach( $excel[0] as $name ){
                    $line[] = $v[$name];
                }
                $excel[] = $line;
            }
            $excel[0] = $header;
            date_default_timezone_set('Chile/Continental');
            require_once('../libs/PHPExcel/PHPExcel.php');

            $doc = new PHPExcel();
            $doc->setActiveSheetIndex(0);

            $doc->getActiveSheet()->fromArray($excel, null, 'A1');
            $lastCol = $doc->getActiveSheet()->getHighestColumn();
            foreach( range('A',$lastCol) as $col ){
                $doc->getActiveSheet()->getColumnDimension($col)
                    ->setAutoSize(true);  // ajustamos el ancho de las columnas automaticamente
            }
            $doc->getActiveSheet()->calculateColumnWidths();
            $doc->getActiveSheet()->freezePane('A2'); // dejamos fija la primera columna del excel
            $doc->getActiveSheet()->getStyle("A1:".$lastCol."1")->getFont()->setBold(true);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Ventas.xls"');
            header('Cache-Control: max-age=0');

            // Do your stuff here
            $writer = PHPExcel_IOFactory::createWriter($doc, 'Excel5');

            $writer->save('php://output');
            exit;
        }// fin Excel

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
