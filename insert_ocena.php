<?php
session_start();
include 'dbcon.php';

// Check if user is logged in and is a profesor
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'profesor') {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

if(isset($_POST['dodaj_ocenu'])) {
    $ucenik_id = $_POST['ucenik_id'];
    $predmet_id = $_POST['predmet_id'];
    $profesor_id = $_POST['profesor_id'];
    $vrednost = $_POST['vrednost'];
    $datum = $_POST['datum'];
    $komentar = isset($_POST['komentar']) ? $_POST['komentar'] : '';
    
    // Validate that this professor teaches this subject
    $check_query = "SELECT * FROM drzi WHERE profesor_id = ? AND predmet_id = ?";
    $check_stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($check_stmt, "ii", $profesor_id, $predmet_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if(mysqli_num_rows($check_result) == 0) {
        // Professor doesn't teach this subject
        header('location: profesor_dashboard.php?message=Nemate pravo da ocenjujete ovaj predmet!');
        exit();
    }
    
    // Validate that the student is in the correct grade for this subject
    $check_query = "SELECT u.razred, p.razred AS predmet_razred 
                   FROM ucenik u, predmet p 
                   WHERE u.id = ? AND p.id = ?";
    $check_stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($check_stmt, "ii", $ucenik_id, $predmet_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    $row = mysqli_fetch_assoc($check_result);
    
    if($row['razred'] != $row['predmet_razred']) {
        // Student is not in the correct grade for this subject
        header('location: profesor_dashboard.php?message=Učenik nije u odgovarajućem razredu za ovaj predmet!');
        exit();
    }
    
    // Insert the grade
    $query = "INSERT INTO ocena (ucenik_id, predmet_id, profesor_id, vrednost, datum, komentar) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "iiiiss", $ucenik_id, $predmet_id, $profesor_id, $vrednost, $datum, $komentar);
    $result = mysqli_stmt_execute($stmt);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: profesor_dashboard.php?message=Ocena uspešno dodata!');
    }
}
?>
