<?php
require '../includes/dbcon.php';

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
