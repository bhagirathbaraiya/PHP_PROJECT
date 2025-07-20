<!-- [ Pre-loader ] End -->
<style>
:root {
    --primary-white: #ffffff;
    --light-gray: #eeeeee;
    --medium-gray: #e5e5e5;
    --gray: #e4e4e4;
    --info-blue: #5bc0de;
    --success-green: #a1be3b;
    --teal: #51bbb7;
    --green: #5cb85c;
    --danger-light: #e8595980;
    --danger: #e85959;
    --dark-red: #d9534f;
    --red: #d44c4c;
    --dark-gray: #42454a;
    --darker-gray: #292c31;
    --darkest: #1c1f24;
}

/* Override sidebar colors with custom palette */
.pcoded-navbar {
    background: var(--darker-gray) !important;
    color: var(--light-gray) !important;
}

.pcoded-navbar .header-logo {
    background: var(--darkest) !important;
}

.pcoded-navbar .main-menu-header {
    background: var(--dark-gray) !important;
    color: var(--primary-white) !important;
}

.pcoded-navbar .main-menu-header .user-details > div,
.pcoded-navbar .main-menu-header .user-details > span {
    color: var(--light-gray) !important;
}

.pcoded-navbar .pcoded-inner-navbar li > a {
    color: var(--light-gray) !important;
}

.pcoded-navbar .pcoded-inner-navbar li.active > a, 
.pcoded-navbar .pcoded-inner-navbar li:focus > a, 
.pcoded-navbar .pcoded-inner-navbar li:hover > a {
    color: var(--teal) !important;
    background: transparent !important;
}

.pcoded-navbar .pcoded-inner-navbar > li.active > a, 
.pcoded-navbar .pcoded-inner-navbar > li.pcoded-trigger > a {
    background: var(--teal) !important;
    color: var(--primary-white) !important;
}

.pcoded-navbar .pcoded-inner-navbar > li.active:after,
.pcoded-navbar .pcoded-inner-navbar > li.pcoded-trigger:after {
    background: var(--teal) !important;
}

.pcoded-navbar .main-menu-header + div .list-group-item {
    background: var(--dark-gray) !important;
    color: var(--light-gray) !important;
}

.pcoded-navbar .main-menu-header + div .list-group-item:hover {
    background: var(--teal) !important;
    color: var(--primary-white) !important;
}

.pcoded-navbar .pcoded-inner-navbar li > a > .pcoded-micon {
    color: var(--medium-gray) !important;
}

.pcoded-navbar .pcoded-inner-navbar li.active > a > .pcoded-micon,
.pcoded-navbar .pcoded-inner-navbar li:hover > a > .pcoded-micon {
    color: var(--primary-white) !important;
}
</style>
<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar  ">
	<div class="navbar-wrapper  ">
		<div class="navbar-content scroll-div ">
			<div class="">
				<div class="main-menu-header">
					<?php
					$id = intval($_SESSION["id"]);
					$query = mysqli_query($con, "select * from users where id='$id'");
					while ($row = mysqli_fetch_array($query)) {
						?>
						<img class="img-radius"
							src="https://student.marwadiuniversity.ac.in:553/handler/getImage.ashx?SID=123766"
							alt="User-Profile-Image">
						<div class="user-details">

							<span><?php echo htmlentities($row['fullName']); ?></span>
							<div id="more-details"><?php echo htmlentities($row['userEmail']); ?>
								<!-- <i class="fa fa-chevron-down m-l-5"></i> -->
							</div>
						</div><?php } ?>
				</div>
				<div class="collapse" id="nav-user-link">
					<ul class="list-unstyled">
						<li class="list-group-item"><a href="profile.php"><i class="feather icon-user m-r-5"></i>View
								Profile</a></li>
						<li class="list-group-item"><a href="setting.php"><i
									class="feather icon-settings m-r-5"></i>Settings</a></li>
						<li class="list-group-item"><a href="logout.php"><i
									class="feather icon-log-out m-r-5"></i>Logout</a></li>
					</ul>
				</div>
			</div>

			<ul class="nav pcoded-inner-navbar ">
				<!-- <li class="nav-item pcoded-menu-caption">
					<label>User Side</label>
				</li> -->
				<li class="nav-item">
					<a href="dashboard.php" class="nav-link "><span class="pcoded-micon"><i
								class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
				</li>

				<li class="nav-item">
					<a href="register-complaint.php" class="nav-link "><span class="pcoded-micon"><i
								class="feather icon-file-text"></i></span><span class="pcoded-mtext">Subjects</span></a>
				</li>
				<li class="nav-item">
					<a href="register-complaint.php" class="nav-link "><span class="pcoded-micon"><i
								class="feather icon-file-text"></i></span><span class="pcoded-mtext">Subjects</span></a>
				</li>
				<li class="nav-item">
					<a href="profile.php" class="nav-link "><span class="pcoded-micon">
						<i class="feather icon-user"></i>
						</i></span><span class="pcoded-mtext">Profile</span></a>
				</li>
			</ul>
		</div>
	</div>
</nav>