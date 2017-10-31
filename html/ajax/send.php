<?php
ini_set("display_errors", 1);
include_once 'common.php';
if( isset($_REQUEST['nombre']) && isset($_REQUEST['mail']) && isset($_REQUEST['fono']) && isset($_REQUEST['comentario']) && !empty($_REQUEST['nombre']) && !empty($_REQUEST['mail']) && !empty($_REQUEST['fono']) && !empty($_REQUEST['comentario']) ){
    //TODO:
    $cur = $dbh->query("SELECT * FROM config;");
    $configs = array();
    if( isset($cur[0]) ){
        foreach( $cur as $row ){
            $configs[$row['llave']] = $row;
        }
    }
    if( isset($configs) ){
        $to = $configs['cuentaCorreo']['valor'];
        $sitio = $configs['nombreSitio']['valor'];
        $nombre = $_REQUEST['nombre'];
        $mail = $_REQUEST['mail'];
        $fono = $_REQUEST['fono'];
        $url_sitio = "http://".$_SERVER['HTTP_HOST'];
        $comentario = "
      <html>
        <body>
          <h1>Solicitud de Contacto.</h1>
          <p>
          Han escrito desde la secci&oacute;n de Contacto del Sitio. <br/>
          </p>
          <h2>Detalles:</h2>
          <table border=\"0\" style=\"font-size: 14px; text-align: left;\">
            <tr>
              <th>Nombre:</th>
              <td>". $nombre ."</td>
            </tr>
            <tr>
              <th>E-Mail:</th>
              <td><a href=\"mailto:".$mail."\">". $mail ."</a></td>
            </tr>
            <tr>
              <th>Tel&eacute;fono:</th>
              <td>". $fono ."</td>
            </tr>
            <tr>
              <th colspan=\"2\">Mensaje:</th>
            </tr>
            <tr>
              <td colspan=\"2\">
                <p style=\"border: 1px solid #666; background-color: #f0f0f0; text-align: left; padding: 10px 15px; margin: 10px auto; font-style: italic; line-height: 22px; font-size: 18px;\">&quot;". $_REQUEST['comentario'] ."&quot;</p>
              </td>
            </tr>
          </table>
          <p style=\"margin: 10px auto; font-style: italic; color: #999;\">Mesaje enviado autom&aacute;ticamente desde el sitio web <a href=\"".$url_sitio."\">".$sitio."</a>.</p>
        </body>
      </html>";
        if( sendEmail($to, "Nueva Solicitud de Contacto Web", $comentario, $mail) ){
          echo "Mensaje enviado";
        } else {
          echo "No se pudo enviar el mensaje.";
        }
    }
} else {
    echo "Debe llenar todos los campos";
}
