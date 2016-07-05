<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if( !isset($_SESSION['user']) || empty($_SESSION['user']) ){
    require 'login.php';
}
if( isset($_REQUEST['logout']) ){
    session_destroy();
    header("Location: /admin");
}
?>
