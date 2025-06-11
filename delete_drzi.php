<?php
include 'dbcon.php';

if(isset($_POST['delete_drzi'])) {
    $id = $_POST['id'];
    
    $query = "DELETE FROM drzi WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: index.php?message=Veza uspeu0161no obrisana');
    }
}
?>
