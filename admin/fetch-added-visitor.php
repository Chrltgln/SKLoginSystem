<?php
include '../includes/database.php';

$limit = 7;
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total rows with search filter
$totalRowsQuery = "
    SELECT COUNT(*) AS total 
    FROM visitors 
    INNER JOIN time_logs ON visitors.id = time_logs.client_id
    INNER JOIN email ON visitors.id = email.client_id
    INNER JOIN sex ON visitors.sex_id = sex.id
    WHERE visitors.type IN ('CHAIRPERSON', 'COUNCILOR')
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
        visitors.sex_id,
        sex.sex_name,
        visitors.age,
        visitors.static_code,
        visitors.type,
        email.email,
        visitors.static_code
    FROM 
        visitors
    INNER JOIN 
        sex ON visitors.sex_id = sex.id
    INNER JOIN
        email ON visitors.id = email.client_id
    WHERE 
        visitors.type IN ('CHAIRPERSON', 'COUNCILOR')
    ORDER BY 
        visitors.created_at DESC 
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>
