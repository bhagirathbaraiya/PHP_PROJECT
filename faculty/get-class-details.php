<?php
session_start();
include('include/config.php');

// Check if faculty is logged in
if(strlen($_SESSION['alogin']) == 0) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit();
}

// Validate class ID parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid class ID']);
    exit();
}

$class_id = intval($_GET['id']);
$faculty_id = $_SESSION['id'];

try {
    // First, verify that this class belongs to the logged-in faculty
    $verify_query = "SELECT id FROM class WHERE id = ? AND host_id = ?";
    $verify_stmt = mysqli_prepare($con, $verify_query);
    mysqli_stmt_bind_param($verify_stmt, "ii", $class_id, $faculty_id);
    mysqli_stmt_execute($verify_stmt);
    $verify_result = mysqli_stmt_get_result($verify_stmt);
    
    if (mysqli_num_rows($verify_result) == 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Class not found or access denied']);
        mysqli_stmt_close($verify_stmt);
        exit();
    }
    mysqli_stmt_close($verify_stmt);
    
    // Get class details with statistics
    $class_query = "SELECT c.*, 
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
                    WHERE c.id = ? 
                    GROUP BY c.id";
    
    $class_stmt = mysqli_prepare($con, $class_query);
    mysqli_stmt_bind_param($class_stmt, "i", $class_id);
    mysqli_stmt_execute($class_stmt);
    $class_result = mysqli_stmt_get_result($class_stmt);
    $class_data = mysqli_fetch_assoc($class_result);
    mysqli_stmt_close($class_stmt);
    
    if (!$class_data) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Class not found']);
        exit();
    }
    
    // Get students enrolled in this class
    $students_query = "SELECT s.grno, s.erno, s.fname, s.lname, s.email, s.status 
                       FROM students s 
                       INNER JOIN student_to_class sc ON s.grno = sc.grno 
                       WHERE sc.class_id = ? 
                       ORDER BY s.fname, s.lname";
    
    $students_stmt = mysqli_prepare($con, $students_query);
    mysqli_stmt_bind_param($students_stmt, "i", $class_id);
    mysqli_stmt_execute($students_stmt);
    $students_result = mysqli_stmt_get_result($students_stmt);
    $students_data = mysqli_fetch_all($students_result, MYSQLI_ASSOC);
    mysqli_stmt_close($students_stmt);
    
    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'class' => $class_data,
        'students' => $students_data
    ]);
    
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
