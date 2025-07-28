<?php
session_start();
error_reporting(0);
include_once("user/include/config.php");

// Handle login POST
$login_error = '';
if (isset($_POST['login_submit'])) {
    $id = trim($_POST['login_id'] ?? '');
    $password = trim($_POST['login_password'] ?? '');
    
    // Try faculty login first (hardcoded credentials)
    if ($id === 'faculty' && $password === 'password@123') {
        $_SESSION['alogin'] = $id;
        $_SESSION['aid'] = 'faculty_001';
        header("location:faculty/dashboard.php");
        exit();
    } else {
        // Try admin login
        $password_md5 = md5($password);
        $query = mysqli_query($con, "SELECT * FROM admin WHERE email='$id' and password='$password_md5'");
        $num = mysqli_fetch_array($query);
        if ($num > 0) {
            $_SESSION['alogin'] = $id;
            $_SESSION['aid'] = $num['id'];
            header("location:admin/dashboard.php");
            exit();
        } else {
            // Try user login
            $query = mysqli_query($con, "SELECT id,fullName FROM users WHERE userEmail='$id' and password='$password_md5'");
            $num = mysqli_fetch_array($query);
            if ($num > 0) {
                $_SESSION['login'] = $id;
                $_SESSION['id'] = $num['id'];
                $_SESSION['username'] = $num['fullName'];
                header("location:user/dashboard.php");
                exit();
            } else {
                $login_error = 'Invalid credentials.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Complaint Management System | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="rgb(128, 198, 238)">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="public/LOGO_S.png" type="image/gif" />
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg,rgb(128, 198, 238) 0%, #f7f9fb 100%);
            color: #102d4a;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-glass {
            background: rgba(255, 255, 255, 0);
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            border: 1.5px solid rgba(255, 255, 255, 0);
            backdrop-filter: blur(12px);
            padding: 40px 32px 32px 32px;
            max-width: 410px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-logo {
            width: 120px;
            height: auto;
            margin-bottom: 18px;
        }
        @media (max-width: 600px) {
            .login-logo {
                width: 70px;
            }
            .login-glass {
                padding: 24px 8px 18px 8px;
            }
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0097A7;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        .form-group {
            width: 100%;
            margin-bottom: 16px;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #b2ebf2;
            font-size: 1.08rem;
            padding: 10px 14px;
        }
        .login-btn {
            width: 100%;
            background: #0097A7;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 10px 0;
            font-size: 1.15rem;
            font-weight: 600;
            margin-top: 8px;
            margin-bottom: 8px;
            transition: background 0.2s;
        }
        .login-btn:hover, .login-btn:focus {
            background:rgba(0, 150, 167, 0.77);
        }
        .google-btn{
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            border-radius: 50%;
            border: none;
            font-size: 1.08rem;
            font-weight: 600;
            margin-bottom: 8px;
            padding: 0;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
         .telegram-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 12px;
            border: none;
            font-size: 1.08rem;
            font-weight: 600;
            margin-bottom: 8px;
            padding: 10px 0;
            cursor: pointer;
            transition: background 0.2s;
        }
        .google-btn {
            background: #fff;
            color: #0097A7;
            border: 1.5px solid #0097A7;
        }
        .google-btn:hover, .google-btn:focus {
            background: #e0f7fa;
        }
        .telegram-btn {
            background: #0088cc;
            color: #fff;
            border: none;
        }
        .telegram-btn:hover, .telegram-btn:focus {
            background: #005f8c;
        }
        .forgot-link {
            color: #0097A7;
            font-size: 1rem;
            text-align: right;
            width: 100%;
            display: block;
            margin-bottom: 8px;
            cursor: pointer;
        }
        .error-msg {
            color: #A41E22;
            font-size: 1rem;
            margin-bottom: 8px;
            text-align: center;
        }
        .modal-bg {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.25);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-bg.active {
            display: flex;
        }
        .modal-content {
            background: rgba(255,255,255,0.95);
            border-radius: 16px;
            padding: 32px 24px 24px 24px;
            min-width: 300px;
            max-width: 90vw;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            text-align: center;
        }
        .modal-content input {
            margin-bottom: 12px;
        }
        .modal-close {
            position: absolute;
            top: 12px; right: 18px;
            font-size: 1.5rem;
            color: #A41E22;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-glass">
        <img src="public/LOGO_B.png" class="login-logo d-none d-md-block" alt="Logo" id="main-logo">
        <img src="public/LOGO_S.png" class="login-logo d-block d-md-none" alt="Logo Small" id="small-logo" style="display:none;">
        <form method="post" autocomplete="off">
            <?php if($login_error): ?>
                <div class="error-msg"><?php echo $login_error; ?></div>
            <?php endif; ?>
            <div class="form-group">
                <input type="text" class="form-control" name="login_id" id="login_id" placeholder="Email/GR/ER/" required autofocus>
            </div>
            <div class="form-group" style="position:relative;">
                <input type="password" class="form-control" name="login_password" id="login_password" placeholder="Password" required>
                <!-- <span class="forgot-link" id="forgot-link">Forgot password?</span> -->
                <button type="button" id="toggle-password" style="position:absolute;top:50%;right:14px;transform:translateY(-50%);cursor:pointer;font-size:1.2rem;color:#0097A7;user-select:none;background:none;border:none;padding:0;" tabindex="0" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
            </div>
            <button class="login-btn" type="submit" name="login_submit">Login</button>
            <div style="display:flex;justify-content:center;width:100%;margin-top:10px;">
               <button type="button" class="google-btn" tabindex="0">
                  <img src="public/google_logo.png" alt="Google Logo" style="width: 24px; height: 24px; display:block; margin:auto;">
               </button>
            </div>
            <!-- <div class="error-msg">* Forgot password through telegram only *</div> -->
        </form>
    </div>
    <!-- Modal for Telegram password recovery -->
    <div class="modal-bg" id="modal-bg">
        <div class="modal-content" style="position:relative;">
            <button class="modal-close" id="modal-close">&times;</button>
            <h5 style="color:#0097A7; font-weight:700;">Password Recovery</h5>
            <form id="telegram-form" method="post" onsubmit="return false;">
                <input type="text" class="form-control" id="recover_id" placeholder="Enter your Email/Username" required>
                <button type="submit" class="telegram-btn"><span class="icon-telegram"></span> Send Password to Telegram</button>
            </form>
            <div id="telegram-msg" style="margin-top:10px;color:#A41E22;font-size:1rem;"></div>
        </div>
    </div>
    <script>
        // Responsive logo switch
        function updateLogo() {
            if(window.innerWidth < 600) {
                document.getElementById('main-logo').style.display = 'none';
                document.getElementById('small-logo').style.display = 'block';
            } else {
                document.getElementById('main-logo').style.display = 'block';
                document.getElementById('small-logo').style.display = 'none';
            }
        }
        window.addEventListener('resize', updateLogo);
        window.addEventListener('DOMContentLoaded', updateLogo);
        // Show/hide password logic
        const passwordInput = document.getElementById('login_password');
        const togglePassword = document.getElementById('toggle-password');
        const eyeIcon = togglePassword.querySelector('i');
        togglePassword.addEventListener('click', function() {
            if(passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                this.setAttribute('aria-label', 'Hide password');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
                this.setAttribute('aria-label', 'Show password');
            }
        });
        togglePassword.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
        // Modal logic
        const modalBg = document.getElementById('modal-bg');
        const forgotLink = document.getElementById('forgot-link');
        const modalClose = document.getElementById('modal-close');
        forgotLink.onclick = () => { modalBg.classList.add('active'); };
        modalClose.onclick = () => { modalBg.classList.remove('active'); document.getElementById('telegram-msg').textContent = ''; };
        // Telegram form (placeholder)
        document.getElementById('telegram-form').onsubmit = function() {
            const id = document.getElementById('recover_id').value.trim();
            if(!id) return false;
            document.getElementById('telegram-msg').textContent = 'Password sent to your Telegram (demo placeholder).';
            setTimeout(() => { modalBg.classList.remove('active'); document.getElementById('telegram-msg').textContent = ''; }, 2000);
            return false;
        };
    </script>
</body>
</html>