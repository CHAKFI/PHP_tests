<?php 
	session_start(); 

	if (!isset($_SESSION['user'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: login.php");
	}

?>
<!DOCTYPE html>
<html>
<head>

	<title>~Accueil~</title>
	<link rel="icon" type="image/png" href="img/icon.png">
	
</head>
<body style="background-image: url('img/11.jpg'); background-size: cover;">
             
                   <?php 
                   include"css/process-style.php"; 
                   ?>
     <!-- Barre : PASSWORD MANAGER -->
   <div id="brr">
				<p style="margin-left: 470px;"><strong>PassWord Manager</strong>					      
				    <a href="index.php?logout='1'">
		                <button style="margin-left: 400px;" class="butt">
		                 <span>
		                  Sign Out
		                 </span>
		                </button>
		              </a>
		              </p>
		    </div>

	<div>

		<!-- notification message "you are now signed in" -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<?php  if (isset($_SESSION['user'])) : ?>
			<p id="mssgIndexWelcm"> Welcome <strong id="usr"><?php echo $_SESSION['user']; ?></strong></p>
			
		<?php endif ?>
	</div>
		
</body>
</html>