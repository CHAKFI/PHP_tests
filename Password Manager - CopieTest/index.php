<?php 
	session_start(); 

	if (!isset($_SESSION['user'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: login.php");
	}
           
?>
<!DOCTYPE html>
<html>
<head>

	<title>~Accueil~</title>
	<link rel="icon" type="image/png" href="img/icon.png">
	<link href="css/style.css" rel="stylesheet">
	
</head>
<body style="background-image: url('img/11.jpg'); background-size: cover;">
             
                   <?php 
                   include"css/process-style.php"; 
                   ?>
     <!-- Barre : PASSWORD MANAGER -->
   <div id="brr">
				<p style="margin-left: 550px;"><strong>PassWord Manager</strong>					      
				    <a href="index.php?logout='1'">
		                <button style="margin-left: 445px;" class="butt">
		                 <span>
		                  Sign Out
		                 </span>
		                </button>
		              </a>
		              </p>
		    </div>

	<div>

		<!-- notification message "you are now signed in" -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div>
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<?php  if (isset($_SESSION['user'])) : ?>
			<p id="mssgIndexWelcm"> Welcome <strong id="usr"><?php echo $_SESSION['user']; ?></strong></p>
			
		<?php endif ?>
	</div>
       
        
        <?php 

            $servername = "localhost";
			  $userSer = "root";
			  $pwdSer = "";
              $dbname = "passman";
              $sp = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; // simple espace
              //connect to the server select database
		  				$con = mysqli_connect($servername, $userSer, $pwdSer);
						mysqli_select_db($con, $dbname);
              
              //récupérer le nom utilisateur
                 $id = $_SESSION['user'];

              //requtte sql qui affiche lien user pssw
                 $query = "SELECT lien, username, pssw FROM password WHERE username = '$id'"; 
			     $result = mysqli_query($con, $query);
			     $num = mysqli_num_rows($result);

			

		       echo '<div class="table-title">';
                echo '<h3>Your Passwords</h3>';
                 echo '</div>';
                  echo '<table class="table-fill">';
                   echo '<thead>';
			        echo '<tr>';
			         echo '<th class="text-left">Username</th>';
			         echo '<th class="text-left">Link</th>';
			         echo '<th class="text-left">Password</th>';
			        echo '</tr>';
			       echo '</thead>';
			       echo '<tbody class="table-hover">';
                    
          while ($rows = mysqli_fetch_array($result)){
          	         echo '<tr>';
                   echo '<td>'.$sp.$rows['username'].'</td>'; 
                   echo '<td>'.$sp.$rows['lien'].'</td>';
                   echo '<td>'.$sp.$rows['pssw'].'</td>';
                     echo '</tr>';
                     } 
                     echo '<form name="form1" method="post" '.$_SERVER['PHP_SELF'].'>';
                     echo '<td><label><input name="usrn" type="text" id="usn"/></label></td>';
                      echo '<td><label><input name="lnk" type="text" id="ln"/></label></td>';
                       echo '<td><label><input name="pssd" type="password" id="pw"/></label></td>';
                      
               echo '</tbody>';
               echo '</table>';

 
         ?>

  <button class="buttADD" name="ajouter" type="submit">
  	<span>
  		Add
  	</span>
  </button>

  <button class="buttMOD">
  	<span>
  		Modify
  	</span>
  </button>

  <button class="buttDEL" name="supprimer" type="submit" >
  	<span>
  		Delete
  	</span>
  </button>

     </form>

	<?php 

	   require'button_process_Mysql.php'; 
	   include('errors.php');

	?>

</body>
</html>