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

		  	   <form action="process.php" method="POST">  
			  	<p>
			  		<label id="txt1">UserName: </label>	
			  		<input style="font-size: 20px;" type="text" name="user" />
			  	</p>
			  	<p>
			  		<label style="margin-left: 1.5%;" id="txt2">Password: </label>	
			  		<input style="font-size: 20px;" type="password" name="pass" />
			  	</p>
			  	<p>
			  		<button class ="button">
                       <span>
                       	Login
                       	</span>
                      </button>
			  	</p>
		 	   </form>
		
                     <a href="signup.php">
                      <button class ="button">
                       <span>
                        Sign Up
                       </span>
                      </button>
                     </a>
    

     	  </div>
         
              
		</body>
	</html>