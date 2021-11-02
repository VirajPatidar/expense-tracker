<?php
    require_once "controllerUserData.php"; 
    require "connection.php";

    header('Content-Type: application/json');

    $data = array();
    $email = $_SESSION["email"];
    for($i=9; $i>=0; $i--) {
        
        $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-$i, 1, date('Y')));
        $date_max = date('Y-m-d', mktime(0, 0, 0, (date('m')-$i+1), 1, date('Y')));
        $query = "SELECT budget, savings FROM budget WHERE email = '$email' AND date >= '$date_min' AND date < '$date_max';";
        $res = mysqli_query($con, $query);
        if(mysqli_num_rows($res) > 0) {
            foreach ($res as $row) {
                $data[] = $row;
            }
        }
        else {
            $data[] = array('budget' => 0, 'savings' => 0);
        }
    }

    echo json_encode($data);
?>