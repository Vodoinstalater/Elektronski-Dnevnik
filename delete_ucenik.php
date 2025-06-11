<?php
include 'dbcon.php';

if(isset($_POST["delete_ucenik"])) {
    $id = $_POST['id'];

    // Use prepared statement to prevent SQL injection
    $query = "DELETE FROM `ucenik` WHERE `id` = ?";
    $stmt = mysqli_prepare($connection, $query);
    
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);
        
        if($result) {
            header('location:index.php?message=Ucenik je uspesno obrisan');
        } else {
            header('location:index.php?message=Greska pri brisanju ucenika: ' . mysqli_error($connection));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('location:index.php?message=Greska pri pripremi upita: ' . mysqli_error($connection));
    }
} else {
    // If accessed directly without POST data, redirect to index
    header('location:index.php');
}
?>
