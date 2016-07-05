<?php
include_once 'common.php';
header("Content-type: application/json; charset=utf-8");
$response = array();
$response['name'] = date("YmdHis")."-".$_FILES['file']['name'];
$filepath = PATH."/html/assets/".$response['name'];
if( move_uploaded_file($_FILES['file']['tmp_name'],$filepath) ){
    print json_encode($response);
}
?>
