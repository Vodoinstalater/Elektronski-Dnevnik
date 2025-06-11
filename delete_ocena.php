<?php
session_start();
include 'dbcon.php';

// Check if user is logged in and is an admin (or has appropriate permissions)
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

if(isset($_POST['delete_ocena'])) {
    $id = $_POST['id'];
    
    // Only admin or the professor who created the grade can delete it
    if($_SESSION['user_type'] == 'profesor') {
        // Check if this professor created the grade
        $check_query = "SELECT * FROM ocena WHERE id = ? AND profesor_id = ?";
        $check_stmt = mysqli_prepare($connection, $check_query);
        mysqli_stmt_bind_param($check_stmt, "ii", $id, $_SESSION['user_id']);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        
        if(mysqli_num_rows($check_result) == 0) {
            // Professor didn't create this grade
            header('location: profesor_dashboard.php?message=Nemate pravo da obrišete ovu ocenu!');
            exit();
        }
    }
    
    // Delete the grade
    $query = "DELETE FROM ocena WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        // Redirect based on user type
        if($_SESSION['user_type'] == 'profesor') {
            header('location: profesor_dashboard.php?message=Ocena uspešno obrisana!');
        } else {
            header('location: index.php?message=Ocena uspešno obrisana!');
        }
    }
}
?>
