<?php
include 'dbcon.php';

if(isset($_POST["dodaj_ucenika"])) {
  
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $razred = $_POST['razred'];
    $odeljenje = $_POST['odeljenje'];

    // Validate all required fields
    if($ime == '' || empty($ime)) {
        header('location:index.php?message=Niste uneli ime!');
        exit();
    }
    if($prezime == '' || empty($prezime)) {
        header('location:index.php?message=Niste uneli prezime!');
        exit();
    }
    if($razred == '' || empty($razred)) {
        header('location:index.php?message=Niste izabrali razred!');
        exit();
    }
    if($odeljenje == '' || empty($odeljenje)) {
        header('location:index.php?message=Niste izabrali odeljenje!');
        exit();
    }

    // Use prepared statement to prevent SQL injection
    $query = "INSERT INTO `ucenik` (`ime`, `prezime`, `razred`, `odeljenje`,`login`,`password`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $ime, $prezime, $razred, $odeljenje, $ime, $ime);
        $result = mysqli_stmt_execute($stmt);
        
        if($result) {
            header('location:index.php?message=Ucenik je uspesno dodat');
        } else {
            header('location:index.php?message=Greska pri dodavanju ucenika: ' . mysqli_error($connection));
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
