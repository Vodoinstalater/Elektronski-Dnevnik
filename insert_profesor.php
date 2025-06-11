<?php
include 'dbcon.php';

if(isset($_POST['dodaj_profesora'])) {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    
    $query = "INSERT INTO `profesor` (ime, prezime,login ,password) VALUES ('$ime', '$prezime','$ime','$ime')";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: index.php?message=Profesor je uspesno dodat u Bazu Podataka 👍');
    }
}
?>
