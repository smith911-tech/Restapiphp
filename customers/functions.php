<?php
require '../includes/dbcon.php';

function error422(){
    $data = [
        'status' => 422,
        'message' =>  " Method not allowed",
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
}

function storeCustomer($customerInput){
    global $con;

    $name = mysqli_real_escape_string($con, $customerInput["name"]);
    $email = mysqli_real_escape_string($con, $customerInput["email"]);
    $phone = mysqli_real_escape_string($con, $customerInput["phone"]);

    if(
        empty(trim($name)) || empty(trim($email)) || empty(trim($phone))
    )
    {
        return error422();
    }else {
        $query = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($con, $query);
        if($result){
            $data = [
                'status' => 201,
                'message' =>  " Customer created Successfully ",
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);
        }else{
            $data = [
                'status' => 500,
                'message' => "Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error ");
            return json_encode($data);
        }
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
        }else{
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
