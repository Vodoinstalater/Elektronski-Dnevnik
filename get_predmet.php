<?php
include 'dbcon.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM predmet WHERE id = $id";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    }
    
    $row = mysqli_fetch_assoc($result);
    
    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($row);
}
?>
