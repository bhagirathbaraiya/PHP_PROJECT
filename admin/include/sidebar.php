
		<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar" style="background: linear-gradient(135deg, #e0e7ef 0%, #f7f9fb 100%); box-shadow: 0 4px 24px rgba(0,0,0,0.10); border-right: 1.5px solid rgba(255,255,255,0.35); backdrop-filter: blur(12px);">
    <div class="navbar-wrapper">
        <div class="navbar-content scroll-div">
            <!-- Search Bar -->
            <div style="padding: 18px 18px 8px 18px;">
                <input type="text" id="sidebar-search" placeholder="Search..." style="width: 100%; padding: 8px 12px; border-radius: 12px; border: 1px solid #0097A7; background: rgba(255,255,255,0.7); color: #102d4a; font-size: 1rem; outline: none; transition: border 0.2s;" oninput="filterSidebarOptions()">
            </div>
            <ul class="nav pcoded-inner-navbar" id="sidebar-options-list" style="margin-top: 0;">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a href="category.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Add Category</span></a>
                </li>
                <li class="nav-item">
                    <a href="subcategory.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Add Subcategory</span></a>
                </li>
                <li class="nav-item">
                    <a href="state.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Add State</span></a>
                </li>
                <li class="nav-item">
                    <a href="manage-users.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">Manage Users</span></a>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#" class="nav-link"><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Manage Complaint</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="all-complaint.php">All Complaints</a></li>
                        <li><a href="notprocess-complaint.php">Not Process Yet</a></li>
                        <li><a href="inprocess-complaint.php">In Process</a></li>
                        <li><a href="closed-complaint.php">Closed Complaints</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="between-date-userreport.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">User Reports</span></a>
                </li>
                <li class="nav-item">
                    <a href="between-date-complaintreport.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Complaints Report</span></a>
                </li>
                <li class="nav-item">
                    <a href="user-search.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-search"></i></span><span class="pcoded-mtext">User Search</span></a>
                </li>
                <li class="nav-item">
                    <a href="complaint-search.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-search"></i></span><span class="pcoded-mtext">Search Complaint</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
function filterSidebarOptions() {
    var input = document.getElementById('sidebar-search');
    var filter = input.value.toLowerCase();
    var ul = document.getElementById('sidebar-options-list');
    var items = ul.getElementsByTagName('li');
    for (var i = 0; i < items.length; i++) {
        var text = items[i].innerText.toLowerCase();
        if (text.indexOf(filter) > -1) {
            items[i].style.display = '';
        } else {
            items[i].style.display = 'none';
        }
    }
}
</script>
<style>
.pcoded-navbar {
    background: linear-gradient(135deg, #e0e7ef 0%, #f7f9fb 100%) !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    border-right: 1.5px solid rgba(255,255,255,0.35);
    backdrop-filter: blur(12px);
}
.pcoded-inner-navbar > .nav-item > .nav-link {
    color: #102d4a !important;
    background: rgba(255,255,255,0.18);
    border-radius: 12px;
    margin: 6px 12px;
    padding: 10px 18px;
    font-weight: 600;
    transition: background 0.18s, color 0.18s, box-shadow 0.18s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.pcoded-inner-navbar > .nav-item > .nav-link:hover, .pcoded-inner-navbar > .nav-item > .nav-link:focus {
    background: #0097A7 !important;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(0,151,167,0.13);
}
.pcoded-inner-navbar > .nav-item.active > .nav-link, .pcoded-inner-navbar > .nav-item > .nav-link.active {
    background: #A41E22 !important;
    color: #fff !important;
}
.pcoded-inner-navbar .pcoded-submenu {
    background: rgba(255,255,255,0.13);
    border-radius: 10px;
    margin: 4px 0 4px 18px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    padding: 6px 0;
}
.pcoded-inner-navbar .pcoded-submenu li a {
    color: #0097A7 !important;
    font-weight: 500;
    border-radius: 8px;
    padding: 7px 16px;
    transition: background 0.15s, color 0.15s;
}
.pcoded-inner-navbar .pcoded-submenu li a:hover, .pcoded-inner-navbar .pcoded-submenu li a:focus {
    background: #F9B600 !important;
    color: #A41E22 !important;
}
#sidebar-search:focus {
    border: 1.5px solid #A41E22;
}
</style>