<?php require_once "controllerUserData.php"; 
require_once "controllerIncomeData.php";
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

<?php
echo $_POST["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $fetch_info['name'] ?> | Income</title>
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .dataTables_length{
            margin-left: 40px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>
    <br>
    <div class="container">
        <div class="row">
            <p class="h3 mb-3">Income statistics in brief</p>
            <div class="col-3">
                <div class="card border-success mb-3" style="max-width: 18rem;">
                    <div class="card-header h6">This month's income</div>
                    <div class="card-body text-success">
                        <h5 class="card-title"><?php echo date('F Y'); ?></h5>
                        <p class="card-text display-4 text-dark">₹150000</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header h6">Previous month's income</div>
                    <div class="card-body text-primary">
                        <h5 class="card-title"><?php echo date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));?></h5>
                        <p class="card-text display-4 text-dark">₹137000</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-info mb-3" style="max-width: 18rem;">
                    <div class="card-header h6">This year's income</div>
                    <div class="card-body">
                        <h5 class="card-title" style="color: #00acc1"><?php echo date("Y",strtotime("-1 year"));?> - <?php echo date('Y'); ?></h5>
                        <p class="card-text display-4 text-dark">₹1650000</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header h6">% increase from last year</div>
                    <div class="card-body">
                        <h5 class="card-title" style="color: #e65100">Compared to <?php echo date("Y",strtotime("-1 year"));?></h5>
                        <p class="card-text display-4 text-dark">15.3 %</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 mb-2">
                <p class="h3">Graphical Analysis</p>
                <div class="col-6">
                    <div class="card shadow bg-body rounded">
                        <div class="card-body">
                            <canvas id="category" width="600" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card shadow bg-body rounded">
                        <div class="card-body">
                            <canvas id="time" width="600" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5 pt-2">
                <p class="h3">Income records</p>
                <div class="card shadow bg-body rounded" style="width: 100%">
                    <div class="card-body">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="pe-2">Minimum date:</td>
                                    <td><input type="text" id="min" name="min"></td>
                                </tr>
                                <tr>
                                    <td class="pe-2">Maximum date:</td>
                                    <td><input type="text" id="max" name="max"></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <div class="table-responsive">
                            <table id="example"
                                class="table table-bordered text-nowrap text-center table-striped align-middle pt-3">
                                <thead style="background-color: #f1f4fb">
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>
                                            <a href="#create" class="btn p-2" style="height: 2.5em; width: 2.5em; "
                                                data-bs-toggle="modal"><i class="fa fa-lg fa-plus-circle"
                                                    aria-hidden="true"></i></a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $income_data = "SELECT * FROM income";
                                    $res = mysqli_query($con, $income_data);
                                    if (mysqli_num_rows($res) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_array($res)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["name"]; ?></td>
                                                <td><?php echo $row["category"]; ?></td>
                                                <td><?php echo $row["value"]; ?></td>
                                                <td><?php echo $row["date"]; ?></td>
                                                <td>
                                                    <button type="submit" class="btn p-2" style="height: 2.5em; width: 2.5em; "><a href="#edit" data-bs-toggle="modal"><i class="fa fa-lg fa-edit"></i></a></button>
                                                    <button type="submit" class="btn p-2" style="height: 2.5em; width: 2.5em; "><a href="#delete" data-bs-toggle="modal"><i class="fa fa-lg fa-trash"></i></a></button>          
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                      } else {
                                        echo "0 results";
                                      }
                                    ?>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="CreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="CreateLabel">Add Income Record</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <form action="income.php" method="POST" autocomplete="">
                    <div class="form-group row mt-2">
                        <label for="name" class="col-3 col-form-label"><strong>Name</strong></label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="OnSale" class="col-3 col-form-label"><strong>Category</strong></label>
                        <div class="col-9">
                            <select class="form-control" id="role" name="category">
                                <?php
                                $categories = "SELECT DISTINCT category FROM income";
                                $res = mysqli_query($con, $categories);
                                if (mysqli_num_rows($res) > 0) {
                                    while($row = mysqli_fetch_array($res)) {
                                ?>
                                        <option><?php echo $row["category"] ?></option>
                                <?php
                                    }
                                ?>
                                    <option>Other</option>
                                <?php
                                } else {
                                ?>
                                    <option>Create category</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="new-category" class="col-3 col-form-label"><strong>New Category</strong></label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="new-category" name="new-category">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="amount" class="col-3 col-form-label"><strong>Amount</strong></label>
                        <div class="col-9">
                            <input type="int" class="form-control" id="amount" name="amount">
                        </div>
                    </div>
                    <div class="form-group row mt-2 mb-3">
                        <label for="date" class="col-3 col-form-label"><strong>Date</strong></label>
                        <div class="col-9">
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>
                    <div class="form-group row d-flex">
                        <button type="submit" name="add-income" class="btn btn-primary" style="width: 70px">Save</button>
                        <button type="button" class="btn btn-secondary ms-2" style="width: 70px" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="editLabel">Edit Income Record</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <form>
                    <div class="form-group row mt-2">
                        <label for="name" class="col-3 col-form-label"><strong>Name</strong></label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="name">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="OnSale" class="col-3 col-form-label"><strong>Category</strong></label>
                        <div class="col-9">
                            <select class="form-control" id="role">
                                <option>Salary</option>
                                <option>Mutual Fund</option>
                                <option>Crypto</option>
                                <option>Interest</option>
                                <option>Fixed Deposit</option>
                                <option>Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-2 mb-3">
                        <label for="date" class="col-3 col-form-label"><strong>Date</strong></label>
                        <div class="col-9">
                            <input type="date" class="form-control" id="date">
                        </div>
                    </div>
                    <div class="form-group row d-flex">
                        <button type="submit" class="btn btn-primary" style="width: 130px">Save Changes</button>
                        <button type="button" class="btn btn-secondary ms-2" style="width: 70px" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteLabel">Delete Record</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h5>Are you sure you want to delete this record?</h5> <br>
                    <form action="income.php" method="POST" autocomplete="">
                        <div class="form-group row">
                            <div class="col-3 text-nowrap">
                                <button type="submit" name="delete-income" class="btn" style="background-color: #df4b4b; color: #ffffff">Delete User</button>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('category').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mutual Fund', 'Salary', 'Crypto', 'Interest', 'FD', 'Others'],
                datasets: [{
                    label: 'Income source from categories',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: false
            }
        });
    </script>
    <script>
        const ctx2 = document.getElementById('time').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Income over time',
                    data: [20, 19, 33, 20, 32, 32, 40],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: false
            }
        });
    </script>

    <!-- Bootsrap + JQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Blfrtip',
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                iDisplayLength: -1,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>
    <script>
        var minDate, maxDate;
        // $("div.toolbar").html('From <input name="min" id="min" type="date" value="0"> / <input name="max" id="max" type="date" value="0">');
        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date( data[2] );
                // var min_date = document.getElementById("min").value;
                // var min = new Date(min_date);
                // var max_date = document.getElementById("max").value;
                // var max = new Date(max_date);
        
                if (
                    ( min === null && max === null ) ||
                    ( min === null && date <= max ) ||
                    ( min <= date   && max === null ) ||
                    ( min <= date   && date <= max )
                ) {
                    return true;
                }
                return false;
            }
        );
        
        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });
        
            // DataTables initialisation
            var table = $('#example').DataTable();
        
            // Refilter the table
            $('#min, #max').on('change', function () {
                table.draw();
            });
        });
    </script>
</body>
</html>