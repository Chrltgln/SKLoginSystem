<?php
include '../../includes/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = trim($_POST['id']);
    $type = trim($_POST['type']);
    $firstName = trim($_POST['firstname']);
    $middleName = trim($_POST['middlename']);
    $lastName = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $sex = trim($_POST['sex']);
    $age = trim($_POST['age']);
    $purpose = trim($_POST['purpose']);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format.";
        $_SESSION['message_type'] = "danger";
        header("Location: ../view-visitor.php");
        exit();
    }

    if (!is_numeric($age) || (int)$age <= 0) {
        $_SESSION['message'] = "Age must be a positive number.";
        $_SESSION['message_type'] = "danger";
        header("Location: ../view-visitor.php");
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update visitors table
        $queryVisitors = "
            UPDATE visitors 
            SET 
                first_name = ?, 
                middle_name = ?, 
                last_name = ?, 
                sex_id = ?, 
                age = ?, 
                type = ?
            WHERE id = ?
        ";
        $stmtVisitors = $conn->prepare($queryVisitors);
        $stmtVisitors->bind_param("ssssiss", $firstName, $middleName, $lastName, $sex, $age, $type, $id);
        $stmtVisitors->execute();

        // Update email table
        $queryEmail = "UPDATE email SET email = ? WHERE client_id = ?";
        $stmtEmail = $conn->prepare($queryEmail);
        $stmtEmail->bind_param("si", $email, $id);
        $stmtEmail->execute();

        // Update purpose table
        $queryPurpose = "UPDATE purpose SET purpose = ? WHERE client_id = ?";
        $stmtPurpose = $conn->prepare($queryPurpose);
        $stmtPurpose->bind_param("si", $purpose, $id);
        $stmtPurpose->execute();

        // Commit transaction
        $conn->commit();

        $_SESSION['message'] = "Visitor's details updated successfully.";
        $_SESSION['message_type'] = "success";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = "Failed to update visitor's details.";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: ../view-visitor.php");
    exit();
} else {
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../view-visitor.php");
    exit();
}
?>
