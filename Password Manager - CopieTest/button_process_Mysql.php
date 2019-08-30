<?php 

 $errors = array();
 $usn="";
 $ln="";
 $psw="";

 if (isset($_POST['ajouter'])){

   $usn = mysqli_real_escape_string($con, $_POST['usrn']);
   $ln = mysqli_real_escape_string($con, $_POST['lnk']);
   $psw= mysqli_real_escape_string($con, $_POST['pssd']);
           
       if(empty($usn)){array_push($errors, "Username is required");}
       if (empty($ln)){array_push($errors, "Link required");}
       if(empty($psw)){array_push($errors, "Password required");}
         
         if (count($errors) == 0) {
			//encrypt the password before saving in the database
			$query = "INSERT INTO password (lien, username, pssw, id_au) VALUES('$ln','$usn','$psw','4')";
			 
			 mysqli_query($con, $query);

              echo'<p align="center" ><img src="img/v.png" width="15px" height="15px"></img><stong><font color="green"> Addition has been successfully completed </font><strong></p>';
				
			
         }
         echo("<meta http-equiv='refresh' content='2'>"); // Actualiser

      }
    
     
 if(isset($_POST['supprimer'])) {
         	
       $usn = mysqli_real_escape_string($con, $_POST['usrn']);
       $ln = mysqli_real_escape_string($con, $_POST['lnk']);
       $psw= mysqli_real_escape_string($con, $_POST['pssd']);
           
       if(empty($usn)){array_push($errors, "Username is required");}
       if (empty($ln)){array_push($errors, "Link required");}
       if(empty($psw)){array_push($errors, "Password required");}
         
       if (count($errors) == 0) {
          $query="DELETE FROM password WHERE username='$usn' AND lien='$ln' AND pssw='$psw'";
          mysqli_query($con, $query);

          echo '<p align="center"><img src="img/v.png" width="15px" height="15px"></img><stong><font color="green"> Deletion has been completed </font><strong></p>';
         }
         echo("<meta http-equiv='refresh' content='2'>"); // Actualiser
      }
          

?>