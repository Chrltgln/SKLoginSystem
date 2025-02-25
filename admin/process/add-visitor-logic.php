<?php
include '../../includes/database.php';

date_default_timezone_set('Asia/Manila');
session_start();

// Retrieve and sanitize inputs
$firstName = strtoupper(trim($_POST['firstname'] ?? ''));
$middleName = strtoupper(trim($_POST['middlename'] ?? ''));
$lastName = strtoupper(trim($_POST['lastname'] ?? ''));
$email = trim($_POST['email'] ?? '');
$age = (int) ($_POST['age'] ?? 0);
$sex = (int) ($_POST['sex'] ?? 0); 
$type = strtoupper(trim($_POST['role'] ?? '')); 

if (empty($firstName) || empty($lastName) || empty($email) || $age <= 0 || $sex <= 0 || empty($type)) {
    $_SESSION['error'] = 'Please fill out all required fields correctly.';
    header("Location: ../add-visitor-modal.php");
    exit();
}

function generateRandomCode($length = 6)
{
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}

$StaticCode = generateRandomCode();

try {
    $conn->begin_transaction();

    $addVisitorQuery = "
        INSERT INTO visitors (`first_name`, `middle_name`, `last_name`, `sex_id`, `age`, `static_code`, `type`, `created_at`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $visitorStmt = $conn->prepare($addVisitorQuery);
    $visitorStmt->bind_param("sssiiss", $firstName, $middleName, $lastName, $sex, $age, $StaticCode, $type);
    $visitorStmt->execute();
    $visitorId = $conn->insert_id; 

    $addEmailQuery = "
        INSERT INTO email (`client_id`, `email`) 
        VALUES (?, ?)";
    $emailStmt = $conn->prepare($addEmailQuery);
    $emailStmt->bind_param("is", $visitorId, $email);
    $emailStmt->execute();

    $conn->commit();

    $_SESSION['success'] = 'Visitor added successfully!';
    header("Location: ../view-visitor.php");
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error'] = 'Error adding visitor: ' . $e->getMessage();
    header("Location: ../view-visitor.php");
} finally {
    $visitorStmt->close();
    $emailStmt->close();
    $conn->close();
}
?>
