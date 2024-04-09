<?php
require_once "src/Controllers/ConnectController.php";

$stmt = $PDOconn->prepare("SELECT M_SKU, SUM(Use_num) AS totalUse FROM material_use GROUP BY M_SKU");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$labels_material_use = array();
$values_material_use = array();
foreach ($result as $row) {
    $labels_material_use[] = $row['M_SKU'];
    $values_material_use[] = $row['totalUse'];
}

$stmt = $PDOconn->prepare("SELECT Project_ID, P_name, P_num FROM project");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$labels_project = array();
$values_project = array();
foreach ($result as $row) {
    $labels_project[] = $row['Project_ID'] . " " . $row['P_name'];
    $values_project[] = $row['P_num'];
}

$startDate = date('Y-m-d', strtotime('-12 months'));
$stmt = $PDOconn->prepare("SELECT DATE_FORMAT(Quot_date, '%Y-%m') AS month_year, SUM(Net_Price) AS totalNetPrice FROM quotation WHERE Quot_date >= :start_date GROUP BY month_year");
$stmt->bindParam(':start_date', $startDate);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$labels_quotation = array();
$values_quotation = array();
for ($i = 0; $i < 12; $i++) {
    $monthYear = date('Y-m', strtotime("-$i months"));
    $date = DateTime::createFromFormat('Y-m', $monthYear);
    $monthName = $date->format('M');
    $formattedDate = $date->format('Y') . ' ' . $monthName;
    $labels_quotation[] = $formattedDate;
    $found = false;
    foreach ($result as $row) {
        if ($row['month_year'] === $monthYear) {
            $values_quotation[] = $row['totalNetPrice'];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $values_quotation[] = 0; // Set totalNetPrice to 0 if no data found for the month
    }
}
// Reverse the array
$labels_quotation = array_reverse($labels_quotation);
$values_quotation = array_reverse($values_quotation);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="public/css/loading.css" type="text/css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="public/css/main.css" type="text/css" />
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    <a class="nav-link " href="department.php">Department</a>
                    <!-- <a class="nav-link" href="department_manager.php">Department-Management</a> -->
                    <a class="nav-link" href="employee.php">Employee</a>
                    <a class="nav-link" href="quotation.php">Quotation</a>
                    <a class="nav-link" href="customer.php">Customer</a>
                    <a class="nav-link" href="project.php">Project</a>
                    <a class="nav-link" href="supplier.php">Supplier</a>
                    <a class="nav-link " href="material.php">Material</a>
                    <a class="nav-link" href="production_order.php">Production-Order</a>
                    <a class="nav-link " href="area-measurement-sheet.php">Area-measurement-sheet</a>
                    <a class="nav-link" href="bill.php">Bill</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="glassmorphism-light shadow my-5 px-4 py-4">
            <h1>Material</h1>
            <canvas id="chart_material" height="100"></canvas>
        </div>
        <div class="glassmorphism-light shadow my-5 px-4 py-4">
            <h1>Project</h1>
            <canvas id="chart_project" height="100"></canvas>
        </div>
    </div>
    <div class="container-fluid">
        <div class="glassmorphism-light shadow my-5 px-4 py-4">
            <h1>Total Net_Price</h1>
            <canvas id="chart_quotation" height="100"></canvas>
        </div>
    </div>
</body>

<script src="public/js/main.js"></script>
<script>
    var labels_material_use = <?php echo json_encode($labels_material_use); ?>;
    var values_material_use = <?php echo json_encode($values_material_use); ?>;

    var ctx = document.getElementById('chart_material').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels_material_use,
            datasets: [{
                label: 'Total Use',
                data: values_material_use,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<script>
    var labels_project = <?php echo json_encode($labels_project); ?>;
    var values_project = <?php echo json_encode($values_project); ?>;

    var ctx = document.getElementById('chart_project').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels_project,
            datasets: [{
                label: 'Total Project Num',
                data: values_project,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<script>
    // JavaScript code to create the chart
    var labels_quotation = <?php echo json_encode($labels_quotation); ?>;
    var values_quotation = <?php echo json_encode($values_quotation); ?>;
    var ctx = document.getElementById('chart_quotation').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels_quotation,
            datasets: [{
                label: 'Total Net Price',
                data: values_quotation,
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

</html>