<?php 

require_once getcwd()."/../../CompropagoSdk/UnitTest/autoload.php";

use CompropagoSdk\Factory\Factory;
use CompropagoSdk\Client;

$request = @file_get_contents('php://input');

var_dump($request);
/*if(!$resp_webhook = Factory::getInstanceOf('CpOrderInfo', $request)){
    die('Invalid Request');
}

$publickey     = $v1;
$privatekey    = $v2;
$live          = $v3; // si es modo pruebas cambiar por 'false'

try{
    $client = new Client($publickey, $privatekey, $live );

    if($resp_webhook->id == $id_Recibo){
        die("Probando el WebHook?, Ruta correcta.");
    }

    $response = $client->api->verifyOrder($resp_webhook->id);

    switch ($response->type){
        case 'charge.success':
            // TODO: Actions on success payment
            break;
        case 'charge.pending':
            // TODO: Actions on pending payment
            break;
        case 'charge.declined':
            // TODO: Actions on declined payment
            break;
        case 'charge.expired':
            // TODO: Actions on expired payment
            break;
        case 'charge.deleted':
            // TODO: Actions on deleted payment
            break;
        case 'charge.canceled':
            // TODO: Actions on canceled payment
            break;
        default:
            die('Invalid Response type');
    }
}catch (Exception $e) {
    die($e->getMessage());
}*/