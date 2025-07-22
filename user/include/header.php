<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark user-glass-header" style="backdrop-filter: blur(16px); background: rgba(255,255,255,0.18); border-bottom: 1.5px solid rgba(255,255,255,0.35); box-shadow: 0 4px 24px rgba(0,0,0,0.10);">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        <a href="dashboard.php" class="b-brand">
            <strong style="color:#0097A7; letter-spacing:1px; font-size:1.3rem;">Assignment Tracker</strong>
        </a>
        <a href="#!" class="mob-toggler">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle d-flex align-items-center" data-toggle="dropdown" style="gap:10px; min-width:120px;">
                        <img src="https://student.marwadiuniversity.ac.in:553/handler/getImage.ashx?SID=123766" class="img-radius" alt="User-Profile-Image" style="width:40px; height:40px; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.07); border:2px solid #fff; background:#f7f9fb; object-fit:cover;">
                        <span style="color:#102d4a; font-weight:600; font-size:1rem;"> <?php 
$ret=mysqli_query($con,"select fullname from users where id='".$_SESSION['id']."'");
$row=mysqli_fetch_array($ret);
$name=$row['fullname'];
echo $name;
?> </span>
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
                            <li><a href="profile.php" class="dropdown-item d-flex align-items-center" style="gap:8px;"><i class="feather icon-user"></i> Profile</a></li>
                            <li><a href="setting.php" class="dropdown-item d-flex align-items-center" style="gap:8px;"><i class="feather icon-mail"></i> Settings</a></li>
                            <li><a href="logout.php" class="dropdown-item d-flex align-items-center" style="gap:8px;"><i class="feather icon-lock"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<style>
@media (max-width: 991px) {
    .user-glass-header {
        flex-direction: column;
        padding: 8px 0 0 0;
    }
    .user-glass-header .navbar-nav {
        flex-direction: row;
        justify-content: flex-end;
        width: 100%;
    }
    .user-glass-header .dropdown-toggle span {
        display: none !important;
    }
    .user-glass-header .dropdown-toggle img {
        margin-right: 0 !important;
    }
}
@media (max-width: 600px) {
    .user-glass-header .b-brand strong {
        font-size: 1rem;
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