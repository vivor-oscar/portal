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

try {
    $sql = "SELECT 
                t.id, t.teacher_code, t.school_status, t.first_name, t.surname, 
                t.other_names, t.date_of_birth, t.sex, t.marital_status, 
                t.phone_number, t.email, t.gh_card_number, t.ssnit_number,
                t.created_at,
                p.professional_status, p.teacher_type, p.basic_level, p.basic_subject
            FROM teachers t
            LEFT JOIN teacher_professional_info p ON t.id = p.teacher_id
            ORDER BY t.created_at DESC";
    
    $result = $conn->query($sql);
    
    if ($result) {
        $teachers = [];
        while ($row = $result->fetch_assoc()) {
            $teachers[] = $row;
        }
        
        echo json_encode([
            'success' => true,
            'teachers' => $teachers
        ]);
    } else {
        throw new Exception('Failed to fetch teachers: ' . $conn->error);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>