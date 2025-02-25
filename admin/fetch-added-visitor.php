<?php
include '../includes/database.php';

$limit = 7; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

// Count total rows with search filter
$totalRowsQuery = "
    SELECT COUNT(*) AS total 
    FROM visitors 
    INNER JOIN time_logs ON visitors.id = time_logs.client_id
";
$totalRowsResult = $conn->query($totalRowsQuery);
$totalRows = $totalRowsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit); 

$stmt = $conn->prepare("
    SELECT 
        visitors.id,
        visitors.first_name,
        visitors.middle_name,
        visitors.last_name,
        sex.sex_name ,
        visitors.age,
        visitors.static_code,
        visitors.type      
    FROM 
        visitors
    INNER JOIN 
        sex 
    ON 
        visitors.sex_id = sex.id
        ORDER BY created_at DESC 
        
    LIMIT $limit OFFSET $offset");
$stmt->execute();
$result = $stmt->get_result(); 
?>
