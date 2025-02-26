<?php
include '../../includes/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    
    $id = $_POST['id']; 

    $checkQuery = "SELECT * FROM visitors WHERE id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $deleteQuery = "DELETE FROM visitors WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Successfully deleted";
            $_SESSION['message_type'] = "success";
            header("Location: ../view-visitor.php");
            exit;
        } else {
            echo "Failed to delete account.";
        }
    } else {
        echo "Account not found.";
    }
} else {
    echo "Invalid request.";
}
?>
