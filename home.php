<?php require_once "controllerUserData.php"; 
require_once "controllerIncomeExpenseData.php";
require "connection.php";
?>
<?php 
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: reset-code.php');
            }
        }else{
            header('Location: user-otp.php');
        }
    }
}else{
    header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $fetch_info['name'] ?> | Portfolio</title>
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        canvas{
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>
    <br>
    <h5 class="ms-3 mb-2 fw-bolder">Welcome <?php echo $fetch_info['name'] ?>,</h5>
    <br>
    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-budget-tab" data-bs-toggle="tab" data-bs-target="#nav-budget" type="button" role="tab" aria-controls="nav-budget" aria-selected="true">Budget & Savings</button>
                        <button class="nav-link" id="nav-income-tab" data-bs-toggle="tab" data-bs-target="#nav-income" type="button" role="tab" aria-controls="nav-income" aria-selected="false">Income</button>
                        <button class="nav-link" id="nav-expense-tab" data-bs-toggle="tab" data-bs-target="#nav-expense" type="button" role="tab" aria-controls="nav-expense" aria-selected="false">Expenses</button>
                    </div>
                </nav>
            </div>

            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-budget" role="tabpanel" aria-labelledby="nav-budget-tab">
                        <div class="row mt-2">
                            <div class="col-2">
                                <div class="card border-danger mb-3">
                                    <div class="card-header h6">Current Monthly Budget</div>
                                    <div class="card-body text-danger">
                                        <h5 class="card-title"><?php echo date('F Y'); ?></h5>
                                        <p class="card-text display-6 text-dark">
                                            <?php
                                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                                            $query = "SELECT budget FROM budget WHERE email = '" . $_SESSION['email'] . "' AND date >= '$date_min';";
                                            $res = mysqli_query($con, $query);
                                            if (mysqli_num_rows($res) > 0) {
                                                $res_data = mysqli_fetch_array($res);
                                                if($res_data["budget"] != NULL)
                                                    echo "₹" . $res_data["budget"];
                                                else
                                                    echo "₹0";
                                            }
                                            else
                                                echo "₹0";
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-danger mb-3">
                                    <div class="card-header h6">Previous month's budget</div>
                                    <div class="card-body text-danger">
                                        <h5 class="card-title"><?php echo date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">
                                            <?php
                                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-1, 1, date('Y')));
                                            $date_max = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                                            $query = "SELECT budget FROM budget WHERE email = '" . $_SESSION['email'] . "' AND date >= '$date_min' AND date < '$date_max';";
                                            $res = mysqli_query($con, $query);
                                            if (mysqli_num_rows($res) > 0) {
                                                $res_data = mysqli_fetch_array($res);
                                                if($res_data["budget"] != NULL)
                                                    echo "₹" . $res_data["budget"];
                                                else
                                                    echo "₹0";
                                            }
                                            else
                                                echo "₹0";
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-success mb-3">
                                    <div class="card-header h6">Previous month's savings<span class="fw-bold">*<span></div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"><?php echo date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">
                                            <?php
                                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-1, 1, date('Y')));
                                            $date_max = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                                            $query = "SELECT savings FROM budget WHERE email = '" . $_SESSION['email'] . "' AND date >= '$date_min' AND date < '$date_max';";
                                            $res = mysqli_query($con, $query);
                                            if (mysqli_num_rows($res) > 0) {
                                                $res_data = mysqli_fetch_array($res);
                                                if($res_data["savings"] != NULL)
                                                    echo "₹" . $res_data["savings"];
                                                else
                                                    echo "₹0";
                                            }
                                            else
                                                echo "₹0";
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-success mb-3">
                                    <div class="card-header h6">% savings last month<span class="fw-bold">*<span></div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"><?php echo date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">
                                            <?php
                                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-1, 1, date('Y')));
                                            $date_max = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                                            $query = "SELECT savings, budget FROM budget WHERE email = '" . $_SESSION['email'] . "' AND date >= '$date_min' AND date < '$date_max';";
                                            $res = mysqli_query($con, $query);
                                            if (mysqli_num_rows($res) > 0) {
                                                $res_data = mysqli_fetch_array($res);
                                                if($res_data["budget"] == 0)
                                                    echo '-';
                                                else {
                                                    $perc = ($res_data["savings"] / $res_data["budget"]) * 100;
                                                    $perc = number_format((float)$perc, 2, '.', '');
                                                    echo $perc . "%";
                                                }
                                            }
                                            else {
                                                echo '0%';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-success mb-3">
                                    <div class="card-header h6">Average savings of last 6 months</div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"><?php echo date('M', mktime(0, 0, 0, date('m')-5, 1, date('Y')));?> to <?php echo date('M Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">
                                            <?php
                                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-6, 1, date('Y')));
                                            $date_max = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                                            $query = "SELECT AVG(savings) AS savings FROM budget WHERE email = '" . $_SESSION['email'] . "' AND date >= '$date_min' AND date < '$date_max';";
                                            $res = mysqli_query($con, $query);
                                            if (mysqli_num_rows($res) > 0) {
                                                $res_data = mysqli_fetch_array($res);
                                                $savings = number_format((float)$res_data["savings"], 2, '.', '');
                                                if($res_data["savings"] != NULL)
                                                    echo "₹" . $savings;
                                                else
                                                    echo "₹0";
                                            }
                                            else
                                                echo "₹0";
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-success mb-3">
                                    <div class="card-header h6">Total savings of last 6 months</div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"><?php echo date('M', mktime(0, 0, 0, date('m')-5, 1, date('Y')));?> to <?php echo date('M Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">
                                            <?php
                                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-6, 1, date('Y')));
                                            $date_max = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                                            $query = "SELECT SUM(savings) AS savings FROM budget WHERE email = '" . $_SESSION['email'] . "' AND date >= '$date_min' AND date < '$date_max';";
                                            $res = mysqli_query($con, $query);
                                            if (mysqli_num_rows($res) > 0) {
                                                $res_data = mysqli_fetch_array($res);
                                                $savings = $res_data["savings"];
                                                if($res_data["savings"] != NULL)
                                                    echo "₹" . $savings;
                                                else
                                                    echo "₹0";
                                            }
                                            else
                                                echo "₹0";
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="card-text mt-3 mb-0"><span class="fw-bold">* Previous month's savings</span> = Previous month's budget - Previous month's expenses</p>
                        <p class="card-text mb-0"><span class="fw-bold">* % savings of last month</span> = (Previous month's savings &divide; Previous month's budget) &times; 100</p>
                        <br>

                        <h5 class="mt-1">% of budget spent this month</h5>
                        <div class="progress mb-3" style="height: 20px;">
                            <?php
                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                            $res = mysqli_query($con, "SELECT budget FROM budget WHERE date>='$date_min' AND email='" . $_SESSION['email'] . "';");
                            if (mysqli_num_rows($res) > 0) {
                                $res_data = mysqli_fetch_array($res);
                                $budget = $res_data["budget"];
                                $get_expense = "SELECT SUM(value) AS amount FROM expense WHERE date >= '$date_min' AND email = '" . $_SESSION['email'] . "'";
                                $expense = mysqli_query($con, $get_expense);
                                $expense_data = mysqli_fetch_array($expense);
                                if($expense_data["amount"] == NULL) {
                                    $expense_data["amount"] = 0;
                                }
                                $perc = ($expense_data["amount"] / $budget) * 100;
                            }
                            else {
                                echo "* Budget not set !";
                                $perc = 0;
                            }
                            ?>
                            <div class="progress-bar" role="progressbar" style="width: <?= $perc ?>%; background-color:#1a237e !important;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <?= $perc ?>%
                            </div>
                        </div>
                        <br>
                        <a href="#budget" class="btn btn-primary" data-bs-toggle="modal">Set or Change Budget</a>
                    </div>


                    <div class="tab-pane fade" id="nav-income" role="tabpanel" aria-labelledby="nav-income-tab">
                        <div class="card border-primary" style="width: 23rem;">
                            <div class="card-body">
                                <h5 class="card-title mb-0">
                                    Income earned this month: 
                                    <?php
                                        $date_min = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                                        $query = "SELECT SUM(value) as amount FROM income WHERE email = '" . $_SESSION['email'] . "' AND date >= '$date_min';";
                                        $res = mysqli_query($con, $query);
                                        if (mysqli_num_rows($res) > 0) {
                                            $res_data = mysqli_fetch_array($res);
                                            if($res_data["amount"] != NULL)
                                                echo "₹" . $res_data["amount"];
                                            else
                                                echo "₹0";
                                        }
                                        else
                                            echo "₹0";
                                    ?>
                                </h5>
                            </div>
                        </div>
                        <br>
                        <h5 class="card-title">Last 10 income entries</h5>
                        <table class="table table-striped table-hover table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $income_data = "SELECT * FROM income where email = '" . $_SESSION['email'] . "' ORDER BY date DESC LIMIT 10;";
                                    $res = mysqli_query($con, $income_data);
                                    if (mysqli_num_rows($res) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_array($res)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["name"]; ?></td>
                                                <td><?php echo $row["category"]; ?></td>
                                                <td><?php echo $row["date"]; ?></td>
                                                <td><?php echo $row["value"]; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } 
                                    else
                                        echo "0 results";
                                    ?>
                            </tbody>
                        </table>
                        <a href="income.php" class="btn btn-primary">Show detailed income statistics</a>
                    </div>


                    <div class="tab-pane fade" id="nav-expense" role="tabpanel" aria-labelledby="nav-expense-tab">
                        <div class="card border-danger" style="width: 21rem;">
                            <div class="card-body">
                                <h5 class="card-title mb-0">
                                    This month's expenses: 
                                    <?php
                                        $date_min = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                                        $query = "SELECT SUM(value) as amount FROM expense WHERE email = '" . $_SESSION['email'] . "' AND date >= '$date_min';";
                                        $res = mysqli_query($con, $query);
                                        if (mysqli_num_rows($res) > 0) {
                                            $res_data = mysqli_fetch_array($res);
                                            if($res_data["amount"] != NULL)
                                                echo "₹" . $res_data["amount"];
                                            else
                                                echo "₹0";
                                        }
                                        else
                                            echo "₹0";
                                    ?>
                                </h5>
                            </div>
                        </div>
                        <br>
                        <h5 class="card-title">Last 10 expense entries</h5>
                        <table class="table table-striped table-hover table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $expense_data = "SELECT * FROM expense where email = '" . $_SESSION['email'] . "' ORDER BY date DESC LIMIT 10;";
                                    $res = mysqli_query($con, $expense_data);
                                    if (mysqli_num_rows($res) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_array($res)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["name"]; ?></td>
                                                <td><?php echo $row["category"]; ?></td>
                                                <td><?php echo $row["date"]; ?></td>
                                                <td><?php echo $row["value"]; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } 
                                    else
                                        echo "0 results";
                                    ?>
                            </tbody>
                        </table>
                        <a href="expense.php" class="btn btn-primary">Show detailed expense statistics</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>

    <div class="container mb-5">
        <h5 class="mb-2">Graphical Analysis: Income Vs Expense</h5>
        <div class="card shadow bg-body rounded">
            <div class="card-body">
                <canvas id="income-expense" width="1200" height="600" style="margin: 0 auto;"></canvas>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <h5 class="mb-2">Graphical Analysis: Budget Vs Savings</h5>
        <div class="card shadow bg-body rounded">
            <div class="card-body">
                <canvas id="budget-savings" width="1200" height="600" style="margin: 0 auto;"></canvas>
            </div>
        </div>
    </div>

    <!--Budget Modal-->
    <div class="modal fade" id="budget" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editLabel">Set or change Budget</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="home.php", method="POST">
                        <div class="form-group row mt-2">
                            <label for="budget" class="col-4 col-form-label"><strong>Budget Value</strong></label>
                            <div class="col-8">
                                <input type="number" class="form-control" id="budget" name="budget">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row d-flex">
                            <button type="submit" class="btn btn-primary" style="width: 70px" name="set-budget">Save</button>
                            <button type="button" class="btn btn-secondary ms-2" style="width: 70px" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>


    <!-- Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootsrap + JQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        // const ctx = document.getElementById('income-expense').getContext('2d');
        // const myChart1 = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        //         datasets: [
        //             { 
        //                 data: [48200, 75000, 41100, 50200, 63500, 60900, 94700, 62000, 88000, 71000, 41000, 67000],
        //                 label: "Income",
        //                 borderColor: "#3e95cd",
        //                 fill: false
        //             }, 
        //             { 
        //                 data: [38600, 81400, 50600, 40600, 10700, 71100, 73300, 60600, 50600, 70700, 63500, 60900],
        //                 label: "Expense",
        //                 borderColor: "#8e5ea2",
        //                 fill: false
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: false,
        //         plugins: {
        //             title: {
        //                 display: true,
        //                 text: 'Income Vs Expenses over time (1 Year)',
        //             },
        //             scales: {
        //                 y: {
        //                     suggestedMin: 1000,
        //                     suggestedMax: 100000
        //                 }
        //             }
        //         },
        //     }
        // });
    </script>
    <script>
        $(document).ready(function () {
            showLineGraph();
        });

        function showLineGraph() 
        {
            $.post("getIncomeExpenseGraphData.php",
            function (data)
            {
                let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                let currentMonth = new Date().getMonth();
                var income_values = [];
                var expense_values = [];
                var label = [];
                var tempMonth = "";
                for(var i=0; i<10; i++) {
                    tempMonth = (currentMonth - i + 12 ) % 12;
                    label.push(months[tempMonth]);
                }
                label.reverse();
                for (var i in data) {
                    income_values.push(data[i][0]);
                    expense_values.push(data[i][1]);
                }
                var chartdata = {
                    labels: label,
                    datasets: [
                    { 
                        data: income_values,
                        label: "Income",
                        borderColor: "#3e95cd",
                        fill: false
                    }, 
                    { 
                        data: expense_values,
                        label: "Expense",
                        borderColor: "#8e5ea2",
                        fill: false
                    }
                ]
                };
                var graphTarget = $("#income-expense");
                var lineGraph = new Chart(graphTarget, {
                    type: 'line',
                    data: chartdata
                });
            });
        }
    </script>
    <script>
        // const ctx2 = document.getElementById('budget-savings').getContext('2d');
        // const myChart2 = new Chart(ctx2, {
        //     type: 'bar',
        //     data: {
        //         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        //         datasets: [
        //             { 
        //                 label: "Budget",
        //                 data: [48200, 75000, 41100, 50200, 63500, 60900, 94700, 62000, 88000, 71000, 41000, 67000],
        //                 borderColor: "#3e95cd",
        //                 backgroundColor: "#3e95cd",
        //             }, 
        //             { 
        //                 label: "Savings",
        //                 data: [38600, 81400, 50600, 40600, 10700, 71100, 73300, 60600, 50600, 70700, 63500, 60900],
        //                 borderColor: "#8e5ea2",
        //                 backgroundColor: "#8e5ea2",
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: false,
        //         plugins: {
        //             title: {
        //                 display: true,
        //                 text: 'Budget Vs Savings over time (1 Year)',
        //             },
        //             scales: {
        //                 y: {
        //                     suggestedMin: 1000,
        //                     suggestedMax: 100000
        //                 }
        //             }
        //         },
        //     }
        // });
    </script>
    <script>
        $(document).ready(function () {
            showBarGraph();
        });

        function showBarGraph() 
        {
            $.post("getBudgetSavingsGraphData.php",
            function (data)
            {
                console.log(data);
                let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                let currentMonth = new Date().getMonth();
                var budget_values = [];
                var savings_values = [];
                var label = [];
                var tempMonth = "";
                for(var i=0; i<10; i++) {
                    tempMonth = (currentMonth - i + 12 ) % 12;
                    label.push(months[tempMonth]);
                }
                label.reverse();
                for (var i in data) {
                    budget_values.push(data[i]['budget']);
                    savings_values.push(data[i]['savings']);
                }
                console.log(budget_values);
                console.log(savings_values);
                var chartdata = {
                    labels: label,
                    datasets: [
                    { 
                        data: budget_values,
                        label: "Income",
                        borderColor: "#3e95cd",
                        backgroundColor: "#3e95cd",
                    }, 
                    { 
                        data: savings_values,
                        label: "Expense",
                        borderColor: "#8e5ea2",
                        backgroundColor: "#8e5ea2",
                    }
                ]
                };
                var graphTarget = $("#budget-savings");
                var lineGraph = new Chart(graphTarget, {
                    type: 'bar',
                    data: chartdata
                });
            });
        }
    </script>

</body>
</html>