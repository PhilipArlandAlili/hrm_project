<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySQL Data to Chart.js</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
</head>

<body>
    <h2>Data from MySQL to Chart.js</h2>

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
    <canvas id="myChart" width="400" height="200"></canvas>

    <script>
        var ctxHorizontalBar = document.getElementById('myChart').getContext('2d');
        var dataHorizontalBar = <?php echo $json_data; ?>;

        var myHorizontalBarChart = new Chart(ctxHorizontalBar, {
            type: 'horizontalBar',
            data: {
                labels: dataHorizontalBar.map(item => item.dept_name),
                datasets: [{
                    label: 'Employee Count',
                    data: dataHorizontalBar.map(item => item.employee_count),
                    backgroundColor: '#4e73df',
                    hoverBackgroundColor: 'rgba(78, 115, 223, 0.8)',
                    borderColor: '#4e73df',
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
</body>
</html>