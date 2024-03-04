<?php
// error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

include('functions.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == 'PUT'){
    $inputData = json_decode(file_get_contents("php://input"), true);
    if(empty($inputData)){
        $updateCustomer = updateCustomer($_POST, $_GET);
    }
    else{
        echo $updateCustomer = updateCustomer($inputData, $_GET);
    }
    echo $updateCustomer;

}else{
    $data = [
        'status' => 405,
        'message' => $requestMethod . " Method not allowed",
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}