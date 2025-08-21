<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/include/config.php';

if (!isset($_SESSION['alogin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Determine faculty ID (erno)
$facultyId = isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0;
if ($facultyId <= 0) {
    // Fallback: resolve by email
    $email = $_SESSION['alogin'];
    if (!empty($email)) {
        if ($stmt = mysqli_prepare($con, 'SELECT erno FROM faculty WHERE email = ? LIMIT 1')) {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($res)) {
                $facultyId = (int)$row['erno'];
            }
            mysqli_stmt_close($stmt);
        }
    }
}
if ($facultyId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid faculty session']);
    exit;
}

// Validate input
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$grnosRaw = isset($_POST['grnos']) ? $_POST['grnos'] : '';

if ($name === '') {
    echo json_encode(['success' => false, 'message' => 'Class name is required']);
    exit;
}

mysqli_begin_transaction($con);
try {
    // Insert class
    $stmt = mysqli_prepare($con, "INSERT INTO `class` (`host_id`, `name`, `description`) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception('Failed to prepare class creation: '.mysqli_error($con));
    }
    mysqli_stmt_bind_param($stmt, 'iss', $facultyId, $name, $description);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Failed to create class: '.mysqli_error($con));
    }
    $classId = mysqli_insert_id($con);
    mysqli_stmt_close($stmt);

    $addedCount = 0;
    $notFound = [];
    $alreadyEnrolled = [];

    // Parse GRNOs
    $grnos = [];
    if (!empty($grnosRaw)) {
        $tokens = preg_split('/[\s,\n\r]+/', $grnosRaw);
        foreach ($tokens as $token) {
            $token = trim($token);
            if ($token === '') continue;
            if (ctype_digit($token)) {
                $grnos[] = (int)$token;
            }
        }
        $grnos = array_values(array_unique($grnos));
    }

    if (!empty($grnos)) {
        // Prepare reusable statements
        $checkStudentStmt = mysqli_prepare($con, 'SELECT 1 FROM `students` WHERE `grno` = ? LIMIT 1');
        $checkEnrollStmt = mysqli_prepare($con, 'SELECT 1 FROM `student_to_class` WHERE `class_id` = ? AND `grno` = ? LIMIT 1');
        $insertEnrollStmt = mysqli_prepare($con, 'INSERT INTO `student_to_class` (`grno`, `class_id`) VALUES (?, ?)');

        if (!$checkStudentStmt || !$checkEnrollStmt || !$insertEnrollStmt) {
            throw new Exception('Failed to prepare enrollment statements: '.mysqli_error($con));
        }

        foreach ($grnos as $gr) {
            // Check student exists
            mysqli_stmt_bind_param($checkStudentStmt, 'i', $gr);
            mysqli_stmt_execute($checkStudentStmt);
            mysqli_stmt_store_result($checkStudentStmt);
            if (mysqli_stmt_num_rows($checkStudentStmt) === 0) {
                $notFound[] = $gr;
                continue;
            }

            // Check already enrolled
            mysqli_stmt_bind_param($checkEnrollStmt, 'ii', $classId, $gr);
            mysqli_stmt_execute($checkEnrollStmt);
            mysqli_stmt_store_result($checkEnrollStmt);
            if (mysqli_stmt_num_rows($checkEnrollStmt) > 0) {
                $alreadyEnrolled[] = $gr;
                continue;
            }

            // Insert enrollment
            mysqli_stmt_bind_param($insertEnrollStmt, 'ii', $gr, $classId);
            if (mysqli_stmt_execute($insertEnrollStmt)) {
                $addedCount++;
            }
        }

        mysqli_stmt_close($checkStudentStmt);
        mysqli_stmt_close($checkEnrollStmt);
        mysqli_stmt_close($insertEnrollStmt);
    }

    mysqli_commit($con);
    echo json_encode([
        'success' => true,
        'class_id' => $classId,
        'added_count' => $addedCount,
        'not_found' => $notFound,
        'already_enrolled' => $alreadyEnrolled
    ]);
    exit;
} catch (Throwable $e) {
    mysqli_rollback($con);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    exit;
}


