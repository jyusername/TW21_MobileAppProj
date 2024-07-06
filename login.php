<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

$login_error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials
    if ($username == 'admin' && $password == 'password123') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $login_error = 'Incorrect username or password.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url('bg.jpg');
            background-size: cover; 
            background-position: center; 
            height: 100%; 
        }
        .login-box {
            width: 450px; 
            margin: auto; 
            margin-top: 100px; 
            border-radius: 10px; 
            padding: 20px; 
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); 
        }
        .social-login {
            margin-top: 20px; 
        }
        .social-login hr {
            margin: 10px 0; 
        }
        .social-login .btn-google, .social-login .btn-facebook {
            margin-right: 10px; 
        }
        .login-card-body .form-check {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px; 
        }
        .login-card-body .form-check .btn {
            width: 100%;
        }
        .login-card-body .form-check .forgot-password {
            margin-left: auto; 
        }
        .login-card-body .sign-in-btn {
            display: block;
            width: 100%;
            margin: 15px auto; 
            margin-bottom: 25px;
            border-radius: 8px;
        }
        .login-card-body .sign-up-link {
            margin-top: 10px; 
            text-align: center; 
            font-weight: bold; 
        }

        .login-card-body{
            border-radius: 20px;
        }

    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card" >
        <div class="card-body login-card-body">
            <h3 class="login-box-msg">Login Here</h3>

            
            <?php if ($login_error != ''): ?>
            <p class="text-danger"><?= $login_error ?></p>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="remember"> Remember Me
                    </label>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary sign-in-btn">Sign In</button>
            </form>

            <p class="sign-up-link">
                Don't have an account? <a href="signup.php">Sign up</a>
            </p>
            <!-- Social Login Section -->
            <div class="social-login">
                <hr>
                <div class="text-center mb-3">Login with</div>
                <div class="text-center">
                    <a href="#"><i class="fab fa-google fa-lg btn-google"></i></a>
                    <a href="#"><i class="fab fa-facebook fa-lg btn-facebook"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
