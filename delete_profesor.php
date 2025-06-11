<?php
include 'dbcon.php';

if(isset($_POST['delete_profesor'])) {
    $id = $_POST['id'];
    
    $query = "DELETE FROM `profesor` WHERE id=$id";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: index.php?message=Professor deleted successfully');
    }
}
?>
