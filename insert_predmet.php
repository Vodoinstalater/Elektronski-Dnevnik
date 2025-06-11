<?php
include 'dbcon.php';

if(isset($_POST['dodaj_predmet'])) {
    $naziv = $_POST['naziv'];
    $razred = $_POST['razred'];
    
    $query = "INSERT INTO predmet (naziv, razred) VALUES ('$naziv', '$razred')";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: index.php?message=Predmet uspešno dodat');
    }
}
?>
