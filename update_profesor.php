<?php
include 'dbcon.php';

if(isset($_POST['update_profesor'])) {
    $id = $_POST['id'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    // If password is empty, don't update it
    if(empty($password)) {
        $query = "UPDATE `profesor` SET ime='$ime', prezime='$prezime', login='$login' WHERE id=$id";
    } else {
        $query = "UPDATE `profesor` SET ime='$ime', prezime='$prezime', login='$login', password='$password' WHERE id=$id";
    }
    
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        // Check if we're coming from the professor dashboard
        if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'profesor_dashboard.php') !== false) {
            header('location: profesor_dashboard.php?message=Profesor je uspešno izmenjen');
        } else {
            header('location: index.php?message=Profesor je uspešno izmenjen');
        }
    }
}
?>
