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
            background: linear-gradient(135deg, #e0e7ef 0%, #f7f9fb 100%);
            color: #102d4a;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto 0 auto;
            padding: 0 16px 32px 16px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
        }
        .stat-box {
            background: rgba(255,255,255,0.18);
            border-radius: 18px;
            padding: 24px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            border: 1.5px solid rgba(255,255,255,0.35);
            backdrop-filter: blur(12px);
            transition: box-shadow 0.2s, transform 0.2s;
            cursor: pointer;
        }
        .stat-box:focus, .stat-box:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            transform: translateY(-2px) scale(1.03);
            outline: 2px solid #0097A7;
        }
        .stat-box .stat-icon {
            color: #0097A7;
            background: rgba(242,247,250,0.7);
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-right: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
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
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 24px;
        }
        .chart-card {
            background: rgba(255,255,255,0.18);
            border-radius: 18px;
            padding: 16px 8px 24px 8px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            border: 1.5px solid rgba(255,255,255,0.35);
            backdrop-filter: blur(12px);
            max-width: 420px;
            margin-left: auto;
            margin-right: auto;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .chart-card:focus, .chart-card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            transform: translateY(-2px) scale(1.02);
            outline: 2px solid #0097A7;
        }
        .stat-title.mb-3 {
            margin-bottom: 12px;
        }
        .chart-container {
            min-height: 160px;
            max-width: 340px;
            margin: 0 auto;
            background: rgba(255,255,255,0.22);
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            padding: 8px 0;
        }
        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            gap: 8px;
        }
        .breadcrumb-item a, .breadcrumb-item {
            color: #0097A7;
            text-decoration: none;
            font-size: 1rem;
        }
        .breadcrumb-item.active {
            color: #A41E22;
        }
        @media (max-width: 991px) {
            .dashboard-container {
                gap: 20px;
            }
            .chart-card {
                max-width: 100%;
            }
            .chart-container {
                max-width: 100%;
            }
        }
        @media (max-width: 767px) {
            .dashboard-container {
                margin-top: 16px;
            }
            .stat-grid, .charts-grid {
                grid-template-columns: 1fr;
            }
        }
        /* Accessibility: Focus outline for keyboard navigation */
        :focus {
            outline: 2px solid #0097A7 !important;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <!-- [ Header ] start -->
    <?php include('include/header.php');?>
    <!-- [ Header ] end -->
    <div class="dashboard-container">
        <div class="page-header" style="margin-bottom: 0;">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard Analytics</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php" aria-label="Home"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard Analytics</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stat Boxes -->
        <div class="stat-grid" role="region" aria-label="Statistics Overview">
            <!-- Assignments Header -->
            <div style="grid-column: 1 / -1; text-align:left; margin-bottom: 4px; margin-top: 0;">
                <h4 style="margin:0; color:#0097A7; font-weight:700; letter-spacing:1px;">Assignments</h4>
            </div>
            <!-- Assignments Stat Boxes -->
            <div class="stat-box" tabindex="0" aria-label="Total Assignments: 12">
                <div class="stat-icon"><i class="fas fa-file-alt" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Total Assignments</div>
                    <div class="stat-value">12</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Pending Assignments: 3">
                <div class="stat-icon"><i class="fas fa-hourglass-half" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Pending Assignments</div>
                    <div class="stat-value">3</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Submitted Assignments: 8">
                <div class="stat-icon"><i class="fas fa-check-circle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Submitted Assignments</div>
                    <div class="stat-value">8</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Overdue Assignments: 1">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Overdue Assignments</div>
                    <div class="stat-value">1</div>
                </div>
            </div>
            <!-- Notebooks Header -->
            <div style="grid-column: 1 / -1; text-align:left; margin-top: 18px; margin-bottom: 4px;">
                <h4 style="margin:0; color:#A41E22; font-weight:700; letter-spacing:1px;">Notebooks</h4>
            </div>
            <!-- Notebook Stat Boxes -->
            <div class="stat-box" tabindex="0" aria-label="Total Notebooks: 10">
                <div class="stat-icon"><i class="fas fa-book" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Total Notebooks</div>
                    <div class="stat-value">10</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Pending Notebooks: 2">
                <div class="stat-icon"><i class="fas fa-hourglass-half" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Pending Notebooks</div>
                    <div class="stat-value">2</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Submitted Notebooks: 7">
                <div class="stat-icon"><i class="fas fa-check-circle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Submitted Notebooks</div>
                    <div class="stat-value">7</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Overdue Notebooks: 1">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Overdue Notebooks</div>
                    <div class="stat-value">1</div>
                </div>
            </div>
        </div>
        <!-- Graphs Row -->
        <div class="charts-grid" role="region" aria-label="Charts Overview">
            <div class="chart-card" tabindex="0" aria-label="Assignments Overview Pie Chart">
                <h5 class="stat-title mb-3">Assignments Overview</h5>
                <div id="assignmentPieChart" class="chart-container" aria-label="Assignments Pie Chart"></div>
            </div>
            <div class="chart-card" tabindex="0" aria-label="Notebooks Overview Pie Chart">
                <h5 class="stat-title mb-3">Notebooks Overview</h5>
                <div id="notebookPieChart" class="chart-container" aria-label="Notebooks Pie Chart"></div>
            </div>
            <div class="chart-card" tabindex="0" aria-label="Submission Comparison Bar Chart">
                <h5 class="stat-title mb-3">Submission Comparison</h5>
                <div id="submissionBarChart" class="chart-container" aria-label="Submission Bar Chart"></div>
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
    // Dummy data for progress line chart
    var progressData = {
        categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        assignments: [2, 4, 8, 12],
        notebooks: [1, 3, 6, 10]
    };
    // Pie Chart for Assignments
    var assignmentPieOptions = {
        chart: { type: 'pie', height: 180 },
        series: [assignmentData.pending, assignmentData.submitted, assignmentData.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22'],
        legend: {
            show: true,
            fontSize: '15px',
            position: 'bottom',
            labels: { colors: ['#222'] }
        },
        dataLabels: {
            style: { fontSize: '15px', fontWeight: 'bold' }
        },
        accessibility: {
            enabled: true,
            description: 'Pie chart showing assignment status breakdown.'
        }
    };
    var assignmentPieChart = new ApexCharts(document.querySelector("#assignmentPieChart"), assignmentPieOptions);
    assignmentPieChart.render();
    // Pie Chart for Notebooks
    var notebookPieOptions = {
        chart: { type: 'pie', height: 180 },
        series: [notebookData.pending, notebookData.submitted, notebookData.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22'],
        legend: {
            show: true,
            fontSize: '15px',
            position: 'bottom',
            labels: { colors: ['#222'] }
        },
        dataLabels: {
            style: { fontSize: '15px', fontWeight: 'bold' }
        },
        accessibility: {
            enabled: true,
            description: 'Pie chart showing notebook status breakdown.'
        }
    };
    var notebookPieChart = new ApexCharts(document.querySelector("#notebookPieChart"), notebookPieOptions);
    notebookPieChart.render();
    // Bar Chart for Submission Comparison
    var submissionBarOptions = {
        chart: { type: 'bar', height: 200 },
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
            categories: ['Total', 'Pending', 'Submitted', 'Overdue'],
            labels: { style: { fontSize: '15px', colors: ['#102d4a'] } }
        },
        legend: {
            show: true,
            fontSize: '15px',
            position: 'bottom',
            labels: { colors: ['#222'] }
        },
        dataLabels: {
            style: { fontSize: '15px', fontWeight: 'bold' }
        },
        colors: ['#0097A7', '#F9B600'],
        accessibility: {
            enabled: true,
            description: 'Bar chart comparing assignment and notebook submissions.'
        }
    };
    var submissionBarChart = new ApexCharts(document.querySelector("#submissionBarChart"), submissionBarOptions);
    submissionBarChart.render();
    
</script>
</body>

</html>
<?php } ?>