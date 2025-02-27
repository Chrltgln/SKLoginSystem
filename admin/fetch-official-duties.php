<?php
include '../includes/database.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 7; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

// Prepare SQL for counting total rows
$totalRowsQuery = "
    SELECT COUNT(*) AS total 
    FROM visitors 
    INNER JOIN time_logs ON visitors.id = time_logs.client_id
    WHERE CONCAT(visitors.first_name, ' ', visitors.middle_name, ' ', visitors.last_name) LIKE ? 
    AND visitors.type IN ('CHAIRPERSON', 'COUNCILOR')
";

$stmt = $conn->prepare($totalRowsQuery);
$searchParam = "%$search%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
$totalRows = $result->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);


$visitorsQuery = "
    SELECT DISTINCT
        visitors.first_name,
        visitors.middle_name,
        visitors.last_name,
        visitors.age,
        visitors.sex_id,
        sex.sex_name,
        time_logs.time_in,
        time_logs.time_out,
        time_logs.code,
        purpose.purpose
    FROM visitors
        INNER JOIN time_logs ON visitors.id = time_logs.client_id
        INNER JOIN sex ON visitors.sex_id = sex.id
        INNER JOIN (SELECT client_id, MAX(id) AS latest_purpose_id FROM purpose GROUP BY client_id) AS latest_purposes ON visitors.id = latest_purposes.client_id
        INNER JOIN purpose ON latest_purposes.latest_purpose_id = purpose.id 
    WHERE CONCAT(visitors.first_name, ' ', visitors.middle_name, ' ', visitors.last_name) LIKE ? 
        AND visitors.type IN ('CHAIRPERSON', 'COUNCILOR')
    ORDER BY time_logs.time_in DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($visitorsQuery);
$stmt->bind_param("sii", $searchParam, $limit, $offset);
$stmt->execute();
$visitorsResult = $stmt->get_result();

if (isset($_GET['search'])) {
    if ($visitorsResult->num_rows > 0) {
        while ($row = $visitorsResult->fetch_assoc()) {
            echo "<tr>
                <td>" . strtoupper($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']) . "</td>
                <td>" . (isset($row['time_in']) ? date('Y-m-d', strtotime($row['time_in'])) : '-') . "</td>
                <td>" . (isset($row['time_in']) ? date('H:i:s', strtotime($row['time_in'])) : '-') . "</td>
                <td>" . (isset($row['time_out']) ? date('H:i:s', strtotime($row['time_out'])) : '-') . "</td>
                <td>";
            if (isset($row['time_in'], $row['time_out'])) {
                $timeIn = new DateTime($row['time_in']);
                $timeOut = new DateTime($row['time_out']);
                $interval = $timeIn->diff($timeOut);
                echo $interval->format('%h hours %i minutes %s seconds');
            } else {
                echo '-';
            }

            echo "</td>
                
                <td>
                    <button class='btn btn-success view-details'
                        data-name='" . strtoupper($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']) . "' 
                        data-age='{$row['age']}'
                        data-sex='{$row['sex_name']}'
                        data-code='{$row['code']}'
                        data-purpose='{$row['purpose']}'
                        data-bs-toggle='modal'
                        data-bs-target='#visitorDetailsModal'>
                        View Details
                    </button>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }
    exit;
}
?>
