<?php
include 'dbcon.php';

if(isset($_POST['delete_predmet'])) {
    $id = $_POST['id'];
    
    $query = "DELETE FROM predmet WHERE id = $id";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: index.php?message=Predmet uspešno obrisan');
    }
}
?>
