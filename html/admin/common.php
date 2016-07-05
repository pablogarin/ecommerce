<?php
error_reporting(E_ALL);
ini_set('display_errors',True);
include_once '../common.php';
$sections = $path."/html/admin/sections";
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$sections);

$view = new View();
$view->setFolder(PATH."/html/admin/templates");
