<?php

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
header('Content-Type: application/json');

include('functions.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "GET"){
    if(isset($_GET['id'])){
        $customer = getCustomer($_GET);
        echo $customer;
    }
    else{
        $customersList = getCustomerList();
        echo $customersList;
    }

}
else{
    $data = [
        'status' => 405,
        'message' => $requestMethod. " Method not allowed", 
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
