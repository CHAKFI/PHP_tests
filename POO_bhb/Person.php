<!DOCTYPE html>
		
			<html>
			<head>
				<title>~~PERSON INFORMAION~~</title>
			</head>
			<style>
       
       <!--DEFINE TABLE-->
    table
     {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: center;
     }

    td, th
     {

      border: 1px solid #000000;
      text-align: center;
      padding: 15px;
     }
    td
     {
      background-color: #7F7F7F;
     }
    th
     {
      background-color: #17657D;
     }
   </style>
   
   <body align = "center" style="background-image:url('bg_img4.jpg')">
                   <h1>
                     <p style="font-size:50px;">
                      <strong> ~Votre information~ </strong>
                     </p>
                   </h1>

                   <!--CREATE FORM -->
 
			<body align = "center" style="background-image:url('bg_img4.jpg')">
     
              <form  method="post"  >

            <p style="font-size:30px;">
  				<strong> First Name: <input pe="text" name="Fname" style="font-size:30px;"/></strong>
  			</p>
  			
  			<p style="font-size:30px;">
  				<strong> Last Name: <input pe="text" name="Lname" style="font-size:30px;"/></strong>
  			</p>
  			
  			<p style="font-size:30px;">
  				<strong>  Age: <input type="text" name="age" style="font-size:30px;"/></strong>
  			</p> 
  			
  			<p>
  			  <input type="submit" name="submit" value="Submit" style="font-size:30px; color: #0F056B"/>
  			</p>
		
		</form>
                    
              <?php
                     //define a class PERSON who content information of a person 
                 class Person
                 {
                   private $fname;
                   private $lname;
                   private $age;
                              
                    public function __Person($a, $b, $c)
                      {
                         $fname = $a;
                          $lname = $b;
                       	   $age = $c;
                      }
                      
                        }
                           // Create an instance of class Person
                    $obj = new Person();

                          //VRBL
                    $fnm = $_REQUEST['Fname'];
                    $lnm = $_REQUEST['Lname'];
                    $ag = $_REQUEST['age'];
                    $c = 'style="color: #FFFFFF"';
                    $aln = 'align="center"';
                         
                         //calling  inisialization constructor
                    $obj->__Person($fnm,$lnm,$ag);
                         
                         //Show table
                       echo"</br></br></br></br></br></br>";
                       echo" <table ".$aln.">
                              <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Age</th>
                              </tr>
  
                              <tr>
                                <td ".$c.">".$fnm."</td>";
                           echo"<td ".$c.">".$lnm."</td>
                                <td ".$c.">".$ag."</td> 
                              </tr>
                             </table>";

                                  // vérifier si les champs sont vides et aficher le tableau 
                       if ($_SERVER["REQUEST_METHOD"] == "POST")
                        {
								  if (empty($_POST['fname'])) {
								    echo"First name is required";
								  } 

								  if (empty($_POST['lname'])) {
								    echo"Last name is required";
								  } 

								  if (empty($_POST["website"])) {
								    echo"Age is required";
								  } 
                        }        
             
                 ?>
              
                <div align="below" style="background-color: #BABABA; margin-top: 200px; height: 20px;">

                   © 2019 EST Sidi Bennour | Created by: <strong>CHAKFI Ahmed</strong>

                 </div> 

			</body>
			</html>