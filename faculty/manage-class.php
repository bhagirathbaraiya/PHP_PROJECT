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

// Collections for detailed rendering
$assignments = [];
$notebooks = [];
$assignmentSubmissionsMap = [];
$notebookSubmissionsMap = [];

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

        // Fetch all assignments for this class (for checkbox boxes)
        $aListQuery = "SELECT id, name, due_date, created_at FROM assignments WHERE class_id = ? ORDER BY created_at ASC, id ASC";
        if ($alist = mysqli_prepare($con, $aListQuery)) {
            mysqli_stmt_bind_param($alist, 'i', $classId);
            mysqli_stmt_execute($alist);
            $ares = mysqli_stmt_get_result($alist);
            $assignments = mysqli_fetch_all($ares, MYSQLI_ASSOC);
            mysqli_stmt_close($alist);
        }

        // Fetch all notebooks for this class (for checkbox boxes)
        $nListQuery = "SELECT id, created_at FROM notebook WHERE class_id = ? ORDER BY created_at ASC, id ASC";
        if ($nlist = mysqli_prepare($con, $nListQuery)) {
            mysqli_stmt_bind_param($nlist, 'i', $classId);
            mysqli_stmt_execute($nlist);
            $nres = mysqli_stmt_get_result($nlist);
            $notebooks = mysqli_fetch_all($nres, MYSQLI_ASSOC);
            mysqli_stmt_close($nlist);
        }

        // Build assignment submissions map: [$grno][$assignment_id] = ['submitted_at'=>..., 'graded'=>bool]
        $asDetailQuery = "SELECT asub.assignment_id, asub.grno, asub.submitted_at, asub.grade, asub.status
                           FROM assignments a
                           INNER JOIN assignment_submissions asub ON asub.assignment_id = a.id
                           WHERE a.class_id = ?";
        if ($asdet = mysqli_prepare($con, $asDetailQuery)) {
            mysqli_stmt_bind_param($asdet, 'i', $classId);
            mysqli_stmt_execute($asdet);
            $dres = mysqli_stmt_get_result($asdet);
            while ($row = mysqli_fetch_assoc($dres)) {
                $gr = $row['grno'];
                $aid = $row['assignment_id'];
                if (!isset($assignmentSubmissionsMap[$gr])) $assignmentSubmissionsMap[$gr] = [];
                $assignmentSubmissionsMap[$gr][$aid] = [
                    'submitted_at' => $row['submitted_at'],
                    'graded' => (!empty($row['grade']) || (isset($row['status']) && strtolower($row['status']) === 'graded'))
                ];
            }
            mysqli_stmt_close($asdet);
        }

        // Build notebook submissions map: [$grno][$notebook_id] = ['submitted_at'=>..., 'graded'=>bool]
        $nbDetailQuery = "SELECT nsub.notebook_id, nsub.grno, nsub.submitted_at, nsub.grade, nsub.status
                           FROM notebook n
                           INNER JOIN notebook_submissions nsub ON nsub.notebook_id = n.id
                           WHERE n.class_id = ?";
        if ($nbdet = mysqli_prepare($con, $nbDetailQuery)) {
            mysqli_stmt_bind_param($nbdet, 'i', $classId);
            mysqli_stmt_execute($nbdet);
            $nbres = mysqli_stmt_get_result($nbdet);
            while ($row = mysqli_fetch_assoc($nbres)) {
                $gr = $row['grno'];
                $nid = $row['notebook_id'];
                if (!isset($notebookSubmissionsMap[$gr])) $notebookSubmissionsMap[$gr] = [];
                $notebookSubmissionsMap[$gr][$nid] = [
                    'submitted_at' => $row['submitted_at'],
                    'graded' => (!empty($row['grade']) || (isset($row['status']) && strtolower($row['status']) === 'graded'))
                ];
            }
            mysqli_stmt_close($nbdet);
        }
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
        /* Students table styles */
        .students-table .avatar-mini { width:36px; height:36px; border-radius:50%; border:2px solid #e3e8ee; object-fit:cover; }
        .box-grid { display:flex; flex-wrap:wrap; gap:6px; }
        .ibox { width:18px; height:18px; border:1.5px solid #cbd5e1; border-radius:4px; background:#fff; position:relative; display:inline-block; cursor:pointer; }
        .ibox.checked { background:#e8f5e9; border-color:#34a853; }
        .ibox.checked::after { content:'\2713'; position:absolute; top:50%; left:50%; transform:translate(-50%,-52%); font-size:12px; color:#1b5e20; }
        .ibox:hover { box-shadow:0 0 0 3px rgba(0,151,167,0.12); }
        .ratio-badge { display:inline-block; padding:2px 8px; border-radius:999px; background:#f1f5f9; color:#0f172a; font-weight:600; font-size:0.8rem; margin-right:6px; }
        .progress.progress-sm { height:8px; border-radius:999px; background:#e9ecef; }
        .progress.progress-sm .progress-bar { border-radius:999px; }
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

                            <?php if (empty($students)): ?>
                                    <div class="text-center muted" style="padding:24px;">No students enrolled yet.</div>
                            <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered students-table" id="studentsTable">
                                <thead style="background:#f8f9fa;">
                                    <tr>
                                        <th style="width:60px;">Sr No</th>
                                        <th style="width:120px;">GRNO</th>
                                        <th>Details</th>
                                        <th style="min-width:220px;">Assignments</th>
                                        <th style="min-width:220px;">Notebooks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $aCount = count($assignments);
                                    $nCount = count($notebooks);
                                    foreach ($students as $idx => $s): 
                                        $gr = $s['grno'];
                                        $aTotal = (int)$aCount;
                                        $nTotal = (int)$nCount;
                                        $aGraded = 0;
                                        foreach ($assignments as $aTmp) {
                                            $aidTmp = $aTmp['id'];
                                            if (isset($assignmentSubmissionsMap[$gr]) && isset($assignmentSubmissionsMap[$gr][$aidTmp]) && !empty($assignmentSubmissionsMap[$gr][$aidTmp]['graded'])) {
                                                $aGraded++;
                                            }
                                        }
                                        $nGraded = 0;
                                        foreach ($notebooks as $nTmp) {
                                            $nidTmp = $nTmp['id'];
                                            if (isset($notebookSubmissionsMap[$gr]) && isset($notebookSubmissionsMap[$gr][$nidTmp]) && !empty($notebookSubmissionsMap[$gr][$nidTmp]['graded'])) {
                                                $nGraded++;
                                            }
                                        }
                                ?>
                                    <tr class="student-row"
                                         data-name="<?php echo strtolower(htmlspecialchars($s['fname'].' '.$s['lname'])); ?>"
                                         data-email="<?php echo strtolower(htmlspecialchars($s['email'])); ?>"
                                         data-grno="<?php echo htmlspecialchars($s['grno']); ?>"
                                         data-erno="<?php echo htmlspecialchars($s['erno']); ?>">
                                        <td class="srno"></td>
                                        <td><?php echo htmlspecialchars($s['grno']); ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/images/user/user.png" class="avatar-mini mr-2" alt="avatar">
                                                <div>
                                                    <div class="student-name" style="margin-bottom:0;"><?php echo htmlspecialchars($s['fname'].' '.$s['lname']); ?></div>
                                                    <div class="muted">ER: <?php echo htmlspecialchars($s['erno']); ?> &nbsp; • &nbsp; <?php echo htmlspecialchars($s['email']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-1"><span class="ratio-badge"><?php echo $aGraded; ?>/<?php echo $aTotal; ?></span></div>
                                            <div class="box-grid">
                                                <?php foreach ($assignments as $a): 
                                                    $aid = $a['id'];
                                                    $assignedAt = isset($a['created_at']) ? $a['created_at'] : '';
                                                    $has = isset($assignmentSubmissionsMap[$gr]) && isset($assignmentSubmissionsMap[$gr][$aid]);
                                                    $graded = $has ? (bool)$assignmentSubmissionsMap[$gr][$aid]['graded'] : false;
                                                    $submittedAt = $has ? $assignmentSubmissionsMap[$gr][$aid]['submitted_at'] : '';
                                                    $tip = 'Assigned: '.($assignedAt ?: 'N/A');
                                                    $tip .= ' | Submitted: '.($submittedAt ?: 'Not submitted');
                                                ?>
                                                    <span class="ibox <?php echo $graded ? 'checked' : ''; ?>" data-toggle="tooltip" title="<?php echo htmlspecialchars($tip); ?>" role="checkbox" aria-checked="<?php echo $graded ? 'true' : 'false'; ?>" data-type="assignment" data-id="<?php echo (int)$aid; ?>" data-grno="<?php echo (int)$gr; ?>"></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-1"><span class="ratio-badge"><?php echo $nGraded; ?>/<?php echo $nTotal; ?></span></div>
                                            <div class="box-grid">
                                                <?php foreach ($notebooks as $n): 
                                                    $nid = $n['id'];
                                                    $assignedAt = isset($n['created_at']) ? $n['created_at'] : '';
                                                    $has = isset($notebookSubmissionsMap[$gr]) && isset($notebookSubmissionsMap[$gr][$nid]);
                                                    $graded = $has ? (bool)$notebookSubmissionsMap[$gr][$nid]['graded'] : false;
                                                    $submittedAt = $has ? $notebookSubmissionsMap[$gr][$nid]['submitted_at'] : '';
                                                    $tip = 'Assigned: '.($assignedAt ?: 'N/A');
                                                    $tip .= ' | Submitted: '.($submittedAt ?: 'Not submitted');
                                                ?>
                                                    <span class="ibox <?php echo $graded ? 'checked' : ''; ?>" data-toggle="tooltip" title="<?php echo htmlspecialchars($tip); ?>" role="checkbox" aria-checked="<?php echo $graded ? 'true' : 'false'; ?>" data-type="notebook" data-id="<?php echo (int)$nid; ?>" data-grno="<?php echo (int)$gr; ?>"></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="muted" id="studentsTableInfo"></div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0" id="studentsPagination"></ul>
                            </nav>
                        </div>
                        <?php endif; ?>
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
    var table = document.getElementById('studentsTable');
    var tbody = table ? table.querySelector('tbody') : null;
    var pagination = document.getElementById('studentsPagination');
    var info = document.getElementById('studentsTableInfo');
    var rows = tbody ? Array.prototype.slice.call(tbody.querySelectorAll('tr.student-row')) : [];
    var pageSize = 10;
    var currentPage = 1;

    function filterRows() {
        var q = (searchInput && searchInput.value ? searchInput.value : '').toLowerCase();
        rows.forEach(function(r){
            var hay = (r.getAttribute('data-name') + ' ' + r.getAttribute('data-email') + ' ' + r.getAttribute('data-grno') + ' ' + r.getAttribute('data-erno')).toLowerCase();
            r.style.display = hay.indexOf(q) !== -1 ? '' : 'none';
        });
        currentPage = 1;
        paginate();
    }

    function paginate() {
        var visible = rows.filter(function(r){ return r.style.display !== 'none'; });
        var total = visible.length;
        var pages = Math.max(1, Math.ceil(total / pageSize));
        if (currentPage > pages) currentPage = pages;
        var start = (currentPage - 1) * pageSize;
        var end = start + pageSize;

        // Hide all, then show current page
        visible.forEach(function(r, i){
            r.style.display = (i >= start && i < end) ? '' : 'none';
        });

        // Update serial numbers
        visible.forEach(function(r, i){
            if (i >= start && i < end) {
                var srCell = r.querySelector('td.srno');
                if (srCell) srCell.textContent = (i + 1);
            }
        });

        // Render pagination controls
        if (pagination) {
            pagination.innerHTML = '';
            function addPage(label, page, disabled, active) {
                var li = document.createElement('li');
                li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
                var a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.textContent = label;
                a.addEventListener('click', function(ev){ ev.preventDefault(); if (!disabled) { currentPage = page; paginate(); window.scrollTo({ top: 0, behavior: 'smooth' }); } });
                li.appendChild(a);
                pagination.appendChild(li);
            }
            addPage('«', 1, currentPage === 1, false);
            addPage('‹', Math.max(1, currentPage - 1), currentPage === 1, false);
            for (var p = 1; p <= pages; p++) addPage(String(p), p, false, p === currentPage);
            addPage('›', Math.min(pages, currentPage + 1), currentPage === pages, false);
            addPage('»', pages, currentPage === pages, false);
        }

        if (info) {
            var showingStart = total === 0 ? 0 : start + 1;
            var showingEnd = Math.min(total, end);
            info.textContent = 'Showing ' + showingStart + '–' + showingEnd + ' of ' + total + ' students';
        }

        // Init tooltips for visible page
        if (window.jQuery && typeof jQuery.fn.tooltip === 'function') {
            jQuery('[data-toggle="tooltip"]').tooltip({ container: 'body' });
        }

        // Attach checkbox box click handlers (idempotent binding)
        var boxes = document.querySelectorAll('.ibox');
        boxes.forEach(function(box){
            box.onclick = function(ev){
                var isChecked = box.classList.contains('checked');
                if (isChecked) {
                    var ok = confirm('Uncheck? This will mark it as not graded.');
                    if (!ok) return;
                    box.classList.remove('checked');
                    box.setAttribute('aria-checked', 'false');
                } else {
                    box.classList.add('checked');
                    box.setAttribute('aria-checked', 'true');
                }
            };
            box.setAttribute('tabindex', '0');
            box.onkeydown = function(e){
                if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); box.click(); }
            };
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterRows);
    if (rows.length) paginate();
})();
</script>
<script src="assets/js/vendor-all.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/pcoded.min.js"></script>
</body>
</html>