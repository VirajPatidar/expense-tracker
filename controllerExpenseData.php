<?php 
require "connection.php";
$email = $_SESSION["email"];
$errors = array();

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

//if user adds new income
if(isset($_POST['add-income'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $new_category = mysqli_real_escape_string($con, $_POST['new-category']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['date']);

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

//if user edits income
if(isset($_POST['edit-income'])){

    $id = $_POST["hiddenInput1"];
    console_log($id);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $new_category = mysqli_real_escape_string($con, $_POST['new-category']);
    console_log($new_category);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $email = $_SESSION["email"];

    if(!$id){
        console_log("hello");
        $errors['id-error'] = "ID not found.";
    }
    else {
        if($new_category == ""){
            $edit_income = "UPDATE income SET name='$name', value=$amount, category='$category', date='$date' WHERE email='$email' AND id=$id;";
        }
        else {
            $edit_income = "UPDATE income SET name='$name', value=$amount, category='$new_category', date='$date' WHERE email='$email' AND id=$id;";
        }
        console_log($edit_income);
        $run_query = mysqli_query($con, $edit_income);
        if($run_query){
            $info = "Income edited successfully!";
            $_SESSION['info'] = $info;
            header('Location: income.php');
        }else{
            $errors['db-error'] = "Failed to delete income!";
        }

    }
}

//if user deletes income
if(isset($_POST['delete-income'])){

    $id = $_POST["hiddenInput2"];
    if(!$id){
        $errors['id-error'] = "ID not found.";
    }
    else {
        $delete_income = "DELETE FROM income WHERE id = '$id';";
        $run_query = mysqli_query($con, $delete_income);
        if($run_query){
            $info = "Income deleted successfully!";
            $_SESSION['info'] = $info;
            header('Location: income.php');
        }else{
            $errors['db-error'] = "Failed to delete income!";
        }
    }
}

?>