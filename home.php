<?php require_once "controllerUserData.php"; ?>
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
                                        <p class="card-text display-6 text-dark">₹110000</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-danger mb-3">
                                    <div class="card-header h6">Previous month's budget</div>
                                    <div class="card-body text-danger">
                                        <h5 class="card-title"><?php echo date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">₹100000</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-success mb-3">
                                    <div class="card-header h6">Previous month's savings<span class="fw-bold">*<span></div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"><?php echo date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">₹30000</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-success mb-3">
                                    <div class="card-header h6">% savings of last month<span class="fw-bold">*<span></div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"><?php echo date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">23.1%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-success mb-3">
                                    <div class="card-header h6">Average savings of last 6 months</div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"><?php echo date('M', mktime(0, 0, 0, date('m')-5, 1, date('Y')));?> to <?php echo date('M Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">₹27000</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card border-success mb-3">
                                    <div class="card-header h6">Total savings of last 6 months</div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"><?php echo date('M', mktime(0, 0, 0, date('m')-5, 1, date('Y')));?> to <?php echo date('M Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?></h5>
                                        <p class="card-text display-6 text-dark">₹180000</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="card-text mt-3 mb-0"><span class="fw-bold">* Previous month's savings</span> = Previous month's budget - Previous month's expenses</p>
                        <p class="card-text mb-0"><span class="fw-bold">* % savings of last month</span> = (Previous month's savings &divide; Previous month's budget) &times; 100</p>
                        <br>

                        <h5 class="mt-1">% of budget spent this month</h5>
                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped bg-dark progress-bar-animated" role="progressbar" style="width: 73%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">73%</div>
                        </div>
                        <br>
                        <a href="#budget" class="btn btn-primary" data-bs-toggle="modal">Set or Change Budget</a>
                    </div>
                    <div class="tab-pane fade" id="nav-income" role="tabpanel" aria-labelledby="nav-income-tab">
                        <h5 class="card-title">Income earned this month: ₹140000</h5>
                        <h5 class="card-title">Average income of last 6 months: ₹130000</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="income.php" class="btn btn-primary">Show detailed income statistics</a>
                    </div>
                    <div class="tab-pane fade" id="nav-expense" role="tabpanel" aria-labelledby="nav-expense-tab">
                        <h5 class="card-title">This month's expenses: ₹80000</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="expense.php" class="btn btn-primary">Show detailed expense statistics</a>
                    </div>
                </div>
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
                    <form>
                        <div class="form-group row mt-2">
                            <label for="budget" class="col-4 col-form-label"><strong>Budget Value</strong></label>
                            <div class="col-8">
                                <input type="number" class="form-control" id="budget">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row d-flex">
                            <button type="submit" class="btn btn-primary" style="width: 70px">Save</button>
                            <button type="button" class="btn btn-secondary ms-2" style="width: 70px" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>