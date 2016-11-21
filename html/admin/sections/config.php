<?php
if( isset($_REQUEST['cambia-pass']) ){
    if( !empty($_POST['actual']) && !empty($_POST['nueva']) && !empty($_POST['repeat']) ) {
        $cur = $dbh->query("SELECT * FROM usuario WHERE id=? and password=?;", array($_SESSION['user'],$_POST['actual']));
        if( empty($cur) ){
            session_destroy();
            header("Location: /");
            exit();
        }
        if( $_POST['nueva']!==$_POST['repeat'] ){
            $view->set("error","Las contrase&ntilde;as no coinciden entre si.");
        } else {
            $id = $cur[0]['id'];
            $cur = $dbh->query("UPDATE usuario SET password=? WHERE id=?;", array($_POST['nueva'], $id));
            $view->set("success","Contrase&ntilde;a actualizada exitosamente.");
        }
    } else {
        $view->set("error","Debe ingresar todos los campos.");
    }
} else {
    unset($_POST['actual']);
    unset($_POST['nueva']);
    unset($_POST['repeat']);
}
if( isset($_REQUEST['grabar']) ){
    $query = "UPDATE config SET valor=? WHERE id=?;";
    foreach( $_POST['configs'] as $id=>$valor ){
        $dbh->query($query, array($valor, $id));
    }
    $view->set("success","Datos grabados exitosamente.");
}

$cur = $dbh->query("SELECT * FROM config;");
$data = array();
foreach( $cur as $row ){
    $options = $row['tipo'];
    $tmp = explode('[',$options);
    if( isset($tmp[1]) ){
        $row['tipo'] = $tmp[0];
        $options = str_replace(']','',$tmp[1]);
        $options = explode(',',$options);
    } else {
        $options = array();
    }
    $row["options"] = $options;
    $data[$row['llave']] = $row;
}
$view->set("data", $data);

$template = "config.html";
$view->setTemplate($template);
$content = $view->getView();

?>
