<?php
include 'dbcon.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT id, ime, prezime, login FROM `profesor` WHERE id=$id";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    }
}
?>
