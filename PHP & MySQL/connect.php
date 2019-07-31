<!DOCTYPE html>
<html>
		<head>
			<title> BDD </title>
		</head>
		<body>
		    
		  <?php
		$servername = "localhost";
		$username = "root";
		$password = "root";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password);

		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}
		echo "Connected successfully";
        
        //create database
        $sql = "CREATE DATABASE";
          



		?>



		</body>
</html>
