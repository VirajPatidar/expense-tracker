<?php
    require_once "controllerUserData.php"; 
    require "connection.php";

    header('Content-Type: application/json');

    $data = array();
    $email = $_SESSION["email"];
    for($i=6; $i>=0; $i--) {
        
        $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-$i, 1, date('Y')));
        $date_max = date('Y-m-d', mktime(0, 0, 0, (date('m')-$i+1), 1, date('Y')));
        $query = "SELECT sum(value) AS value FROM income WHERE email = '$email' AND date >= '$date_min' AND date < '$date_max';";
        $res = mysqli_query($con, $query);
        foreach ($res as $row) {
            $data[] = $row;
        }
    }

    echo json_encode($data);

?>