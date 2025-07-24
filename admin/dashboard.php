<?php session_start();
//error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
	?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Complaint Management System || Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin-responsive.css">
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
            <!-- BEGIN: New Admin Dashboard Section (Assignment & Notebook Tracking) -->
            <div class="col-12">
                <div style="padding: 0 0 32px 0;">
                    <h2 style="color:#0097A7; font-weight:700; margin-bottom: 18px;">Assignment & Notebook Tracking Overview</h2>
                    <!-- Modern Glass Entity & Stat Cards Row -->
                    <div class="row" style="margin-bottom: 24px; gap: 0;">
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#0097A7;">1,200</div>
                                    <div class="stat-label">Students</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">85</div>
                                    <div class="stat-label">Faculty</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#F9B600;">12</div>
                                    <div class="stat-label">Departments</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#0097A7;">24</div>
                                    <div class="stat-label">Courses</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">60</div>
                                    <div class="stat-label">Subjects</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#F9B600;">36</div>
                                    <div class="stat-label">Divisions</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 24px; gap: 0;">
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#0097A7;">120</div>
                                    <div class="stat-label">Assignments</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">110</div>
                                    <div class="stat-label">Notebooks</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">A</div>
                                    <div class="stat-label">Avg. Grade</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#0097A7;">91%</div>
                                    <div class="stat-label">On-Time Rate</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#F9B600;">1.8</div>
                                    <div class="stat-label">Avg. Delay (days)</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">12</div>
                                    <div class="stat-label">Pending Grading</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                    .glass-card {
                        background: rgba(255,255,255,0.18);
                        border-radius: 18px;
                        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
                        border: 1.5px solid rgba(255,255,255,0.35);
                        backdrop-filter: blur(12px);
                        min-height: 110px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .stat-value {
                        font-size: 2.1rem;
                        font-weight: 700;
                    }
                    .stat-label {
                        font-size: 1.05rem;
                        color: #222;
                        font-weight: 600;
                    }
                    </style>
                    <div class="row" style="gap: 0;">
                        <!-- Assignments Stat Card -->
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card flat-card widget-primary-card" style="min-height: 140px;">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body">
                                        <i class="feather icon-file-text"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 id="admin-total-assignments">--</h4>
                                        <h6>Total Assignments</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Notebooks Stat Card -->
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card flat-card bg-warning" style="min-height: 140px;">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body">
                                        <i class="feather icon-book"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 id="admin-total-notebooks">--</h4>
                                        <h6>Total Notebooks</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Assignments Stat Card -->
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card flat-card bg-danger" style="min-height: 140px;">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body">
                                        <i class="feather icon-clock"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 id="admin-pending-assignments">--</h4>
                                        <h6>Pending Assignments</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Overdue Notebooks Stat Card -->
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card flat-card widget-purple-card" style="min-height: 140px;">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body">
                                        <i class="feather icon-alert-triangle"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 id="admin-overdue-notebooks">--</h4>
                                        <h6>Overdue Notebooks</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Graphs Row -->
                    <div class="row" style="margin-top: 8px;">
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card flat-card" style="min-height: 320px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Assignments Status</h5>
                                    <div id="admin-assignments-pie" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card flat-card" style="min-height: 320px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#A41E22; font-weight:600;">Notebooks Status</h5>
                                    <div id="admin-notebooks-pie" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-4 mb-4">
                            <div class="card flat-card" style="min-height: 320px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#102d4a; font-weight:600;">Submission Trends</h5>
                                    <div id="admin-submission-bar" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Per Faculty/Subject Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card flat-card" style="margin-top: 8px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Faculty/Subject Overview</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="background:rgba(255,255,255,0.95);">
                                            <thead style="background:#e0f7fa;">
                                                <tr>
                                                    <th>Faculty</th>
                                                    <th>Subject</th>
                                                    <th>Assignments (Total/Pending/Overdue)</th>
                                                    <th>Notebooks (Total/Pending/Overdue)</th>
                                                    <th>Last Submission</th>
                                                </tr>
                                            </thead>
                                            <tbody id="admin-faculty-table-body">
                                                <!-- Dummy data will be injected by JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Top Students Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card flat-card" style="margin-top: 8px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#A41E22; font-weight:600;">Top Performing Students</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="background:rgba(255,255,255,0.95);">
                                            <thead style="background:#ffe0e0;">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Roll No</th>
                                                    <th>Assignments Submitted</th>
                                                    <th>Notebooks Submitted</th>
                                                    <th>Avg. Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody id="admin-top-students-body">
                                                <!-- Dummy data will be injected by JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Recent Overdue Section -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#A41E22; font-weight:600;">Recent Overdue Items</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#ffe0e0;">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Student</th>
                                                    <th>Subject</th>
                                                    <th>Due Date</th>
                                                    <th>Days Overdue</th>
                                                </tr>
                                            </thead>
                                            <tbody id="admin-recent-overdue-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Upcoming Deadlines Section -->
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Upcoming Deadlines (Next 7 Days)</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#e0f7fa;">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Student</th>
                                                    <th>Subject</th>
                                                    <th>Due Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="admin-upcoming-deadlines-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submission Rate Trends Graph -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#102d4a; font-weight:600;">Submission Rate Trends</h5>
                                    <div id="admin-submission-rate-trend" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Distribution by Department/Semester -->
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Distribution by Department</h5>
                                    <div id="admin-distribution-chart" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Most Delayed Students & Faculty with Most Pending Work -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#A41E22; font-weight:600;">Most Delayed Students</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#ffe0e0;">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Roll No</th>
                                                    <th>Overdue Count</th>
                                                    <th>Avg. Delay (days)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="admin-delayed-students-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Faculty with Most Pending Work</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#e0f7fa;">
                                                <tr>
                                                    <th>Faculty</th>
                                                    <th>Pending Assignments</th>
                                                    <th>Pending Notebooks</th>
                                                </tr>
                                            </thead>
                                            <tbody id="admin-faculty-pending-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Recent Activity Log -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#102d4a; font-weight:600;">Recent Activity Log</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#f7f7f7;">
                                                <tr>
                                                    <th>Time</th>
                                                    <th>User</th>
                                                    <th>Action</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody id="admin-activity-log-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: New Admin Dashboard Section -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>

<!-- Apex Chart -->
<script src="assets/js/plugins/apexcharts.min.js"></script>


<!-- custom-chart js -->
<script src="assets/js/pages/dashboard-main.js"></script>
<script>
    // Dummy data for admin dashboard
    var adminAssignmentStats = {
        total: 120,
        pending: 18,
        submitted: 95,
        overdue: 7
    };
    var adminNotebookStats = {
        total: 110,
        pending: 15,
        submitted: 90,
        overdue: 5
    };
    // Set stat card values
    document.getElementById('admin-total-assignments').textContent = adminAssignmentStats.total;
    document.getElementById('admin-total-notebooks').textContent = adminNotebookStats.total;
    document.getElementById('admin-pending-assignments').textContent = adminAssignmentStats.pending;
    document.getElementById('admin-overdue-notebooks').textContent = adminNotebookStats.overdue;
    // Pie Chart for Assignments
    var adminAssignmentsPie = new ApexCharts(document.querySelector("#admin-assignments-pie"), {
        chart: { type: 'pie', height: 180 },
        series: [adminAssignmentStats.pending, adminAssignmentStats.submitted, adminAssignmentStats.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22'],
        legend: { show: true, fontSize: '15px', position: 'bottom', labels: { colors: ['#222'] } },
        dataLabels: { style: { fontSize: '15px', fontWeight: 'bold' } }
    });
    adminAssignmentsPie.render();
    // Pie Chart for Notebooks
    var adminNotebooksPie = new ApexCharts(document.querySelector("#admin-notebooks-pie"), {
        chart: { type: 'pie', height: 180 },
        series: [adminNotebookStats.pending, adminNotebookStats.submitted, adminNotebookStats.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22'],
        legend: { show: true, fontSize: '15px', position: 'bottom', labels: { colors: ['#222'] } },
        dataLabels: { style: { fontSize: '15px', fontWeight: 'bold' } }
    });
    adminNotebooksPie.render();
    // Submission Trends Bar Chart
    var adminSubmissionBar = new ApexCharts(document.querySelector("#admin-submission-bar"), {
        chart: { type: 'bar', height: 200 },
        series: [
            { name: 'Assignments', data: [20, 30, 25, 45] },
            { name: 'Notebooks', data: [18, 28, 22, 42] }
        ],
        xaxis: { categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], labels: { style: { fontSize: '15px', colors: ['#102d4a'] } } },
        legend: { show: true, fontSize: '15px', position: 'bottom', labels: { colors: ['#222'] } },
        dataLabels: { style: { fontSize: '15px', fontWeight: 'bold' } },
        colors: ['#0097A7', '#F9B600']
    });
    adminSubmissionBar.render();
    // Faculty/Subject Table Dummy Data
    var facultyTableData = [
        { faculty: 'Dr. John Doe', subject: 'Mathematics', assignments: '30/4/1', notebooks: '25/3/0', last: '2024-06-01' },
        { faculty: 'Prof. Jane Smith', subject: 'Science', assignments: '28/3/2', notebooks: '24/2/1', last: '2024-06-02' },
        { faculty: 'Ms. Emily Clark', subject: 'English', assignments: '32/5/2', notebooks: '28/4/1', last: '2024-06-03' },
        { faculty: 'Dr. Alan Brown', subject: 'History', assignments: '30/6/2', notebooks: '33/6/3', last: '2024-06-04' }
    ];
    var facultyTableBody = document.getElementById('admin-faculty-table-body');
    facultyTableData.forEach(function(row) {
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.faculty}</td><td>${row.subject}</td><td>${row.assignments}</td><td>${row.notebooks}</td><td>${row.last}</td>`;
        facultyTableBody.appendChild(tr);
    });
    // Top Students Dummy Data
    var topStudentsData = [
        { name: 'Alice Johnson', roll: 'U2021001', assignments: 28, notebooks: 25, grade: 'A+' },
        { name: 'Bob Lee', roll: 'U2021002', assignments: 27, notebooks: 24, grade: 'A' },
        { name: 'Cathy Smith', roll: 'U2021003', assignments: 26, notebooks: 23, grade: 'A' },
        { name: 'David Brown', roll: 'U2021004', assignments: 25, notebooks: 22, grade: 'A-' }
    ];
    var topStudentsBody = document.getElementById('admin-top-students-body');
    topStudentsData.forEach(function(row) {
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.name}</td><td>${row.roll}</td><td>${row.assignments}</td><td>${row.notebooks}</td><td>${row.grade}</td>`;
        topStudentsBody.appendChild(tr);
    });
    // Quick Stats Dummy Data
    document.getElementById('admin-avg-grade').textContent = 'A';
    document.getElementById('admin-ontime-rate').textContent = '91%';
    document.getElementById('admin-avg-delay').textContent = '1.8';
    document.getElementById('admin-pending-grading').textContent = '12';
    // Recent Overdue Dummy Data
    var recentOverdue = [
        {type:'Assignment', student:'Alice Johnson', subject:'Mathematics', due:'2024-06-01', days:2},
        {type:'Notebook', student:'Bob Lee', subject:'Science', due:'2024-06-02', days:1},
        {type:'Assignment', student:'Cathy Smith', subject:'English', due:'2024-05-30', days:4},
        {type:'Notebook', student:'David Brown', subject:'History', due:'2024-06-01', days:2}
    ];
    var overdueBody = document.getElementById('admin-recent-overdue-body');
    recentOverdue.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.type}</td><td>${row.student}</td><td>${row.subject}</td><td>${row.due}</td><td>${row.days}</td>`;
        overdueBody.appendChild(tr);
    });
    // Upcoming Deadlines Dummy Data
    var upcomingDeadlines = [
        {type:'Assignment', student:'Alice Johnson', subject:'Mathematics', due:'2024-06-07'},
        {type:'Notebook', student:'Bob Lee', subject:'Science', due:'2024-06-06'},
        {type:'Assignment', student:'Cathy Smith', subject:'English', due:'2024-06-05'},
        {type:'Notebook', student:'David Brown', subject:'History', due:'2024-06-04'}
    ];
    var upcomingBody = document.getElementById('admin-upcoming-deadlines-body');
    upcomingDeadlines.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.type}</td><td>${row.student}</td><td>${row.subject}</td><td>${row.due}</td>`;
        upcomingBody.appendChild(tr);
    });
    // Submission Rate Trends Dummy Data
    var adminSubmissionRateTrend = new ApexCharts(document.querySelector("#admin-submission-rate-trend"), {
        chart: { type: 'line', height: 180 },
        series: [
            { name: 'Assignments', data: [12, 18, 22, 25, 30, 28, 35] },
            { name: 'Notebooks', data: [10, 15, 18, 20, 22, 21, 25] }
        ],
        xaxis: { categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] },
        colors: ['#0097A7', '#A41E22']
    });
    adminSubmissionRateTrend.render();
    // Distribution by Department Dummy Data
    var adminDistributionChart = new ApexCharts(document.querySelector("#admin-distribution-chart"), {
        chart: { type: 'donut', height: 180 },
        series: [40, 30, 20, 10],
        labels: ['Science', 'Arts', 'Commerce', 'Engineering'],
        colors: ['#0097A7', '#F9B600', '#A41E22', '#102d4a']
    });
    adminDistributionChart.render();
    // Most Delayed Students Dummy Data
    var delayedStudents = [
        {name:'Eve Adams', roll:'U2021005', count:3, delay:4.2},
        {name:'Frank Green', roll:'U2021006', count:2, delay:3.5},
        {name:'Grace Lee', roll:'U2021007', count:2, delay:3.0},
        {name:'Helen White', roll:'U2021008', count:1, delay:2.8}
    ];
    var delayedBody = document.getElementById('admin-delayed-students-body');
    delayedStudents.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.name}</td><td>${row.roll}</td><td>${row.count}</td><td>${row.delay}</td>`;
        delayedBody.appendChild(tr);
    });
    // Faculty with Most Pending Work Dummy Data
    var facultyPending = [
        {faculty:'Dr. John Doe', assignments:4, notebooks:3},
        {faculty:'Prof. Jane Smith', assignments:3, notebooks:2},
        {faculty:'Ms. Emily Clark', assignments:5, notebooks:4},
        {faculty:'Dr. Alan Brown', assignments:6, notebooks:6}
    ];
    var facultyPendingBody = document.getElementById('admin-faculty-pending-body');
    facultyPending.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.faculty}</td><td>${row.assignments}</td><td>${row.notebooks}</td>`;
        facultyPendingBody.appendChild(tr);
    });
    // Recent Activity Log Dummy Data
    var activityLog = [
        {time:'2024-06-03 10:15', user:'Alice Johnson', action:'Submitted Assignment', details:'Mathematics - Assignment 3'},
        {time:'2024-06-03 09:50', user:'Bob Lee', action:'Graded Notebook', details:'Science - Notebook 2'},
        {time:'2024-06-03 09:30', user:'Cathy Smith', action:'Commented', details:'English - Assignment 2'},
        {time:'2024-06-03 09:10', user:'David Brown', action:'Submitted Notebook', details:'History - Notebook 1'}
    ];
    var activityBody = document.getElementById('admin-activity-log-body');
    activityLog.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.time}</td><td>${row.user}</td><td>${row.action}</td><td>${row.details}</td>`;
        activityBody.appendChild(tr);
    });
    </script>
</body>

</html>
<?php } ?>