<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id'])==0)
	{
header('location:../index.php');
}
else{
    // Get student's GR number from session
    $student_grno = $_SESSION['id'];
    
    // Get student's classes
    $student_classes_query = "SELECT class_id FROM student_to_class WHERE grno = ?";
    $stmt = mysqli_prepare($con, $student_classes_query);
    mysqli_stmt_bind_param($stmt, "i", $student_grno);
    mysqli_stmt_execute($stmt);
    $class_result = mysqli_stmt_get_result($stmt);
    
    $class_ids = array();
    while($class_row = mysqli_fetch_assoc($class_result)) {
        $class_ids[] = $class_row['class_id'];
    }
    mysqli_stmt_close($stmt);
    
    // Initialize counters
    $total_assignments = 0;
    $pending_assignments = 0;
    $submitted_assignments = 0;
    $overdue_assignments = 0;
    $total_notebooks = 0;
    $pending_notebooks = 0;
    $submitted_notebooks = 0;
    $overdue_notebooks = 0;
    
    if (!empty($class_ids)) {
        $class_ids_str = implode(',', array_map('intval', $class_ids));
        
        // Get assignments data
        $assignments_query = "SELECT a.id, a.due_date, 
                             CASE WHEN asub.id IS NOT NULL THEN 1 ELSE 0 END as is_submitted,
                             CASE WHEN a.due_date < CURDATE() AND asub.id IS NULL THEN 1 ELSE 0 END as is_overdue
                             FROM assignments a 
                             LEFT JOIN assignment_submissions asub ON a.id = asub.assignment_id AND asub.grno = ?
                             WHERE a.class_id IN ($class_ids_str)";
        
        $stmt = mysqli_prepare($con, $assignments_query);
        mysqli_stmt_bind_param($stmt, "i", $student_grno);
        mysqli_stmt_execute($stmt);
        $assignments_result = mysqli_stmt_get_result($stmt);
        
        while($assignment = mysqli_fetch_assoc($assignments_result)) {
            $total_assignments++;
            if ($assignment['is_submitted']) {
                $submitted_assignments++;
            } elseif ($assignment['is_overdue']) {
                $overdue_assignments++;
            } else {
                $pending_assignments++;
            }
        }
        mysqli_stmt_close($stmt);
        
        // Get notebooks data
        $notebooks_query = "SELECT n.id,
                           CASE WHEN nsub.id IS NOT NULL THEN 1 ELSE 0 END as is_submitted
                           FROM notebook n 
                           LEFT JOIN notebook_submissions nsub ON n.id = nsub.notebook_id AND nsub.grno = ?
                           WHERE n.class_id IN ($class_ids_str)";
        
        $stmt = mysqli_prepare($con, $notebooks_query);
        mysqli_stmt_bind_param($stmt, "i", $student_grno);
        mysqli_stmt_execute($stmt);
        $notebooks_result = mysqli_stmt_get_result($stmt);
        
        while($notebook = mysqli_fetch_assoc($notebooks_result)) {
            $total_notebooks++;
            if ($notebook['is_submitted']) {
                $submitted_notebooks++;
            } else {
                $pending_notebooks++;
            }
        }
        mysqli_stmt_close($stmt);
        
        // For notebooks, we'll assume overdue is 0 since there's no due_date field
        $overdue_notebooks = 0;
    }
    
    // Get subjects (classes) data for the student
    $subjects_data = array();
    if (!empty($class_ids)) {
        $subjects_query = "SELECT c.id, c.name, c.description, 
                          CONCAT(f.fname, ' ', f.lname) as faculty_name,
                          f.erno as faculty_id
                          FROM class c 
                          LEFT JOIN faculty f ON c.host_id = f.erno
                          WHERE c.id IN ($class_ids_str)";
        
        $subjects_result = mysqli_query($con, $subjects_query);
        
        while($subject = mysqli_fetch_assoc($subjects_result)) {
            // Get assignments data for this class
            $class_assignments_query = "SELECT COUNT(*) as total,
                                       SUM(CASE WHEN asub.id IS NOT NULL THEN 1 ELSE 0 END) as submitted,
                                       SUM(CASE WHEN a.due_date < CURDATE() AND asub.id IS NULL THEN 1 ELSE 0 END) as overdue
                                       FROM assignments a 
                                       LEFT JOIN assignment_submissions asub ON a.id = asub.assignment_id AND asub.grno = ?
                                       WHERE a.class_id = ?";
            
            $stmt = mysqli_prepare($con, $class_assignments_query);
            mysqli_stmt_bind_param($stmt, "ii", $student_grno, $subject['id']);
            mysqli_stmt_execute($stmt);
            $class_assign_result = mysqli_stmt_get_result($stmt);
            $class_assign_data = mysqli_fetch_assoc($class_assign_result);
            mysqli_stmt_close($stmt);
            
            // Get notebooks data for this class
            $class_notebooks_query = "SELECT COUNT(*) as total,
                                     SUM(CASE WHEN nsub.id IS NOT NULL THEN 1 ELSE 0 END) as submitted
                                     FROM notebook n 
                                     LEFT JOIN notebook_submissions nsub ON n.id = nsub.notebook_id AND nsub.grno = ?
                                     WHERE n.class_id = ?";
            
            $stmt = mysqli_prepare($con, $class_notebooks_query);
            mysqli_stmt_bind_param($stmt, "ii", $student_grno, $subject['id']);
            mysqli_stmt_execute($stmt);
            $class_notebook_result = mysqli_stmt_get_result($stmt);
            $class_notebook_data = mysqli_fetch_assoc($class_notebook_result);
            mysqli_stmt_close($stmt);
            
            $assignment_total = $class_assign_data['total'] ?: 0;
            $assignment_submitted = $class_assign_data['submitted'] ?: 0;
            $assignment_overdue = $class_assign_data['overdue'] ?: 0;
            $assignment_pending = $assignment_total - $assignment_submitted - $assignment_overdue;
            
            $notebook_total = $class_notebook_data['total'] ?: 0;
            $notebook_submitted = $class_notebook_data['submitted'] ?: 0;
            $notebook_pending = $notebook_total - $notebook_submitted;
            
            $subjects_data[] = array(
                'name' => $subject['name'] ?: 'Unknown Subject',
                'description' => $subject['description'] ?: '',
                'faculty' => $subject['faculty_name'] ?: 'Unknown Faculty',
                'assignments' => array(
                    'total' => $assignment_total,
                    'completed' => $assignment_submitted,
                    'pending' => $assignment_pending,
                    'due' => $assignment_overdue
                ),
                'notebooks' => array(
                    'total' => $notebook_total,
                    'completed' => $notebook_submitted,
                    'pending' => $notebook_pending,
                    'due' => 0
                )
            );
        }
    }
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
            margin-top: 70px;
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
            <!-- <div class="page-block">
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
            </div> -->
        </div>
        <!-- Stat Boxes -->
        <div class="stat-grid" role="region" aria-label="Statistics Overview">
            <!-- Assignments Header -->
            <div style="grid-column: 1 / -1; text-align:left; margin-bottom: 4px; margin-top: 0;">
                <h4 style="margin:0; color:#0097A7; font-weight:700; letter-spacing:1px;">Assignments</h4>
            </div>
            <!-- Assignments Stat Boxes -->
            <div class="stat-box" tabindex="0" aria-label="Total Assignments: <?php echo $total_assignments; ?>">
                <div class="stat-icon"><i class="fas fa-file-alt" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Total Assignments</div>
                    <div class="stat-value"><?php echo $total_assignments; ?></div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Pending Assignments: <?php echo $pending_assignments; ?>">
                <div class="stat-icon"><i class="fas fa-hourglass-half" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Pending Assignments</div>
                    <div class="stat-value"><?php echo $pending_assignments; ?></div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Submitted Assignments: <?php echo $submitted_assignments; ?>">
                <div class="stat-icon"><i class="fas fa-check-circle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Submitted Assignments</div>
                    <div class="stat-value"><?php echo $submitted_assignments; ?></div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Overdue Assignments: <?php echo $overdue_assignments; ?>">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Overdue Assignments</div>
                    <div class="stat-value"><?php echo $overdue_assignments; ?></div>
                </div>
            </div>
            <!-- Notebooks Header -->
            <div style="grid-column: 1 / -1; text-align:left; margin-top: 18px; margin-bottom: 4px;">
                <h4 style="margin:0; color:#A41E22; font-weight:700; letter-spacing:1px;">Notebooks</h4>
            </div>
            <!-- Notebook Stat Boxes -->
            <div class="stat-box" tabindex="0" aria-label="Total Notebooks: <?php echo $total_notebooks; ?>">
                <div class="stat-icon"><i class="fas fa-book" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Total Notebooks</div>
                    <div class="stat-value"><?php echo $total_notebooks; ?></div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Pending Notebooks: <?php echo $pending_notebooks; ?>">
                <div class="stat-icon"><i class="fas fa-hourglass-half" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Pending Notebooks</div>
                    <div class="stat-value"><?php echo $pending_notebooks; ?></div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Submitted Notebooks: <?php echo $submitted_notebooks; ?>">
                <div class="stat-icon"><i class="fas fa-check-circle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Submitted Notebooks</div>
                    <div class="stat-value"><?php echo $submitted_notebooks; ?></div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Overdue Notebooks: <?php echo $overdue_notebooks; ?>">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Overdue Notebooks</div>
                    <div class="stat-value"><?php echo $overdue_notebooks; ?></div>
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
    <!-- Your Subjects Section -->
    <div class="dashboard-container" style="margin-top: 0;">
        <div style="grid-column: 1 / -1; display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; margin-top: 0;">
            <h4 style="margin:0; color:#102d4a; font-weight:700; letter-spacing:1px;">Your Subjects</h4>
            <button id="toggle-all-graphs-btn" class="toggle-all-graphs-btn" aria-label="Toggle All Graphs" title="Toggle All Graphs">
                <i class="fas fa-chart-pie"></i> <span id="toggle-all-graphs-label">Show All Graphs</span>
            </button>
        </div>
        <div class="subjects-grid" role="region" aria-label="Subjects Overview">
            <!-- Subject cards will be injected here by JS -->
        </div>
    </div>
    <script src="../admin/assets/js/vendor-all.min.js"></script>
    <script src="../admin/assets/js/plugins/bootstrap.min.js"></script>
    <script src="../admin/assets/js/plugins/apexcharts.min.js"></script>
<script>
    // Real data from PHP
    var assignmentData = {
        total: <?php echo $total_assignments; ?>,
        pending: <?php echo $pending_assignments; ?>,
        submitted: <?php echo $submitted_assignments; ?>,
        overdue: <?php echo $overdue_assignments; ?>
    };
    var notebookData = {
        total: <?php echo $total_notebooks; ?>,
        pending: <?php echo $pending_notebooks; ?>,
        submitted: <?php echo $submitted_notebooks; ?>,
        overdue: <?php echo $overdue_notebooks; ?>
    };
    // Dummy data for progress line chart (can be enhanced later with real data)
    var progressData = {
        categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        assignments: [0, 0, 0, assignmentData.total],
        notebooks: [0, 0, 0, notebookData.total]
    };
    // Pie Chart for Assignments (handle empty data)
    var assignmentPieOptions = {
        chart: { type: 'pie', height: 180 },
        series: assignmentData.total > 0 ? [assignmentData.pending, assignmentData.submitted, assignmentData.overdue] : [1],
        labels: assignmentData.total > 0 ? ['Pending', 'Submitted', 'Overdue'] : ['No Data'],
        colors: assignmentData.total > 0 ? ['#F9B600', '#0097A7', '#A41E22'] : ['#E0E0E0'],
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
        },
        noData: {
            text: 'No assignments available',
            align: 'center',
            verticalAlign: 'middle'
        }
    };
    var assignmentPieChart = new ApexCharts(document.querySelector("#assignmentPieChart"), assignmentPieOptions);
    assignmentPieChart.render();
    // Pie Chart for Notebooks (handle empty data)
    var notebookPieOptions = {
        chart: { type: 'pie', height: 180 },
        series: notebookData.total > 0 ? [notebookData.pending, notebookData.submitted, notebookData.overdue] : [1],
        labels: notebookData.total > 0 ? ['Pending', 'Submitted', 'Overdue'] : ['No Data'],
        colors: notebookData.total > 0 ? ['#F9B600', '#0097A7', '#A41E22'] : ['#E0E0E0'],
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
        },
        noData: {
            text: 'No notebooks available',
            align: 'center',
            verticalAlign: 'middle'
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
    
    // Real subjects data from PHP
    var subjects = <?php echo json_encode($subjects_data); ?>;

    // Render subject cards
    var subjectsGrid = document.querySelector('.subjects-grid');
    
    if (subjects.length === 0) {
        // Show message when no subjects are enrolled
        subjectsGrid.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                <i class="fas fa-book-open" style="font-size: 3rem; margin-bottom: 16px; color: #0097A7;"></i>
                <h5 style="margin: 0; color: #102d4a;">No Subjects Enrolled</h5>
                <p style="margin: 8px 0 0 0; color: #666;">You are not enrolled in any classes yet.</p>
            </div>
        `;
    } else {
        subjects.forEach(function(subject, idx) {
            var card = document.createElement('div');
            card.className = 'subject-card';
            card.tabIndex = 0;
            card.setAttribute('aria-label', subject.name + ' assignments and notebooks overview');
            card.innerHTML = `
                <div class="subject-title">${subject.name}</div>
                <div class="faculty-name">Faculty: ${subject.faculty}</div>
                <div class="subject-section assignment-section">
                    <div class="section-label"><i class='fas fa-file-alt'></i> Assignments</div>
                    <div class="subject-stats stats-view" id="assignment-stats-${idx}">
                        <div class="subject-stat total">
                            <span class="stat-label">Total</span>
                            <span class="stat-value">${subject.assignments.total}</span>
                        </div>
                        <div class="subject-stat completed">
                            <span class="stat-label">Completed</span>
                            <span class="stat-value">${subject.assignments.completed}</span>
                        </div>
                        <div class="subject-stat pending">
                            <span class="stat-label">Pending</span>
                            <span class="stat-value">${subject.assignments.pending}</span>
                        </div>
                        <div class="subject-stat due">
                            <span class="stat-label">Due</span>
                            <span class="stat-value">${subject.assignments.due}</span>
                        </div>
                </div>
                <div class="chart-view" id="assignment-chart-${idx}" style="display:none; min-width:180px; min-height:120px;"></div>
            </div>
            <div class="subject-section notebook-section">
                <div class="section-label"><i class='fas fa-book'></i> Notebooks</div>
                <div class="subject-stats stats-view" id="notebook-stats-${idx}">
                    <div class="subject-stat total">
                        <span class="stat-label">Total</span>
                        <span class="stat-value">${subject.notebooks.total}</span>
                    </div>
                    <div class="subject-stat completed">
                        <span class="stat-label">Completed</span>
                        <span class="stat-value">${subject.notebooks.completed}</span>
                    </div>
                    <div class="subject-stat pending">
                        <span class="stat-label">Pending</span>
                        <span class="stat-value">${subject.notebooks.pending}</span>
                    </div>
                    <div class="subject-stat due">
                        <span class="stat-label">Due</span>
                        <span class="stat-value">${subject.notebooks.due}</span>
                    </div>
                </div>
                <div class="chart-view" id="notebook-chart-${idx}" style="display:none; min-width:180px; min-height:120px;"></div>
            </div>
        `;
        subjectsGrid.appendChild(card);
        });
    }
    
    // Hide toggle button if no subjects
    if (subjects.length === 0) {
        document.getElementById('toggle-all-graphs-btn').style.display = 'none';
    }

    // Toggle all charts/stat views logic
    var chartInstances = {};
    var allGraphsVisible = false;
    function renderPieChartIfNeeded(idx, type) {
        if (subjects.length === 0 || !subjects[idx]) return;
        
        var chartId = type + '-chart-' + idx;
        var chartDiv = document.getElementById(chartId);
        if (!chartInstances[chartId]) {
            var data = type === 'assignment' ? subjects[idx].assignments : subjects[idx].notebooks;
            var hasData = data.total > 0;
            var chartOptions = {
                chart: { type: 'pie', height: 140 },
                series: hasData ? [data.completed, data.pending, data.due] : [1],
                labels: hasData ? ['Completed', 'Pending', 'Due'] : ['No Data'],
                colors: hasData ? ['#0097A7', '#F9B600', '#A41E22'] : ['#E0E0E0'],
                legend: {
                    show: true,
                    fontSize: '13px',
                    position: 'bottom',
                    labels: { colors: ['#222'] }
                },
                dataLabels: {
                    style: { fontSize: '13px', fontWeight: 'bold' }
                },
                accessibility: {
                    enabled: true,
                    description: (type.charAt(0).toUpperCase() + type.slice(1)) + ' pie chart for ' + subjects[idx].name
                },
                noData: {
                    text: 'No ' + type + 's available',
                    align: 'center',
                    verticalAlign: 'middle'
                }
            };
            chartInstances[chartId] = new ApexCharts(chartDiv, chartOptions);
            chartInstances[chartId].render();
        }
    }
    function toggleAllGraphs(showGraphs) {
        if (subjects.length === 0) return;
        
        subjects.forEach(function(subject, idx) {
            ['assignment', 'notebook'].forEach(function(type) {
                var statsId = type + '-stats-' + idx;
                var chartId = type + '-chart-' + idx;
                var statsDiv = document.getElementById(statsId);
                var chartDiv = document.getElementById(chartId);
                if (showGraphs) {
                    statsDiv.style.display = 'none';
                    chartDiv.style.display = 'block';
                    renderPieChartIfNeeded(idx, type);
                } else {
                    statsDiv.style.display = 'flex';
                    chartDiv.style.display = 'none';
                }
            });
        });
        allGraphsVisible = showGraphs;
        document.getElementById('toggle-all-graphs-label').textContent = showGraphs ? 'Show All Stats' : 'Show All Graphs';
    }
    document.getElementById('toggle-all-graphs-btn').addEventListener('click', function() {
        toggleAllGraphs(!allGraphsVisible);
    });
</script>
<style>
/* Subject Cards Glassmorphism */
.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
    margin-top: 8px;
}
.subject-card {
    background: rgba(255,255,255,0.18);
    border-radius: 18px;
    padding: 22px 20px 18px 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    border: 1.5px solid rgba(255,255,255,0.35);
    backdrop-filter: blur(12px);
    transition: box-shadow 0.2s, transform 0.2s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    min-height: 220px;
    margin-bottom: 0;
}
.subject-card:focus, .subject-card:hover {
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    transform: translateY(-2px) scale(1.03);
    outline: 2px solid #0097A7;
}
.subject-title {
    font-size: 1.18rem;
    font-weight: 700;
    color: #0097A7;
    margin-bottom: 2px;
    letter-spacing: 0.5px;
}
.subject-code {
    font-size: 1rem;
    font-weight: 500;
    color: #A41E22;
    margin-left: 4px;
}
.faculty-name {
    font-size: 0.98rem;
    color: #102d4a;
    margin-bottom: 10px;
    font-weight: 500;
}
.subject-section {
    width: 100%;
    margin-bottom: 10px;
    background: rgba(255,255,255,0.13);
    border-radius: 12px;
    padding: 10px 12px 8px 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid rgba(255,255,255,0.18);
}
.subject-section:last-child {
    margin-bottom: 0;
}
.section-label {
    font-size: 1.05rem;
    font-weight: 600;
    color: #222;
    margin-bottom: 7px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.section-label i {
    color: #0097A7;
    font-size: 1.1rem;
}
.subject-stats {
    display: flex;
    gap: 16px;
    width: 100%;
    justify-content: flex-start;
}
.subject-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 56px;
}
.subject-stat .stat-label {
    font-size: 0.93rem;
    color: #222;
    font-weight: 500;
    margin-bottom: 2px;
}
.subject-stat .stat-value {
    font-size: 1.15rem;
    font-weight: 600;
}
.subject-stat.total .stat-value {
    color: #102d4a;
}
.subject-stat.completed .stat-value {
    color: #0097A7;
}
.subject-stat.pending .stat-value {
    color: #F9B600;
}
.subject-stat.due .stat-value {
    color: #A41E22;
}
@media (max-width: 991px) {
    .subjects-grid {
        gap: 16px;
    }
}
@media (max-width: 767px) {
    .subjects-grid {
        grid-template-columns: 1fr;
    }
}
.toggle-all-graphs-btn {
    background: rgba(255,255,255,0.25);
    border: 1px solid rgba(0,151,167,0.18);
    border-radius: 18px;
    cursor: pointer;
    padding: 6px 16px 6px 12px;
    font-size: 1.08rem;
    color: #0097A7;
    transition: background 0.15s, box-shadow 0.15s;
    outline: none;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    display: flex;
    align-items: center;
    gap: 7px;
    font-weight: 600;
}
.toggle-all-graphs-btn:focus, .toggle-all-graphs-btn:hover {
    background: #e0f7fa;
    color: #A41E22;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
}
.toggle-all-graphs-btn i {
    pointer-events: none;
}
.chart-view {
    width: 100%;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.subject-stats {
    transition: display 0.2s;
}
</style>
</body>

</html>
<?php } ?>