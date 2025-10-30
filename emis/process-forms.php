<?php
// process_form.php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Database configuration
include '../includes/database.php';

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit();
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate required fields
function validate_required($fields) {
    foreach ($fields as $field => $value) {
        if (empty($value)) {
            return "Field '$field' is required.";
        }
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Start transaction
        $conn->begin_transaction();
        
        // Personal Information
        $teacherCode = sanitize_input($_POST['teacherCode']);
        $schoolStatus = sanitize_input($_POST['schoolStatus']);
        $firstName = sanitize_input($_POST['firstName']);
        $surname = sanitize_input($_POST['surname']);
        $otherNames = isset($_POST['otherNames']) ? sanitize_input($_POST['otherNames']) : '';
        $dob = sanitize_input($_POST['dob']);
        $sex = sanitize_input($_POST['sex']);
        $maritalStatus = sanitize_input($_POST['maritalStatus']);
        $phone = sanitize_input($_POST['phone']);
        $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
        $ghCard = isset($_POST['ghCard']) ? sanitize_input($_POST['ghCard']) : '';
        $ssnit = sanitize_input($_POST['ssnit']);
        
        // Validate required fields
        $requiredFields = [
            'Teacher Code' => $teacherCode,
            'School Status' => $schoolStatus,
            'First Name' => $firstName,
            'Surname' => $surname,
            'Date of Birth' => $dob,
            'Sex' => $sex,
            'Marital Status' => $maritalStatus,
            'Phone Number' => $phone,
            'SSNIT Number' => $ssnit
        ];
        
        $validationError = validate_required($requiredFields);
        if ($validationError) {
            throw new Exception($validationError);
        }
        
        // Check if teacher code already exists
        $checkStmt = $conn->prepare("SELECT id FROM teachers WHERE teacher_code = ?");
        $checkStmt->bind_param("s", $teacherCode);
        $checkStmt->execute();
        $checkStmt->store_result();
        
        if ($checkStmt->num_rows > 0) {
            throw new Exception("Teacher code already exists. Please use a unique teacher code.");
        }
        $checkStmt->close();
        
        // Insert personal information into teachers table
        $teacherStmt = $conn->prepare("INSERT INTO teachers (
            teacher_code, school_status, first_name, surname, other_names, 
            date_of_birth, sex, marital_status, phone_number, email, 
            gh_card_number, ssnit_number
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $teacherStmt->bind_param(
            "ssssssssssss", 
            $teacherCode, $schoolStatus, $firstName, $surname, $otherNames,
            $dob, $sex, $maritalStatus, $phone, $email, $ghCard, $ssnit
        );
        
        if (!$teacherStmt->execute()) {
            throw new Exception("Error saving teacher information: " . $teacherStmt->error);
        }
        
        $teacherId = $conn->insert_id;
        $teacherStmt->close();
        
        // Professional Information
        $profStatus = sanitize_input($_POST['profStatus']);
        
        // Initialize professional fields
        $teacherType = null;
        $basicLevel = null;
        $basicSubject = null;
        $modeQualification = null;
        $academicQualification = null;
        $professionalCert = null;
        $basicClasses = [];
        
        if ($profStatus === 'Trained') {
            $teacherType = isset($_POST['teacherType']) ? sanitize_input($_POST['teacherType']) : null;
            $basicLevel = isset($_POST['basicLevel']) ? sanitize_input($_POST['basicLevel']) : null;
            $basicSubject = isset($_POST['basicSubject']) ? sanitize_input($_POST['basicSubject']) : null;
            $modeQualification = isset($_POST['modeQualification']) ? sanitize_input($_POST['modeQualification']) : null;
            $academicQualification = isset($_POST['academicQualification']) ? sanitize_input($_POST['academicQualification']) : null;
            $professionalCert = isset($_POST['professionalCert']) ? sanitize_input($_POST['professionalCert']) : null;
            
            // Get classes for trained teacher
            if (isset($_POST['basicClasses']) && $teacherType === 'Class') {
                foreach ($_POST['basicClasses'] as $class) {
                    $basicClasses[] = sanitize_input($class);
                }
            }
        } else {
            // Untrained teacher
            $teacherType = isset($_POST['teacherTypeUntrained']) ? sanitize_input($_POST['teacherTypeUntrained']) : null;
            $basicLevel = isset($_POST['basicLevelUntrained']) ? sanitize_input($_POST['basicLevelUntrained']) : null;
            $basicSubject = isset($_POST['basicSubjectUntrained']) ? sanitize_input($_POST['basicSubjectUntrained']) : null;
            
            // Get classes for untrained teacher
            if (isset($_POST['basicClassesUntrained']) && $teacherType === 'Class') {
                foreach ($_POST['basicClassesUntrained'] as $class) {
                    $basicClasses[] = sanitize_input($class);
                }
            }
        }
        
        // Insert professional information
        $profStmt = $conn->prepare("INSERT INTO teacher_professional_info (
            teacher_id, professional_status, teacher_type, basic_level, basic_subject,
            mode_of_qualification, academic_qualification, professional_certificate
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $profStmt->bind_param(
            "isssssss",
            $teacherId, $profStatus, $teacherType, $basicLevel, $basicSubject,
            $modeQualification, $academicQualification, $professionalCert
        );
        
        if (!$profStmt->execute()) {
            throw new Exception("Error saving professional information: " . $profStmt->error);
        }
        $profStmt->close();
        
        // Insert classes if any
        if (!empty($basicClasses)) {
            $classStmt = $conn->prepare("INSERT INTO teacher_classes (teacher_id, class_name) VALUES (?, ?)");
            
            foreach ($basicClasses as $className) {
                $classStmt->bind_param("is", $teacherId, $className);
                if (!$classStmt->execute()) {
                    throw new Exception("Error saving class information: " . $classStmt->error);
                }
            }
            $classStmt->close();
        }
        
        // Commit transaction
        $conn->commit();
        
        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'Teacher registration completed successfully!',
            'teacher_id' => $teacherId
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
}

$conn->close();
?>