<?php

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
