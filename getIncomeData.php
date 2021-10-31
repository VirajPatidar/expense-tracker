<?php
    require_once "controllerUserData.php"; 
    require "connection.php";

    header('Content-Type: application/json');

    $sqlQuery = "SELECT * from income where email='" . $_SESSION["email"] . "';";

    $result = mysqli_query($con, $sqlQuery);

    $data = array();
    foreach ($result as $row) {
        $data[] = $row;
    }

    echo json_encode($data);

?>