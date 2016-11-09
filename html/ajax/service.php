<?php
require_once("../common.php");
if( isset($_REQUEST['action']) ){
    $cartId = $_COOKIE[COOKIE_ID];
    $cart = new CartControl($cartId);

    $action = $_REQUEST['action'];
    switch( $action ){
    case "add":
        $product = $_REQUEST['product'];
        $quantity = $_REQUEST['quantity'];
        $add = $cart->addProduct($product, $quantity);
        header("Content-type: application/json; charset=utf-8");
        print json_encode(array("ok"=>$add));
        break;
    case "remove":
        $product = $_REQUEST['product'];
        $add = $cart->unsetProduct($product);
        header("Content-type: application/json; charset=utf-8");
        print json_encode(array("ok"=>$add));
        break;
    case "getCart":
        if( isset($_REQUEST['format']) ){
            switch($_REQUEST['format']){
            case 'html':
                print $cart->getSmallView();
                break;
            }
        }
        break;
    case 'setUser':
        if( (isset($_REQUEST['correo'])) && (isset($_REQUEST['nombre'])) && (isset($_REQUEST['apellido'])) && (isset($_REQUEST['fono'])) ){
            if( (!empty($_REQUEST['correo'])) && (!empty($_REQUEST['nombre'])) && (!empty($_REQUEST['apellido'])) && (!empty($_REQUEST['fono'])) ){
                $data = array(
                    "correo" => $_REQUEST['correo'],
                    "correo" => $_REQUEST['correo'],
                    "correo" => $_REQUEST['correo'],
                    "fono" => $_REQUEST['fono']
                );
            } else {
                print json_encode(array("ok"=>false, "message"=>"Debe llenar todos los campos"));
            }
        }
        break;
    case 'costo-comuna':
        if( isset($_REQUEST['zona']) ){
            $zona = $_REQUEST['zona'];
            $cur = $dbh->query("SELECT * FROM costo_despacho WHERE idZona=?;", array($zona));
            if( isset($cur[0]) ){
                print json_encode(array("ok" => true, "costo" => $cur[0]['costo']));
            } else {
                print json_encode(array("ok" => false, "message" => "La comuna seleccionada no está habilitada para el despacho"));
            }
        }
        break;
    case 'modo-pago':
        $id = $_POST['id'];
        $_SESSION['modo-pago'] = $id;
        print json_encode(array("ok"=>true));
        break;
    }
}

?>
