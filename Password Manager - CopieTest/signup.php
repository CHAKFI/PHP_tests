<?php include('server.php') ?>
<!DOCTYPE html>
    <html>
        <head>

        	<link rel="icon" type="image/png" href="img/icon.png">
	         <title>Registration</title>
	
        </head>
  <body align="center">

         <!-- background Animation -->
          <?php
		   include'css/styleStars.php';
		   include'css/login_button_Sgout_style.php';
		   include'css/style.php';
		    ?>

	          <div id="stars"></div>
	          <div id="stars2"></div>
	          <div id="stars3"></div>  
  

          <!-- Créer une forme Sign up -->
   <div id="frm" style="">
	
	   <div id="title">
	    <H1>Register</H1>
	   </div>
	
	    <form action="signup.php" method="POST">
        
         <!--TEST IF username or password or email are required-->
		<?php include('errors.php'); ?>

		<p>
			<label id="txt" style="margin-left: 14%;">Username:</label>
			<input style="font-size: 18px;" type="text" name="username" placeholder="Your Username.." value="<?php echo $username; ?>">
		</p>
		<p>
			<label id="txt" style="margin-left: 22.5%;">Email:</label>
			<input style="font-size: 18px;" type="email" name="email" placeholder="Your email.." value="<?php echo $email; ?>">
		</p>
		<p>
			<label id="txt" style="margin-left: 15.5%;">Password:</label>
			<input style="font-size: 18px;" type="password" name="password_1" placeholder="Password!..">
		</p>
		<p>
			<label id="txt">Confirm password:</label>
			<input style="font-size: 18px;" type="password" name="password_2" placeholder="Password!..">
		</p>
		<p>
			<button class ="button" name="reg_user">
				<span>
				  Register
				</span>
			</button>
		</p>
		
		</form>
		 
		 <p id="fontfam">
			Already a member! 
			<a href="login.php">
				<button class ="butREG">
				 <span>
				  Sign In
				 </span>
			    </button>
		    </a>

		  </p>	

	</div>

	
</body>
</html>