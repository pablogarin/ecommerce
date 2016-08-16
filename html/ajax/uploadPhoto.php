<?php
include_once 'common.php';
header("Content-type: application/json; charset=utf-8");
$response = array();
$name = $_FILES['file']['name'];
$tmp = split("\.", $name);
$ext = $tmp[count($tmp)-1];
$name = preg_replace("/\.$ext$/", "", $name);
$response['name'] = date("YmdHis").url_slug($name).".$ext";
$filepath = PATH."/html/assets/tmp/".$response['name'];
$response["filePath"] = "/assets/tmp/".$response['name'];
if( move_uploaded_file($_FILES['file']['tmp_name'],$filepath) ){
    print json_encode($response);
}
?>
