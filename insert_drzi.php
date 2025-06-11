<?php
include 'dbcon.php';

if(isset($_POST['dodaj_drzi'])) {
    $profesor_id = $_POST['profesor_id'];
    $predmet_id = $_POST['predmet_id'];
    
    // Check if this relationship already exists
    $check_query = "SELECT * FROM drzi WHERE profesor_id = ? AND predmet_id = ?";
    $check_stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($check_stmt, "ii", $profesor_id, $predmet_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if(mysqli_num_rows($check_result) > 0) {
        // Relationship already exists
        header('location: index.php?message=Ova veza već postoji!');
        exit();
    }
    
    // Insert the new relationship
    $query = "INSERT INTO drzi (profesor_id, predmet_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ii", $profesor_id, $predmet_id);
    $result = mysqli_stmt_execute($stmt);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: index.php?message=Veza uspešno dodata');
    }
}
?>
