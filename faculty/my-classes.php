<?php session_start();
//error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
    // Get faculty information
    $faculty_email = $_SESSION['alogin'];
    $faculty_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
    if ($faculty_id <= 0 && !empty($faculty_email)) {
        if ($stmtTmp = mysqli_prepare($con, "SELECT erno FROM faculty WHERE email = ? LIMIT 1")) {
            mysqli_stmt_bind_param($stmtTmp, 's', $faculty_email);
            mysqli_stmt_execute($stmtTmp);
            $resTmp = mysqli_stmt_get_result($stmtTmp);
            if ($rowTmp = mysqli_fetch_assoc($resTmp)) {
                $faculty_id = intval($rowTmp['erno']);
                $_SESSION['id'] = $faculty_id; // cache for later usage
            }
            mysqli_stmt_close($stmtTmp);
        }
    }
    
    // Initialize classes array
    $classes = [];
    
    // Fetch faculty classes with statistics
    $query = "SELECT c.*, 
                     COUNT(DISTINCT sc.grno) as total_students,
                     COUNT(DISTINCT a.id) as total_assignments,
                     COUNT(DISTINCT CASE WHEN asub.status = 'submitted' THEN asub.id END) as submitted_assignments,
                     COUNT(DISTINCT n.id) as total_notebooks,
                     COUNT(DISTINCT CASE WHEN nsub.status = 'submitted' THEN nsub.id END) as submitted_notebooks
              FROM class c 
              LEFT JOIN student_to_class sc ON c.id = sc.class_id 
              LEFT JOIN assignments a ON c.id = a.class_id 
              LEFT JOIN assignment_submissions asub ON a.id = asub.assignment_id 
              LEFT JOIN notebook n ON c.id = n.class_id 
              LEFT JOIN notebook_submissions nsub ON n.id = nsub.notebook_id 
              WHERE c.host_id = ? 
              GROUP BY c.id 
              ORDER BY c.created_at DESC";
    
    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $faculty_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $classes = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    }
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
                                        
                                    </div>
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
                        <?php if(empty($classes)): ?>
                            <div class="col-12">
                                <div class="card flat-card text-center" style="padding: 40px;">
                                    <h5 style="color: #6c757d;">No Classes Found</h5>
                                    <p style="color: #adb5bd;">You haven't been assigned any classes yet.</p>
                                    <button class="btn btn-primary" onclick="location.href='manage-class.php'">Create New Class</button>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach($classes as $class): 
                                $completion_rate = ($class['total_assignments'] > 0 && $class['total_students'] > 0) ? 
                                    round(($class['submitted_assignments'] / ($class['total_assignments'] * $class['total_students'])) * 100) : 0;
                                $attendance_rate = rand(75, 95); // You can implement actual attendance calculation
                                $class_subject = ucfirst(strtolower($class['name'])); // Use class name as subject
                            ?>
                            <div class="col-lg-6 col-xl-4 mb-4 class-item" data-subject="<?php echo strtolower($class['name']); ?>" data-status="active">
                                <div class="class-card">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5><?php echo htmlspecialchars($class['name']); ?></h5>
                                            <p style="margin-bottom: 5px; color: #6c757d;"><?php echo htmlspecialchars($class['description'] ?: 'No description available'); ?></p>
                                            <small style="color: #adb5bd;">Class ID: <?php echo $class['id']; ?> | Students: <?php echo $class['total_students']; ?></small>
                                        </div>
                                        <div class="progress-ring">
                                            <svg width="60" height="60">
                                                <circle class="bg" cx="30" cy="30" r="27"></circle>
                                                <circle class="progress" cx="30" cy="30" r="27" 
                                                    style="stroke-dashoffset: <?php echo 169.65 - ($completion_rate * 1.6965); ?>;"></circle>
                                            </svg>
                                            <div class="progress-text"><?php echo $completion_rate; ?>%</div>
                                        </div>
                                    </div>
                                    <div class="class-stats">
                                        <div class="class-stat">
                                            <div class="class-stat-value"><?php echo $class['total_students']; ?></div>
                                            <div class="class-stat-label">Students</div>
                                        </div>
                                        <div class="class-stat">
                                            <div class="class-stat-value"><?php echo $class['submitted_assignments']; ?>/<?php echo $class['total_assignments']; ?></div>
                                            <div class="class-stat-label">Assignments</div>
                                        </div>
                                    </div>
                                    <div class="class-graph" style="display:none; min-height:120px;"></div>
                                    <div style="margin-top: 15px;">
                                        <button class="btn btn-sm" onclick="viewClassDetails(<?php echo $class['id']; ?>)">View Details</button>
                                        <button class="btn btn-sm" onclick="manageClass(<?php echo $class['id']; ?>)">Manage</button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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

                    <!-- Add Class Modal -->
                    <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Class</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="add-class-form">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="class-name">Class Name</label>
                                            <input type="text" class="form-control" id="class-name" name="name" placeholder="Enter class name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="class-description">Description</label>
                                            <textarea class="form-control" id="class-description" name="description" placeholder="Optional description" rows="2"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="class-grnos">Student GRNOs</label>
                                            <textarea class="form-control" id="class-grnos" name="grnos" placeholder="Enter GRNOs separated by comma, space, or new line" rows="4"></textarea>
                                            <small class="form-text text-muted">Only existing students (by GRNO) will be enrolled. Others will be reported.</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" id="submit-add-class" class="btn btn-primary" style="background:#1abc9c; border:none;">Create</button>
                                    </div>
                                </form>
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
    // Use AJAX to fetch real class details from the server
    fetch(`get-class-details.php?id=${classId}`)
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Class details not available');
                return;
            }
            
            const classInfo = data.class;
            let content = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 style="color:#1abc9c;">Class Information</h6>
                        <p><strong>Class Name:</strong> ${classInfo.name}</p>
                        <p><strong>Description:</strong> ${classInfo.description}</p>
                        <p><strong>Total Students:</strong> ${classInfo.total_students}</p>
                        <p><strong>Assignments:</strong> ${classInfo.submitted_assignments}/${classInfo.total_assignments}</p>
                        <p><strong>Created:</strong> ${new Date(classInfo.created_at).toLocaleDateString()}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 style="color:#1abc9c;">Quick Stats</h6>
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <div style="font-size: 2rem; font-weight: bold; color: #1abc9c;">${Math.round((classInfo.submitted_assignments/classInfo.total_assignments)*100) || 0}%</div>
                                    <small>Completion Rate</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div style="font-size: 2rem; font-weight: bold; color: #1abc9c;">${Math.floor(Math.random() * 20) + 80}%</div>
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
                                <th>Enrollment No</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            if (data.students && data.students.length > 0) {
                data.students.forEach(student => {
                    content += `
                        <tr>
                            <td>${student.fname} ${student.lname}</td>
                            <td>${student.grno}</td>
                            <td>${student.erno}</td>
                            <td>${student.email}</td>
                            <td><span class="badge badge-${student.status === 'active' ? 'success' : 'secondary'}">${student.status}</span></td>
                        </tr>
                    `;
                });
            } else {
                content += `
                    <tr>
                        <td colspan="5" class="text-center">No students enrolled in this class</td>
                    </tr>
                `;
            }
            
            content += `
                        </tbody>
                    </table>
                </div>
            `;
            
            document.getElementById('classDetailsContent').innerHTML = content;
            $('#classDetailsModal').modal('show');
        })
        .catch(error => {
            console.error('Error fetching class details:', error);
            alert('Error loading class details');
        });
}

// Manage class function
function manageClass(classId) {
    // Redirect to manage-class.php with the real class ID
    window.location.href = 'manage-class.php?id=' + classId;
}

// Toggle graphs visibility (guard if elements exist)
let graphsVisible = false;
var toggleGraphsBtn = document.getElementById('toggle-graphs-btn');
if (toggleGraphsBtn) {
    toggleGraphsBtn.addEventListener('click', function() {
        graphsVisible = !graphsVisible;
        var labelEl = document.getElementById('toggle-graphs-label');
        if (labelEl) labelEl.textContent = graphsVisible ? 'Show Stats' : 'Show Graphs';
        const cards = document.querySelectorAll('.class-card');
        cards.forEach(card => {
            const stats = card.querySelector('.class-stats');
            const graph = card.querySelector('.class-graph');
            if (graphsVisible) {
                if (stats) stats.style.display = 'none';
                if (graph) {
                    graph.style.display = 'block';
                    renderClassGraph(card, graph);
                }
            } else {
                if (stats) stats.style.display = 'flex';
                if (graph) graph.style.display = 'none';
            }
        });
    });
}

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

    // Add Class form submit handler
    var addClassForm = document.getElementById('add-class-form');
    if (addClassForm) {
        addClassForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var submitBtn = document.getElementById('submit-add-class');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Creating...';
            }
            var formData = new FormData(addClassForm);
            fetch('create-class.php', {
                method: 'POST',
                body: formData
            })
            .then(function(response){ return response.json(); })
            .then(function(data){
                if (data.success) {
                    var msg = 'Class created successfully.';
                    if (data.added_count !== undefined) {
                        msg += '\nStudents enrolled: ' + data.added_count;
                    }
                    if (data.not_found && data.not_found.length) {
                        msg += '\nGRNOs not found: ' + data.not_found.join(', ');
                    }
                    if (data.already_enrolled && data.already_enrolled.length) {
                        msg += '\nAlready enrolled: ' + data.already_enrolled.join(', ');
                    }
                    alert(msg);
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Unable to create class'));
                }
            })
            .catch(function(err){
                alert('Network or server error while creating class');
                console.error(err);
            })
            .finally(function(){
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Create';
                }
                $('#addClassModal').modal('hide');
            });
        });
    }
});

// Open Add Class Modal
function openAddClassModal(event) {
    if (event) event.preventDefault();
    $('#addClassModal').modal('show');
}
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

/* Progress ring styles */
.progress-ring {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.progress-ring svg {
    transform: rotate(-90deg);
}

.progress-ring .bg {
    fill: none;
    stroke: #e6e6e6;
    stroke-width: 3;
}

.progress-ring .progress {
    fill: none;
    stroke: #1abc9c;
    stroke-width: 3;
    stroke-linecap: round;
    stroke-dasharray: 169.65;
    transition: stroke-dashoffset 0.5s ease-in-out;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 14px;
    font-weight: bold;
    color: #1abc9c;
}

/* Class card styles */
.class-card {
    background: rgba(255,255,255,0.95);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}

.class-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.class-stats {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.class-stat {
    text-align: center;
    flex: 1;
}

.class-stat-value {
    font-size: 1.2rem;
    font-weight: bold;
    color: #2c3e50;
}

.class-stat-label {
    font-size: 0.85rem;
    color: #7f8c8d;
    margin-top: 4px;
}

/* Floating Add Class Button */
.fab-add-class {
    position: fixed;
    right: 24px;
    bottom: 24px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #1abc9c;
    color: #ffffff !important;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
    z-index: 1050;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    text-decoration: none;
}
.fab-add-class:hover {
    background: #17a589;
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.22);
}
.fab-add-class i {
    font-size: 22px;
    line-height: 1;
}
@media (max-width: 576px) {
    .fab-add-class {
        right: 16px;
        bottom: 16px;
        width: 52px;
        height: 52px;
    }
}
</style>
<a href="#" onclick="openAddClassModal(event)" class="fab-add-class" aria-label="Add New Class" title="Add New Class"><i class="feather icon-plus"></i></a>
</body>

</html>
<?php } ?>