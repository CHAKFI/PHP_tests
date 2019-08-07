<!DOCTYPE html>
<html>
     <head>
		<link rel="icon" type="image/png" href="img/icon.png">
			<title>~ Acceuil ~</title>
	 </head>
		<body align="center" style="background-image:url('img/8.jpg'); background-size: cover;">
		  <?php 
		 
		 // to get values passe from form in login.php file

		     
		     if(isset($_POST['user']))
		       {
		        $username = $_POST['user'];
		       }
				
			
			 if(isset($_POST['pass']))
			   {
		  	    $password = $_POST['pass'];
		       }
		              $servername = "localhost";
						$username = "root";
						$password = "";
                        $dbname = "passman";
		                 //connect to the server select database
		  				$con = mysqli_connect($servername, $username, $password);
						 mysqli_select_db($con, $dbname);

				 // to prevent mysql injection
					 $username = stripcslashes($username);
					  $password = stripcslashes($password);
					   $username = mysqli_real_escape_string($con, $username);
						$password = mysqli_real_escape_string($con, $username);
						
						 // Query the database for user
						 $Rsql = "select * from authentf where username ='$username' and pssw ='$password'";
					     $result = mysqli_query($con, $Rsql) or die('Failed to query database '.mysqli_error($con));
					     $row = mysqli_fetch_array($result);
					
				      if ( $row['username'] == $username && $row['pssw'] == $password )
					      {
					    echo '<p style="font-family: Century Gothic; font-size: 30px; margin-left: 40%; color: white; width: 30%; background: rgba(1, 254, 18, 0.2); padding: 1px; border-radius: 15px;" login success! Welcome'.$row['username'].'</p>';
		        	      } 
		        	      
		        	  else 
		        	      {
				        echo '<p style="font-family: Century Gothic; font-size: 30px; margin-left: 36%; color:white; width: 30%; background: rgba(254, 1, 1, 0.2); padding: 1px; border-radius: 15px;">Failed to login!<a href="login.php" style="font-family: Century Gothic; color:white;"> Try again</a></p>';
		                  }
		?>
		</body>
</html>



