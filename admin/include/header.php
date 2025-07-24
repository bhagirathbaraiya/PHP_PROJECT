<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark admin-glass-header" style="backdrop-filter: blur(2px); background: rgba(255,255,255,0.18); border-bottom: 1.5px solid rgba(255,255,255,0.35);position:fixed; box-shadow: 0 4px 24px rgba(0,0,0,0.10); width:100%; z-index:1000;">
    <div class="m-header" style="gap:10px;">
        <a class="mobile-menu" id="mobile-collapse" href="#!" style="margin-right:10px;"><span></span></a>
        <!-- Hamburger for sidebar toggle -->
        <a href="dashboard.php" class="b-brand d-flex align-items-center" style="gap:10px;">
            <img src="../public/LOGO_B.png" alt="Logo Big" class="logo-big" style="height:48px; width:auto; display:inline-block;">
            <img src="../public/LOGO_S.png" alt="Logo Small" class="logo-small" style="height:36px; width:auto; display:none;">
        </a>
        <a href="#" class="mob-toggler d-none d-lg-inline">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="navbar-collapse mt-0">
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="icon feather icon-bell"></i>
                        <?php
$rt = mysqli_query($con,"select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId where tblcomplaints.status is null");
$num1 = mysqli_num_rows($rt);
?>
                        <span class="badge badge-pill badge-danger"><?php echo htmlentities($num1)?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right notification glass-dropdown" style="backdrop-filter: blur(12px); background: rgba(255,255,255,0.85); border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,0.10); border:1.5px solid rgba(255,255,255,0.35); min-width:260px;">
                        <div class="noti-head">
                            <h6 class="d-inline-block m-b-0">Notifications</h6>
                        </div>
                        <ul class="noti-body">
                            <li class="notification">
                                <?php
                                $cnt=1;
                                while($row=mysqli_fetch_array($rt))
                                {
                                ?>
                                <div class="media">
                                    <img class="img-radius" src="assets/images/user/user.png" alt="Generic placeholder image" style="width:40px; height:40px; border-radius:50%; border:2px solid #fff; object-fit:cover;">
                                    <div class="media-body">
                                        <p><strong><?php echo htmlentities($row['name']);?></strong><span class="n-time text-muted"></span></p>
                                        <p>Complaint No.<a href="complaint-details.php?cid=<?php echo htmlentities($row['complaintNumber']);?>"><?php echo htmlentities($row['complaintNumber']);?> at <small><?php echo htmlentities($row['regDate']);?></small> </a></p>
                                    </div>
                                </div>
                                <br><?php $cnt=$cnt+1; } ?>
                            </li>
                        </ul>
                        <div class="noti-footer">
                            <a href="#!">show all</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="dropdown drp-user d-flex">
                   
					<div class="pro-head d-flex align-items-center" style="gap:10px; padding:16px 16px 12px 16px; border-bottom:1px solid #e0e7ef;">
                            <img src="https://student.marwadiuniversity.ac.in:553/handler/getImage.ashx?SID=123766" class="img-radius user-profile-img" alt="User-Profile-Image" style="width:44px; height:44px; border-radius:50%; border:2px solid #fff; object-fit:cover;">
                            <span class="user-name d-none d-lg-inline" style="color:#102d4a; font-weight:600; font-size:1.05rem;"> <?php echo "BHAGIRATH"; ?> </span>
                            <a href="logout.php" class="dud-logout ml-auto" title="Logout" style="color:#A41E22;">
                                <i class="feather icon-log-out"></i>
                            </a>
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
    /* Force hamburger to the left of the logo in the header */
    .pcoded-header .m-header {
        display: flex !important;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        gap: 10px;
        width: 100%;
        padding: 0 10px;
    }
    .pcoded-header .m-header .mobile-menu {
        position: relative !important;
        left: 0 !important;
        right: auto !important;
        margin-right: 0 !important;
        margin-left: 0 !important;
        z-index: 2;
    }
    .pcoded-header .m-header .b-brand {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    @media (max-width: 991px) {
        .logo-big {
            display: none !important;
        }
        .logo-small {
            display: inline-block !important;
        }
        .admin-glass-header .b-brand strong {
            font-size: 1rem;
        }
        .admin-glass-header .dropdown-toggle span {
            display: none !important;
        }
        .admin-glass-header .dropdown-toggle img {
            margin-right: 0 !important;
        }
        .mob-toggler {
            display: none !important;
        }
        .user-name {
            display: none !important;
        }
        .user-profile-img {
            width: 36px !important;
            height: 36px !important;
        }
    }
    @media (min-width: 992px) {
        .mob-toggler {
            display: inline !important;
        }
        .user-name {
            display: inline !important;
        }
    }
    @media (max-width: 600px) {
        .logo-small {
            height: 28px !important;
        }
        .admin-glass-header .dropdown-toggle img {
            width: 32px !important;
            height: 32px !important;
        }
    }
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
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('touchstart', function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                    toggle.click();
                });
                toggle.style.cursor = 'pointer';
            });
        });
    })();
</script>