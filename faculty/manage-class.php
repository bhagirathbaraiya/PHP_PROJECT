<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {
    header('location:../index.php');
    exit();
}

// Validate class id
$classId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$facultyId = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;

$class = null;
$students = [];
$totals = [
    'students' => 0,
    'assignments' => 0,
    'assignments_submitted' => 0,
    'notebooks' => 0,
    'notebooks_submitted' => 0,
];

if ($classId > 0 && $facultyId > 0) {
    // Verify ownership and fetch class with stats
    $query = "SELECT c.*, 
                     COUNT(DISTINCT sc.grno) AS total_students,
                     COUNT(DISTINCT a.id) AS total_assignments,
                     COUNT(DISTINCT CASE WHEN asub.status = 'submitted' THEN asub.id END) AS submitted_assignments,
                     COUNT(DISTINCT n.id) AS total_notebooks,
                     COUNT(DISTINCT CASE WHEN nsub.status = 'submitted' THEN nsub.id END) AS submitted_notebooks
              FROM class c
              LEFT JOIN student_to_class sc ON c.id = sc.class_id
              LEFT JOIN assignments a ON c.id = a.class_id
              LEFT JOIN assignment_submissions asub ON a.id = asub.assignment_id
              LEFT JOIN notebook n ON c.id = n.class_id
              LEFT JOIN notebook_submissions nsub ON n.id = nsub.notebook_id
              WHERE c.id = ? AND c.host_id = ?
              GROUP BY c.id";

    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, 'ii', $classId, $facultyId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $class = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }

    if ($class) {
        $totals['students'] = (int)$class['total_students'];
        $totals['assignments'] = (int)$class['total_assignments'];
        $totals['assignments_submitted'] = (int)$class['submitted_assignments'];
        $totals['notebooks'] = (int)$class['total_notebooks'];
        $totals['notebooks_submitted'] = (int)$class['submitted_notebooks'];

        // Fetch students enrolled in the class
        $studentsQuery = "SELECT s.grno, s.erno, s.fname, s.lname, s.email, s.status
                          FROM students s
                          INNER JOIN student_to_class sc ON s.grno = sc.grno
                          WHERE sc.class_id = ?
                          ORDER BY s.fname, s.lname";
        if ($sstmt = mysqli_prepare($con, $studentsQuery)) {
            mysqli_stmt_bind_param($sstmt, 'i', $classId);
            mysqli_stmt_execute($sstmt);
            $sres = mysqli_stmt_get_result($sstmt);
            $students = mysqli_fetch_all($sres, MYSQLI_ASSOC);
            mysqli_stmt_close($sstmt);
        }

        // Total assignments and notebooks for per-student denominators
        $totalAssignments = $totals['assignments'];
        $totalNotebooks = $totals['notebooks'];

        // Fetch per-student assignment submissions (distinct assignments submitted)
        $asMap = [];
        $asQuery = "SELECT asub.grno, COUNT(DISTINCT asub.assignment_id) AS cnt
                    FROM assignments a
                    INNER JOIN assignment_submissions asub ON asub.assignment_id = a.id AND asub.status = 'submitted'
                    WHERE a.class_id = ?
                    GROUP BY asub.grno";
        if ($astmt = mysqli_prepare($con, $asQuery)) {
            mysqli_stmt_bind_param($astmt, 'i', $classId);
            mysqli_stmt_execute($astmt);
            $ares = mysqli_stmt_get_result($astmt);
            while ($row = mysqli_fetch_assoc($ares)) {
                $asMap[$row['grno']] = (int)$row['cnt'];
            }
            mysqli_stmt_close($astmt);
        }

        // Fetch per-student notebook submissions (distinct notebooks submitted)
        $nsMap = [];
        $nsQuery = "SELECT nsub.grno, COUNT(DISTINCT nsub.notebook_id) AS cnt
                    FROM notebook n
                    INNER JOIN notebook_submissions nsub ON nsub.notebook_id = n.id AND nsub.status = 'submitted'
                    WHERE n.class_id = ?
                    GROUP BY nsub.grno";
        if ($nsstmt = mysqli_prepare($con, $nsQuery)) {
            mysqli_stmt_bind_param($nsstmt, 'i', $classId);
            mysqli_stmt_execute($nsstmt);
            $nsres = mysqli_stmt_get_result($nsstmt);
            while ($row = mysqli_fetch_assoc($nsres)) {
                $nsMap[$row['grno']] = (int)$row['cnt'];
            }
            mysqli_stmt_close($nsstmt);
        }

        // Enrich students with progress
        foreach ($students as &$stu) {
            $grno = $stu['grno'];
            $stu['assignments_submitted'] = isset($asMap[$grno]) ? $asMap[$grno] : 0;
            $stu['notebooks_submitted'] = isset($nsMap[$grno]) ? $nsMap[$grno] : 0;
            $stu['total_assignments'] = $totalAssignments;
            $stu['total_notebooks'] = $totalNotebooks;
        }
        unset($stu);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Class || Assignment & Notebook Tracking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin-responsive.css">
    <link rel="stylesheet" href="assets/css/responsive-class.css">
    <style>
        body {
            margin-top: 70px;
            background: linear-gradient(135deg, #e0e7ef 0%, #f7f9fb 100%);
            color: #102d4a;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .pcoded-main-container { padding-top: 20px; }
        @media (max-width: 991px) { .pcoded-main-container { padding-top: 10px; } }

        .mini-stat { background:#fff; border:1px solid #e3e8ee; border-radius:14px; padding:14px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.06); }
        .mini-stat .label { color:#6c757d; font-weight:600; font-size:0.95rem; }
        .mini-stat .value { color:#0097A7; font-weight:700; font-size:1.6rem; }

        .class-header h4 { color:#1abc9c; font-weight:600; margin-bottom:4px; }
        .class-sub { color:#666; margin-bottom:0; }

        .search-wrap input { border:1px solid #e3e8ee; padding:10px 12px; border-radius:10px; }
        .search-wrap input:focus { border-color:#0097A7; box-shadow:0 0 0 0.2rem rgba(0,151,167,0.18); outline:none; }

        .student-card { background:#fff; border:1px solid #e3e8ee; border-radius:14px; padding:12px; box-shadow:0 2px 10px rgba(0,0,0,0.06); height:100%; }
        .student-name { font-weight:600; color:#102d4a; margin-bottom:2px; }
        .student-meta { color:#6c757d; font-size:0.92rem; margin-bottom:8px; }
        .chip { display:inline-block; background:#f1f5f9; color:#0f172a; border-radius:999px; padding:4px 10px; font-size:0.82rem; margin-right:6px; }
        .status-badge { font-size:0.78rem; padding:4px 8px; border-radius:8px; }
        .status-active { background:#e8f5e9; color:#1b5e20; }
        .status-inactive { background:#eceff1; color:#263238; }
        .avatar { width:44px; height:44px; border-radius:50%; border:2px solid #e3e8ee; object-fit:cover; }
        .muted { color:#94a3b8; font-size:0.85rem; }
        .btn-soft { background:#0097A7; color:#fff; border:none; border-radius:10px; padding:8px 14px; }
        .btn-soft:hover { background:#0e7c86; }
    </style>
</head>
<body class="">
<?php include('include/sidebar.php');?>
<?php include('include/header.php');?>
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="row">
            <div class="col-12">
                <div class="card flat-card">
                    <div class="card-body">
                        <?php if (!$class): ?>
                            <div class="text-center">
                                <h5 style="color:#6c757d;">Class not found or access denied</h5>
                                <p class="muted">Make sure you opened a class you own.</p>
                                <a href="my-classes.php" class="btn btn-soft">Back to My Classes</a>
                            </div>
                        <?php else: ?>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 class-header">
                            <div>
                                <h4>Manage Class: <?php echo htmlspecialchars($class['name']); ?></h4>
                                <p class="class-sub">Class ID: <span style="color:#0097A7; font-weight:600;">#<?php echo (int)$class['id']; ?></span></p>
                                <?php if (!empty($class['description'])): ?>
                                    <p class="muted" style="margin-top:6px; max-width:720px;"><?php echo htmlspecialchars($class['description']); ?></p>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a href="my-classes.php" class="btn btn-soft">Back to My Classes</a>
                            </div>
                        </div>

                        <div class="row g-2" style="margin-bottom:12px;">
                            <div class="col-6 col-md-3 mb-3"><div class="mini-stat"><div class="label">Total Students</div><div class="value"><?php echo $totals['students']; ?></div></div></div>
                            <div class="col-6 col-md-3 mb-3"><div class="mini-stat"><div class="label">Assignments Submitted</div><div class="value"><?php echo $totals['assignments_submitted']; ?>/<?php echo $totals['assignments']; ?></div></div></div>
                            <div class="col-6 col-md-3 mb-3"><div class="mini-stat"><div class="label">Notebooks Submitted</div><div class="value"><?php echo $totals['notebooks_submitted']; ?>/<?php echo $totals['notebooks']; ?></div></div></div>
                            <div class="col-6 col-md-3 mb-3"><div class="mini-stat"><div class="label">Pending Assignments</div><div class="value"><?php echo max(0, ($totals['assignments'] * max(1,$totals['students'])) - $totals['assignments_submitted']); ?></div></div></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12 col-md-6"><h5 style="color:#0097A7; margin-bottom:8px;">Students</h5></div>
                            <div class="col-12 col-md-6">
                                <div class="search-wrap">
                                    <input type="text" id="studentSearch" class="form-control" placeholder="Search students by name, email, GR/ER number">
                                </div>
                            </div>
                        </div>

                        <div class="row" id="studentsGrid">
                            <?php if (empty($students)): ?>
                                <div class="col-12">
                                    <div class="text-center muted" style="padding:24px;">No students enrolled yet.</div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($students as $idx => $s): ?>
                                    <div class="col-lg-6 col-xl-4 mb-3 student-item" 
                                         data-name="<?php echo strtolower(htmlspecialchars($s['fname'].' '.$s['lname'])); ?>"
                                         data-email="<?php echo strtolower(htmlspecialchars($s['email'])); ?>"
                                         data-grno="<?php echo htmlspecialchars($s['grno']); ?>"
                                         data-erno="<?php echo htmlspecialchars($s['erno']); ?>">
                                        <div class="student-card">
                                            <div class="d-flex align-items-center">
                                                <img src="assets/images/user/user.png" class="avatar" alt="avatar">
                                                <div style="margin-left:10px;">
                                                    <div class="student-name"><?php echo htmlspecialchars($s['fname'].' '.$s['lname']); ?></div>
                                                    <div class="student-meta">GR: <?php echo htmlspecialchars($s['grno']); ?> &nbsp; • &nbsp; ER: <?php echo htmlspecialchars($s['erno']); ?></div>
                                                </div>
                                            </div>
                                            <div class="student-meta" style="margin-top:6px;">
                                                <?php echo htmlspecialchars($s['email']); ?>
                                            </div>
                                            <div style="margin-top:6px;">
                                                <span class="chip">Assignments: <?php echo (int)$s['assignments_submitted']; ?>/<?php echo (int)$s['total_assignments']; ?></span>
                                                <span class="chip">Notebooks: <?php echo (int)$s['notebooks_submitted']; ?>/<?php echo (int)$s['total_notebooks']; ?></span>
                                                <span class="status-badge <?php echo ($s['status']==='active'?'status-active':'status-inactive'); ?>"><?php echo htmlspecialchars($s['status']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    var searchInput = document.getElementById('studentSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e){
            var q = (e.target.value || '').toLowerCase();
            var items = document.querySelectorAll('.student-item');
            Array.prototype.forEach.call(items, function(el){
                var hay = (el.getAttribute('data-name') + ' ' + el.getAttribute('data-email') + ' ' + el.getAttribute('data-grno') + ' ' + el.getAttribute('data-erno')).toLowerCase();
                el.style.display = hay.indexOf(q) !== -1 ? 'block' : 'none';
            });
        });
    }
})();
</script>
<script src="assets/js/vendor-all.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/pcoded.min.js"></script>
</body>
</html>