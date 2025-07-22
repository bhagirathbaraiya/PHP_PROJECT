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
            background: #ffffff;
            color: #102d4a;
        }
        .glass {
            background: rgba(255,255,255,0.5);
            box-shadow: 0 8px 32px 0 #00000033;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1.5px solid #F9B600;
            padding: 24px 20px;
            margin-bottom: 24px;
        }
        .modern-card {
            border-radius: 20px;
            box-shadow: 0 4px 24px 0 #00000033;
            background: #ffffff;
            border: 1px solid #eaeaea;
            padding: 24px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            min-height: 120px;
        }
        .modern-card .card-body {
            font-size: 2.5rem;
            color: #00a6be;
            background: #eaeaea;
            border-radius: 50%;
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }
        .modern-card.bg-danger .card-body {
            color: #cd201f;
            background: #f9b600;
        }
        .modern-card.bg-warning .card-body {
            color: #f8a115;
            background: #eaeaea;
        }
        .modern-card.widget-purple-card .card-body {
            color: #b91ea6;
            background: #eaeaea;
        }
        .modern-card .card-info h4 {
            margin: 0;
            font-size: 2rem;
            color: #102d4a;
        }
        .modern-card .card-info h6 {
            margin: 0;
            color: #757575;
            font-size: 1rem;
            font-weight: 400;
        }
        /* Glassmorphism for chart containers */
        #complaintPieChart, #complaintBarChart {
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 #00000033;
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid #eaeaea;
            padding: 16px;
        }
        /* Responsive tweaks */
        @media (max-width: 767px) {
            .modern-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px 10px;
            }
            .modern-card .card-body {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
        .stat-icon {
            color: #0097A7;
            background: #fff;
            border-radius: 50%;
            border: 2px solid #0097A7;
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-right: 20px;
        }
        .stat-title {
            color: #000000;
            font-weight: 600;
        }
        .stat-value {
            color: #A41E22;
            font-size: 2rem;
        }
    </style>
</head>
<body class="">
	<!-- [ Pre-loader ] start -->
<?php include('include/sidebar.php');?>
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	<?php include('include/header.php');?>
	<!-- [ Header ] end -->
	
	

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
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
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Assignments Stat Boxes -->
            <div class="col-md-6 col-xl-3">
                <div class="glass d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                    <div>
                        <div class="stat-title">Total Assignments</div>
                        <div class="stat-value">12</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="glass d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div>
                        <div class="stat-title">Pending Assignments</div>
                        <div class="stat-value">3</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="glass d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <div class="stat-title">Submitted Assignments</div>
                        <div class="stat-value">8</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="glass d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div>
                        <div class="stat-title">Overdue Assignments</div>
                        <div class="stat-value">1</div>
                    </div>
                </div>
            </div>
            <!-- Notebook Stat Boxes -->
            <div class="col-md-6 col-xl-3">
                <div class="glass d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-book"></i></div>
                    <div>
                        <div class="stat-title">Total Notebooks</div>
                        <div class="stat-value">10</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="glass d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div>
                        <div class="stat-title">Pending Notebooks</div>
                        <div class="stat-value">2</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="glass d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <div class="stat-title">Submitted Notebooks</div>
                        <div class="stat-value">7</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="glass d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div>
                        <div class="stat-title">Overdue Notebooks</div>
                        <div class="stat-value">1</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Graphs Row -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="glass" style="min-height: 320px;">
                    <h5 class="stat-title mb-3">Assignments Overview</h5>
                    <div id="assignmentPieChart" style="min-height: 220px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="glass" style="min-height: 320px;">
                    <h5 class="stat-title mb-3">Notebooks Overview</h5>
                    <div id="notebookPieChart" style="min-height: 220px;"></div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="glass" style="min-height: 320px;">
                    <h5 class="stat-title mb-3">Submission Comparison</h5>
                    <div id="submissionBarChart" style="min-height: 220px;"></div>
                </div>
            </div>
        </div>
            <!-- Latest Customers end -->
        </div>
        <!-- [ Main Content ] end -->
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