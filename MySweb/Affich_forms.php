<!DOCTYPE HTML>

<html>
  <head>
  <title>MySweb</title>
  </head>
 
       <!--definir la taille et la forme du tableau-->
   <style>
  
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

                   <!--AFFICHAGE du tableau -->
        <?php 
                $nm = $_REQUEST['name'];
                 $ag = $_REQUEST['age'];
                  $c = 'style="color: #FFFFFF"';
                   $aln = 'align="center"';

                       echo"</br></br></br></br></br></br>";
                       echo" <table ".$aln.">
                              <tr>
                                <th>Name</th>
                                <th>Age</th>
                              </tr>
  
                              <tr>
                                <td ".$c.">".$nm."</td>";
                           echo"<td ".$c.">".$ag."</td>
                              </tr>
                             </table>";
         ?>
              <div align="below" style="background-color: #BABABA; margin-top: 235px; height: 20px;">

                 © 2019 EST Sidi Bennour | Created by: <strong>CHAKFI Ahmed</strong>
                
              </div> 

  </body>
</html>
