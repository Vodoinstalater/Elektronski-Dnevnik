<?php
include 'dbcon.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM `ucenik` WHERE `id` = ?";
    $stmt = mysqli_prepare($connection, $query);
    
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if($result) {
            $student = mysqli_fetch_assoc($result);
            echo json_encode($student);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Student not found']);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID is required']);
}
?>
