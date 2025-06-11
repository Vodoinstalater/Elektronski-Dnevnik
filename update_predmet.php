<?php
include 'dbcon.php';

if(isset($_POST['update_predmet'])) {
    $id = $_POST['id'];
    $naziv = $_POST['naziv'];
    $razred = $_POST['razred'];
    
    $query = "UPDATE predmet SET naziv = '$naziv', razred = '$razred' WHERE id = $id";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: index.php?message=Predmet uspešno ažuriran');
    }
}
?>
