<?php
    require_once "controllerUserData.php"; 
    require "connection.php";

    header('Content-Type: application/json');

    $sqlQuery = "SELECT SUM(value) AS value, category from income where email='" . $_SESSION["email"] . "' GROUP BY category;";

    $result = mysqli_query($con, $sqlQuery);

    $data = array();
    foreach ($result as $row) {
        $data[] = $row;
    }

    echo json_encode($data);

?>