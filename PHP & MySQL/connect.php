<!DOCTYPE html>
<html>
		<head>
			<title> BDD </title>
		</head>
		 <body align = "center" style="background-image:url('IMG/bg_img4.jpg')">
		    
		  <?php
				$servername = "localhost";
				$username = "root";
				$password = "root";

				// Create connection
				$conn = mysqli_connect($servername, $username, );

				// Check connection
				if (!$conn)
				   {
				    die("Connection failed: " . mysqli_connect_error());
				   }
				    echo "\r\nConnection successfully\r\n";
                  
                
				
                    // using database
				   $usingDB = "USE person;";
				if (mysqli_query($conn,$usingDB))
				   {
                    echo"\r\nDatabase changed and can be used\r\n";
				   }
				else
				   {
				   	echo "\r\nCan't using database : ".mysqli_error($conn)."\r\n";
				   }   

				   if(mysqli_close($conn)) echo "connection has been closed";
                   

		    ?>



		</body>
</html>
