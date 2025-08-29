<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['id'])==0)
	{
header('location:../index.php');
}
else{
    // Fetch student data from database
    $student_id = $_SESSION['id']; // Assuming session stores grno
    $query = mysqli_query($con, "SELECT * FROM faculty WHERE erno='$student_id'");
    $student_data = mysqli_fetch_array($query);
    
    if(!$student_data) {
        // If student not found, redirect to login
        header('location:../index.php');
        exit();
    }
    
    // Handle password update
    $message = '';
    $error = '';
    
    if(isset($_POST['update_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify old password
        if(password_verify($old_password, $student_data['password'])) {
            if($new_password === $confirm_password) {
                if(strlen($new_password) >= 6) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_query = mysqli_query($con, "UPDATE students SET password='$hashed_password', updated_at=CURRENT_TIMESTAMP WHERE grno='$student_id'");
                    
                    if($update_query) {
                        $message = 'Password updated successfully!';
                        // Log the action
                        mysqli_query($con, "INSERT INTO common_log (user_id, user_role, action, description, status) VALUES ('$student_id', 'student', 'update', 'Password updated', 'success')");
                    } else {
                        $error = 'Failed to update password. Please try again.';
                    }
                } else {
                    $error = 'New password must be at least 6 characters long.';
                }
            } else {
                $error = 'New passwords do not match.';
            }
        } else {
            $error = 'Current password is incorrect.';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CMS || Student Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/user-responsive.css">
    <link rel="stylesheet" href="../admin/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            margin-top: 70px;
            background: linear-gradient(120deg, #e0e7ef 0%, #f7f9fb 100%);
            min-height: 100vh;
        }
        .profile-glass-bg {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 8px 32px 8px;
            background: linear-gradient(120deg, #e0e7ef 0%, #f7f9fb 100%);
        }
        .profile-glass-card {
            display: flex;
            flex-direction: row;
            gap: 40px;
            background: rgba(255,255,255,0.22);
            border-radius: 2.5rem;
            box-shadow: 0 8px 40px 0 rgba(0,0,0,0.13), 0 1.5px 0 rgba(255,255,255,0.25) inset;
            backdrop-filter: blur(22px) saturate(1.2);
            border: 1.5px solid rgba(255,255,255,0.38);
            padding: 40px 48px;
            max-width: 820px;
            width: 100%;
            align-items: flex-start;
            position: relative;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .profile-glass-card:hover {
            box-shadow: 0 12px 48px 0 rgba(0,151,167,0.13), 0 2px 0 rgba(255,255,255,0.30) inset;
            transform: translateY(-2px) scale(1.01);
        }
        .profile-glass-image-wrap {
            flex: 0 0 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            margin-top: 0;
        }
        .profile-glass-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.7);
            box-shadow: 0 2px 16px rgba(0,0,0,0.10);
            /* margin-bottom: 18px; */
            background: linear-gradient(135deg, #e0e7ef 0%, #f7f9fb 100%);
        }
        .profile-glass-info {
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            gap: 22px;
            min-width: 0;
        }
        .profile-glass-name {
            text-align: center;
            font-size: 1.45rem;
            font-weight: 700;
            color: #0097A7;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }
        .profile-glass-id {
            text-align: center;
            font-size: 1.05rem;
            color: #A41E22;
            font-weight: 500;
            margin-bottom: 0;
        }
        .profile-glass-section {
            background: rgba(255,255,255,0.18);
            border-radius: 1.2rem;
            padding: 18px 22px 14px 22px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid rgba(255,255,255,0.18);
            margin-bottom: 0;
        }
        .profile-glass-section-title {
            font-size: 1.13rem;
            font-weight: 700;
            color: #0097A7;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .profile-glass-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 32px;
        }
        .profile-glass-field {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .btn{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            width: 100%;
            background-color: #0097A7;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-control-input{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 10px;
            width: 100%;
            padding: 10px 20px;
            border-radius: 5px;
            border: 1px solid #0097A7;
        }
        .profile-glass-label {
            font-size: 0.98rem;
            color: #222;
            font-weight: 500;
            margin-bottom: 2px;
            opacity: 0.85;
        }
        .profile-glass-value {
            font-size: 1.08rem;
            font-weight: 600;
            color: #102d4a;
            word-break: break-all;
        }
        .profile-glass-telegram {
            flex-direction: row;
            align-items: center;
            gap: 18px;
        }
        .profile-glass-qr-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-left: 8px;
        }
        .profile-glass-qr {
            padding: 8px;
            width: 70px;
            height: 70px;
            border-radius: 16px;
            border: 2px solid #e0e7ef;
            margin-bottom: 4px;
            background: #fff;
            box-shadow: 0 1px 8px rgba(0,0,0,0.07);
        }
        .profile-glass-qr-note {
            font-size: 0.93rem;
            color: #A41E22;
            text-align: center;
            margin-top: 2px;
            font-weight: 500;
            opacity: 0.85;
        }
        /* Personal Info Section Improvements */
        .personal-info-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 32px;
        }
        .personal-info-fields .telegram-field {
            grid-column: 1 / -1;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 8px;
        }
        .profile-glass-qr-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 6px;
        }
        .profile-glass-qr {
            padding: 8px;
            width: 90px;
            height: 90px;
            border-radius: 16px;
            border: 2px solid #e0e7ef;
            margin-bottom: 4px;
            background: #fff;
            box-shadow: 0 1px 8px rgba(0,0,0,0.07);
        }
        .profile-glass-qr-note {
            font-size: 0.93rem;
            color: #A41E22;
            text-align: center;
            margin-top: 2px;
            font-weight: 500;
            opacity: 0.85;
        }
        /* Update Credentials Section Improvements */
        .update-credentials-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 8px;
        }
        .update-credentials-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .password-input-wrap {
            display: flex;
            align-items: center;
            position: relative;
        }
        .form-control-input[type="password"],
        .form-control-input[type="text"] {
            flex: 1 1 0;
            padding-right: 38px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0 4px;
            color: #0097A7;
            font-size: 1.15rem;
            height: 100%;
            display: flex;
            align-items: center;
        }
        .toggle-password:focus {
            outline: none;
        }
        .eye-icon {
            font-size: 1.15rem;
        }
        .update-btn {
            margin-top: 10px;
            width: 100%;
        }
        @media (max-width: 900px) {
            .profile-glass-card {
                flex-direction: column;
                align-items: center;
                gap: 24px;
                padding: 32px 10px;
            }
            .profile-glass-image-wrap {
                margin-bottom: 0;
            }
            .profile-glass-info {
                width: 100%;
            }
            .personal-info-fields {
                grid-template-columns: 1fr;
                gap: 14px 0;
            }
        }
        @media (max-width: 600px) {
            .profile-glass-card {
                padding: 16px 2vw;
                border-radius: 1.2rem;
            }
            .profile-glass-image {
                width: 110px;
                height: 110px;
            }
            .profile-glass-section {
                padding: 10px 6px 8px 6px;
                border-radius: 0.8rem;
            }
            .profile-glass-fields {
                grid-template-columns: 1fr;
                gap: 10px 0;
            }
            .profile-glass-name {
                font-size: 1.13rem;
            }
            .update-credentials-form {
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <?php include('include/header.php');?>
    <?php include('include/sidebar.php');?>
    <div class="profile-glass-bg">
        <div class="profile-glass-card">
            
            <div class="profile-glass-info">
            <div class="profile-glass-image-wrap">
                <img src="https://marwadieducation.edu.in/MEFOnline/handler/getImage.ashx?Id=<?php echo strtoupper(($student_data['erno'])); ?>" alt="Student Photo" class="profile-glass-image">
            </div>
                <div class="profile-glass-name"><?php echo htmlspecialchars($student_data['fname'] . ' ' . $student_data['lname']); ?></div>
                <div class="profile-glass-id">Student ID: <?php echo htmlspecialchars($student_data['erno']); ?> , <?php echo htmlspecialchars($student_data['erno']); ?></div>
                <div class="profile-glass-section">
                    <div class="profile-glass-section-title">Personal Information</div>
                    <div class="profile-glass-fields personal-info-fields">
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Full Name</span>
                            <span class="profile-glass-value"><?php echo htmlspecialchars($student_data['fname'] . ' ' . $student_data['lname']); ?></span>
                        </div>
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Email</span>
                            <span class="profile-glass-value"><?php echo htmlspecialchars($student_data['email']); ?></span>
                        </div>
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Mobile Number</span>
                            <span class="profile-glass-value"><?php echo $student_data['mobile'] ? '+91 ' . htmlspecialchars($student_data['mobile']) : 'Not provided'; ?></span>
                        </div>
                        <!-- <div class="profile-glass-field telegram-field">
                            <span class="profile-glass-label">Telegram ID</span>
                            <span class="profile-glass-value"><?php echo $student_data['telegram'] ? '@' . htmlspecialchars($student_data['telegram']) : 'Not registered'; ?></span>
                            <?php if($student_data['telegram']) { ?>
                            <div class="profile-glass-qr-wrap">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://t.me/<?php echo htmlspecialchars($student_data['telegram']); ?>" alt="Telegram QR" class="profile-glass-qr">
                                <div class="profile-glass-qr-note">Scan to register/update Telegram</div>
                            </div>
                            <?php } ?>
                        </div> -->
                    </div>
                </div>
                <!-- <div class="profile-glass-section">
                    <div class="profile-glass-section-title">Educational Details</div>
                    <div class="profile-glass-fields">
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Department</span>
                            <span class="profile-glass-value">Computer Science</span>
                        </div>
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Course</span>
                            <span class="profile-glass-value">B.Tech</span>
                        </div>
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Semester</span>
                            <span class="profile-glass-value">5th</span>
                        </div>
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Division</span>
                            <span class="profile-glass-value">A</span>
                        </div>
                    </div>
                </div> -->
                <div class="profile-glass-section">
                    <div class="profile-glass-section-title">Update Credentials</div>
                    <?php if($message) { ?>
                        <div style="background: rgba(0, 151, 167, 0.1); border: 1px solid #0097A7; color: #0097A7; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php } ?>
                    <?php if($error) { ?>
                        <div style="background: rgba(164, 30, 34, 0.1); border: 1px solid #A41E22; color: #A41E22; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php } ?>
                    <form class="update-credentials-form" method="POST" autocomplete="off">
                        <div class="update-credentials-field">
                            <label class="profile-glass-label" for="old-password">Old Password</label>
                            <div class="password-input-wrap">
                                <input type="password" id="old-password" name="old_password" class="form-control-input" placeholder="Enter Old Password" autocomplete="current-password" required>
                                <button type="button" class="toggle-password" tabindex="-1" aria-label="Show/Hide Password"><i class="fa-solid fa-eye eye-icon"></i></button>
                            </div>
                        </div>
                        <div class="update-credentials-field">
                            <label class="profile-glass-label" for="new-password">New Password</label>
                            <div class="password-input-wrap">
                                <input type="password" id="new-password" name="new_password" class="form-control-input" placeholder="Enter New Password" autocomplete="new-password" required>
                                <button type="button" class="toggle-password" tabindex="-1" aria-label="Show/Hide Password"><i class="fa-solid fa-eye eye-icon"></i></button>
                            </div>
                        </div>
                        <div class="update-credentials-field">
                            <label class="profile-glass-label" for="confirm-password">Confirm New Password</label>
                            <div class="password-input-wrap">
                                <input type="password" id="confirm-password" name="confirm_password" class="form-control-input" placeholder="Confirm New Password" autocomplete="new-password" required>
                                <button type="button" class="toggle-password" tabindex="-1" aria-label="Show/Hide Password"><i class="fa-solid fa-eye eye-icon"></i></button>
                            </div>
                        </div>
                        <div class="update-credentials-field">
                            <button class="btn btn-primary update-btn" type="submit" name="update_password">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../admin/assets/js/vendor-all.min.js"></script>
    <script src="../admin/assets/js/plugins/bootstrap.min.js"></script>
    <script src="../admin/assets/js/pcoded.min.js"></script>
    <script>
    // Password show/hide toggle with Font Awesome icons
    document.querySelectorAll('.toggle-password').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = btn.parentElement.querySelector('input');
            var icon = btn.querySelector('.eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // Password validation
    document.querySelector('.update-credentials-form').addEventListener('submit', function(e) {
        var newPassword = document.getElementById('new-password').value;
        var confirmPassword = document.getElementById('confirm-password').value;
        
        if (newPassword.length < 6) {
            e.preventDefault();
            alert('New password must be at least 6 characters long.');
            return false;
        }
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('New passwords do not match.');
            return false;
        }
        
        return true;
    });
    </script>
</body>
</html>
<?php } ?>