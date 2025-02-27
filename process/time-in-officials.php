<?php

session_start();
date_default_timezone_set('Asia/Manila');

include '../includes/database.php';

if (isset($_POST['timeInForOfficials'])) {
    $staticCode = $_POST['codeForTimeIn'];

    // Query to get client_id and check if they are already timed in
    $checkTimeInQuery = "
        SELECT time_logs.id
        FROM time_logs
        INNER JOIN visitors ON time_logs.client_id = visitors.id
        WHERE visitors.static_code = ? 
          AND visitors.type IN ('CHAIRPERSON', 'COUNCILOR')
          AND time_logs.time_out IS NULL
    ";

    $stmtCheck = $conn->prepare($checkTimeInQuery);
    $stmtCheck->bind_param("s", $staticCode);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Official is already timed in
        $_SESSION['message'] = "You are already timed in. Please time out before recording a new time in.";
        $_SESSION['message_type'] = 'danger';
    } else {
        // Query to insert into `time_logs`
        $timeLogsQuery = "
            INSERT INTO time_logs (client_id, time_in, code)
            SELECT visitors.id, NOW(), visitors.static_code
            FROM visitors
            WHERE visitors.static_code = ? 
              AND visitors.type IN ('CHAIRPERSON', 'COUNCILOR')
        ";

        // Prepare and execute the first query
        $stmt = $conn->prepare($timeLogsQuery);
        $stmt->bind_param("s", $staticCode);

        if ($stmt->execute()) {
            // Get the `client_id` of the visitor
            $getClientIdQuery = "
                SELECT id FROM visitors
                WHERE static_code = ? 
                  AND type IN ('CHAIRPERSON', 'COUNCILOR')
            ";
            $stmtGetClientId = $conn->prepare($getClientIdQuery);
            $stmtGetClientId->bind_param("s", $staticCode);
            $stmtGetClientId->execute();
            $result = $stmtGetClientId->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $clientId = $row['id'];

                // Insert into the `purpose` table
                $purposeQuery = "
                    INSERT INTO purpose (client_id, purpose)
                    VALUES (?, 'ON DUTY')
                ";
                $stmtPurpose = $conn->prepare($purposeQuery);
                $stmtPurpose->bind_param("i", $clientId);

                if ($stmtPurpose->execute()) {
                    $_SESSION['message'] = "Successfully Time IN for officials.";
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = "Failed to log purpose.";
                    $_SESSION['message_type'] = 'danger';
                }

                $stmtPurpose->close();
            } else {
                $_SESSION['message'] = "No matching visitor found.";
                $_SESSION['message_type'] = 'warning';
            }

            $stmtGetClientId->close();
        } else {
            $_SESSION['message'] = "Failed to time in for officials.";
            $_SESSION['message_type'] = 'danger';
        }

        $stmt->close();
    }

    $stmtCheck->close();
}

header("Location: ../index.php");
exit();
