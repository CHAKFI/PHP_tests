
		  <?php 
              session_start();
              $errors = array();
              $_SESSION['success'] = "";
              $servername = "localhost";
			  $userSer = "root";
			  $pwdSer = "";
              $dbname = "passman";

              //connect to the server select database
		  				$con = mysqli_connect($servername, $userSer, $pwdSer);
						mysqli_select_db($con, $dbname);

      		 // REGISTER USER
		$username = "";
		$email = "";
		$password_1 = "";
		$password_2 = "";

	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($con, $_POST['username']);
		$email = mysqli_real_escape_string($con, $_POST['email']);
		$password_1 = mysqli_real_escape_string($con, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($con, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			//encrypt the password before saving in the database
			$password = md5($password_1);
			$query = "INSERT INTO authentf (username, email, pssw) VALUES('$username', '$email', '$password')";
			mysqli_query($con, $query);

			$_SESSION['user'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}
        
	}

	// ... 

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($con, $_POST['user']);
		$password = mysqli_real_escape_string($con, $_POST['pass']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
		  	$password = md5($password);
			$query = "SELECT * FROM authentf WHERE username='$username' AND pssw='$password'";
			$results = mysqli_query($con, $query);
            
            
			if (mysqli_num_rows($results) == 1) {
				$_SESSION['user'] = $username;
				$_SESSION['success'] = "You are now signed in";
				header('location: index.php');
			}else {
				echo'<p id="mssg">Wrong username or password</p>';
			}
		} 
	}
		?>               
	






