<?php session_start();
//error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
	?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Faculty Dashboard || Assignment & Notebook Tracking System</title>
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
        
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- BEGIN: Faculty Dashboard Section (Assignment & Notebook Tracking) -->
            <div class="col-12">
                <div style="padding: 0 0 32px 0;">
                    
                    <!-- Faculty Overview Stats -->
                    <div class="row" style="margin-bottom: 24px; gap: 0;">
                        <div class="col-md-3 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#0097A7;">45</div>
                                    <div class="stat-label">My Students</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">4</div>
                                    <div class="stat-label">My Subjects</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#F9B600;">12</div>
                                    <div class="stat-label">Active Classes</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#102d4a;">8</div>
                                    <div class="stat-label">Pending Reviews</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment & Notebook Tracking Stats -->
                    <div class="row" style="margin-bottom: 24px; gap: 0;">
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#0097A7;">28</div>
                                    <div class="stat-label">Total Assignments</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">25</div>
                                    <div class="stat-label">Total Notebooks</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#F9B600;">5</div>
                                    <div class="stat-label">Pending Assignments</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#102d4a;">3</div>
                                    <div class="stat-label">Pending Notebooks</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">2</div>
                                    <div class="stat-label">Overdue Items</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#0097A7;">92%</div>
                                    <div class="stat-label">Submission Rate</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        body{
                            margin-top: 70px;
                        }
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
                    .subject-card {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        border-radius: 15px;
                        padding: 20px;
                        margin-bottom: 20px;
                        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
                    }
                    .progress-ring {
                        width: 80px;
                        height: 80px;
                        margin: 0 auto;
                    }
                    .progress-ring circle {
                        fill: none;
                        stroke-width: 8;
                        stroke-linecap: round;
                    }
                    .progress-ring .bg {
                        stroke: rgba(255,255,255,0.2);
                    }
                    .progress-ring .progress {
                        stroke: #fff;
                        stroke-dasharray: 251.2;
                        stroke-dashoffset: 251.2;
                        transition: stroke-dashoffset 0.5s ease;
                    }
                    </style>

                    <!-- Main Tracking Cards -->
                    <div class="row" style="gap: 0;">
                        <!-- Assignments Tracking Card -->
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card flat-card widget-primary-card" style="min-height: 140px;">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body">
                                        <i class="feather icon-file-text"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 id="faculty-total-assignments">28</h4>
                                        <h6>Total Assignments</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Notebooks Tracking Card -->
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card flat-card bg-warning" style="min-height: 140px;">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body">
                                        <i class="feather icon-book"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 id="faculty-total-notebooks">25</h4>
                                        <h6>Total Notebooks</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Assignments Card -->
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card flat-card bg-danger" style="min-height: 140px;">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body">
                                        <i class="feather icon-clock"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 id="faculty-pending-assignments">5</h4>
                                        <h6>Pending Assignments</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Overdue Items Card -->
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card flat-card widget-purple-card" style="min-height: 140px;">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body">
                                        <i class="feather icon-alert-triangle"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 id="faculty-overdue-items">2</h4>
                                        <h6>Overdue Items</h6>
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
                                    <div id="faculty-assignments-pie" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card flat-card" style="min-height: 320px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#A41E22; font-weight:600;">Notebooks Status</h5>
                                    <div id="faculty-notebooks-pie" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-4 mb-4">
                            <div class="card flat-card" style="min-height: 320px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#102d4a; font-weight:600;">Weekly Submission Trends</h5>
                                    <div id="faculty-submission-bar" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Performance Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card flat-card" style="margin-top: 8px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Student Performance Overview</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="background:rgba(255,255,255,0.95);">
                                            <thead style="background:#e0f7fa;">
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Roll No</th>
                                                    <th>Subject</th>
                                                    <th>Assignments (Submitted/Total)</th>
                                                    <th>Notebooks (Submitted/Total)</th>
                                                    <th>Average Grade</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="faculty-student-table-body">
                                                <!-- Data will be injected by JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Submissions & Upcoming Deadlines -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#A41E22; font-weight:600;">Recent Submissions</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#ffe0e0;">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Student</th>
                                                    <th>Subject</th>
                                                    <th>Submission Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="faculty-recent-submissions-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                    <th>Days Left</th>
                                                </tr>
                                            </thead>
                                            <tbody id="faculty-upcoming-deadlines-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Analytics -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#102d4a; font-weight:600;">Submission Rate Trends</h5>
                                    <div id="faculty-submission-rate-trend" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Grade Distribution</h5>
                                    <div id="faculty-grade-distribution" style="min-height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Performers & Need Attention -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#A41E22; font-weight:600;">Top Performing Students</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#ffe0e0;">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Roll No</th>
                                                    <th>Subject</th>
                                                    <th>Avg. Grade</th>
                                                    <th>Completion Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody id="faculty-top-performers-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Students Needing Attention</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#e0f7fa;">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Roll No</th>
                                                    <th>Subject</th>
                                                    <th>Missing Items</th>
                                                    <th>Last Activity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="faculty-need-attention-body"></tbody>
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
                                                    <th>Student</th>
                                                    <th>Action</th>
                                                    <th>Subject</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody id="faculty-activity-log-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Faculty Dashboard Section -->
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
    // Faculty-specific data for assignment and notebook tracking
    var facultyAssignmentStats = {
        total: 28,
        pending: 5,
        submitted: 20,
        overdue: 3,
        graded: 18
    };
    var facultyNotebookStats = {
        total: 25,
        pending: 3,
        submitted: 22,
        overdue: 2,
        graded: 20
    };

    // Set stat card values
    document.getElementById('faculty-total-assignments').textContent = facultyAssignmentStats.total;
    document.getElementById('faculty-total-notebooks').textContent = facultyNotebookStats.total;
    document.getElementById('faculty-pending-assignments').textContent = facultyAssignmentStats.pending;
    document.getElementById('faculty-overdue-items').textContent = facultyAssignmentStats.overdue + facultyNotebookStats.overdue;

    // Pie Chart for Assignments
    var facultyAssignmentsPie = new ApexCharts(document.querySelector("#faculty-assignments-pie"), {
        chart: { type: 'pie', height: 180 },
        series: [facultyAssignmentStats.pending, facultyAssignmentStats.submitted, facultyAssignmentStats.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22'],
        legend: { show: true, fontSize: '12px', position: 'bottom', labels: { colors: ['#222'] } },
        dataLabels: { style: { fontSize: '12px', fontWeight: 'bold' } }
    });
    facultyAssignmentsPie.render();

    // Pie Chart for Notebooks
    var facultyNotebooksPie = new ApexCharts(document.querySelector("#faculty-notebooks-pie"), {
        chart: { type: 'pie', height: 180 },
        series: [facultyNotebookStats.pending, facultyNotebookStats.submitted, facultyNotebookStats.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22'],
        legend: { show: true, fontSize: '12px', position: 'bottom', labels: { colors: ['#222'] } },
        dataLabels: { style: { fontSize: '12px', fontWeight: 'bold' } }
    });
    facultyNotebooksPie.render();

    // Weekly Submission Trends Bar Chart
    var facultySubmissionBar = new ApexCharts(document.querySelector("#faculty-submission-bar"), {
        chart: { type: 'bar', height: 200 },
        series: [
            { name: 'Assignments', data: [5, 8, 12, 6, 9, 4, 7] },
            { name: 'Notebooks', data: [4, 6, 10, 5, 8, 3, 6] }
        ],
        xaxis: { categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], labels: { style: { fontSize: '12px', colors: ['#102d4a'] } } },
        legend: { show: true, fontSize: '12px', position: 'bottom', labels: { colors: ['#222'] } },
        dataLabels: { style: { fontSize: '10px', fontWeight: 'bold' } },
        colors: ['#0097A7', '#F9B600']
    });
    facultySubmissionBar.render();

    // Student Performance Table Data
    var studentTableData = [
        { name: 'Alice Johnson', roll: 'U2021001', subject: 'Mathematics', assignments: '8/10', notebooks: '7/8', grade: 'A+', status: 'Excellent' },
        { name: 'Bob Lee', roll: 'U2021002', subject: 'Physics', assignments: '9/12', notebooks: '8/10', grade: 'A', status: 'Good' },
        { name: 'Cathy Smith', roll: 'U2021003', subject: 'Chemistry', assignments: '6/10', notebooks: '5/8', grade: 'B+', status: 'Average' },
        { name: 'David Brown', roll: 'U2021004', subject: 'Biology', assignments: '7/10', notebooks: '6/8', grade: 'A-', status: 'Good' },
        { name: 'Eve Adams', roll: 'U2021005', subject: 'Mathematics', assignments: '5/10', notebooks: '4/8', grade: 'B', status: 'Needs Attention' }
    ];
    var studentTableBody = document.getElementById('faculty-student-table-body');
    studentTableData.forEach(function(row) {
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.name}</td><td>${row.roll}</td><td>${row.subject}</td><td>${row.assignments}</td><td>${row.notebooks}</td><td>${row.grade}</td><td><span class="badge badge-${row.status === 'Excellent' ? 'success' : row.status === 'Good' ? 'info' : row.status === 'Average' ? 'warning' : 'danger'}">${row.status}</span></td>`;
        studentTableBody.appendChild(tr);
    });

    // Recent Submissions Data
    var recentSubmissions = [
        {type:'Assignment', student:'Alice Johnson', subject:'Mathematics', date:'2024-06-03', status:'Submitted'},
        {type:'Notebook', student:'Bob Lee', subject:'Physics', date:'2024-06-03', status:'Submitted'},
        {type:'Assignment', student:'Cathy Smith', subject:'Chemistry', date:'2024-06-02', status:'Late'},
        {type:'Notebook', student:'David Brown', subject:'Biology', date:'2024-06-02', status:'Submitted'}
    ];
    var submissionsBody = document.getElementById('faculty-recent-submissions-body');
    recentSubmissions.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.type}</td><td>${row.student}</td><td>${row.subject}</td><td>${row.date}</td><td><span class="badge badge-${row.status === 'Submitted' ? 'success' : 'warning'}">${row.status}</span></td>`;
        submissionsBody.appendChild(tr);
    });

    // Upcoming Deadlines Data
    var upcomingDeadlines = [
        {type:'Assignment', student:'Alice Johnson', subject:'Mathematics', due:'2024-06-07', days:4},
        {type:'Notebook', student:'Bob Lee', subject:'Physics', due:'2024-06-06', days:3},
        {type:'Assignment', student:'Cathy Smith', subject:'Chemistry', due:'2024-06-05', days:2},
        {type:'Notebook', student:'David Brown', subject:'Biology', due:'2024-06-04', days:1}
    ];
    var deadlinesBody = document.getElementById('faculty-upcoming-deadlines-body');
    upcomingDeadlines.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.type}</td><td>${row.student}</td><td>${row.subject}</td><td>${row.due}</td><td><span class="badge badge-${row.days <= 1 ? 'danger' : row.days <= 3 ? 'warning' : 'info'}">${row.days} days</span></td>`;
        deadlinesBody.appendChild(tr);
    });

    // Submission Rate Trends
    var facultySubmissionRateTrend = new ApexCharts(document.querySelector("#faculty-submission-rate-trend"), {
        chart: { type: 'line', height: 180 },
        series: [
            { name: 'Assignments', data: [85, 88, 92, 89, 94, 91, 95] },
            { name: 'Notebooks', data: [82, 85, 88, 86, 90, 87, 92] }
        ],
        xaxis: { categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'] },
        colors: ['#0097A7', '#A41E22'],
        yaxis: { labels: { formatter: function(val) { return val + '%'; } } }
    });
    facultySubmissionRateTrend.render();

    // Grade Distribution
    var facultyGradeDistribution = new ApexCharts(document.querySelector("#faculty-grade-distribution"), {
        chart: { type: 'donut', height: 180 },
        series: [25, 35, 20, 15, 5],
        labels: ['A+', 'A', 'B+', 'B', 'C'],
        colors: ['#28a745', '#17a2b8', '#ffc107', '#fd7e14', '#dc3545']
    });
    facultyGradeDistribution.render();

    // Top Performers Data
    var topPerformers = [
        {name:'Alice Johnson', roll:'U2021001', subject:'Mathematics', grade:'A+', rate:'95%'},
        {name:'Bob Lee', roll:'U2021002', subject:'Physics', grade:'A', rate:'92%'},
        {name:'David Brown', roll:'U2021004', subject:'Biology', grade:'A-', rate:'88%'},
        {name:'Cathy Smith', roll:'U2021003', subject:'Chemistry', grade:'B+', rate:'85%'}
    ];
    var performersBody = document.getElementById('faculty-top-performers-body');
    topPerformers.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.name}</td><td>${row.roll}</td><td>${row.subject}</td><td>${row.grade}</td><td>${row.rate}</td>`;
        performersBody.appendChild(tr);
    });

    // Students Needing Attention Data
    var needAttention = [
        {name:'Eve Adams', roll:'U2021005', subject:'Mathematics', missing:3, last:'2024-05-28'},
        {name:'Frank Green', roll:'U2021006', subject:'Physics', missing:2, last:'2024-05-29'},
        {name:'Grace Lee', roll:'U2021007', subject:'Chemistry', missing:4, last:'2024-05-27'},
        {name:'Helen White', roll:'U2021008', subject:'Biology', missing:1, last:'2024-05-30'}
    ];
    var attentionBody = document.getElementById('faculty-need-attention-body');
    needAttention.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.name}</td><td>${row.roll}</td><td>${row.subject}</td><td>${row.missing}</td><td>${row.last}</td>`;
        attentionBody.appendChild(tr);
    });

    // Recent Activity Log Data
    var activityLog = [
        {time:'2024-06-03 10:15', student:'Alice Johnson', action:'Submitted Assignment', subject:'Mathematics', details:'Assignment 3 - Calculus'},
        {time:'2024-06-03 09:50', student:'Bob Lee', action:'Graded Notebook', subject:'Physics', details:'Notebook 2 - Mechanics'},
        {time:'2024-06-03 09:30', student:'Cathy Smith', action:'Late Submission', subject:'Chemistry', details:'Assignment 2 - Organic Chemistry'},
        {time:'2024-06-03 09:10', student:'David Brown', action:'Submitted Notebook', subject:'Biology', details:'Notebook 1 - Cell Biology'}
    ];
    var activityBody = document.getElementById('faculty-activity-log-body');
    activityLog.forEach(function(row){
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.time}</td><td>${row.student}</td><td>${row.action}</td><td>${row.subject}</td><td>${row.details}</td>`;
        activityBody.appendChild(tr);
    });
    </script>
</body>

</html>
<?php } ?>