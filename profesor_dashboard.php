<?php
// Initialize session
session_start();

// Check if user is logged in and is a profesor
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'profesor') {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

include 'dbcon.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor Dashboard - Elektronski Dnevnik</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e8ecf0;
            margin-bottom: 30px;
        }
        
        .user-welcome {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
        }
        
        .user-info h1 {
            margin: 0;
            font-size: 1.5em;
            color: #2c3e50;
        }
        
        .user-info p {
            margin: 5px 0 0;
            color: #6c757d;
        }
        
        .logout-btn {
            padding: 8px 15px;
            font-size: 0.9em;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .sidebar {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }
        
        .sidebar-menu a.active {
            border-left: 3px solid #667eea;
            font-weight: 600;
        }
        
        .content-area {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }
        
        .dashboard-title {
            margin-top: 0;
            margin-bottom: 25px;
            color: #2c3e50;
            font-size: 1.8em;
            font-weight: 600;
            border-bottom: 2px solid #e8ecf0;
            padding-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .dashboard-header {
                flex-direction: column;
                text-align: center;
            }
            
            .user-welcome {
                margin-bottom: 15px;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <div class="user-welcome">
            <div class="user-avatar">
                <?php echo substr($_SESSION['username'], 0, 1); ?>
            </div>
            <div class="user-info">
                <h1>Dobrodošli, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
                <p>Profesor</p>
            </div>
        </div>
        
        <a href="logout.php" class="btn btn-primary logout-btn">Odjavi se</a>
    </div>
    
    <div class="dashboard-container">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#" class="active">Početna</a></li>
                <li><a href="#">Učenici</a></li>
                <li><a href="#">Ocene</a></li>
                <li><a href="#">Izveštaji</a></li>
                <li><a href="#">Moj profil</a></li>
            </ul>
        </div>
        
        <div class="content-area">
            <h2 class="dashboard-title">Profesor Dashboard</h2>
            
            <!-- Subjects Section -->
            <div class="adding">
                <h3>Moji predmeti:</h3>
            </div>

            <div class="tabela"></div>  
           
            <table>
                <thead>
                    <tr>
                        <th>Naziv predmeta</th>
                        <th>Razred</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    $profesor_id = $_SESSION['user_id'];
                    $query = 'SELECT pr.naziv, pr.razred 
                              FROM drzi d 
                              JOIN predmet pr ON d.predmet_id = pr.id 
                              WHERE d.profesor_id = ? 
                              ORDER BY pr.razred, pr.naziv';
                    
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "i", $profesor_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    if (!$result){
                        die("query Failed".mysqli_error($connection));
                    } else{
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                                ?>
                            <tr>
                                <td><?php echo $row['naziv'];?></td>
                                <td><?php echo $row['razred'];?></td>
                            </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="2" style="text-align: center;">Trenutno nemate dodeljenih predmeta.</td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                </tbody>
            </table>
            
            <!-- Students Section - Only showing students in classes that the professor teaches -->
            <div class="adding" style="margin-top: 30px;">
                <h3>Moji učenici:</h3>
            </div>

            <div class="tabela"></div>  
           
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Razred</th>
                        <th>Predmet</th>
                        <th>Akcije</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    $profesor_id = $_SESSION['user_id'];
                    
                    // Get the grade levels (razred) of subjects taught by this professor
                    $query = 'SELECT DISTINCT pr.razred 
                              FROM drzi d 
                              JOIN predmet pr ON d.predmet_id = pr.id 
                              WHERE d.profesor_id = ?';
                    
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "i", $profesor_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    if (!$result) {
                        die("Query Failed: " . mysqli_error($connection));
                    }
                    
                    // Create an array of grade levels taught by this professor
                    $taught_grades = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $taught_grades[] = $row['razred'];
                    }
                    
                    if (count($taught_grades) > 0) {
                        // Create a comma-separated list of grade levels for the IN clause
                        $grade_list = implode(',', $taught_grades);
                        
                        // Get students in those grade levels
                        $query = "SELECT u.*, GROUP_CONCAT(DISTINCT p.naziv SEPARATOR ', ') as predmeti 
                                  FROM ucenik u 
                                  JOIN predmet p ON u.razred = p.razred 
                                  JOIN drzi d ON p.id = d.predmet_id 
                                  WHERE u.razred IN ($grade_list) 
                                  AND d.profesor_id = ? 
                                  GROUP BY u.id 
                                  ORDER BY u.razred, u.odeljenje, u.prezime, u.ime";
                        
                        $stmt = mysqli_prepare($connection, $query);
                        mysqli_stmt_bind_param($stmt, "i", $profesor_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        if (!$result) {
                            die("Query Failed: " . mysqli_error($connection));
                        }
                        
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['ime']; ?></td>
                                <td><?php echo $row['prezime']; ?></td>
                                <td><?php echo $row['razred'] . '-' . $row['odeljenje']; ?></td>
                                <td><?php echo $row['predmeti']; ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="openGradeModal(<?php echo $row['id']; ?>, '<?php echo $row['ime'] . ' ' . $row['prezime']; ?>', <?php echo $row['razred']; ?>)">Oceni</button>
                                </td>
                            </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Nema učenika u razredima koje predajete.</td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Nemate dodeljenih predmeta.</td>
                        </tr>
                        <?php
                    }
                ?>

                </tbody>
            </table>
        </div>
    </div>
    
    <?php 
    if(isset($_GET['message'])){
        echo "<div class='message-popup'>" . $_GET['message'] . "</div>";
    }
    ?>
    
    <!-- Include all the modals from index.php -->
    <?php include 'profesor_modals.php'; ?>
    <?php include 'grade_modal.php'; ?>
    
    <style>
        .message-popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease, fadeOut 0.5s ease 3s forwards;
        }
        
        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
            }
        }
    </style>
</body>
</html>
