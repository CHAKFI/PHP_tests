<!DOCTYPE html>
	<html>
		<head>
		 <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
		    <link rel="icon" type="image/png" href="img/icon.png">
		     <title>~ Login ~</title>
		      <link rel="stylesheet" type="text/css" href="style.css">
		
		</head>
		<body align="center">
		 
		     </br></br></br>

		  <!-- background Animation -->
		  <?php include'styleStars.php'; ?>

	          <div id="stars"></div>
	          <div id="stars2"></div>
	          <div id="stars3"></div>
		   
		   <!-- Créer une forme Login -->
		  <div id="frm">
		  	  
		  	  <div id="title">
		  	  <H1>Login</H1>
		  	  </div>

		  	   <form action="process.php" method="POST">  
			  	<p>
			  		<label id="txt1">UserName: </label>	
			  		<input style="font-size:20px;" type="text" name="user" />
			  	</p>
			  	<p>
			  		<label style="margin-left: 2.5%;" id="txt2">Password: </label>	
			  		<input style="font-size:20px;" type="password" name="pass" />
			  	</p>
			  	<p>
			  		<input style="font-size:15px;" type="submit" id="btn" value="L O G I N"  />
			  	</p>
		 	   </form>
		 	
     	  </div>
                           	   
		
		</body>
	</html>