<?php
include_once 'common.php';
if( isset($_REQUEST['nombre']) && isset($_REQUEST['mail']) && isset($_REQUEST['fono']) && isset($_REQUEST['comentario']) && !empty($_REQUEST['nombre']) && !empty($_REQUEST['mail']) && !empty($_REQUEST['fono']) && !empty($_REQUEST['comentario']) ){
    //TODO:
    $cur = $dbh->query("select * from configs where nombre='E-Mail Contacto';");
    if( isset($cur[0]) ){
        $to = $cur[0]['valor'];
        $nombre = $_REQUEST['nombre'];
        $mail = $_REQUEST['mail'];
        $fono = $_REQUEST['fono'];
        $comentario = "Cliente: $nombre.\nTelefono: $fono.\nMensaje: ".$_REQUEST['comentario'];
        mail($to,"Contacto desde el sitio: $nombre",$comentario,"From:".$to);
        echo "Mensaje enviado";
    }
} else {
    echo "Debe llenar todos los campos";
}
