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
$facultyId = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;

if (!in_array($action, ['create', 'delete'], true) || $classId <= 0 || $facultyId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

// Verify class ownership
$verify = mysqli_prepare($con, "SELECT id FROM class WHERE id = ? AND host_id = ?");
mysqli_stmt_bind_param($verify, 'ii', $classId, $facultyId);
mysqli_stmt_execute($verify);
$res = mysqli_stmt_get_result($verify);
if (mysqli_num_rows($res) === 0) {
    echo json_encode(['success' => false, 'message' => 'Class not found or access denied']);
    mysqli_stmt_close($verify);
    exit();
}
mysqli_stmt_close($verify);

if ($action === 'create') {
    $ins = mysqli_prepare($con, "INSERT INTO notebook (class_id, created_at, updated_at) VALUES (?, NOW(), NOW())");
    mysqli_stmt_bind_param($ins, 'i', $classId);
    $ok = mysqli_stmt_execute($ins);
    $id = $ok ? mysqli_insert_id($con) : 0;
    mysqli_stmt_close($ins);
    echo json_encode(['success' => (bool)$ok, 'id' => $id]);
    exit();
}

if ($action === 'delete') {
    $id = isset($input['id']) ? intval($input['id']) : 0;
    if ($id <= 0) { echo json_encode(['success' => false, 'message' => 'Invalid id']); exit(); }
    // ensure notebook belongs to class
    $chk = mysqli_prepare($con, "SELECT id FROM notebook WHERE id = ? AND class_id = ?");
    mysqli_stmt_bind_param($chk, 'ii', $id, $classId);
    mysqli_stmt_execute($chk);
    $res = mysqli_stmt_get_result($chk);
    if (mysqli_num_rows($res) === 0) {
        echo json_encode(['success' => false, 'message' => 'Notebook not found']);
        mysqli_stmt_close($chk);
        exit();
    }
    mysqli_stmt_close($chk);
    // delete submissions first
    $delSub = mysqli_prepare($con, "DELETE FROM notebook_submissions WHERE notebook_id = ?");
    mysqli_stmt_bind_param($delSub, 'i', $id);
    mysqli_stmt_execute($delSub);
    mysqli_stmt_close($delSub);
    // delete notebook
    $del = mysqli_prepare($con, "DELETE FROM notebook WHERE id = ?");
    mysqli_stmt_bind_param($del, 'i', $id);
    $ok = mysqli_stmt_execute($del);
    mysqli_stmt_close($del);
    echo json_encode(['success' => (bool)$ok]);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Unknown action']);
?>


