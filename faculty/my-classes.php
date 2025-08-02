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
    <title>My Classes || Assignment & Notebook Tracking System</title>
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
            <!-- BEGIN: My Classes Section -->
            <div class="col-12">
                <div style="padding: 0 0 32px 0;">
                    
                    <!-- Page Header -->
                    <div class="row" style="margin-bottom: 24px;">
                        <div class="col-12">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 style="color:#1abc9c; font-weight:600; margin-bottom: 8px;">My Classes</h4>
                                            <p style="color:#666; margin-bottom: 0;">Manage your classes, view student progress, and track assignments</p>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary" style="background:#1abc9c; border:none; border-radius:12px; padding:10px 20px;">
                                                <i class="feather icon-plus"></i> Add New Class
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Class Overview Stats -->
                    <div class="row" style="margin-bottom: 24px; gap: 0;">
                        <div class="col-md-3 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#0097A7;">12</div>
                                    <div class="stat-label">Total Classes</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#A41E22;">156</div>
                                    <div class="stat-label">Total Students</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#F9B600;">89%</div>
                                    <div class="stat-label">Average Attendance</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card glass-card">
                                <div class="text-center">
                                    <div class="stat-value" style="color:#102d4a;">92%</div>
                                    <div class="stat-label">Submission Rate</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        body{
                            margin-top: 70px;
                            background: linear-gradient(135deg, #e0e7ef 0%, #f7f9fb 100%);
                            color: #102d4a;
                            font-family: 'Segoe UI', Arial, sans-serif;
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
                        transition: box-shadow 0.2s, transform 0.2s;
                    }
                    .glass-card:hover {
                        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
                        transform: translateY(-2px) scale(1.03);
                    }
                    .stat-value {
                        font-size: 2.1rem;
                        font-weight: 700;
                        color: #0097A7;
                    }
                    .stat-label {
                        font-size: 1.05rem;
                        color: #6c757d;
                        font-weight: 600;
                    }
                    .class-card {
                        background: linear-gradient(135deg, #f7f9fb 0%, #e0e7ef 100%);
                        color: #222;
                        border-radius: 18px;
                        padding: 18px 14px 16px 14px;
                        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
                        border: 1.5px solid #e3e8ee;
                        transition: box-shadow 0.2s, transform 0.2s;
                        position: relative;
                        overflow: hidden;
                        min-height: 220px;
                        margin-bottom: 0;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                    }
                    .class-card::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        height: 4px;
                        background: linear-gradient(90deg, #0097A7 0%, #A41E22 100%);
                        border-radius: 18px 18px 0 0;
                    }
                    .class-card:hover {
                        box-shadow: 0 8px 32px rgba(0,0,0,0.14);
                        transform: translateY(-2px) scale(1.03);
                    }
                    .class-card h5 {
                        color: #0097A7;
                        font-weight: 700;
                        margin-bottom: 8px;
                        font-size: 1.18rem;
                        letter-spacing: 0.5px;
                    }
                    .class-card p {
                        color: #6c757d;
                        margin-bottom: 5px;
                        font-size: 0.98rem;
                    }
                    .class-card small {
                        color: #adb5bd;
                        font-size: 0.92rem;
                    }
                    .class-stats {
                        display: flex;
                        justify-content: space-between;
                        margin-top: 15px;
                        flex-wrap: wrap;
                        gap: 8px;
                    }
                    .class-stat {
                        text-align: center;
                        flex: 1;
                        min-width: 80px;
                        background: #fff;
                        border-radius: 10px;
                        box-shadow: 0 1px 6px rgba(0,151,167,0.04);
                        padding: 10px 0 8px 0;
                        margin: 0 2px;
                    }
                    .class-stat-value {
                        font-size: 1.35rem;
                        font-weight: 700;
                        color: #0097A7;
                        margin-bottom: 2px;
                    }
                    .class-stat-label {
                        font-size: 0.92rem;
                        color: #6c757d;
                        font-weight: 500;
                    }
                    .progress-ring {
                        width: 60px;
                        height: 60px;
                        margin: 0 auto;
                        background: #fff;
                        border-radius: 50%;
                        box-shadow: 0 1px 8px rgba(0,151,167,0.07);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .class-card .btn {
                        background: #0097A7;
                        color: white;
                        border: none;
                        border-radius: 8px;
                        padding: 6px 14px;
                        font-size: 0.92rem;
                        font-weight: 500;
                        margin-right: 8px;
                        margin-bottom: 4px;
                        transition: all 0.3s ease;
                        box-shadow: 0 1px 6px rgba(0,151,167,0.07);
                    }
                    .class-card .btn:last-child {
                        margin-right: 0;
                    }
                    .class-card .btn:hover {
                        background: #A41E22;
                        transform: translateY(-1px);
                    }
                    .class-card .btn:focus {
                        box-shadow: 0 0 0 0.2rem rgba(0,151,167,0.18);
                    }
                    .class-graph {
                        background: #fff;
                        border-radius: 12px;
                        box-shadow: 0 1px 8px rgba(0,151,167,0.07);
                        margin-top: 10px;
                        padding: 8px 0;
                    }
                    @media (max-width: 768px) {
                        .class-card {
                            padding: 12px 6px 12px 6px;
                            min-height: 180px;
                        }
                        .class-stats {
                            flex-direction: column;
                            gap: 8px;
                        }
                        .class-stat {
                            min-width: auto;
                            padding: 8px 0 6px 0;
                        }
                        .class-stat-value {
                            font-size: 1.1rem;
                        }
                        .filter-btn {
                            padding: 6px 12px;
                            font-size: 0.9rem;
                            margin-right: 8px;
                            margin-bottom: 8px;
                        }
                    }
                    
                    @media (max-width: 576px) {
                        .pcoded-main-container,
    .pcoded-content,
    .row,
    .col-12,
    .card,
    .flat-card,
    .glass-card {
        margin-right: 0 !important;
        margin-left: 0 !important;
        padding-right: 0 !important;
        padding-left: 0 !important;
        width: 100% !important;
        box-sizing: border-box;
    }
    body {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }
    .class-card {
        padding-right: 4px !important;
        padding-left: 4px !important;
        border-radius: 14px;
    }
                    }
                    </style>

                    <!-- Remove Filter Buttons and Toggle Graphs Button -->
                    <!-- Themed Search Bar -->
                    <div class="row" style="margin-bottom: 20px;">
    <div class="col-12">
        <div class="card flat-card" style="background:rgba(255,255,255,0.18); border-radius:16px;">
            <div class="card-body" style="padding: 18px 18px 10px 18px;">
                <div style="position:relative; max-width:400px; margin:auto;">
                    <input type="text" id="class-searchbar" class="form-control"
                        placeholder="Search classes, subjects, students..."
                        style="border-radius: 16px; padding: 12px 44px 12px 18px; font-size: 1.08rem; background:rgba(255,255,255,0.7); color:#102d4a; border:1.5px solid #0097A7; box-shadow:0 2px 8px rgba(0,151,167,0.07);">
                    <span style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#0097A7; font-size:1.3rem;">
                        <i class="feather icon-search"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

                    <!-- Classes Grid -->
                    <div class="row" id="classes-container">
                        <!-- Class 1: Mathematics -->
                        <div class="col-lg-6 col-xl-4 mb-4 class-item" data-subject="mathematics" data-status="active">
                            <div class="class-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5>Mathematics 101</h5>
                                        <p style="margin-bottom: 5px; color: #6c757d;">Calculus & Algebra</p>
                                        <small style="color: #adb5bd;">Class: 10A | Room: 201</small>
                                    </div>
                                    <div class="progress-ring">
                                        <svg width="60" height="60">
                                            <circle class="bg" cx="30" cy="30" r="27"></circle>
                                            <circle class="progress" cx="30" cy="30" r="27" style="stroke-dashoffset: 37.7;"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="class-stats">
                                    <div class="class-stat">
                                        <div class="class-stat-value">15</div>
                                        <div class="class-stat-label">Students</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">8/12</div>
                                        <div class="class-stat-label">Assignments</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">85%</div>
                                        <div class="class-stat-label">Attendance</div>
                                    </div>
                                </div>
                                <div class="class-graph" style="display:none; min-height:120px;"></div>
                                <div style="margin-top: 15px;">
                                    <button class="btn btn-sm" onclick="viewClassDetails('math101')">View Details</button>
                                    <button class="btn btn-sm" onclick="manageClass('math101')">Manage</button>
                                </div>
                            </div>
                        </div>

                        <!-- Class 2: Physics -->
                        <div class="col-lg-6 col-xl-4 mb-4 class-item" data-subject="physics" data-status="active">
                            <div class="class-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5>Physics 201</h5>
                                        <p style="margin-bottom: 5px; color: #6c757d;">Mechanics & Thermodynamics</p>
                                        <small style="color: #adb5bd;">Class: 11B | Room: 305</small>
                                    </div>
                                    <div class="progress-ring">
                                        <svg width="60" height="60">
                                            <circle class="bg" cx="30" cy="30" r="27"></circle>
                                            <circle class="progress" cx="30" cy="30" r="27" style="stroke-dashoffset: 18.85;"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="class-stats">
                                    <div class="class-stat">
                                        <div class="class-stat-value">18</div>
                                        <div class="class-stat-label">Students</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">10/12</div>
                                        <div class="class-stat-label">Assignments</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">92%</div>
                                        <div class="class-stat-label">Attendance</div>
                                    </div>
                                </div>
                                <div class="class-graph" style="display:none; min-height:120px;"></div>
                                <div style="margin-top: 15px;">
                                    <button class="btn btn-sm" onclick="viewClassDetails('physics201')">View Details</button>
                                    <button class="btn btn-sm" onclick="manageClass('physics201')">Manage</button>
                                </div>
                            </div>
                        </div>

                        <!-- Class 3: Chemistry -->
                        <div class="col-lg-6 col-xl-4 mb-4 class-item" data-subject="chemistry" data-status="active">
                            <div class="class-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5>Chemistry 301</h5>
                                        <p style="margin-bottom: 5px; color: #6c757d;">Organic Chemistry</p>
                                        <small style="color: #adb5bd;">Class: 12A | Room: 401</small>
                                    </div>
                                    <div class="progress-ring">
                                        <svg width="60" height="60">
                                            <circle class="bg" cx="30" cy="30" r="27"></circle>
                                            <circle class="progress" cx="30" cy="30" r="27" style="stroke-dashoffset: 56.55;"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="class-stats">
                                    <div class="class-stat">
                                        <div class="class-stat-value">12</div>
                                        <div class="class-stat-label">Students</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">6/10</div>
                                        <div class="class-stat-label">Assignments</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">78%</div>
                                        <div class="class-stat-label">Attendance</div>
                                    </div>
                                </div>
                                <div class="class-graph" style="display:none; min-height:120px;"></div>
                                <div style="margin-top: 15px;">
                                    <button class="btn btn-sm" onclick="viewClassDetails('chem301')">View Details</button>
                                    <button class="btn btn-sm" onclick="manageClass('chem301')">Manage</button>
                                </div>
                            </div>
                        </div>

                        <!-- Class 4: Biology -->
                        <div class="col-lg-6 col-xl-4 mb-4 class-item" data-subject="biology" data-status="active">
                            <div class="class-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5>Biology 401</h5>
                                        <p style="margin-bottom: 5px; color: #6c757d;">Cell Biology & Genetics</p>
                                        <small style="color: #adb5bd;">Class: 12B | Room: 501</small>
                                    </div>
                                    <div class="progress-ring">
                                        <svg width="60" height="60">
                                            <circle class="bg" cx="30" cy="30" r="27"></circle>
                                            <circle class="progress" cx="30" cy="30" r="27" style="stroke-dashoffset: 9.425;"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="class-stats">
                                    <div class="class-stat">
                                        <div class="class-stat-value">14</div>
                                        <div class="class-stat-label">Students</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">9/10</div>
                                        <div class="class-stat-label">Assignments</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">95%</div>
                                        <div class="class-stat-label">Attendance</div>
                                    </div>
                                </div>
                                <div class="class-graph" style="display:none; min-height:120px;"></div>
                                <div style="margin-top: 15px;">
                                    <button class="btn btn-sm" onclick="viewClassDetails('bio401')">View Details</button>
                                    <button class="btn btn-sm" onclick="manageClass('bio401')">Manage</button>
                                </div>
                            </div>
                        </div>

                        <!-- Class 5: Advanced Mathematics -->
                        <div class="col-lg-6 col-xl-4 mb-4 class-item" data-subject="mathematics" data-status="active">
                            <div class="class-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5>Advanced Math 501</h5>
                                        <p style="margin-bottom: 5px; color: #6c757d;">Linear Algebra & Statistics</p>
                                        <small style="color: #adb5bd;">Class: 12C | Room: 601</small>
                                    </div>
                                    <div class="progress-ring">
                                        <svg width="60" height="60">
                                            <circle class="bg" cx="30" cy="30" r="27"></circle>
                                            <circle class="progress" cx="30" cy="30" r="27" style="stroke-dashoffset: 47.125;"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="class-stats">
                                    <div class="class-stat">
                                        <div class="class-stat-value">10</div>
                                        <div class="class-stat-label">Students</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">7/8</div>
                                        <div class="class-stat-label">Assignments</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">88%</div>
                                        <div class="class-stat-label">Attendance</div>
                                    </div>
                                </div>
                                <div class="class-graph" style="display:none; min-height:120px;"></div>
                                <div style="margin-top: 15px;">
                                    <button class="btn btn-sm" onclick="viewClassDetails('advmath501')">View Details</button>
                                    <button class="btn btn-sm" onclick="manageClass('advmath501')">Manage</button>
                                </div>
                            </div>
                        </div>

                        <!-- Class 6: Physics Lab -->
                        <div class="col-lg-6 col-xl-4 mb-4 class-item" data-subject="physics" data-status="active">
                            <div class="class-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5>Physics Lab 202</h5>
                                        <p style="margin-bottom: 5px; color: #6c757d;">Experimental Physics</p>
                                        <small style="color: #adb5bd;">Class: 11A | Lab: 306</small>
                                    </div>
                                    <div class="progress-ring">
                                        <svg width="60" height="60">
                                            <circle class="bg" cx="30" cy="30" r="27"></circle>
                                            <circle class="progress" cx="30" cy="30" r="27" style="stroke-dashoffset: 28.275;"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="class-stats">
                                    <div class="class-stat">
                                        <div class="class-stat-value">16</div>
                                        <div class="class-stat-label">Students</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">5/6</div>
                                        <div class="class-stat-label">Experiments</div>
                                    </div>
                                    <div class="class-stat">
                                        <div class="class-stat-value">90%</div>
                                        <div class="class-stat-label">Attendance</div>
                                    </div>
                                </div>
                                <div class="class-graph" style="display:none; min-height:120px;"></div>
                                <div style="margin-top: 15px;">
                                    <button class="btn btn-sm" onclick="viewClassDetails('physicslab202')">View Details</button>
                                    <button class="btn btn-sm" onclick="manageClass('physicslab202')">Manage</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Class Details Modal -->
                    <div class="modal fade" id="classDetailsModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Class Details</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="classDetailsContent">
                                    <!-- Content will be loaded dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row" style="margin-top: 24px;">
                        <div class="col-12">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#1abc9c; font-weight:600;">Quick Actions</h5>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <button class="btn btn-outline-primary w-100" style="border-radius: 12px; padding: 15px;">
                                                <i class="feather icon-file-text mr-2"></i>
                                                Create Assignment
                                            </button>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <button class="btn btn-outline-success w-100" style="border-radius: 12px; padding: 15px;">
                                                <i class="feather icon-book mr-2"></i>
                                                Check Notebooks
                                            </button>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <button class="btn btn-outline-warning w-100" style="border-radius: 12px; padding: 15px;">
                                                <i class="feather icon-users mr-2"></i>
                                                Manage Students
                                            </button>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <button class="btn btn-outline-info w-100" style="border-radius: 12px; padding: 15px;">
                                                <i class="feather icon-bar-chart-2 mr-2"></i>
                                                View Reports
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END: My Classes Section -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script src="assets/js/plugins/apexcharts.min.js"></script>

<script>
// Add search functionality
document.getElementById('class-searchbar').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const classItems = document.querySelectorAll('.class-item');
    classItems.forEach(item => {
        // Search in class name, subject, stats, and student names (if present in HTML)
        const text = item.innerText.toLowerCase();
        if (text.includes(query)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});

// View class details
function viewClassDetails(classId) {
    const classData = {
        'math101': {
            name: 'Mathematics 101',
            subject: 'Calculus & Algebra',
            students: 15,
            assignments: 12,
            completed: 8,
            attendance: 85,
            studentsList: [
                {name: 'Alice Johnson', roll: 'U2021001', attendance: 95, assignments: 8, grade: 'A+'},
                {name: 'Bob Lee', roll: 'U2021002', attendance: 88, assignments: 7, grade: 'A'},
                {name: 'Cathy Smith', roll: 'U2021003', attendance: 92, assignments: 8, grade: 'A-'},
                {name: 'David Brown', roll: 'U2021004', attendance: 78, assignments: 6, grade: 'B+'},
                {name: 'Eve Adams', roll: 'U2021005', attendance: 85, assignments: 7, grade: 'A'}
            ]
        },
        'physics201': {
            name: 'Physics 201',
            subject: 'Mechanics & Thermodynamics',
            students: 18,
            assignments: 12,
            completed: 10,
            attendance: 92,
            studentsList: [
                {name: 'Frank Green', roll: 'U2021006', attendance: 94, assignments: 10, grade: 'A+'},
                {name: 'Grace Lee', roll: 'U2021007', attendance: 89, assignments: 9, grade: 'A'},
                {name: 'Helen White', roll: 'U2021008', attendance: 91, assignments: 10, grade: 'A+'},
                {name: 'Ian Black', roll: 'U2021009', attendance: 87, assignments: 8, grade: 'A-'},
                {name: 'Jane Doe', roll: 'U2021010', attendance: 93, assignments: 10, grade: 'A+'}
            ]
        }
    };
    
    const classInfo = classData[classId];
    if (!classInfo) {
        alert('Class details not available');
        return;
    }
    
    let content = `
        <div class="row">
            <div class="col-md-6">
                <h6 style="color:#1abc9c;">Class Information</h6>
                <p><strong>Class Name:</strong> ${classInfo.name}</p>
                <p><strong>Subject:</strong> ${classInfo.subject}</p>
                <p><strong>Total Students:</strong> ${classInfo.students}</p>
                <p><strong>Assignments:</strong> ${classInfo.completed}/${classInfo.assignments}</p>
                <p><strong>Average Attendance:</strong> ${classInfo.attendance}%</p>
            </div>
            <div class="col-md-6">
                <h6 style="color:#1abc9c;">Quick Stats</h6>
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <div style="font-size: 2rem; font-weight: bold; color: #1abc9c;">${Math.round((classInfo.completed/classInfo.assignments)*100)}%</div>
                            <small>Completion Rate</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <div style="font-size: 2rem; font-weight: bold; color: #1abc9c;">${classInfo.attendance}%</div>
                            <small>Attendance</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <h6 style="color:#1abc9c;">Student List</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Attendance</th>
                        <th>Assignments</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    classInfo.studentsList.forEach(student => {
        content += `
            <tr>
                <td>${student.name}</td>
                <td>${student.roll}</td>
                <td>${student.attendance}%</td>
                <td>${student.assignments}/${classInfo.assignments}</td>
                <td><span class="badge badge-${student.grade === 'A+' ? 'success' : student.grade === 'A' ? 'info' : student.grade === 'A-' ? 'warning' : 'secondary'}">${student.grade}</span></td>
            </tr>
        `;
    });
    
    content += `
                </tbody>
            </table>
        </div>
    `;
    
    document.getElementById('classDetailsContent').innerHTML = content;
    $('#classDetailsModal').modal('show');
}

// Manage class function
function manageClass(classId) {
    // This would typically redirect to a class management page
    alert('Opening class management for: ' + classId);
    // window.location.href = 'manage-class.php?id=' + classId;
}

// Toggle graphs visibility
let graphsVisible = false;
document.getElementById('toggle-graphs-btn').addEventListener('click', function() {
    graphsVisible = !graphsVisible;
    document.getElementById('toggle-graphs-label').textContent = graphsVisible ? 'Show Stats' : 'Show Graphs';
    const cards = document.querySelectorAll('.class-card');
    cards.forEach(card => {
        const stats = card.querySelector('.class-stats');
        const graph = card.querySelector('.class-graph');
        if (graphsVisible) {
            stats.style.display = 'none';
            graph.style.display = 'block';
            renderClassGraph(card, graph);
        } else {
            stats.style.display = 'flex';
            graph.style.display = 'none';
        }
    });
});

// Simple graph rendering (replace with Chart.js or ApexCharts for real graphs)
function renderClassGraph(card, graphDiv) {
    // Get stats from the card
    const stats = card.querySelectorAll('.class-stat-value');
    let labels = [];
    let data = [];
    stats.forEach((stat, idx) => {
        labels.push(stat.nextElementSibling.textContent);
        let val = stat.textContent;
        if (val.includes('/')) val = val.split('/')[0];
        if (val.includes('%')) val = val.replace('%','');
        data.push(Number(val));
    });

    // Clear previous chart if exists
    graphDiv.innerHTML = '';
    // Create a unique id for the chart
    const chartId = 'piechart-' + Math.random().toString(36).substr(2, 9);
    graphDiv.id = chartId;

    // Pie chart options
    var options = {
        chart: {
            type: 'pie',
            height: 120
        },
        series: data,
        labels: labels,
        colors: ['#0097A7', '#F9B600', '#A41E22'],
        legend: {
            show: true,
            position: 'bottom',
            fontSize: '13px',
            labels: { colors: ['#222'] }
        },
        dataLabels: {
            style: { fontSize: '13px', fontWeight: 'bold' }
        }
    };
    var chart = new ApexCharts(document.getElementById(chartId), options);
    chart.render();
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here
    console.log('My Classes page loaded');
});
</script>
<style>
#class-searchbar:focus {
    border-color: #A41E22;
    background: #fff;
}
body.dark-mode #class-searchbar {
    background: rgba(30,42,54,0.85);
    color: #fff;
    border-color: #1abc9c;
}
</style>
</body>

</html>
<?php } ?>