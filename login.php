<?php
// Include database connection
include 'dbcon.php';

// Initialize session
session_start();

// Check if user is already logged in
if(isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
    if($_SESSION['user_type'] == 'profesor') {
        header("Location: profesor_dashboard.php");
        exit;
    } else {
        header("Location: ucenik_dashboard.php");
        exit;
    }
}

// Process profesor login form submission
$error_profesor = null;
if(isset($_POST['login_profesor'])) {
    $login = $_POST['login_profesor_username'];
    $password = $_POST['login_profesor_password'];
    
    // Validate input
    if(empty($login) || empty($password)) {
        $error_profesor = "Molimo unesite korisničko ime i lozinku.";
    } else {
        // Query to check profesor credentials
        $query = "SELECT * FROM `profesor` WHERE login='$login' AND password='$password' LIMIT 1";
        $result = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($result) == 1) {
            $profesor = mysqli_fetch_assoc($result);
            
            // Set session variables
            $_SESSION['user_id'] = $profesor['id'];
            $_SESSION['username'] = $profesor['ime'] . ' ' . $profesor['prezime'];
            $_SESSION['user_type'] = 'profesor';
            
            // Redirect to profesor dashboard
            header("Location: profesor_dashboard.php");
            exit;
        } else {
            $error_profesor = "Pogrešno korisničko ime ili lozinka.";
        }
    }
}

// Process ucenik login form submission
$error_ucenik = null;
if(isset($_POST['login_ucenik'])) {
    $login = $_POST['login_ucenik_username'];
    $password = $_POST['login_ucenik_password'];
    
    // Validate input
    if(empty($login) || empty($password)) {
        $error_ucenik = "Molimo unesite korisničko ime i lozinku.";
    } else {
        // Query to check ucenik credentials
        $query = "SELECT * FROM `ucenik` WHERE login='$login' AND password='$password' LIMIT 1";
        $result = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($result) == 1) {
            $ucenik = mysqli_fetch_assoc($result);
            
            // Set session variables
            $_SESSION['user_id'] = $ucenik['id'];
            $_SESSION['username'] = $ucenik['ime'] . ' ' . $ucenik['prezime'];
            $_SESSION['user_type'] = 'ucenik';
            
            // Redirect to ucenik dashboard
            header("Location: ucenik_dashboard.php");
            exit;
        } else {
            $error_ucenik = "Pogrešno korisničko ime ili lozinka.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Elektronski Dnevnik</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Login page specific styles */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .app-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .app-logo h1 {
            font-size: 2.5em;
            color: #2c3e50;
            margin: 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .login-container {
            display: flex;
            gap: 30px;
            max-width: 900px;
            width: 100%;
        }
        
        .login-box {
            flex: 1;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .profesor-box .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .ucenik-box .login-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }
        
        .login-header {
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
            font-size: 1.8em;
        }
        
        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 0.9em;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .login-footer {
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e8ecf0;
            font-size: 0.9em;
            color: #6c757d;
        }
        
        .login-btn {
            width: 100%;
            padding: 14px;
            margin-top: 20px;
            font-size: 1.1em;
        }
        
        .profesor-box .login-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .ucenik-box .login-btn {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }
        
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9em;
            display: flex;
            align-items: center;
        }
        
        .error-message:before {
            content: '⚠️';
            margin-right: 10px;
            font-size: 1.2em;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .app-logo h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="app-logo">
        <h1>Elektronski Dnevnik</h1>
        <div style="text-align: center; margin-top: 10px;">
            <a href="index.php" style="font-size: 0.9em; color: #667eea; text-decoration: none;">Admin view</a>
        </div>
    </div>
    
    <div class="login-container">
        <!-- Profesor Login Box -->
        <div class="login-box profesor-box">
            <div class="login-header">
                <h2>Prijava za profesore</h2>
                <p>Pristupite sistemu kao profesor</p>
            </div>
            
            <div class="login-body">
                
                <?php if(isset($error_profesor)): ?>
                    <div class="error-message"><?php echo $error_profesor; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="form-group">
                        <label for="login_profesor_username">Korisničko ime:</label>
                        <input type="text" id="login_profesor_username" name="login_profesor_username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="login_profesor_password">Lozinka:</label>
                        <input type="password" id="login_profesor_password" name="login_profesor_password" required>
                    </div>
                    
                    <button type="submit" name="login_profesor" class="btn btn-primary login-btn">Prijavi se kao profesor</button>
                </form>
            </div>
            
            <div class="login-footer">
                <p>Pristup samo za ovlašćene profesore</p>
            </div>
        </div>
        
        <!-- Ucenik Login Box -->
        <div class="login-box ucenik-box">
            <div class="login-header">
                <h2>Prijava za učenike</h2>
                <p>Pristupite sistemu kao učenik</p>
            </div>
            
            <div class="login-body">

                
                <?php if(isset($error_ucenik)): ?>
                    <div class="error-message"><?php echo $error_ucenik; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="form-group">
                        <label for="login_ucenik_username">Korisničko ime:</label>
                        <input type="text" id="login_ucenik_username" name="login_ucenik_username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="login_ucenik_password">Lozinka:</label>
                        <input type="password" id="login_ucenik_password" name="login_ucenik_password" required>
                    </div>
                    
                    <button type="submit" name="login_ucenik" class="btn btn-primary login-btn">Prijavi se kao učenik</button>
                </form>
            </div>
            
            <div class="login-footer">
                <p>Pristup za učenike škole</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 30px; text-align: center; color: #6c757d;">
        <p>© 2024 Elektronski Dnevnik by Uros Vidakovic IT 67/17.</p>
    </div>
</body>
</html>
