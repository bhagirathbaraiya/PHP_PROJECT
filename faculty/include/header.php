<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark admin-glass-header" style="backdrop-filter: blur(2px); background: rgba(255,255,255,0.18); border-bottom: 1.5px solid rgba(255,255,255,0.35);position:fixed; box-shadow: 0 4px 24px rgba(0,0,0,0.10); width:100%; z-index:1000;">
    <div class="m-header d-flex align-items-center justify-content-between w-100" style="gap:10px; padding: 0 15px;">
        <div class="d-flex align-items-center" style="gap:10px;">
            <a class="mobile-menu" id="mobile-collapse" href="#!" style="margin-right:10px;"><span></span></a>
            <!-- Hamburger for sidebar toggle -->
            <a href="dashboard.php" class="b-brand d-flex align-items-center" style="gap:10px;">
                <img src="../public/LOGO_B.png" alt="Logo Big" class="logo-big" style="height:48px; width:auto; display:inline-block;">
                <img src="../public/LOGO_S.png" alt="Logo Small" class="logo-small" style="height:36px; width:auto; display:none;">
            </a>
        </div>

        <ul class="navbar-nav d-flex flex-row align-items-center" style="gap:10px;">
        <li>
            <div class="dropdown drp-user d-flex">

                <div class="pro-head d-flex align-items-center" style="gap:10px; padding:16px 16px 12px 16px; border-bottom:1px solid #e0e7ef;">
                    <img src="https://marwadieducation.edu.in/MEFOnline/handler/getImage.ashx?Id=2355" class="img-radius user-profile-img" alt="User-Profile-Image" style="width:44px; height:44px; border-radius:50%; border:2px solid #fff; object-fit:cover;">
                    <span class="user-name d-none d-lg-inline" style="color:#102d4a; font-weight:600; font-size:1.05rem;"> <?php echo "Faculty"; ?> </span>
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
        justify-content: space-between;
        width: 100%;
        padding: 0 15px;
    }

    .b-brand {
        margin-right: 0 !important;
    }

    /* Header navigation alignment */
    .navbar-nav {
        flex-direction: row !important;
        align-items: center;
        gap: 10px;
        margin: 0 !important;
    }

    .navbar-nav li {
        margin: 0 !important;
    }

    /* Force hamburger to the left of the logo in the header */
    .pcoded-header .m-header {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        position: relative;
        width: 100%;
        padding: 0 15px;
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

        /* Mobile header alignment fixes */
        .pcoded-header {
            height: 60px !important;
        }

        .m-header {
            height: 60px !important;
            padding: 0 10px !important;
        }

        .navbar-nav {
            height: 100% !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .navbar-nav li {
            height: auto !important;
            display: flex !important;
            align-items: center !important;
        }

        .dropdown {
            height: auto !important;
            display: flex !important;
            align-items: center !important;
        }

        .dropdown-toggle {
            height: auto !important;
            padding: 4px !important;
            display: flex !important;
            align-items: center !important;
        }

        .icon-bell {
            font-size: 18px !important;
        }

        .badge {
            font-size: 10px !important;
            padding: 2px 6px !important;
            min-width: 18px !important;
            height: 18px !important;
            line-height: 14px !important;
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

        .m-header {
            padding: 0 8px !important;
        }

        .navbar-nav {
            gap: 6px !important;
        }

        .icon-bell {
            font-size: 16px !important;
        }

        .badge {
            font-size: 9px !important;
            padding: 1px 4px !important;
            min-width: 16px !important;
            height: 16px !important;
            line-height: 14px !important;
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