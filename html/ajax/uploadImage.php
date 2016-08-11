<?php
include_once 'common.php';
if( isset($_FILES['upload']) ){
    $response = array();
    $fileName = date("YmdHis")."-".$_FILES['upload']['name'];
    $filepath = PATH."/html/assets/".$fileName;
    if( move_uploaded_file($_FILES['upload']['tmp_name'],$filepath) ){
        $response['uploaded'] = 1;
        $response['fileName'] = $fileName;
        $response['url'] = "/assets/".$response['fileName'];
    } else {
        $response['uploaded'] = 0;
        $response['error'] = "No se pudo copiar la imagen en la carpeta de destino.";
    }
} else {
    $response['uploaded'] = 0;
    $response['error'] = "Debe enviar un archivo para subir.";
}
header("Content-type: application/json; charset=utf-8");
print json_encode($response);
?>
