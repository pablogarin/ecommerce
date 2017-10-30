<?php
/*
 *  El orden de los parametros recibidos es:
 *
 *  1) TBK_ORDEN_COMPRA
 *  2) TBK_TIPO_TRANSACCION
 *  3) TBK_RESPUESTA
 *  4) TBK_MONTO
 *  5) TBK_CODIGO_AUTORIZACION
 *  6) TBK_FINAL_NUMERO_TARJETA
 *  7) TBK_FECHA_CONTABLE
 *  8) TBK_FECHA_TRANSACCION
 *  9) TBK_HORA_TRANSACCION 
 *  10) TBK_ID_SESION
 *  11) TBK_ID_TRANSACCION
 *  12) TBK_TIPO_PAGO
 *  13) TBK_NUMERO_CUOTAS
 *  14) TBK_TASA_INTERES_MAX 
 *  15) TBK_VCI
 *  16) TBK_MAC
 *
 * */
/*
 * La estructura de la base de datos es la siguiente:
 *  TABLA: venta
 *  +-----------------------+--------------+------+-----+-------------------+----------------+
 *  | Field                 | Type         | Null | Key | Default           | Extra          |
 *  +-----------------------+--------------+------+-----+-------------------+----------------+
 *  | id                    | int(11)      | NO   | PRI | NULL              | auto_increment |
 *  | numero                | varchar(120) | NO   |     | NULL              |                |
 *  | esFactura             | int(11)      | YES  |     | 0                 |                |
 *  | fecha                 | timestamp    | NO   |     | CURRENT_TIMESTAMP |                |
 *  | costoDespacho         | float        | YES  |     | 0                 |                |
 *  | total                 | float        | YES  |     | 0                 |                |
 *  | idCliente             | int(11)      | NO   |     | NULL              |                |
 *  | idEstado              | int(11)      | NO   |     | NULL              |                |
 *  | idDireccion           | int(11)      | YES  |     | NULL              |                |
 *  | idEmpresa             | int(11)      | YES  |     | NULL              |                |
 *  | tipoTransaccionTBK    | varchar(120) | YES  |     | TR_NORMAL         |                |
 *  | codigoAutorizacionTBK | varchar(120) | YES  |     | NULL              |                |
 *  | idCarro               | int(11)      | NO   |     | NULL              |                |
 *  | descuento             | float        | YES  |     | 0                 |                |
 *  | notificada            | int(11)      | YES  |     | 0                 |                |
 *  | sync                  | int(11)      | YES  |     | 0                 |                |
 *  | cod_venta_SAP         | text         | YES  |     | NULL              |                |
 *  +-----------------------+--------------+------+-----+-------------------+----------------+
 *  TABLA: venta_detalle
 *  +------------+---------+------+-----+---------+----------------+
 *  | Field      | Type    | Null | Key | Default | Extra          |
 *  +------------+---------+------+-----+---------+----------------+
 *  | id         | int(11) | NO   | PRI | NULL    | auto_increment |
 *  | idVenta    | int(11) | NO   |     | NULL    |                |
 *  | idProducto | int(11) | NO   |     | NULL    |                |
 *  | cantidad   | int(11) | YES  |     | 1       |                |
 *  | precio     | float   | NO   |     | NULL    |                |
 *  | descuento  | float   | YES  |     | 0       |                |
 *  | incluyeIVA | int(11) | YES  |     | 1       |                |
 *  | paraRegalo | int(11) | YES  |     | 0       |                |
 *  +------------+---------+------+-----+---------+----------------+
 *
 * */


/*----- DB CONFIG ------*/
include_once("common.php");
$handle = fopen(PATH."/html/comun/postData.md","wa+");
fwrite($handle, "XT COMPRA INVOCADO!: ". print_r($_POST,1));
fclose($handle);
$cur = $dbh->query("SELECT * FROM config;");
$configs = array();
if( isset($cur[0]) ){
    foreach( $cur as $row ){
        $configs[$row['llave']] = $row;
    }
}
define("URL", $configs['urlSitio']['valor']);
/*----- END DB CONFIG ------*/

// ANTES QUE NADA, GRABAMOS LA RESPUESTA EN NUESTRA BDD
$TBK_ORDEN_COMPRA = trim(strip_tags($_POST['TBK_ORDEN_COMPRA']));
$TBK_TIPO_TRANSACCION = trim(strip_tags($_POST['TBK_TIPO_TRANSACCION']));
$TBK_RESPUESTA = trim(strip_tags($_POST['TBK_RESPUESTA']));
$TBK_MONTO = trim(strip_tags($_POST['TBK_MONTO']));
$TBK_CODIGO_AUTORIZACION = trim(strip_tags($_POST['TBK_CODIGO_AUTORIZACION']));
$TBK_FINAL_NUMERO_TARJETA = trim(strip_tags($_POST['TBK_FINAL_NUMERO_TARJETA']));
$TBK_FECHA_CONTABLE = trim(strip_tags($_POST['TBK_FECHA_CONTABLE']));
$TBK_FECHA_TRANSACCION = trim(strip_tags($_POST['TBK_FECHA_TRANSACCION']));
$TBK_HORA_TRANSACCION = trim(strip_tags($_POST['TBK_HORA_TRANSACCION']));
$TBK_ID_SESION = trim(strip_tags($_POST['TBK_ID_SESION']));
$TBK_ID_TRANSACCION = trim(strip_tags($_POST['TBK_ID_TRANSACCION']));
$TBK_TIPO_PAGO = trim(strip_tags($_POST['TBK_TIPO_PAGO']));
$TBK_NUMERO_CUOTAS = trim(strip_tags($_POST['TBK_NUMERO_CUOTAS']));
$TBK_TASA_INTERES_MAX = trim(strip_tags($_POST['TBK_TASA_INTERES_MAX']));
$TBK_VCI = trim(strip_tags($_POST['TBK_VCI']));
$TBK_MAC = trim(strip_tags($_POST['TBK_MAC']));
$datos = array(
    $TBK_ORDEN_COMPRA,
    $TBK_TIPO_TRANSACCION,
    $TBK_RESPUESTA,
    $TBK_MONTO,
    $TBK_CODIGO_AUTORIZACION,
    $TBK_FINAL_NUMERO_TARJETA,
    $TBK_FECHA_CONTABLE,
    $TBK_FECHA_TRANSACCION,
    $TBK_HORA_TRANSACCION,
    $TBK_ID_SESION,
    $TBK_ID_TRANSACCION,
    $TBK_TIPO_PAGO,
    $TBK_NUMERO_CUOTAS,
    $TBK_TASA_INTERES_MAX,
    $TBK_VCI,
    $TBK_MAC
);
// EL METODO PARA GRABAR LA ORDEN SE DEBE ELEGIR AL REALIZAR LA IMPLEMENTACION
$query = "INSERT INTO pago_venta VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$cursor = $dbh->query($query, $datos);
// RESPUEST TBK GRABADA

// AUTORIZADA?
if( @$_POST['TBK_RESPUESTA']!=0 ){ // cuando TBK rechaza la compra, devuelve un valor distinto a 0
    logResult("Rechazado por Transbank");
    print "ACEPTADO"; // cuando es rechazado por TBK debemos responder 'ACEPTADO' 
    exit;// Para que seguir validando si fue rechazado desde TBK??
}
// END AUTORIZADA

//GENERAMOS EL ARCHIVO PARA VERIFICAR LA MAC
$install = PATH."/html/";
$mac_filepath = "$install/comun/mac_$TBK_ORDEN_COMPRA.txt";
$handle = fopen($mac_filepath,"w+");
$content = array();
foreach( $_POST as $k=>$v ){
    $content[] = "$k=$v";
}
$content = implode('&',$content);
fwrite($handle, $content);
fclose($handle);
//FIN ARCHIVO MAC

// MAC??
exec("$install/KCC/tbk_check_mac.cgi $mac_filepath",$result);
if( trim($result[0])!='CORRECTO' ){
    logResult("No paso el checkeo de MAC. Respuesta: '$result'");
    exit("RECHAZADO");
}
unlink($mac_filepath); // YA NO SIRVE PARA ABSOLUTAMENTE NADA. LA INFORMACION DEL ARCHIVO SE PUEDE RESCATAR DE LA TABLA pago_venta.
// END MAC

// OC??
$id = $_POST['TBK_ORDEN_COMPRA'];
if( $id==null ){
    $id = "NULL";
    logResult("ID de compra no encontrada");
    exit("RECHAZADO");
}
$venta = $dbh->query("SELECT * FROM venta WHERE numero=?;", array($id));
if( !empty($venta) ){
    $venta = $venta[0];
} else {
    logResult("No se encontro la venta en la base de datos");
    exit("RECHAZADO");
}
// END OC

// TIPO??
if( @$_POST['TBK_TIPO_TRANSACCION']!=$venta['tipoTransaccionTBK'] ){
    logResult("Tipo de transaccion no correponde");
    exit("RECHAZADO");
}
// END TIPO

// MONTO??
$total = (int)$venta['total']+(int)$venta['costoDespacho'];
$total = "$total"."00"; // los totales llegan con dos (2) ceros extras al final que son los decimales.
if( $_POST['TBK_MONTO']!=$total ){
    logResult("El monto de la compra no coincide: $".$total." != $".$_POST['TBK_MONTO']);
    exit("RECHAZADO");
}
// END MONTO
// Antes de aceptar la compra, grabamos los detalles de la misma:
$dbh->query("UPDATE venta SET codigoAutorizacionTBK=? WHERE id=?;",array($_POST['TBK_CODIGO_AUTORIZACION'], $_POST['TBK_ID_SESION']));

print "ACEPTADO";
exit;

// FUNCIONES DE APOYO
function logResult($cause){
    global $id, $_REQUEST;
    $date = date("Y-m-d H:i:s");
    $handle = fopen(PATH."/comun/postData.md","wa+");
    fwrite($handle, "$date - $id - $cause. detalles: \n");
    fwrite($handle,print_r($_REQUEST,1));
    fwrite($handle,"\n================================================================\n");
    fclose($handle);
}
?>
