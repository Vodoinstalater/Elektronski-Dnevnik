<?php
include 'dbcon.php';

if(isset($_POST["update_ucenik"])) {
    $id = $_POST['id'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $razred = $_POST['razred'];
    $odeljenje = $_POST['odeljenje'];
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

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

    // Prepare the statement based on whether password is being updated
    if(empty($password)) {
        // Don't update password if it's empty
        $query = "UPDATE `ucenik` SET `ime` = ?, `prezime` = ?, `razred` = ?, `odeljenje` = ?, `login` = ? WHERE `id` = ?";
        $stmt = mysqli_prepare($connection, $query);
        
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssi", $ime, $prezime, $razred, $odeljenje, $login, $id);
            $result = mysqli_stmt_execute($stmt);
        } else {
            $result = false;
        }
    } else {
        // Update password as well
        $query = "UPDATE `ucenik` SET `ime` = ?, `prezime` = ?, `razred` = ?, `odeljenje` = ?, `login` = ?, `password` = ? WHERE `id` = ?";
        $stmt = mysqli_prepare($connection, $query);
        
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssi", $ime, $prezime, $razred, $odeljenje, $login, $password, $id);
            $result = mysqli_stmt_execute($stmt);
        } else {
            $result = false;
        }
    }
    
    // Process the result
    if(isset($stmt)) {
        if($result) {
            // Check if we're coming from the professor dashboard
            if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'profesor_dashboard.php') !== false) {
                header('location:profesor_dashboard.php?message=Učenik je uspešno ažuriran');
            } else {
                header('location:index.php?message=Učenik je uspešno ažuriran');
            }
        } else {
            header('location:index.php?message=Greška pri ažuriranju učenika: ' . mysqli_error($connection));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('location:index.php?message=Greška pri pripremi upita: ' . mysqli_error($connection));
    }
} else {
    // If accessed directly without POST data, redirect to index
    header('location:index.php');
}
?>
