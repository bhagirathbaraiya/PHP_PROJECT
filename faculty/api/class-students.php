<?php
session_start();
header('Content-Type: application/json');

require_once('../include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) $input = [];

$action = isset($input['action']) ? trim($input['action']) : '';
$classId = isset($input['class_id']) && is_numeric($input['class_id']) ? intval($input['class_id']) : 0;
$grnos = isset($input['grnos']) && is_array($input['grnos']) ? $input['grnos'] : [];

if (!in_array($action, ['add', 'remove'], true) || $classId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$facultyId = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
if ($facultyId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Faculty not identified']);
    exit();
}

// Verify class ownership
$verifyQuery = "SELECT id FROM class WHERE id = ? AND host_id = ?";
if (!$stmt = mysqli_prepare($con, $verifyQuery)) {
    echo json_encode(['success' => false, 'message' => 'Database error (prepare)']);
    exit();
}
mysqli_stmt_bind_param($stmt, 'ii', $classId, $facultyId);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$owns = mysqli_num_rows($res) > 0;
mysqli_stmt_close($stmt);
if (!$owns) {
    echo json_encode(['success' => false, 'message' => 'Class not found or access denied']);
    exit();
}

// Normalize GRNOs
$grnos = array_values(array_unique(array_filter(array_map(function($x){
    if (is_string($x)) $x = trim($x);
    if ($x === '' || $x === null) return null;
    if (!is_numeric($x)) return null;
    return intval($x);
}, $grnos), function($v){ return $v !== null; })));

if (empty($grnos)) {
    echo json_encode(['success' => false, 'message' => 'No GRNOs provided']);
    exit();
}

// Check which GRNOs exist
$placeholders = implode(',', array_fill(0, count($grnos), '?'));
$types = str_repeat('i', count($grnos));

$exists = [];
if ($q = mysqli_prepare($con, "SELECT grno FROM students WHERE grno IN ($placeholders)")) {
    mysqli_stmt_bind_param($q, $types, ...$grnos);
    mysqli_stmt_execute($q);
    $r = mysqli_stmt_get_result($q);
    while ($row = mysqli_fetch_assoc($r)) { $exists[] = intval($row['grno']); }
    mysqli_stmt_close($q);
}

$notFound = array_values(array_diff($grnos, $exists));

if ($action === 'add') {
    // Find already enrolled
    $enrolled = [];
    if (!empty($exists)) {
        $ph2 = implode(',', array_fill(0, count($exists), '?'));
        $types2 = str_repeat('i', count($exists) + 1);
        $params = array_merge([$classId], $exists);

        if ($q2 = mysqli_prepare($con, "SELECT grno FROM student_to_class WHERE class_id = ? AND grno IN ($ph2)")) {
            mysqli_stmt_bind_param($q2, $types2, ...$params);
            mysqli_stmt_execute($q2);
            $r2 = mysqli_stmt_get_result($q2);
            while ($row = mysqli_fetch_assoc($r2)) { $enrolled[] = intval($row['grno']); }
            mysqli_stmt_close($q2);
        }
    }

    $toAdd = array_values(array_diff($exists, $enrolled));
    $addedCount = 0;
    if (!empty($toAdd)) {
        $ins = mysqli_prepare($con, "INSERT INTO student_to_class (grno, class_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        foreach ($toAdd as $gr) {
            mysqli_stmt_bind_param($ins, 'ii', $gr, $classId);
            mysqli_stmt_execute($ins);
            if (mysqli_affected_rows($con) > 0) $addedCount++;
        }
        mysqli_stmt_close($ins);
    }

    echo json_encode([
        'success' => true,
        'added_count' => $addedCount,
        'already_enrolled' => $enrolled,
        'not_found' => $notFound
    ]);
    exit();
}

if ($action === 'remove') {
    // Remove only those currently enrolled
    $inClass = [];
    if (!empty($exists)) {
        $ph2 = implode(',', array_fill(0, count($exists), '?'));
        $types2 = str_repeat('i', count($exists) + 1);
        $params = array_merge([$classId], $exists);
        if ($q2 = mysqli_prepare($con, "SELECT grno FROM student_to_class WHERE class_id = ? AND grno IN ($ph2)")) {
            mysqli_stmt_bind_param($q2, $types2, ...$params);
            mysqli_stmt_execute($q2);
            $r2 = mysqli_stmt_get_result($q2);
            while ($row = mysqli_fetch_assoc($r2)) { $inClass[] = intval($row['grno']); }
            mysqli_stmt_close($q2);
        }
    }

    $notInClass = array_values(array_diff($grnos, $inClass));
    $removed = 0;
    if (!empty($inClass)) {
        $ph3 = implode(',', array_fill(0, count($inClass), '?'));
        $types3 = str_repeat('i', count($inClass) + 1);
        $params3 = array_merge([$classId], $inClass);
        if ($del = mysqli_prepare($con, "DELETE FROM student_to_class WHERE class_id = ? AND grno IN ($ph3)")) {
            mysqli_stmt_bind_param($del, $types3, ...$params3);
            mysqli_stmt_execute($del);
            $removed = mysqli_affected_rows($con);
            mysqli_stmt_close($del);
        }
    }

    echo json_encode([
        'success' => true,
        'removed_count' => $removed,
        'not_in_class' => $notInClass
    ]);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Unknown action']);
?>


