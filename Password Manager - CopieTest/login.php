<?php include('server.php');?>
<!DOCTYPE html>
	<html>
		<head>

		    <link rel="icon" type="image/png" href="img/icon.png">
		     <title>~ Login ~</title>
		       
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
		   
		   		   </br></br></br>
		   <!-- Créer une forme Login -->
		  <div id="frm">
		  	  
		  	  <div id="title">
		  	   <H1>Login</H1>
		  	  </div>

		  	   <form action="login.php" method="POST">  
                     
                      <!--TEST IF username or password are required-->
                 <?php include('errors.php'); ?>

			  	<p>
			  		<label id="txt">UserName: </label>	
			  		<input style="font-size: 18px;" type="text" name="user" placeholder="Your Username.."/>
			  	</p>
			  	<p>
			  		<label id="txt" style="margin-left: 1.5%;">Password: </label>	
			  		<input style="font-size: 18px;" type="password" name="pass" placeholder="Password!.."/>
			  	</p>
			  	<p>
			  		<button class ="button" name="login_user">
                       <span>
                       	Sign In
                       	</span>
                      </button>
			  	</p>
		 	   </form>
		          
		          <p id="fontfam">
			        Not yet a member!
                     <a href="signup.php">
                      <button class ="butREG2">
                       <span>
                        Sign Up
                       </span>
                      </button>
                     </a>
                    </p> 
    

     	  </div>
         
              
		</body>
	</html>