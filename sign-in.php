<?php require 'includes/config.php'; ?>
<?php require 'includes/db.php'; ?>
<?php 
    $fetch_school_logo = mysqli_query($connection, "SELECT * FROM rev_erp_user_details");
    if (mysqli_num_rows($fetch_school_logo) > 0) {
        while($jh = mysqli_fetch_assoc($fetch_school_logo)) {
            $school_logo = htmlspecialchars($jh['rev_user_school_logo'], ENT_QUOTES, 'UTF-8');
        }
    }
?>

<?php date_default_timezone_set('Asia/Kolkata'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<style type="text/css">
.loading_msg{
        margin: auto;
  border: 20px solid #066AC9;
  border-radius: 200%;
  border-top: 20px solid #fff;
  width: 50px;
  height: 50px;
  animation: spinner 4s linear infinite;
}
@keyframes spinner {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<?php 
    if (isset($_GET['ref'])) {
        $loc = htmlspecialchars($_GET['ref'], ENT_QUOTES, 'UTF-8');
    }
?>
<?php 
    if (isset($_COOKIE['aut'])) {
        $auto_login_code = htmlspecialchars($_COOKIE['aut'], ENT_QUOTES, 'UTF-8');
        $fetch_user_auto_login_details =mysqli_query($connection,"SELECT * FROM rev_user_details WHERE rev_auto_login = '$auto_login_code' AND rev_teach_sts = '1'");

        if (mysqli_num_rows($fetch_user_auto_login_details) > 0) {
            while($j = mysqli_fetch_assoc($fetch_user_auto_login_details)) {
                $user_email = htmlspecialchars($j['rev_teach_email'], ENT_QUOTES, 'UTF-8');
                $_SESSION['teach_details'] = $user_email;
                 header("Location: " . BASE_URL . 'pages/action');    
            }            
        }
    }

    if (isset($_POST['submit'])) {
        $rev_email_id = mysqli_escape_string($connection, trim($_POST['email']));
        $rev_pass = mysqli_escape_string($connection, trim($_POST['password']));

        if ($rev_email_id == "" || $rev_pass == "") {
            $error_message = "Please fill all the fields";
        }

        if (!isset($error_message)) {
                $fetch_from_table = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$rev_email_id' AND user_sts = '1'");
                if (mysqli_num_rows($fetch_from_table) > 0) {
                    while($tr = mysqli_fetch_assoc($fetch_from_table)) {
                        $teacher_pass = htmlspecialchars($tr['user_password'], ENT_QUOTES, 'UTF-8');
                    }
                    if (password_verify($rev_pass, $teacher_pass)) { 
                        $cookiename = 'aut';
                        $cookievalue = md5(date('Y-m-d H:i:s'));
                        setcookie($cookiename, $cookievalue, time() + (86400 * 30), "/"); 
                        $_SESSION['teach_details'] = $rev_email_id;
                        header("Location: " . BASE_URL . 'pages/action');
                    } else {
                        $error_message = "Sorry! The entered Email ID or Password are not matching";
                    }
                } else {
                    $error_message = "Entered Email ID is not registered in Revisewell...! Please contact your school admin to register";
                }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | ERP</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="<?php echo $school_logo; ?>">
    <style>
        :root {
            --primary-color: #066AC9;
            --secondary-color: #00C9FF;
            --accent-color: #6A11CB;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
            background: linear-gradient(-45deg, #6A11CB, #2575FC, #00C9FF, #92FE9D);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            position: relative;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            z-index: -1;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            z-index: -1;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        }

        .login-container h1 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .login-container p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .login-container .logo {
            width: 100px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .login-container .logo:hover {
            transform: scale(1.05);
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(6, 106, 201, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }

        .password-wrapper .toggle-password:hover {
            color: var(--primary-color);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(6, 106, 201, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            background: linear-gradient(to right, #0556a3, #00b7eb);
            box-shadow: 0 6px 20px rgba(6, 106, 201, 0.4);
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.5s ease;
            pointer-events: none;
        }

        .btn-login:hover::after {
            left: 100%;
        }

        .loading_msg {
            display: none;
            margin: 20px auto;
            border: 4px solid var(--primary-color);
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spinner 1s linear infinite;
        }

        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .footer-links {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }

        .footer-links a {
            color: var(--primary-color);
            text-decoration: none;
            margin: 0 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .footer-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .footer-links a:hover {
            color: #0556a3;
        }

        .footer-links a:hover::after {
            width: 100%;
        }

        /* Floating bubbles animation */
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0) rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Floating background elements -->
    <div class="bubble" style="width: 100px; height: 100px; top: 10%; left: 10%; animation: float 15s infinite linear;"></div>
    <div class="bubble" style="width: 150px; height: 150px; bottom: 15%; right: 10%; animation: float 18s infinite linear reverse;"></div>
    <div class="bubble" style="width: 80px; height: 80px; top: 60%; left: 20%; animation: float 12s infinite linear;"></div>
    <div class="bubble" style="width: 120px; height: 120px; top: 30%; right: 20%; animation: float 20s infinite linear reverse;"></div>

    <div class="login-container">
        <img src="<?php echo $school_logo; ?>" alt="ERP Logo" class="logo">
        <h1>Login to ERP</h1>
        <p>Welcome back! Please log in to continue.</p>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" autocomplete="off">
            <div class="form-group">
                <label for="email">Email ID</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($rev_email_id) ? htmlspecialchars($rev_email_id, ENT_QUOTES, 'UTF-8') : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <button type="submit" name="submit" class="btn-login">Login</button>
            <div class="loading_msg"></div>
        </form>

        <div class="footer-links">
            <a href="privacypolicy.html">Privacy Policy</a>
            <a href="terms.html">Terms & Conditions</a>
            <a href="refund.html">Refund Policy</a>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        document.querySelector('form').addEventListener('submit', function () {
            document.querySelector('.btn-login').style.display = 'none';
            document.querySelector('.loading_msg').style.display = 'block';
        });

        // Create more floating bubbles dynamically
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.querySelector('body');
            for (let i = 0; i < 8; i++) {
                const bubble = document.createElement('div');
                bubble.className = 'bubble';
                const size = Math.random() * 100 + 50;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const duration = Math.random() * 15 + 10;
                const delay = Math.random() * 5;
                
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.left = `${posX}%`;
                bubble.style.top = `${posY}%`;
                bubble.style.opacity = Math.random() * 0.2 + 0.1;
                bubble.style.animation = `float ${duration}s infinite ${delay}s linear ${Math.random() > 0.5 ? 'reverse' : ''}`;
                
                body.appendChild(bubble);
            }
        });
    </script>
</body>
</html>