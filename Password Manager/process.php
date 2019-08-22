<!DOCTYPE html>
<html>
     
     <head>
		    <link rel="icon" type="image/png" href="img/icon.png">
			<title>~ Acceuil ~</title>
	 </head>
		
		<body align="center" style="background-image: url('img/11.jpg'); background-size: cover;">

			      <?php 
                   include"css/process-style.php"; 
                   ?>

			<div id="brr">
				<p style="margin-left: 470px;"><strong>PassWord Manager</strong>					      
				    <a href="login.php">
		                <button style="margin-left: 400px;" class="butt">
		                 <span>
		                  Sign Out
		                 </span>
		                </button>
		              </a>
		              </p>
		    </div>

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
					    echo '<p id="txt" > Login Success! Welcome '.$row['username'].'</p>';
		        	      } 

		        	  else 
		        	      {
				        echo '</br></br></br></br></br><img src="img/failed.png" height="250" width="450">';
				        echo '<div id="txt2">Register Now if you are not registered
				                  <a href="signup.php">
			                       <button class ="button">
			                        <span>
			                         Sign Up
			                        </span>
			                       </button>
			                      </a> 
			                      Or 
			                      <a id="lien"href="login.php">
				                   <button class ="button">
			                        <span>
			                         Try Again
			                        </span>
			                       </button>
			                       </div>';
		                  }
             
		?>               
		</body>
</html>



