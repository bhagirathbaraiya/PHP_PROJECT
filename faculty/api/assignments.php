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

// Verify class ownership for actions involving class
if (in_array($action, ['create', 'update', 'delete'], true)) {
    if ($classId <= 0 || $facultyId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid identifiers']);
        exit();
    }
    $verifyQuery = "SELECT id FROM class WHERE id = ? AND host_id = ?";
    if ($stmt = mysqli_prepare($con, $verifyQuery)) {
        mysqli_stmt_bind_param($stmt, 'ii', $classId, $facultyId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($res) === 0) {
            echo json_encode(['success' => false, 'message' => 'Class not found or access denied']);
            mysqli_stmt_close($stmt);
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

if ($action === 'create') {
    $name = isset($input['name']) ? trim($input['name']) : '';
    $description = isset($input['description']) ? trim($input['description']) : '';
    $due = isset($input['due_date']) ? trim($input['due_date']) : '';
    if ($name === '' || $due === '') {
        echo json_encode(['success' => false, 'message' => 'Name and due date are required']);
        exit();
    }
    $ins = mysqli_prepare($con, "INSERT INTO assignments (name, description, due_date, class_id, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    mysqli_stmt_bind_param($ins, 'sssi', $name, $description, $due, $classId);
    $ok = mysqli_stmt_execute($ins);
    $newId = $ok ? mysqli_insert_id($con) : 0;
    mysqli_stmt_close($ins);
    echo json_encode(['success' => (bool)$ok, 'id' => $newId]);
    exit();
}

if ($action === 'update') {
    $id = isset($input['id']) ? intval($input['id']) : 0;
    $name = isset($input['name']) ? trim($input['name']) : '';
    $description = isset($input['description']) ? trim($input['description']) : '';
    $due = isset($input['due_date']) ? trim($input['due_date']) : '';
    if ($id <= 0 || $name === '' || $due === '') {
        echo json_encode(['success' => false, 'message' => 'Invalid payload']);
        exit();
    }
    // ensure assignment belongs to class
    $chk = mysqli_prepare($con, "SELECT id FROM assignments WHERE id = ? AND class_id = ?");
    mysqli_stmt_bind_param($chk, 'ii', $id, $classId);
    mysqli_stmt_execute($chk);
    $res = mysqli_stmt_get_result($chk);
    if (mysqli_num_rows($res) === 0) {
        echo json_encode(['success' => false, 'message' => 'Assignment not found']);
        mysqli_stmt_close($chk);
        exit();
    }
    mysqli_stmt_close($chk);

    $upd = mysqli_prepare($con, "UPDATE assignments SET name = ?, description = ?, due_date = ?, updated_at = NOW() WHERE id = ?");
    mysqli_stmt_bind_param($upd, 'sssi', $name, $description, $due, $id);
    $ok = mysqli_stmt_execute($upd);
    mysqli_stmt_close($upd);
    echo json_encode(['success' => (bool)$ok]);
    exit();
}

if ($action === 'delete') {
    $id = isset($input['id']) ? intval($input['id']) : 0;
    if ($id <= 0) { echo json_encode(['success' => false, 'message' => 'Invalid id']); exit(); }
    // ensure assignment belongs to class
    $chk = mysqli_prepare($con, "SELECT id FROM assignments WHERE id = ? AND class_id = ?");
    mysqli_stmt_bind_param($chk, 'ii', $id, $classId);
    mysqli_stmt_execute($chk);
    $res = mysqli_stmt_get_result($chk);
    if (mysqli_num_rows($res) === 0) {
        echo json_encode(['success' => false, 'message' => 'Assignment not found']);
        mysqli_stmt_close($chk);
        exit();
    }
    mysqli_stmt_close($chk);
    // delete submissions first (FK safety if any)
    $delSub = mysqli_prepare($con, "DELETE FROM assignment_submissions WHERE assignment_id = ?");
    mysqli_stmt_bind_param($delSub, 'i', $id);
    mysqli_stmt_execute($delSub);
    mysqli_stmt_close($delSub);
    // delete assignment
    $del = mysqli_prepare($con, "DELETE FROM assignments WHERE id = ?");
    mysqli_stmt_bind_param($del, 'i', $id);
    $ok = mysqli_stmt_execute($del);
    mysqli_stmt_close($del);
    echo json_encode(['success' => (bool)$ok]);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Unknown action']);
?>


