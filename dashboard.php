<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HRM PROJECT</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('includes/navbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Administration</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">34</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                HRM</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">32</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Finance
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">32</div>
                                                </div>
                                                <div class="col">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Human Resource</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">32</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Employees with leave</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <script
                                            src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
                                        <?php
                                        $mysqli = new mysqli("localhost", "root", "root", "hrm_project");
                                        if ($mysqli->connect_error) {
                                            die("Connection failed: " . $mysqli->connect_error);
                                        }
                                        $result = $mysqli->query("SELECT
                                                                    d.dept_name,
                                                                    COUNT(el.id) AS leave_count
                                                                FROM
                                                                    hrm_project.departments d
                                                                JOIN
                                                                    hrm_project.employees_unitassignments eu ON d.iddepartments = eu.departments_iddepartments
                                                                JOIN
                                                                    hrm_project.employees_has_leave el ON eu.employees_idemployees = el.employees_id
                                                                GROUP BY
                                                                    d.dept_name
                                                                ORDER BY
                                                                    leave_count DESC
                                                                ");
                                        $data = array();
                                        while ($row = $result->fetch_assoc()) {
                                            $data[] = $row;
                                        }
                                        $json_data = json_encode($data);
                                        ?>
                                        <canvas id="myChart" width="300" height="130"></canvas>
                                        <script>
                                            var ctx = document.getElementById('myChart').getContext('2d');
                                            var data = <?php echo $json_data; ?>;
                                            var myChart = new Chart(ctx, {
                                                type: 'bar',
                                                data: {
                                                    labels: data.map(item => item.dept_name),
                                                    datasets: [{
                                                        label: 'Number of Employees with Leave',
                                                        data: data.map(item => item.leave_count),
                                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                        borderColor: 'rgba(75, 192, 192, 1)',
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4" style="height: 95%">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Employees</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <?php
                                        $mysqli = new mysqli("localhost", "root", "root", "hrm_project");

                                        if ($mysqli->connect_error) {
                                            die("Connection failed: " . $mysqli->connect_error);
                                        }
                                        $result = $mysqli->query("SELECT
                                                                    d.dept_name,
                                                                    COUNT(e.idemployees) AS employee_count
                                                                FROM
                                                                    hrm_project.departments d
                                                                JOIN
                                                                    hrm_project.employees_unitassignments eu ON d.iddepartments = eu.departments_iddepartments
                                                                JOIN
                                                                    hrm_project.employees e ON eu.employees_idemployees = e.idemployees
                                                                GROUP BY
                                                                    d.dept_name
                                                                ORDER BY
                                                                    employee_count DESC
                                                                ");
                                        $data = array();

                                        while ($row = $result->fetch_assoc()) {
                                            $data[] = $row;
                                        }
                                        $json_data = json_encode($data);
                                        ?>
                                        <canvas id="employeeChart"></canvas>
                                        <script>
                                            var ctxHorizontalBar = document.getElementById('employeeChart').getContext('2d');
                                            var dataHorizontalBar = <?php echo $json_data; ?>;
                                            var myHorizontalBarChart = new Chart(ctxHorizontalBar, {
                                                type: 'horizontalBar',
                                                data: {
                                                    labels: dataHorizontalBar.map(item => item.dept_name),
                                                    datasets: [{
                                                        label: 'Employee Count',
                                                        data: dataHorizontalBar.map(item => item.employee_count),
                                                        backgroundColor: 'lightgreen',
                                                        borderColor: 'green',
                                                        hoverBackgroundColor: 'rgba(78, 115, 223, 0.8)',
                                                        borderWidth: 1,
                                                    }],
                                                },
                                                options: {
                                                    maintainAspectRatio: false,
                                                    scales: {
                                                        x: {
                                                            display: true,
                                                            title: {
                                                                display: true,
                                                                text: 'Employee Count',
                                                            },
                                                        },
                                                        y: {
                                                            display: true,
                                                            title: {
                                                                display: true,
                                                                text: 'Department Name',
                                                            },
                                                        },
                                                    },
                                                    tooltips: {
                                                        backgroundColor: "rgb(255,255,255)",
                                                        bodyFontColor: "#858796",
                                                        borderColor: '#dddfeb',
                                                        borderWidth: 1,
                                                        xPadding: 15,
                                                        yPadding: 15,
                                                        displayColors: false,
                                                        caretPadding: 10,
                                                    },
                                                    legend: {
                                                        display: true,
                                                    },
                                                },
                                            });
                                        </script>

                                    </div>
                                    <div class="mt-4 text-center small">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>