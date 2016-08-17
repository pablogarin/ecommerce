<?php
use Modelos\Venta as Venta;

$Model = new Venta($dbh);

if( isset($_REQUEST['excel']) ){
    $columns = $Model->getValidFields();
    $detalle = array(
        "idProducto" => array(
            "nombre" => "idProducto",
            "type" => "text",
            "label" => "Producto"
        ),
        "cantidad" => array(
            "nombre" => "cantidad",
            "type" => "text",
            "label" => "Cantidad"
        ),
        "totalProducto" => array(
            "nombre" => "totalProducto",
            "type" => "text",
            "label" => "Total"
        )
    );
    $order = array(
        "numero",
        "idEstado",
        "idCliente",
        "fecha",
        "idProducto",
        "cantidad",
        "totalProducto",
        "costoDespacho",
        "total"
    );
    $columns = array_merge($columns, $detalle);
    $tmp = array();
    foreach( $order as $name ){
        $tmp[$name] = $columns[$name];
        unset($columns[$name]);
    }
    $columns = array_merge($tmp, $columns);
    $data = $Model->query->all();
    $tmp = array();
    foreach( $data as $k=>$v ){
        $v['total'] = (float)$v["total"]+(float)$v["costoDespacho"];
        $estado = $dbh->query("SELECT * FROM estado WHERE id=?;",array($v['idEstado']));
        foreach( $estado as $row ){
            $v['idEstado'] = $row['descripcion'];
        }
        $cliente = $dbh->query("SELECT * FROM cliente WHERE id=?;",array($v['idCliente']));
        foreach( $cliente as $row ){
            $v['idCliente'] = $row['correo'];
        }
        $detalle = $dbh->query("SELECT *, p.nombre as idProducto, vd.precio as totalProducto FROM venta_detalle vd LEFT JOIN producto p ON p.id=vd.idProducto WHERE idVenta=?;",array($v['id']));
        foreach( $detalle as $row ){
            $tmp[] = array_merge($v, $row);
        }
    }
    $data = $tmp;
    $excel = array();
    $header = array();
    foreach( $columns as $k=>$v ){
        if( !in_array($v['type'],array('hidden','index')) ){
            $excel[0][] = $v['nombre'];
            $header[] = html_entity_decode($v['label']);
        }
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

$view->set("title", "Productos");
$orden = "";
if( isset($_REQUEST['orden']) ){
    $orden = $_REQUEST['orden'];
    $Model->order = preg_replace('/[^a-zA-Z0-9]/i','',$orden);
} else {
    $Model->order = "fecha desc";
}
if( isset($_POST['q']) ){
    $query = $_POST['q'];
    $values = array($query);
    $cur = $dbh->query("SELECT id FROM cliente WHERE correo LIKE ?;",array("%$query%"));
    foreach( $cur as $row ){
        $values[] = $row['id'];
    }
    Venta::setFilter(array("numero", "idCliente"), $values);
    $view->set("query", $query);
}
if( isset($_REQUEST['id']) ){
    $ID = $_REQUEST['id'];
    $view->set("id", $ID);
    $modelData = ($dbh->query("SELECT * FROM venta WHERE id=?",array($ID))[0]);
    if( isset($_REQUEST['pagar']) ){
        $ins = $dbh->query("UPDATE venta SET idEstado=? WHERE id=?;",array(5,$ID));
    }
    if( $modelData['idEstado']!=3 && isset($_REQUEST['cancelar']) ){
        $ins = $dbh->query("UPDATE venta SET idEstado=? WHERE id=?;",array(3,$ID));
        $cur = $dbh->query("SELECT * FROM venta_detalle WHERE idVenta=?;",array($ID));
        foreach( $cur as $row ){
            $upd = $dbh->query("UPDATE producto SET stock=stock+".$row['cantidad']." WHERE id=?;",array($row['idProducto']));
        }
    }
    $cur = $dbh->query("SELECT * FROM cliente WHERE id=?;",array($modelData['idCliente']));
    foreach( $cur as $row ){
        $modelData['cliente'] = $row;
    }
    $cur = $dbh->query("SELECT * FROM direccion WHERE id=?;",array($modelData['idDireccion']));
    foreach( $cur as $row ){
        $modelData['direccion'] = $row;
    }
    if( (int)$modelData['idEstado']==4 ){
        $view->set("pagar", true);
    }
    $cur = $dbh->query("SELECT descripcion FROM estado WHERE id=?;",array($modelData['idEstado']));
    foreach( $cur as $row ){
        $modelData['idEstado'] = $row['descripcion'];
    }
    $cur = $dbh->query("SELECT * FROM venta_detalle vd LEFT JOIN producto p ON vd.idProducto=p.id WHERE vd.idVenta=?;",array($ID));
    $modelData['productos'] = $cur;
}
$backURL = "/admin/productos";
$formTemplate = "detalle-venta.html";
$listTemplate = "ventas.html";
$cols = array(
    "numero",
    "idCliente",
    "fecha",
    "costoDespacho",
    "total",
    "idEstado"
);
$orderFields = array(
/*
    "foto",
    "nombre",
    "SKU",
    "categoria",
    "tipo",
    "descripcion",
    "precio",
    "precioReferencia"
**/
);
//*
$types = array(
    "total" => "money"
);
$foreigns = array(
    "idEstado" => "select descripcion from estado where id=?;",
    "idCliente" => "select correo from cliente where id=?;"
);
//*/
$view->set("cols", $cols);

?>
