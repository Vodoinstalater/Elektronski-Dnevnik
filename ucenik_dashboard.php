<?php
// Initialize session
session_start();

// Check if user is logged in and is a ucenik
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'ucenik') {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

include 'dbcon.php';

// Get student information
$student_id = $_SESSION['user_id'];
$query = "SELECT * FROM `ucenik` WHERE id = $student_id";
$result = mysqli_query($connection, $query);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Učenik Dashboard - Elektronski Dnevnik</title>
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
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
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
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
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
            background-color: rgba(106, 17, 203, 0.1);
            color: #6a11cb;
        }
        
        .sidebar-menu a.active {
            border-left: 3px solid #6a11cb;
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
        
        .student-info-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 1.2em;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .grades-section {
            margin-top: 30px;
        }
        
        .grades-section h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .grade-card {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .grade-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .subject-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2em;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .subject-info {
            flex-grow: 1;
        }
        
        .subject-name {
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }
        
        .grade-date {
            font-size: 0.8em;
            color: #6c757d;
            margin: 5px 0 0;
        }
        
        .grade-value {
            font-size: 1.5em;
            font-weight: 700;
            color: #6a11cb;
            margin-left: 15px;
            background: rgba(106, 17, 203, 0.1);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
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
                <p>Učenik</p>
            </div>
        </div>
        
        <a href="logout.php" class="btn btn-primary logout-btn">Odjavi se</a>
    </div>
    
    <div class="dashboard-container">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#" class="active">Početna</a></li>
                <li><a href="#">Ocene</a></li>
                <li><a href="#">Raspored časova</a></li>
                <li><a href="#">Izostanci</a></li>
                <li><a href="#">Moj profil</a></li>
            </ul>
        </div>
        
        <div class="content-area">
            <h2 class="dashboard-title">Učenik Dashboard</h2>
            
            <div class="student-info-card">
                <div class="info-item">
                    <span class="info-label">Ime i prezime</span>
                    <span class="info-value"><?php echo $student['ime'] . ' ' . $student['prezime']; ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Razred i odeljenje</span>
                    <span class="info-value"><?php echo $student['razred'] . '-' . $student['odeljenje']; ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Razredni starešina</span>
                    <span class="info-value">
                        <?php 
                        // Get class teacher (you would need to implement this based on your database structure)
                        echo "Marko Marković"; // Placeholder
                        ?>
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Školska godina</span>
                    <span class="info-value">2024/2025</span>
                </div>
            </div>
            
            <!-- Subjects Section - Automatically assigned based on student's grade level -->
            <div class="grades-section">
                <h3>Moji predmeti</h3>
                
                <?php
                // Get subjects for this student's grade level
                $student_razred = $student['razred'];
                $query = "SELECT * FROM predmet WHERE razred = ? ORDER BY naziv ASC";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "i", $student_razred);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if (!$result) {
                    die("Query Failed: " . mysqli_error($connection));
                }
                
                if (mysqli_num_rows($result) > 0) {
                    while ($subject = mysqli_fetch_assoc($result)) {
                        // Get the first letter of the subject name for the icon
                        $icon_letter = mb_substr($subject['naziv'], 0, 1, 'UTF-8');
                        ?>
                        <div class="grade-card">
                            <div class="subject-icon"><?php echo $icon_letter; ?></div>
                            <div class="subject-info">
                                <h4 class="subject-name"><?php echo $subject['naziv']; ?></h4>
                                <p class="grade-date"><?php echo $subject['razred']; ?>. razred</p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>Nema predmeta za vaš razred.</p>";
                }
                ?>
            </div>
            
            <div class="grades-section">
                <h3>Moje ocene</h3>
                
                <?php
                // Get grades for this student
                $student_id = $_SESSION['user_id'];
                $query = "SELECT o.*, p.naziv as predmet_naziv, pr.ime as profesor_ime, pr.prezime as profesor_prezime 
                          FROM ocena o 
                          JOIN predmet p ON o.predmet_id = p.id 
                          JOIN profesor pr ON o.profesor_id = pr.id 
                          WHERE o.ucenik_id = ? 
                          ORDER BY o.datum DESC";
                          
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "i", $student_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if (!$result) {
                    die("Query Failed: " . mysqli_error($connection));
                }
                
                if (mysqli_num_rows($result) > 0) {
                    while ($grade = mysqli_fetch_assoc($result)) {
                        // Get the first letter of the subject name for the icon
                        $icon_letter = mb_substr($grade['predmet_naziv'], 0, 1, 'UTF-8');
                        $date = date('d.m.Y', strtotime($grade['datum']));
                        ?>
                        <div class="grade-card">
                            <div class="subject-icon"><?php echo $icon_letter; ?></div>
                            <div class="subject-info">
                                <h4 class="subject-name"><?php echo $grade['predmet_naziv']; ?></h4>
                                <p class="grade-date"><?php echo $date; ?> - <?php echo $grade['profesor_ime'] . ' ' . $grade['profesor_prezime']; ?></p>
                                <?php if (!empty($grade['komentar'])) { ?>
                                    <p class="grade-comment"><?php echo $grade['komentar']; ?></p>
                                <?php } ?>
                            </div>
                            <div class="grade-value"><?php echo $grade['vrednost']; ?></div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>Još uvek nemate ocena.</p>";
                }
                ?>
            </div>
        </div>
    </div>
    
    <?php 
    if(isset($_GET['message'])){
        echo "<div class='message-popup'>" . $_GET['message'] . "</div>";
    }
    ?>
    
    <style>
        .message-popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
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
