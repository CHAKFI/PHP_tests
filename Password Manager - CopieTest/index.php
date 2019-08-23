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
	<link href="css/style.css" rel="stylesheet">
	
</head>
<body style="background-image: url('img/11.jpg'); background-size: cover;">
             
                   <?php 
                   include"css/process-style.php"; 
                   ?>
     <!-- Barre : PASSWORD MANAGER -->
   <div id="brr">
				<p style="margin-left: 550px;"><strong>PassWord Manager</strong>					      
				    <a href="index.php?logout='1'">
		                <button style="margin-left: 450px;" class="butt">
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
       
       <div class="table-title">

<h3>Your Passwords</h3>

</div>

 <table class="table-fill">

 <thead>

<tr>
	<th class="text-left">Username</th>
	<th class="text-left">Lien</th>
	<th class="text-left">Password</th>	
</tr>

 </thead>
  <tbody class="table-hover">

<tr>
	<td class="text-left">azerty</td>
	<td class="text-left">www.azerty.com</td>
	<td class="text-left">azerty</td>
</tr>

<tr>
	<td class="text-left">user</td>
	<td class="text-left">www.user.com</td>
	<td class="text-left">us</td>
</tr>

<tr>
	<td class="text-left">qwert</td>
	<td class="text-left">www.qwert.com</td>
	<td class="text-left">qwt</td>
</tr>

<tr>
	<td class="text-left">admin</td>
	<td class="text-left">www.admin.com</td>
	<td class="text-left">adm</td>
</tr>

<tr>
	<td class="text-left">virtual</td>
	<td class="text-left">www.virtual.com</td>
	<td class="text-left">vrt</td>
</tr>

 </tbody>

  </table>

  <button class="buttADD">
  	<span>
  		Add
  	</span>
  </button>

  <button class="buttMOD">
  	<span>
  		Modify
  	</span>
  </button>

  <button class="buttDEL">
  	<span>
  		Delete
  	</span>
  </button>
		
</body>
</html>