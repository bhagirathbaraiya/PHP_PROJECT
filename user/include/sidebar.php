
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar">
		<div class="navbar-wrapper">
			<div class="navbar-content scroll-div">
				<!-- Mobile Toggle Button -->
				<button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle Sidebar">
					<span class="sidebar-toggle-icon">&#9776;</span>
				</button>
				<div class="">
					<div class="main-menu-header">
						<?php
$id=intval($_SESSION["id"]);
$query=mysqli_query($con,"select * from users where id='$id'");
while($row=mysqli_fetch_array($query))
{
?>
						<img class="img-radius" src="../admin/assets/images/user/user.png" alt="User-Profile-Image">
						<div class="user-details">
								
							<span><?php echo  htmlentities($row['fullName']);?></span>
							<div id="more-details"><?php echo  htmlentities($row['userEmail']);?><i class="fa fa-chevron-down m-l-5"></i></div>
						</div><?php } ?>
					</div>
					<div class="collapse" id="nav-user-link">
						<ul class="list-unstyled">
							<li class="list-group-item"><a href="profile.php"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
							<li class="list-group-item"><a href="setting.php"><i class="feather icon-settings m-r-5"></i>Settings</a></li>
							<li class="list-group-item"><a href="logout.php"><i class="feather icon-log-out m-r-5"></i>Logout</a></li>
						</ul>
					</div>
				</div>
				
				<ul class="nav pcoded-inner-navbar">
					<li class="nav-item pcoded-menu-caption">
						<label>User Side</label>
					</li>
					<li class="nav-item">
					    <a href="dashboard.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
					
					<!-- <li class="nav-item">
					    <a href="register-complaint.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Lodge Complaint</span></a>
					</li> -->
					<!-- <li class="nav-item">
					    <a href="complaint-history.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Complaint History</span></a>
					</li> -->

				</ul>
				
		
				
			</div>
		</div>
	</nav>
	<!-- Responsive Sidebar Script -->
	<script>
	(function() {
	  function toggleSidebar() {
		var sidebar = document.querySelector('.pcoded-navbar');
		if (sidebar) {
		  sidebar.classList.toggle('sidebar-collapsed');
		}
	  }
	  // Vanilla JS
	  document.addEventListener('DOMContentLoaded', function() {
		var toggleBtn = document.getElementById('sidebarToggle');
		if (toggleBtn) {
		  toggleBtn.addEventListener('click', toggleSidebar);
		} else {
		  // Button not found, check your HTML structure
		  console.warn('Sidebar toggle button not found.');
		}
	  });
	  // jQuery fallback if available
	  if (window.jQuery) {
		$(function() {
		  $('#sidebarToggle').on('click', toggleSidebar);
		});
	  }
	})();
	</script>