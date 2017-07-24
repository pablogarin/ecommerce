<?php

session_start();

$path = $_SERVER['DOCUMENT_ROOT'];

$path = str_replace('/html','',$path);
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$path);

$classes = $path."/classes";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$classes);

$modelos = $path."/modelos";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$modelos);

$controllers = $path."/controllers";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$controllers);

$includes = $path."/includes";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$includes);

$libs = $path."/html/libs";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$libs);

$webpay = $path."/libwebpay";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$webpay);


define('PATH',$path);
define('COOKIE_ID',md5($path));
define('USER_COOKIE_ID',md5($path."user"));

// INCLUDES
include_once 'View.class.php';
include_once 'install.php';
include_once 'connect.php';
include_once 'model.php';
include_once 'functions.php';
include_once 'CartControl.class.php';
include_once 'OrdenCompra.class.php';
include_once 'Controller.class.php';

?>
