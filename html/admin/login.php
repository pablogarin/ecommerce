<?php
$login = true;
if( !empty($_REQUEST) ){
    foreach( $_REQUEST as $k=>$v ){
        $view->set($k,$v);
    }
    if( isset($_REQUEST['username']) && isset($_REQUEST['password']) ){
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $res = $dbh->query("SELECT * FROM usuario WHERE username=? AND password=?;",array($username,$password));
        if( ($dbh->errorInfo()[2])!=null || empty($res[0]) ){
            $view->set("error",true);
        } else {
            $login = false;
            $_SESSION['user'] = $res[0]['id'];
        }
    }
}
if( $login ){
    $view->setTemplate("login.html");
    print $view->getView();
    exit;
}
?>
