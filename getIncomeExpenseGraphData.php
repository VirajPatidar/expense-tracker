<?php
    require_once "controllerUserData.php"; 
    require "connection.php";

    header('Content-Type: application/json');

    $data = array();
    $email = $_SESSION["email"];
    for($i=9; $i>=0; $i--) {
        
        $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-$i, 1, date('Y')));
        $date_max = date('Y-m-d', mktime(0, 0, 0, (date('m')-$i+1), 1, date('Y')));

        $query = "SELECT sum(value) AS value FROM income WHERE email = '$email' AND date >= '$date_min' AND date < '$date_max';"; 
        $res = mysqli_query($con, $query);
        $res_data = mysqli_fetch_array($res);
        $data[9-$i][0] = $res_data["value"];

        $query = "SELECT sum(value) AS value FROM expense WHERE email = '$email' AND date >= '$date_min' AND date < '$date_max';";
        $res = mysqli_query($con, $query);
        $res_data = mysqli_fetch_array($res);
        $data[9-$i][1] = $res_data["value"];
    }

    echo json_encode($data);
?>