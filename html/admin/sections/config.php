<?php

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
