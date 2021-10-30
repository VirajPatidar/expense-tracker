<?php 
require "connection.php";
$email = $_SESSION["email"];
$errors = array();

//if user adds new income
if(isset($_POST['add-income'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $new_category = mysqli_real_escape_string($con, $_POST['new-category']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $date = str_replace('-', '/', $date);
    $newDate = date("Y/m/d", strtotime($date));

    if(!$name || !$category || !$amount || !$date){
        $errors['empty-field'] = "Fields must not ne empty!";
    }
    else {
        $id = 0;
        $res = mysqli_query($con, "SELECT MAX(id) AS id FROM income;");
        if(mysqli_num_rows($res) > 0){
            $id_data = mysqli_fetch_array($res);
            $id = $id_data["id"] + 1;
        }
        if($new_category == ""){
            $add_income = "INSERT INTO income VALUES ('$email', $id, '$name', $amount, 0, '$category', '$newDate');";
        }
        else {
            $add_income = "INSERT INTO income VALUES ('$email', $id, '$name', $amount, 0, '$new_category', '$newDate');";
        }
        $run_query = mysqli_query($con, $add_income);
        if($run_query){
            $info = "Income added successfully!";
            $_SESSION['info'] = $info;
            header('Location: income.php');
        }else{
            $errors['db-error'] = "Failed to add income!";
        }
    }
}

//if user deletes income
if(isset($_POST['delete_income'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $new_category = mysqli_real_escape_string($con, $_POST['new-category']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['date']);

    if(!$name || !$category || !$amount || !$date){
        $errors['empty-field'] = "Fields must not ne empty!";
    }
    else {
        $id = 5;
        if($new_category == ""){
            $add_income = "INSERT INTO income VALUES ('$email', $id, '$name', $amount, 0, '$category', '$date');";
        }
        else {
            $add_income = "INSERT INTO income VALUES ('$email', $id, '$name', $amount, 0, '$new_category', '$date');";
        }
        $run_query = mysqli_query($con, $add_income);
        if($run_query){
            $info = "Income added successfully!";
            $_SESSION['info'] = $info;
            header('Location: income.php');
        }else{
            $errors['db-error'] = "Failed to add income!";
        }
    }
}

?>