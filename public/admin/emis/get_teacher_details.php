<?php
header('Content-Type: application/json');

// Database configuration
include '../../../includes/database.php';

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid teacher ID']);
    exit();
}

$teacherId = (int)$_GET['id'];

try {
    // Get teacher personal information
    $sql = "SELECT 
                t.*, p.professional_status, p.teacher_type, p.basic_level, 
                p.basic_subject, p.mode_of_qualification, p.academic_qualification, 
                p.professional_certificate
            FROM teachers t
            LEFT JOIN teacher_professional_info p ON t.id = p.teacher_id
            WHERE t.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacherId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Teacher not found']);
        exit();
    }
    
    $teacher = $result->fetch_assoc();
    $stmt->close();
    
    // Get teacher classes
    $classes = [];
    $classSql = "SELECT class_name FROM teacher_classes WHERE teacher_id = ?";
    $classStmt = $conn->prepare($classSql);
    $classStmt->bind_param("i", $teacherId);
    $classStmt->execute();
    $classResult = $classStmt->get_result();
    
    while ($row = $classResult->fetch_assoc()) {
        $classes[] = $row['class_name'];
    }
    $classStmt->close();
    
    $teacher['classes'] = $classes;
    
    echo json_encode([
        'success' => true,
        'teacher' => $teacher
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>