<!DOCTYPE html>
<html>
     
     <head>
		    <link rel="icon" type="image/png" href="img/icon.png">
			<title>~ Acceuil ~</title>
	 </head>
		
		<body align="center" >
		     <!-- background Animation -->
             <?php include'css/styleStars.php'; ?>

	          <div id="stars"></div>
	          <div id="stars2"></div>
	          <div id="stars3"></div>

		  <?php 

              include"css/process-style.php";
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
						$userSer = "root";
						$pwdSer = "";
                        $dbname = "passman";
		                 //connect to the server select database
		  				$con = mysqli_connect($servername, $userSer, $pwdSer);
						 mysqli_select_db($con, $dbname);

		 // to prevent mysql injection

					 $username = stripcslashes($username);
					  $password = stripcslashes($password);
					   $username = mysqli_real_escape_string($con, $username);
						$password = mysqli_real_escape_string($con, $password);
						
		 // Query the database for user

						 $Rsql = "select * from authentf where username ='$username' and pssw ='$password'";
					     $result = mysqli_query($con, $Rsql) or die('Failed to query database '.mysqli_error($con));
					     $row = mysqli_fetch_array($result);
					
				      if ( $row['username'] == $username && $row['pssw'] == $password )
					      {
					    echo '<p id="txt1" style="font-family: Century Gothic; font-size: 30px; margin-left: 25%; color: white; width: 50%; background: rgba(1, 254, 18, 0.2); padding: 1px; border-radius: 15px;"> Login Success! Welcome '.$row['username'].'</p>';
					    echo '<div style="margin-top: 36%;">
					              <a href="login.php">
					                <button class="button">
					                 <span>
					                  Sign Out
					                 </span>
					                </button>
					              </a>
					           </div>';

		        	      } 

		        	  else 
		        	      {
				        echo '<p id="txt2" >Failed to login! incorrect username or password <a id="lien" href="login.php"> Try again</a></p>';
				        echo '<p id="txt2">Register <a id="lien" href="signup.php"> Here </a> if you are not registered</p>';
		                  }
            
		?>               
		</body>
</html>



