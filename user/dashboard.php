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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/user-responsive.css">
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
            <div class="col-md-6">
                <div id="complaintPieChart" style="min-height: 300px;"></div>
            </div>
            <div class="col-md-6">
                <div id="complaintBarChart" style="min-height: 300px;"></div>
            </div>
           
        
              <div class="col-md-12 col-xl-6">
                
                <!-- widget-success-card start -->
                <div class="card flat-card widget-primary-card">
                    <div class="row-table">
                        <div class="col-sm-4 card-body">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="col-sm-9">
                           <?php 
$uid=$_SESSION['id'];
$query5=mysqli_query($con,"select complaintNumber from tblcomplaints where userId='$uid'");
$totcom=mysqli_num_rows($query5);
?>
                            <h4><?php echo $totcom;?></h4>
                            <h6>Total Assignments</h6>
                        </div>
                    </div>
                </div>
                <!-- widget-success-card end -->
            </div>
              <div class="col-md-12 col-xl-6">
                
                <!-- widget-success-card start -->
                <div class="card flat-card bg-danger">
                    <div class="row-table">
                        <div class="col-sm-4 card-body">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="col-sm-9">
<?php 
$query5=mysqli_query($con,"select complaintNumber from tblcomplaints where userId='$uid' and status is null");
$newcom=mysqli_num_rows($query5);
?>
                            <h4><?php echo $newcom;?></h4>
                            <h6>Pending Assignments</h6>
                        </div>
                    </div>
                </div>
                <!-- widget-success-card end -->
            </div>
              <div class="col-md-12 col-xl-6">
                
                <!-- widget-success-card start -->
                <div class="card flat-card bg-warning">
                    <div class="row-table">
                        <div class="col-sm-3 card-body">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="col-sm-9">
<?php 
$query5=mysqli_query($con,"select complaintNumber from tblcomplaints where userId='$uid' and status='in process'");
$inprocesscom=mysqli_num_rows($query5);
?>
                            <h4><?php echo $inprocesscom;?></h4>
                            <h6>Inprocess Assignments</h6>
                        </div>
                    </div>
                </div>

                <!-- widget-success-card end -->
            </div>
              <div class="col-md-12 col-xl-6">
                
                <!-- widget-success-card start -->
                <div class="card flat-card widget-purple-card">
                    <div class="row-table">
                        <div class="col-sm-3 card-body">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="col-sm-9">
<?php 
$query5=mysqli_query($con,"select complaintNumber from tblcomplaints where userId='$uid' and status='closed'");
$closedcom=mysqli_num_rows($query5);
?>
                            <h4><?php echo $closedcom;?></h4>
                            <h6>Closed Assignments</h6>
                        </div>
                    </div>
                </div>
                
                <!-- widget-success-card end -->
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
    var total = <?php echo $totcom; ?>;
    var pending = <?php echo $newcom; ?>;
    var inprocess = <?php echo $inprocesscom; ?>;
    var closed = <?php echo $closedcom; ?>;
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Pie Chart
    var pieOptions = {
        chart: { type: 'pie' },
        series: [pending, inprocess, closed],
        labels: ['Pending', 'In Process', 'Closed'],
        colors: ['#dc3545', '#ffc107', '#6f42c1']
    };
    var pieChart = new ApexCharts(document.querySelector("#complaintPieChart"), pieOptions);
    pieChart.render();

    // Bar Chart
    var barOptions = {
        chart: { type: 'bar' },
        series: [{
            name: 'Complaints',
            data: [total, pending, inprocess, closed]
        }],
        xaxis: {
            categories: ['Total', 'Pending', 'In Process', 'Closed']
        },
        colors: ['#007bff']
    };
    var barChart = new ApexCharts(document.querySelector("#complaintBarChart"), barOptions);
    barChart.render();
});
</script>
</body>

</html>
<?php } ?>