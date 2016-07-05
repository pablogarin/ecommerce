<?php

session_start();

$path = $_SERVER['DOCUMENT_ROOT'];

$path = str_replace('/html','',$path);
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$path);

$classes = $path."/classes";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$classes);

$includes = $path."/includes";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$includes);

$database = $path."/modelos";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$database);

$libs = $path."/html/libs";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$libs);


define('PATH',$path);
define('COOKIE_ID',md5($path));

// INCLUDES
include_once 'View.class.php';
include_once 'install.php';
include_once 'connect.php';
include_once 'model.php';
include_once 'functions.php';
include_once 'CartControl.class.php';
?>
