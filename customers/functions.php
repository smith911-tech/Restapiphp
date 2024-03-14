<?php
require '../includes/dbcon.php';

function error422($message)
{
    $data = [
        'status' => 422,
        'message' =>  $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
}

function storeCustomer($customerInput)
{
    global $con;

    $name = mysqli_real_escape_string($con, $customerInput["name"]);
    $email = mysqli_real_escape_string($con, $customerInput["email"]);
    $phone = mysqli_real_escape_string($con, $customerInput["phone"]);

    if (
        empty(trim($name)) || empty(trim($email)) || empty(trim($phone))
    ) {
        return error422('Method not allowed'); 
    } else {
        $query = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($con, $query);
        if ($result) {
            $data = [
                'status' => 201,
                'message' =>  " Customer created Successfully ",
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => "Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error ");
            return json_encode($data);
        }
    }
}
function updateCustomer($customerInput, $customerParams)
{
    global $con;

    if(!isset($customerParams['id'])){
        return error422('Customer id not found in url');
    }else if(($customerParams['id']) == null){
        return error422('Enter the customer id');
    }

    $customerId = mysqli_real_escape_string($con, $customerParams["id"]);

    $name = mysqli_real_escape_string($con, $customerInput["name"]);
    $email = mysqli_real_escape_string($con, $customerInput["email"]);
    $phone = mysqli_real_escape_string($con, $customerInput["phone"]);

    if (
        empty(trim($name)) || empty(trim($email)) || empty(trim($phone))
    ) {
        return error422('Method not allowed'); 
    } else {
        $query = "UPDATE customers SET name= '$name', email='$email' , phone='$phone' WHERE id='$customerId' LIMIT 2";
        $result = mysqli_query($con, $query);
        if ($result) {
            $data = [
                'status' => 200,
                'message' =>  " Customer Update Successfully ",
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => "Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error ");
            return json_encode($data);
        }
    }
}
function getCustomer($customerParams)
{
    global $con;
    if ($customerParams['id'] == null) {
        return error422('Enter your customer id');
    }
    $customerId = mysqli_real_escape_string($con, $customerParams['id']);
    $query = "SELECT * FROM customers WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($con, $query);
    if($result){
        if (mysqli_num_rows($result) == 1) {
            $customerData = mysqli_fetch_assoc($result);
            return json_encode($customerData);
        } else {
            $data = [
                'status' => 404,
                'message' => "Customer not found",
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else{
        $data = [
            'status' => 500,
            'message' => "Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error ");
        return json_encode($data);
    }
}

function getCustomerList()
{
    global $con;
    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        $data = [
            'status' => 200,
            'message' => "OK",
            'data' => $res,
        ];
        header("HTTP/1.0 200 Ok");
        return json_encode($data);

        if (mysqli_num_rows($query_run) > 0) {
        } else {
            $data = [
                'status' => 404,
                'message' => "No Customer Found",
            ];
            header("HTTP/1.0 404 No Customer Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => "Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error ");
        return json_encode($data);
    }
}

function deleteCustomer($customerParams){
    global $con;
    if (!isset($customerParams['id'])) {
        return error422('Customer id not found in url');
    } else if (($customerParams['id']) == null) {
        return error422('Enter the customer id');
    }
    $customerId = mysqli_real_escape_string($con, $customerParams["id"]);
    $query = "DELETE FROM customers WHERE id='$customerId' LIMIT 1 ";
    $result = mysqli_query($con, $query);
    if($result){
        $data = [
            'status' => 204,
            'message' => "Customer Deleted Successfully",
        ];
        header("HTTP/1.0 200 DELETE ");
        return json_encode($data);
    }else{
        $data = [
            'status' => 404,
            'message' => "Customer Not Found",
        ];
        header("HTTP/1.0 504 Not Found ");
        return json_encode($data);
    }
}