<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['id'])==0)
	{
header('location:index.php');
}
else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CMS || Student Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/user-responsive.css">
    <link rel="stylesheet" href="../admin/assets/css/style.css">
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
        }
    </style>
</head>
<body>
    <?php include('include/header.php');?>
    <div class="profile-glass-bg">
        <div class="profile-glass-card">
            
            <div class="profile-glass-info">
            <div class="profile-glass-image-wrap">
                <img src="https://student.marwadiuniversity.ac.in:553/handler/getImage.ashx?SID=123766" alt="Student Photo" class="profile-glass-image">
            </div>
                <div class="profile-glass-name">BHAGIRATH BARAIYA</div>
                <div class="profile-glass-id">Student ID: 123766 , 92320527005</div>
                <div class="profile-glass-section">
                    <div class="profile-glass-section-title">Personal Information</div>
                    <div class="profile-glass-fields">
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Full Name</span>
                            <span class="profile-glass-value">BHAGIRATH BARAIYA</span>
                        </div>
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Email</span>
                            <span class="profile-glass-value">bhagirathbhai.baraiya123766@marwadiuniversity.ac.in</span>
                        </div>
                        <div class="profile-glass-field">
                            <span class="profile-glass-label">Mobile Number</span>
                            <span class="profile-glass-value">+91 9876543210</span>
                        </div>
                        <div class="profile-glass-field profile-glass-telegram">
                            <div>
                                <span class="profile-glass-label">Telegram ID</span>
                                <span class="profile-glass-value">@ydf_bot</span>
                            </div>
                            <div class="profile-glass-qr-wrap">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://t.me/ydf_bot" alt="Telegram QR" class="profile-glass-qr">
                                <div class="profile-glass-qr-note">Scan to register/update Telegram</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-glass-section">
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
                </div>
            </div>
        </div>
    </div>
    <script src="../admin/assets/js/vendor-all.min.js"></script>
    <script src="../admin/assets/js/plugins/bootstrap.min.js"></script>
    <script src="../admin/assets/js/pcoded.min.js"></script>
</body>
</html>
<?php } ?>