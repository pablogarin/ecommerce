<?php

$cursor = $dbh->query("select * from texto where id=-1;");
$home = $cursor[0];
$view->set("homeValue", $home['cuerpo']);
if( isset($_POST['grabar']) ){
    exit("grabar");
}
$template = "home.html";
$view->setTemplate($template);
$content = $view->getView();

?>
