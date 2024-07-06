<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .signup-box {
            width: 460px;
            margin-top: 50px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.6);
        }
        .signup-card-body {
            color: #ffffff;
        }
        .signup-card-body .form-check {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .signup-card-body .form-check .btn {
            width: 100%;
        }
        .signup-card-body .form-check .forgot-password {
            margin-left: auto;
        }
        .signup-card-body .sign-up-btn {
            display: block;
            width: 100%;
            margin: 15px auto;
        }
        .signup-card-body .sign-in-link {
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }
        .additional-info {
            margin-top: 20px;
        }
        .additional-info h6 {
            color: #706c6c;
            text-align: center;
            font-weight: bold;
        }
        .additional-info .form-group {
            margin-bottom: 10px;
        }
        .signup-card-body {
            color: #706c6c; /* Text color */
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
</head>
<body class="hold-transition signup-page">
<div class="signup-box">
    <div class="card">
        <div class="card-body signup-card-body">
            <h3 class="signup-box-msg">Create Account</h3>
            <form action="signup_validation.php" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <?php if (isset($errors['name'])): ?>
                        <div class="error-message"><?php echo $errors['name']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <?php if (isset($errors['username'])): ?>
                        <div class="error-message"><?php echo $errors['username']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <div class="error-message"><?php echo $errors['password']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="additional-info">
                    <h6>Additional Information</h6>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="gender" class="form-control" placeholder="Gender (Male/Female)" required>
                            <?php if (isset($errors['gender'])): ?>
                                <div class="error-message"><?php echo $errors['gender']; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="number" name="age" class="form-control" placeholder="Age (12-98)" required min="12" max="98">
                            <?php if (isset($errors['age'])): ?>
                                <div class="error-message"><?php echo $errors['age']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <input type="tel" name="contact_number" class="form-control" placeholder="Contact Number (11 digits)" required pattern="[0-9]{11}">
                            <?php if (isset($errors['contact_number'])): ?>
                                <div class="error-message"><?php echo $errors['contact_number']; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code (4 digits)" required pattern="[0-9]{4}">
                            <?php if (isset($errors['postal_code'])): ?>
                                <div class="error-message"><?php echo $errors['postal_code']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="address" class="form-control" placeholder="Address (City and Street)" required>
                        <?php if (isset($errors['address'])): ?>
                            <div class="error-message"><?php echo $errors['address']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary sign-up-btn">Sign Up</button>
            </form>

            <p class="sign-in-link">
                Already have an account? <a href="login.php" style="color: #007bff;">Sign In</a>
            </p>
            <div class="social-login">
                <hr>
                <div class="text-center mb-3">Sign up with</div>
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
