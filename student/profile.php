
<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['id'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_POST['submit']))
{
	$fname=$_POST['fullname'];
$contactno=$_POST['contactno'];
$address=$_POST['address'];
$state=$_POST['state'];
$country=$_POST['country'];
$pincode=$_POST['pincode'];
$id=$_SESSION["id"];
$sql=mysqli_query($con,"update users set fullName='$fname',contactNo='$contactno',address='$address',State='$state',country='$country',pincode='$pincode' where id='$id'");
if($sql) {
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Profile updated successfully!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href='profile.php';
            }
        });
    </script>";
}
}

	?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CMS||User Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <!-- Favicon icon -->
    <link rel="icon" href="../admin/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- vendor css -->
    <link rel="stylesheet" href="../admin/assets/css/style.css">
    
    <!-- Custom modern CSS -->
    <style>
        /* Color Palette Variables */
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

        .profile-container {
            background: var(--light-gray);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .profile-card {
            background: var(--primary-white);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(28, 31, 36, 0.08);
            overflow: hidden;
            margin: 0 auto;
            max-width: 1200px;
            border: 1px solid var(--gray);
        }
        
        .profile-header {
            background: var(--darkest);
            color: var(--primary-white);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            border-bottom: 3px solid var(--info-blue);
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid var(--info-blue);
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
            box-shadow: 0 6px 20px rgba(91, 192, 222, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(91, 192, 222, 0.5);
        }
        
        .profile-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--primary-white);
        }
        
        .profile-email {
            font-size: 16px;
            color: var(--medium-gray);
            margin-bottom: 20px;
        }
        
        .change-photo-btn {
            background: var(--teal);
            color: var(--primary-white);
            padding: 10px 25px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            border: 2px solid transparent;
        }
        
        .change-photo-btn:hover {
            background: var(--success-green);
            color: var(--primary-white);
            text-decoration: none;
            transform: translateY(-2px);
            border-color: var(--primary-white);
        }
        
        .profile-form {
            padding: 40px 30px;
            background: var(--primary-white);
        }
        
        .form-section {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--darkest);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--info-blue);
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--teal);
        }
        
        .modern-form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .modern-form-group label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }
        
        .modern-form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid var(--gray);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--primary-white);
            box-sizing: border-box;
            color: var(--darkest);
        }
        
        .modern-form-control:focus {
            outline: none;
            border-color: var(--info-blue);
            background: var(--primary-white);
            box-shadow: 0 0 0 3px rgba(91, 192, 222, 0.1);
            transform: translateY(-1px);
        }
        
        .modern-form-control:read-only {
            background: var(--light-gray);
            cursor: not-allowed;
            color: var(--dark-gray);
            border-color: var(--medium-gray);
        }
        
        .modern-btn {
            background: var(--info-blue);
            color: var(--primary-white);
            padding: 15px 40px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(91, 192, 222, 0.3);
        }
        
        .modern-btn:hover {
            background: var(--teal);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(81, 187, 183, 0.4);
        }
        
        .info-card {
            background: var(--success-green);
            color: var(--primary-white);
            padding: 25px 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
            border-left: 4px solid var(--green);
            position: relative;
            overflow: hidden;
        }
        
        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--teal);
        }
        
        .info-card h6 {
            margin: 0;
            font-size: 14px;
            color: var(--light-gray);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .info-card h4 {
            margin: 8px 0 0;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-white);
        }
        
        /* Additional Theme Elements */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .form-row .modern-form-group {
            flex: 1;
            margin: 0 10px 25px;
            min-width: 250px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background: var(--green);
            color: var(--primary-white);
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .divider {
            height: 1px;
            background: var(--medium-gray);
            margin: 30px 0;
            position: relative;
        }
        
        .divider::after {
            content: '';
            position: absolute;
            left: 50%;
            top: -2px;
            transform: translateX(-50%);
            width: 40px;
            height: 4px;
            background: var(--teal);
            border-radius: 2px;
        }
        
        /* Form Validation States */
        .modern-form-control.is-valid {
            border-color: var(--green);
            background-color: rgba(161, 190, 59, 0.05);
        }
        
        .modern-form-control.is-invalid {
            border-color: var(--danger);
            background-color: rgba(232, 89, 89, 0.05);
        }
        
        .modern-form-control.is-valid:focus {
            box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.1);
        }
        
        .modern-form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px var(--danger-light);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                padding: 10px;
            }
            
            .profile-header {
                padding: 30px 20px;
            }
            
            .profile-avatar {
                width: 120px;
                height: 120px;
            }
            
            .profile-name {
                font-size: 24px;
            }
            
            .profile-form {
                padding: 30px 20px;
            }
            
            .modern-form-control {
                padding: 12px 15px;
                font-size: 14px;
            }
            
            .modern-btn {
                width: 100%;
                padding: 12px;
                font-size: 14px;
            }
            
            .form-row {
                flex-direction: column;
                margin: 0;
            }
            
            .form-row .modern-form-group {
                margin: 0 0 25px;
                min-width: auto;
            }
        }
        
        @media (max-width: 576px) {
            .profile-avatar {
                width: 100px;
                height: 100px;
            }
            
            .profile-name {
                font-size: 20px;
            }
            
            .profile-email {
                font-size: 14px;
            }
            
            .section-title {
                font-size: 18px;
            }
            
            .info-card {
                padding: 20px 15px;
            }
            
            .profile-form {
                padding: 25px 15px;
            }
        }
        
        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid var(--light-gray);
            border-radius: 50%;
            border-top-color: var(--info-blue);
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Student Photo & QR Code Styles */
        .student-photo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .student-photo {
            width: 200px;
            height: 200px;
            border-radius: 15px;
            border: 4px solid var(--info-blue);
            object-fit: cover;
            display: block;
            margin: 0 auto 15px;
            box-shadow: 0 8px 25px rgba(91, 192, 222, 0.3);
            transition: all 0.3s ease;
        }
        
        .student-photo:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 30px rgba(91, 192, 222, 0.5);
        }
        
        .qr-code-container {
            text-align: center;
            margin-top: 20px;
        }
        
        .qr-placeholder {
            width: 150px;
            height: 150px;
            background: var(--light-gray);
            border: 2px dashed var(--info-blue);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            transition: all 0.3s ease;
        }
        
        .qr-placeholder:hover {
            background: var(--medium-gray);
            border-color: var(--teal);
        }
        
        .qr-placeholder i {
            font-size: 40px;
            color: var(--info-blue);
            margin-bottom: 10px;
        }
        
        .qr-placeholder p {
            margin: 0;
            color: var(--dark-gray);
            font-weight: 600;
            font-size: 14px;
        }
        
        .section-description {
            color: var(--dark-gray);
            font-size: 14px;
            margin-bottom: 20px;
            font-style: italic;
        }
        
        /* Enhanced form styling for new layout */
        .form-section {
            background: var(--primary-white);
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: 1px solid var(--medium-gray);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
    </style>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="profile-container">
	<?php include('include/sidebar.php');?>
	<?php include('include/header.php');?>

	<div class="pcoded-main-container">
		<div class="pcoded-content">
			<div class="container-fluid">
				<div class="profile-card">
					<?php
					$id=intval($_SESSION["id"]);
					$query=mysqli_query($con,"select * from users where id='$id'");
					while($row=mysqli_fetch_array($query))
					{
					?>
					
					<!-- Profile Form -->
					<div class="profile-form">
						<form method="post">
							<!-- Hidden field to combine names for backend compatibility -->
							<input type="hidden" name="fullname" value="<?php echo htmlentities($row['fullName']);?>">
							
							<div class="row">
								<!-- Left Column - Student Image & QR Code -->
								<div class="col-lg-3">
									<!-- Student Image Section -->
									<div class="form-section">
										<h3 class="section-title">Student Photo</h3>
										<div class="student-photo-container">
											<?php 
											$userphoto=$row['userImage'];
											if($userphoto=="" || !file_exists("userimages/".$userphoto)):
											?>
												<img src="userimages/noimage.png" class="student-photo" alt="Student Picture">
											<?php else: ?>
												<img src="userimages/<?php echo htmlentities($userphoto);?>" class="student-photo" alt="Student Picture">
											<?php endif; ?>
											<a href="update-image.php" class="change-photo-btn">
												<i class="feather icon-camera"></i> Change Photo
											</a>
										</div>
									</div>
									
									<!-- QR Code Section -->
									<div class="form-section">
										<h3 class="section-title">Student QR Code</h3>
										<div class="qr-code-container">
											<div class="qr-placeholder">
												<i class="feather icon-grid"></i>
												<p>QR Code</p>
											</div>
											<small>Scan to view student details</small>
										</div>
									</div>
								</div>
								
								<!-- Right Column - Form Details -->
								<div class="col-lg-9">
									<!-- Personal Details Section -->
									<div class="form-section">
										<h3 class="section-title">Personal Details</h3>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>First Name</label>
												<input type="text" name="firstname" class="modern-form-control" 
													   value="<?php echo explode(' ', htmlentities($row['fullName']))[0]; ?>"
													   placeholder="Enter first name" readonly>
											</div>
											
											<div class="modern-form-group">
												<label>Middle Name</label>
												<input type="text" name="middlename" class="modern-form-control" 
													   value="Kumar" 
													   placeholder="Enter middle name" readonly>
											</div>
											
											<div class="modern-form-group">
												<label>Last Name</label>
												<input type="text" name="lastname" class="modern-form-control" 
													   value="<?php $names = explode(' ', htmlentities($row['fullName'])); echo isset($names[1]) ? $names[1] : 'Sharma'; ?>"
													   placeholder="Enter last name" readonly>
											</div>
										</div>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>Mobile Number</label>
												<input type="text" name="contactno" required class="modern-form-control" 
													   value="<?php echo htmlentities($row['contactNo']);?>"
													   pattern="[0-9]{10}" maxlength="10" placeholder="9876543210">
											</div>
											
											<div class="modern-form-group">
												<label>Email Address</label>
												<input type="email" name="useremail" readonly class="modern-form-control" 
													   value="<?php echo htmlentities($row['userEmail']);?>">
											</div>
										</div>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>Country</label>
												<input type="text" name="country" required class="modern-form-control" 
													   value="<?php echo htmlentities($row['country']);?>"
													   placeholder="Country name">
											</div>
											
											<div class="modern-form-group">
												<label>State</label>
												<select name="state" required class="modern-form-control">
													<option value="<?php echo htmlentities($row['State']);?>"><?php echo htmlentities($st=$row['State']);?></option>
													<?php 
													$sql=mysqli_query($con,"select stateName from state ");
													while ($rw=mysqli_fetch_array($sql)) {
													  if($rw['stateName']==$st) {
														continue;
													  } else {
													?>
													  <option value="<?php echo htmlentities($rw['stateName']);?>"><?php echo htmlentities($rw['stateName']);?></option>
													<?php }}?>
												</select>
											</div>
										</div>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>Address</label>
												<textarea name="address" required class="modern-form-control" rows="2" 
														  placeholder="Enter your complete address"><?php echo htmlentities($row['address']);?></textarea>
											</div>
											
											<div class="modern-form-group">
												<label>Pincode</label>
												<input type="text" name="pincode" maxlength="6" required class="modern-form-control" 
													   value="<?php echo htmlentities($row['pincode']);?>"
													   pattern="[0-9]{6}" placeholder="000000">
											</div>
										</div>
									</div>
									
									<!-- Educational Details Section -->
									<div class="form-section">
										<h3 class="section-title">Educational Details</h3>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>Department</label>
												<select name="department" class="modern-form-control" readonly>
													<option value="Computer Science">Computer Science Engineering</option>
												</select>
											</div>
											
											<div class="modern-form-group">
												<label>Course</label>
												<select name="course" class="modern-form-control" readonly>
													<option value="B.Tech">Bachelor of Technology (B.Tech)</option>
												</select>
											</div>
										</div>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>Semester</label>
												<select name="semester" class="modern-form-control" readonly>
													<option value="5">5th Semester</option>
												</select>
											</div>
											
											<div class="modern-form-group">
												<label>Division</label>
												<select name="division" class="modern-form-control" readonly>
													<option value="A">Division A</option>
												</select>
											</div>
										</div>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>Student ID</label>
												<input type="text" readonly class="modern-form-control" 
													   value="CSE<?php echo date('Y') . str_pad($row['id'], 4, '0', STR_PAD_LEFT);?>">
											</div>
											
											<div class="modern-form-group">
												<label>Enrollment Number</label>
												<input type="text" readonly class="modern-form-control" 
													   value="EN<?php echo date('Y') . str_pad($row['id'], 6, '0', STR_PAD_LEFT);?>">
											</div>
										</div>
									</div>
									
									<!-- Password Change Section -->
									<div class="form-section">
										<h3 class="section-title">Password Management</h3>
										<p class="section-description">Change your account password for security</p>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>Current Password</label>
												<input type="password" name="current_password" class="modern-form-control" 
													   placeholder="Enter current password">
											</div>
											
											<div class="modern-form-group">
												<label>New Password</label>
												<input type="password" name="new_password" class="modern-form-control" 
													   placeholder="Enter new password">
											</div>
										</div>
										
										<div class="form-row">
											<div class="modern-form-group">
												<label>Confirm New Password</label>
												<input type="password" name="confirm_password" class="modern-form-control" 
													   placeholder="Confirm new password">
											</div>
											
											<div class="modern-form-group">
												<label>Last Password Change</label>
												<input type="text" readonly class="modern-form-control" 
													   value="<?php echo date('M d, Y', strtotime($row['regDate']));?>">
											</div>
										</div>
									</div>
									
									<div class="text-center mt-4">
										<button type="submit" class="modern-btn" name="submit" id="updateBtn">
											<i class="feather icon-save"></i> Update Profile
											<span class="loading-spinner" style="display: none;"></span>
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Required Js -->
	<script src="../admin/assets/js/vendor-all.min.js"></script>
	<script src="../admin/assets/js/plugins/bootstrap.min.js"></script>
	<script src="../admin/assets/js/pcoded.min.js"></script>
	
	<script>
		// Enhanced form validation with color scheme
		document.addEventListener('DOMContentLoaded', function() {
			const form = document.querySelector('form[method="post"]');
			const inputs = form.querySelectorAll('.modern-form-control[required]');
			const updateBtn = document.getElementById('updateBtn');
			const spinner = updateBtn.querySelector('.loading-spinner');
			
			// Form validation
			inputs.forEach(input => {
				input.addEventListener('blur', function() {
					validateField(this);
				});
				
				input.addEventListener('input', function() {
					if (this.classList.contains('is-invalid')) {
						validateField(this);
					}
				});
			});
			
			function validateField(field) {
				const value = field.value.trim();
				const fieldType = field.type;
				const fieldName = field.name;
				
				field.classList.remove('is-valid', 'is-invalid');
				
				if (!value) {
					field.classList.add('is-invalid');
					return false;
				}
				
				// Specific validation based on field
				switch(fieldName) {
					case 'contactno':
						if (!/^[0-9]{10}$/.test(value)) {
							field.classList.add('is-invalid');
							return false;
						}
						break;
					case 'pincode':
						if (!/^[0-9]{6}$/.test(value)) {
							field.classList.add('is-invalid');
							return false;
						}
						break;
					case 'fullname':
						if (value.length < 2) {
							field.classList.add('is-invalid');
							return false;
						}
						break;
				}
				
				field.classList.add('is-valid');
				return true;
			}
			
			// Phone number formatting
			const phoneInput = document.querySelector('input[name="contactno"]');
			phoneInput.addEventListener('input', function() {
				this.value = this.value.replace(/[^0-9]/g, '').substr(0, 10);
			});
			
			// Pincode formatting
			const pincodeInput = document.querySelector('input[name="pincode"]');
			pincodeInput.addEventListener('input', function() {
				this.value = this.value.replace(/[^0-9]/g, '').substr(0, 6);
			});
			
			// Form submission
			form.addEventListener('submit', function(e) {
				let isValid = true;
				
				inputs.forEach(input => {
					if (!validateField(input)) {
						isValid = false;
					}
				});
				
				if (!isValid) {
					e.preventDefault();
					Swal.fire({
						title: 'Validation Error!',
						text: 'Please check all required fields and correct any errors.',
						icon: 'error',
						confirmButtonText: 'OK',
						confirmButtonColor: '#d9534f'
					});
					return;
				}
				
				// Show loading state
				updateBtn.disabled = true;
				spinner.style.display = 'inline-block';
				updateBtn.innerHTML = '<i class="feather icon-loader"></i> Updating... <span class="loading-spinner"></span>';
			});
			
			// Auto-capitalize first letter of names
			const nameInput = document.querySelector('input[name="fullname"]');
			nameInput.addEventListener('input', function() {
				this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
			});
			
			// Country name formatting
			const countryInput = document.querySelector('input[name="country"]');
			countryInput.addEventListener('input', function() {
				this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
			});
		});
	</script>
</body>

</html>
<?php } ?>