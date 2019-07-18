<!DOCTYPE HTML>

<html>
  <head>
	<title>MySweb</title>
  </head>

   <body align = "center" style="background-image:url('bg_img4.jpg')">

          <!--Créer un formulaire-->
        </br></br></br></br></br></br></br></br></br></br>
        <form  method="post" <?php require'empty.php'; ?> >
  			
  			<p style="font-size:30px;">
  				<strong> Name: <input pe="text" name="name" style="font-size:30px;"/></strong>
  			</p>
  			
  			<p style="font-size:30px;">
  				<strong>  Age: <input type="text" name="age" style="font-size:30px;"/></strong>
  			</p> 
  			
  			<p>
  			  <input type="submit" name="submit" value="Submit" style="font-size:30px; color: #0F056B"/>
  			</p>
		
		</form>
                 
                 <div align="below" style="background-color: #BABABA; margin-top: 209px; height: 20px;">

                   © 2019 EST Sidi Bennour | Created by: <strong>CHAKFI Ahmed</strong>

                 </div>
   <?php
       if ($_SERVER["REQUEST_METHOD"] == "POST")
           {
           	 $nm = $_POST['name'];
           	  $ag = $_POST['age'];
           	   $c = 'style="color: #FFFFFF"';
                $aln = 'align="center"';

                 return $nm;
                 return $ag;
           }
    ?>
                     

	</body>
</html>

