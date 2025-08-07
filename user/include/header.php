<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark user-glass-header" style="backdrop-filter: blur(2px); background: rgba(255,255,255,0.18); border-bottom: 1.5px solid rgba(255,255,255,0.35);position:fixed; box-shadow: 0 4px 24px rgba(0,0,0,0.10);">
    <div class="m-header">
        <a href="dashboard.php" class="b-brand d-flex align-items-center" style="gap:10px;">
            <img src="../public/LOGO_B.png" alt="Logo Big" class="logo-big" style="height:48px; width:auto; display:inline-block;">
            <img src="../public/LOGO_S.png" alt="Logo Small" class="logo-small" style="height:36px; width:auto; display:none;">
            <!-- <strong style="color:#0097A7; letter-spacing:1px; font-size:1.3rem;">Assignment Tracker</strong> -->
        </a>
        <a href="profile.php" class="mob-toggler">
            <img src="https://student.marwadiuniversity.ac.in:553/handler/getImage.ashx?SID=123766" class="img-radius" alt="User-Profile-Image" style="width:50px; height:50px; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.07); border:2px solid #fff; background:#f7f9fb; object-fit:cover;">
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown drp-user d-flex">
                    <a href="profile.php" class="dropdown-toggle d-flex align-items-center"  style="gap:10px; min-width:120px;">
                    <img src="https://student.marwadiuniversity.ac.in:553/handler/getImage.ashx?SID=123766" class="img-radius" alt="User-Profile-Image" style="width:40px; height:40px; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.07); border:2px solid #fff; background:#f7f9fb; object-fit:cover;">
                        <span style="color:#102d4a; font-weight:600; font-size:1rem;">
                            <?php
                            $ret = mysqli_query($con, "SELECT fname FROM students WHERE grno='" . $_SESSION['id'] . "'");
                            $row = mysqli_fetch_array($ret);
                            $name = $row['fname'];
                            echo $name;
                            ?>
                            </span><br>
                            <a href="logout.php" class="dud-logout" title="Logout" style="color:#A41E22;">
                                <i class="feather icon-log-out"> </i>
                            </a>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right profile-notification glass-dropdown" style="backdrop-filter: blur(12px); background: rgba(255,255,255,0.85); border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,0.10); border:1.5px solid rgba(255,255,255,0.35); min-width:220px;">
                        <div class="pro-head d-flex align-items-center" style="gap:10px; padding:16px 16px 12px 16px; border-bottom:1px solid #e0e7ef;">
                            <img src="https://student.marwadiuniversity.ac.in:553/handler/getImage.ashx?SID=123766" class="img-radius" alt="User-Profile-Image" style="width:44px; height:44px; border-radius:50%; border:2px solid #fff; object-fit:cover;">
                            <span style="color:#102d4a; font-weight:600; font-size:1.05rem;"> <?php echo $name; ?> </span>
                            <a href="logout.php" class="dud-logout ml-auto" title="Logout" style="color:#A41E22;">
                                <i class="feather icon-log-out"></i>
                            </a>
                        </div>
                        <ul class="pro-body" style="padding:10px 0 0 0;">
                            <li></li>
                            
                            
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<style>
    .logo-big {
        height: 48px;
        width: auto;
        display: inline-block;
        vertical-align: middle;
    }

    .logo-small {
        height: 36px;
        width: auto;
        display: none;
        vertical-align: middle;
    }

    .m-header {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
    }

    .b-brand {
        margin-right: auto !important;
    }

    @media (max-width: 991px) {
        .logo-big {
            display: none !important;
        }

        .logo-small {
            display: inline-block !important;
        }

        .user-glass-header .b-brand strong {
            font-size: 1rem;
        }

        .user-glass-header .dropdown-toggle span {
            display: none !important;
        }

        .user-glass-header .dropdown-toggle img {
            margin-right: 0 !important;
        }
    }

    @media (max-width: 600px) {
        .logo-small {
            height: 28px !important;
        }

        .user-glass-header .dropdown-toggle img {
            width: 32px !important;
            height: 32px !important;
        }
    }

    /* Ensure dropdown is touch-friendly on mobile */
    @media (max-width: 991px) {
        .dropdown-menu.profile-notification {
            left: auto !important;
            right: 0 !important;
            min-width: 180px !important;
            top: 48px !important;
            border-radius: 14px !important;
        }

        .dropdown.drp-user .dropdown-toggle {
            padding: 6px 8px !important;
            min-width: unset !important;
        }
    }
</style>
<script>
    // Ensure dropdown works on mobile/touch
    // Requires jQuery and Bootstrap JS to be loaded in the page
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('touchstart', function(e) {
                    // For touch devices, trigger click to open dropdown
                    e.stopPropagation();
                    e.preventDefault();
                    toggle.click();
                });
                // Add pointer cursor for better UX
                toggle.style.cursor = 'pointer';
            });
        });
    })();
</script>