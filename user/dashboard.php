<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id'])==0)
	{
header('location:index.php');
}
else{
	?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assignment Management System || Dashboard</title>
    <link rel="stylesheet" href="../admin/assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="assets/css/user-responsive.css">
    <style>
        body {
            background: #f7f9fb;
            color: #102d4a;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            max-width: 1100px;
            margin: 40px auto 0 auto;
            padding: 0 16px 32px 16px;
        }
        .stat-box {
            background: #fff;
            border-radius: 14px;
            padding: 24px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            box-shadow: none;
            border: none;
            transition: box-shadow 0.2s;
        }
        .stat-box .stat-icon {
            color: #0097A7;
            background: #f2f7fa;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-right: 18px;
        }
        .stat-title {
            color: #222;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .stat-value {
            color: #A41E22;
            font-size: 1.7rem;
            font-weight: 500;
        }
        .stat-info {
            display: flex;
            flex-direction: column;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -12px;
            margin-right: -12px;
        }
        .col-md-6, .col-xl-3, .col-md-12 {
            padding-left: 12px;
            padding-right: 12px;
        }
        .col-md-6 {
            width: 50%;
        }
        .col-xl-3 {
            width: 25%;
        }
        .col-md-12 {
            width: 100%;
        }
        @media (max-width: 991px) {
            .col-xl-3 {
                width: 50%;
            }
        }
        @media (max-width: 767px) {
            .col-md-6, .col-xl-3, .col-md-12 {
                width: 100%;
            }
            .dashboard-container {
                margin-top: 16px;
            }
        }
        .chart-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px 16px;
            margin-bottom: 24px;
            box-shadow: none;
            border: none;
        }
        .stat-title.mb-3 {
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <!-- [ Header ] start -->
    <?php include('include/header.php');?>
    <!-- [ Header ] end -->
    <div class="dashboard-container">
        <div class="page-header" style="margin-bottom: 24px;">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard Analytics</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Assignments Stat Boxes -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Total Assignments</div>
                        <div class="stat-value">12</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Pending Assignments</div>
                        <div class="stat-value">3</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Submitted Assignments</div>
                        <div class="stat-value">8</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Overdue Assignments</div>
                        <div class="stat-value">1</div>
                    </div>
                </div>
            </div>
            <!-- Notebook Stat Boxes -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-book"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Total Notebooks</div>
                        <div class="stat-value">10</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Pending Notebooks</div>
                        <div class="stat-value">2</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Submitted Notebooks</div>
                        <div class="stat-value">7</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Overdue Notebooks</div>
                        <div class="stat-value">1</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Graphs Row -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="chart-card">
                    <h5 class="stat-title mb-3">Assignments Overview</h5>
                    <div id="assignmentPieChart" style="min-height: 220px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <h5 class="stat-title mb-3">Notebooks Overview</h5>
                    <div id="notebookPieChart" style="min-height: 220px;"></div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="chart-card">
                    <h5 class="stat-title mb-3">Submission Comparison</h5>
                    <div id="submissionBarChart" style="min-height: 220px;"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="../admin/assets/js/vendor-all.min.js"></script>
    <script src="../admin/assets/js/plugins/bootstrap.min.js"></script>
    <script src="../admin/assets/js/plugins/apexcharts.min.js"></script>
<script>
    // Dummy data for graphs
    var assignmentData = {
        total: 12,
        pending: 3,
        submitted: 8,
        overdue: 1
    };
    var notebookData = {
        total: 10,
        pending: 2,
        submitted: 7,
        overdue: 1
    };
    // Pie Chart for Assignments
    var assignmentPieOptions = {
        chart: { type: 'pie' },
        series: [assignmentData.pending, assignmentData.submitted, assignmentData.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22']
    };
    var assignmentPieChart = new ApexCharts(document.querySelector("#assignmentPieChart"), assignmentPieOptions);
    assignmentPieChart.render();
    // Pie Chart for Notebooks
    var notebookPieOptions = {
        chart: { type: 'pie' },
        series: [notebookData.pending, notebookData.submitted, notebookData.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22']
    };
    var notebookPieChart = new ApexCharts(document.querySelector("#notebookPieChart"), notebookPieOptions);
    notebookPieChart.render();
    // Bar Chart for Submission Comparison
    var submissionBarOptions = {
        chart: { type: 'bar' },
        series: [
            {
                name: 'Assignments',
                data: [assignmentData.total, assignmentData.pending, assignmentData.submitted, assignmentData.overdue]
            },
            {
                name: 'Notebooks',
                data: [notebookData.total, notebookData.pending, notebookData.submitted, notebookData.overdue]
            }
        ],
        xaxis: {
            categories: ['Total', 'Pending', 'Submitted', 'Overdue']
        },
        colors: ['#0097A7', '#F9B600']
    };
    var submissionBarChart = new ApexCharts(document.querySelector("#submissionBarChart"), submissionBarOptions);
    submissionBarChart.render();
</script>
</body>

</html>
<?php } ?>