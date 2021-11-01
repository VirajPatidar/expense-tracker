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
    $new_category = "";
    if(isset($_POST["new-category"])) {
        $new_category = mysqli_real_escape_string($con, $_POST['new-category']);
        console_log($new_category);
    }
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $email = $_SESSION["email"];

    if(!$name || !$category || !$amount || !$date){
        $errors['empty-field'] = "Fields must not be empty!";
    }
    else {
        $id = 1;
        $res = mysqli_query($con, "SELECT MAX(id) AS id FROM income;");
        $id_data = mysqli_fetch_array($res);
        if($id_data["id"] != NULL){
            $id = $id_data["id"] + 1;
        }
        if($new_category == ""){
            console_log("new category empty");
            $add_income = "INSERT INTO income VALUES ('$email', $id, '$name', $amount, '$category', '$date');";
        }
        else {
            console_log("new category not empty");
            $add_income = "INSERT INTO income VALUES ('$email', $id, '$name', $amount, '$new_category', '$date');";
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
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $email = $_SESSION["email"];

    if(!$id){
        $errors['id-error'] = "ID not found.";
    }
    else {
        if($new_category == ""){
            $edit_income = "UPDATE income SET name='$name', value=$amount, category='$category', date='$date' WHERE email='$email' AND id=$id;";
        }
        else {
            $edit_income = "UPDATE income SET name='$name', value=$amount, category='$new_category', date='$date' WHERE email='$email' AND id=$id;";
        }
        $run_query = mysqli_query($con, $edit_income);
        if($run_query){
            $info = "Income edited successfully!";
            $_SESSION['info'] = $info;
            header('Location: income.php');
        }else{
            $errors['db-error'] = "Failed to edit income!";
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
        $delete_income = "DELETE FROM income WHERE id = '$id' AND email='$email';";
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

//if user adds new expense
if(isset($_POST['add-expense'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $new_category = "";
    if(isset($_POST["new-category"])) {
        $new_category = mysqli_real_escape_string($con, $_POST['new-category']);
    }
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $email = $_SESSION["email"];

    if(!$name || !$category || !$amount || !$date){
        $errors['empty-field'] = "Fields must not be empty!";
    }
    else {
        $id = 1;
        $res = mysqli_query($con, "SELECT MAX(id) AS id FROM expense;");
        $id_data = mysqli_fetch_array($res);
        if($id_data["id"] != NULL){
            $id = $id_data["id"] + 1;
        }
        if($new_category == ""){
            $add_expense = "INSERT INTO expense VALUES ('$email', $id, '$name', $amount, '$category', '$date');";
        }
        else {
            $add_expense = "INSERT INTO expense VALUES ('$email', $id, '$name', $amount, '$new_category', '$date');";
        }
        $run_query = mysqli_query($con, $add_expense);
        if($run_query){
            $info = "Expense added successfully!";
            $_SESSION['info'] = $info;
            header('Location: expense.php');
        }else{
            $errors['db-error'] = "Failed to add expense!";
        }
    }
}

//if user edits expense
if(isset($_POST['edit-expense'])){

    $id = $_POST["hiddenInput1"];
    console_log($id);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $new_category = mysqli_real_escape_string($con, $_POST['new-category']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $email = $_SESSION["email"];

    if(!$id){
        $errors['id-error'] = "ID not found.";
    }
    else {
        if($new_category == ""){
            $edit_expense = "UPDATE expense SET name='$name', value=$amount, category='$category', date='$date' WHERE email='$email' AND id=$id;";
        }
        else {
            $edit_expense = "UPDATE expense SET name='$name', value=$amount, category='$new_category', date='$date' WHERE email='$email' AND id=$id;";
        }
        $run_query = mysqli_query($con, $edit_expense);
        if($run_query){
            $info = "expense edited successfully!";
            $_SESSION['info'] = $info;
            header('Location: expense.php');
        }else{
            $errors['db-error'] = "Failed to edit expense!";
        }

    }
}

//if user deletes expense
if(isset($_POST['delete-expense'])){

    $id = $_POST["hiddenInput2"];
    if(!$id){
        $errors['id-error'] = "ID not found.";
    }
    else {
        $delete_expense = "DELETE FROM expense WHERE id = '$id' AND email='$email';";
        $run_query = mysqli_query($con, $delete_expense);
        if($run_query){
            $info = "expense deleted successfully!";
            $_SESSION['info'] = $info;
            header('Location: expense.php');
        }else{
            $errors['db-error'] = "Failed to delete expense!";
        }
    }
}

?>