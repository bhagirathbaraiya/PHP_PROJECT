<?php session_start();
//error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
exit();
}

$faculty_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;

// Fallback if session id is missing
if ($faculty_id === 0) {
    header('location:../index.php');
    exit();
}

// Fetch faculty name
$faculty_name = 'Faculty';
if ($stmt = mysqli_prepare($con, "SELECT fname, lname FROM faculty WHERE erno = ? LIMIT 1")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) {
        $faculty_name = trim(($row['fname'] ?? '') . ' ' . ($row['lname'] ?? '')) ?: 'Faculty';
    }
    mysqli_stmt_close($stmt);
}

// Stats: classes, students, assignments, notebooks, pending reviews
$total_classes = 0;
$total_students = 0;
$total_assignments = 0;
$total_notebooks = 0;
$pending_reviews = 0;

// Total classes
if ($stmt = mysqli_prepare($con, "SELECT COUNT(*) AS cnt FROM class WHERE host_id = ?")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) { $total_classes = intval($row['cnt']); }
    mysqli_stmt_close($stmt);
}

// Total students across faculty's classes
if ($stmt = mysqli_prepare($con, "SELECT COUNT(DISTINCT sc.grno) AS cnt FROM student_to_class sc INNER JOIN class c ON sc.class_id = c.id WHERE c.host_id = ?")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) { $total_students = intval($row['cnt']); }
    mysqli_stmt_close($stmt);
}

// Total assignments
if ($stmt = mysqli_prepare($con, "SELECT COUNT(*) AS cnt FROM assignments a INNER JOIN class c ON a.class_id = c.id WHERE c.host_id = ?")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) { $total_assignments = intval($row['cnt']); }
    mysqli_stmt_close($stmt);
}

// Total notebooks
if ($stmt = mysqli_prepare($con, "SELECT COUNT(*) AS cnt FROM notebook n INNER JOIN class c ON n.class_id = c.id WHERE c.host_id = ?")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) { $total_notebooks = intval($row['cnt']); }
    mysqli_stmt_close($stmt);
}

// Pending reviews (submitted, not yet graded)
$pending_assign_reviews = 0;
$pending_notebook_reviews = 0;
if ($stmt = mysqli_prepare($con, "SELECT COUNT(*) AS cnt FROM assignment_submissions s INNER JOIN assignments a ON s.assignment_id = a.id INNER JOIN class c ON a.class_id = c.id WHERE c.host_id = ? AND s.status = 'submitted'")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) { $pending_assign_reviews = intval($row['cnt']); }
    mysqli_stmt_close($stmt);
}
if ($stmt = mysqli_prepare($con, "SELECT COUNT(*) AS cnt FROM notebook_submissions s INNER JOIN notebook n ON s.notebook_id = n.id INNER JOIN class c ON n.class_id = c.id WHERE c.host_id = ? AND s.status = 'submitted'")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) { $pending_notebook_reviews = intval($row['cnt']); }
    mysqli_stmt_close($stmt);
}
$pending_reviews = $pending_assign_reviews + $pending_notebook_reviews;

// Submission status distributions
$assignment_status = ['pending' => 0, 'submitted' => 0, 'graded' => 0];
if ($stmt = mysqli_prepare($con, "SELECT s.status, COUNT(*) AS cnt FROM assignment_submissions s INNER JOIN assignments a ON s.assignment_id = a.id INNER JOIN class c ON a.class_id = c.id WHERE c.host_id = ? GROUP BY s.status")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) {
        $statusKey = strtolower($row['status']);
        if (isset($assignment_status[$statusKey])) { $assignment_status[$statusKey] = (int)$row['cnt']; }
    }
    mysqli_stmt_close($stmt);
}

$notebook_status = ['pending' => 0, 'submitted' => 0, 'graded' => 0];
if ($stmt = mysqli_prepare($con, "SELECT s.status, COUNT(*) AS cnt FROM notebook_submissions s INNER JOIN notebook n ON s.notebook_id = n.id INNER JOIN class c ON n.class_id = c.id WHERE c.host_id = ? GROUP BY s.status")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) {
        $statusKey = strtolower($row['status']);
        if (isset($notebook_status[$statusKey])) { $notebook_status[$statusKey] = (int)$row['cnt']; }
    }
    mysqli_stmt_close($stmt);
}

// Weekly submissions trend (last 7 days)
$weekly_days = [];
for ($i = 6; $i >= 0; $i--) { $weekly_days[] = date('Y-m-d', strtotime("-$i days")); }
$weekly_assign_map = array_fill_keys($weekly_days, 0);
$weekly_notebook_map = array_fill_keys($weekly_days, 0);

if ($stmt = mysqli_prepare($con, "SELECT DATE(ssub.submitted_at) AS d, COUNT(*) AS cnt FROM assignment_submissions ssub JOIN assignments a ON a.id = ssub.assignment_id JOIN class c ON c.id = a.class_id WHERE c.host_id = ? AND ssub.submitted_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY DATE(ssub.submitted_at)")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) { $day = $row['d']; if (isset($weekly_assign_map[$day])) { $weekly_assign_map[$day] = (int)$row['cnt']; } }
    mysqli_stmt_close($stmt);
}
if ($stmt = mysqli_prepare($con, "SELECT DATE(nsub.submitted_at) AS d, COUNT(*) AS cnt FROM notebook_submissions nsub JOIN notebook n ON n.id = nsub.notebook_id JOIN class c ON c.id = n.class_id WHERE c.host_id = ? AND nsub.submitted_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY DATE(nsub.submitted_at)")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) { $day = $row['d']; if (isset($weekly_notebook_map[$day])) { $weekly_notebook_map[$day] = (int)$row['cnt']; } }
    mysqli_stmt_close($stmt);
}
$weekly_labels = array_map(function($d){ return date('D', strtotime($d)); }, $weekly_days);
$weekly_assign = array_values($weekly_assign_map);
$weekly_notebook = array_values($weekly_notebook_map);

// Recent submissions (latest 10 across assignments and notebooks)
$recent_submissions = [];
// Assignments
if ($stmt = mysqli_prepare($con, "SELECT 'Assignment' AS type, CONCAT(s.fname,' ',s.lname) AS student, a.name AS item_name, c.name AS class_name, ssub.submitted_at AS submitted_at, ssub.status AS status FROM assignment_submissions ssub JOIN assignments a ON a.id = ssub.assignment_id JOIN class c ON c.id = a.class_id JOIN students s ON s.grno = ssub.grno WHERE c.host_id = ?")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) { $recent_submissions[] = $row; }
    mysqli_stmt_close($stmt);
}
// Notebooks
if ($stmt = mysqli_prepare($con, "SELECT 'Notebook' AS type, CONCAT(s.fname,' ',s.lname) AS student, CONCAT('Notebook #', n.id) AS item_name, c.name AS class_name, nsub.submitted_at AS submitted_at, nsub.status AS status FROM notebook_submissions nsub JOIN notebook n ON n.id = nsub.notebook_id JOIN class c ON c.id = n.class_id JOIN students s ON s.grno = nsub.grno WHERE c.host_id = ?")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) { $recent_submissions[] = $row; }
    mysqli_stmt_close($stmt);
}
// Sort by submitted_at desc and take top 10
usort($recent_submissions, function($a, $b) {
    return strtotime($b['submitted_at']) <=> strtotime($a['submitted_at']);
});
$recent_submissions = array_slice($recent_submissions, 0, 10);

// Upcoming assignment deadlines (next 7 days)
$upcoming_deadlines = [];
if ($stmt = mysqli_prepare($con, "SELECT a.id, a.name AS assignment_name, c.name AS class_name, a.due_date FROM assignments a JOIN class c ON c.id = a.class_id WHERE c.host_id = ? AND a.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) ORDER BY a.due_date ASC LIMIT 10")) {
    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) { $upcoming_deadlines[] = $row; }
    mysqli_stmt_close($stmt);
}
	?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Faculty Dashboard || Assignment & Notebook Tracking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin-responsive.css">
    <style>
        body{ margin-top: 70px; }
        .glass-card { background: rgba(255,255,255,0.18); border-radius: 18px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); border: 1.5px solid rgba(255,255,255,0.35); backdrop-filter: blur(12px); min-height: 110px; display: flex; align-items: center; justify-content: center; }
        .stat-value { font-size: 2.1rem; font-weight: 700; }
        .stat-label { font-size: 1.05rem; color: #222; font-weight: 600; }
    </style>
</head>
<body class="">
<?php include('include/sidebar.php');?>
	<?php include('include/header.php');?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="row">
            <div class="col-12">
                <div style="padding: 0 0 24px 0;">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card flat-card widget-primary-card">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body"><i class="feather icon-users"></i></div>
                                    <div class="col-sm-9">
                                        <h4><?php echo $total_students; ?></h4>
                                        <h6>My Students</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card flat-card bg-warning">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body"><i class="feather icon-layers"></i></div>
                                    <div class="col-sm-9">
                                        <h4><?php echo $total_classes; ?></h4>
                                        <h6>My Classes</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card flat-card widget-purple-card">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body"><i class="feather icon-file-text"></i></div>
                                    <div class="col-sm-9">
                                        <h4><?php echo $total_assignments; ?></h4>
                                        <h6>Assignments</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card flat-card bg-info">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body"><i class="feather icon-book"></i></div>
                                    <div class="col-sm-9">
                                        <h4><?php echo $total_notebooks; ?></h4>
                                        <h6>Notebooks</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="card flat-card bg-danger">
                                <div class="row-table">
                                    <div class="col-sm-3 card-body"><i class="feather icon-clock"></i></div>
                                    <div class="col-sm-9">
                                        <h4><?php echo $pending_reviews; ?></h4>
                                        <h6>Pending Reviews</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3">Assignments Status</h5>
                                    <div id="pie-assignments" style="min-height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3">Notebooks Status</h5>
                                    <div id="pie-notebooks" style="min-height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3">Weekly Submissions</h5>
                                    <div id="bar-weekly" style="min-height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                                    <th>Class</th>
                                                    <th>Item</th>
                                                    <th>Submitted At</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($recent_submissions)) { ?>
                                                    <tr><td colspan="6" class="text-center">No submissions yet.</td></tr>
                                                <?php } else { foreach ($recent_submissions as $row) { ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['student']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                                                        <td><span class="badge badge-<?php echo ($row['status'] === 'submitted') ? 'info' : (($row['status'] === 'graded') ? 'success' : 'warning'); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                                    </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card flat-card">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color:#0097A7; font-weight:600;">Upcoming Assignment Deadlines (7 days)</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead style="background:#e0f7fa;">
                                                <tr>
                                                    <th>Assignment</th>
                                                    <th>Class</th>
                                                    <th>Due Date</th>
                                                    <th>Days Left</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($upcoming_deadlines)) { ?>
                                                    <tr><td colspan="4" class="text-center">No upcoming deadlines.</td></tr>
                                                <?php } else { foreach ($upcoming_deadlines as $d) { $days = (strtotime($d['due_date']) - strtotime(date('Y-m-d'))) / 86400; $days = (int)ceil($days); ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($d['assignment_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['class_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['due_date']); ?></td>
                                                        <td><span class="badge badge-<?php echo ($days <= 1 ? 'danger' : ($days <= 3 ? 'warning' : 'info')); ?>"><?php echo $days; ?> days</span></td>
                                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script src="assets/js/plugins/apexcharts.min.js"></script>
    <script>
    (function(){
        var aPending = <?php echo (int)$assignment_status['pending']; ?>;
        var aSubmitted = <?php echo (int)$assignment_status['submitted']; ?>;
        var aGraded = <?php echo (int)$assignment_status['graded']; ?>;
        var nPending = <?php echo (int)$notebook_status['pending']; ?>;
        var nSubmitted = <?php echo (int)$notebook_status['submitted']; ?>;
        var nGraded = <?php echo (int)$notebook_status['graded']; ?>;
        var weeklyLabels = <?php echo json_encode($weekly_labels); ?>;
        var weeklyAssignments = <?php echo json_encode($weekly_assign); ?>;
        var weeklyNotebooks = <?php echo json_encode($weekly_notebook); ?>;

        var pieAssignments = new ApexCharts(document.querySelector('#pie-assignments'), {
            chart: { type: 'pie', height: 220 },
            series: [aPending, aSubmitted, aGraded],
            labels: ['Pending', 'Submitted', 'Graded'],
            colors: ['#F9B600', '#0097A7', '#28a745'],
            legend: { show: true, position: 'bottom' },
            responsive: [{ breakpoint: 768, options: { chart: { height: 200 } } }]
        });
        pieAssignments.render();

        var pieNotebooks = new ApexCharts(document.querySelector('#pie-notebooks'), {
            chart: { type: 'pie', height: 220 },
            series: [nPending, nSubmitted, nGraded],
            labels: ['Pending', 'Submitted', 'Graded'],
            colors: ['#F9B600', '#A41E22', '#28a745'],
            legend: { show: true, position: 'bottom' },
            responsive: [{ breakpoint: 768, options: { chart: { height: 200 } } }]
        });
        pieNotebooks.render();

        var barWeekly = new ApexCharts(document.querySelector('#bar-weekly'), {
            chart: { type: 'bar', height: 240 },
            series: [
                { name: 'Assignments', data: weeklyAssignments },
                { name: 'Notebooks', data: weeklyNotebooks }
            ],
            xaxis: { categories: weeklyLabels },
            colors: ['#0097A7', '#A41E22'],
            legend: { show: true, position: 'bottom' },
            plotOptions: { bar: { columnWidth: '45%', borderRadius: 4 } },
            dataLabels: { enabled: false },
            responsive: [{ breakpoint: 768, options: { chart: { height: 220 } } }]
        });
        barWeekly.render();
    })();
    </script>
</body>

</html>