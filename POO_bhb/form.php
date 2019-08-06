<!DOCTYPE html>
<html>
      <head>
        <title></title>
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
             
               <?php
             
                    // define variables and set to empty values
            $fnameErr = $lnameErr = $ageErr = $genderErr  = "";
            $fname = $lname = $age = $gender = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (empty($_POST["fname"])) {
                $fnameErr = 'First name is required';
              } else {
                $fname = test_input($_POST["fname"]);
              }
              
              if (empty($_POST["lname"])) {
                $lnameErr = 'Last name is required';
              } else {
                $lname = test_input($_POST["lname"]);
              }
                
              if (empty($_POST["age"])) {
                $ageErr = 'Age is required';
              } else {
                $age = test_input($_POST["age"]);
              }

              if (empty($_POST["gender"])) {
                $genderErr = 'Gender is required';
              } else {
                $gender = test_input($_POST["gender"]);
              }
            }

            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;

            }

               ?>
            
      <body align = "center" style="background-image:url('formIMG/bg_img4.jpg');background-size:cover;">

            <h2>~~INFORMATION~~</h2>
            <p style="font-size:25px;"><span class="error">(*): mean required </span></p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
             <p style="font-size:25px;">
              First name: <input type="text" name="fname" style="font-size:25px;">
              <span class="error" style="color: red;">* <?php echo $fnameErr;?></span>
              <br><br>
             </p> 
             <p style="font-size:25px;">
              Last name: <input type="text" name="lname" style="font-size:25px;">
              <span class="error" style="color: red;">* <?php echo $lnameErr;?></span>
              <br><br>
             </p>
             <p style="font-size:25px;">
              Age: <input type="text" name="age" style="font-size:25px;">
              <span class="error" style="color: red;">* <?php echo $ageErr;?></span>
              <br><br>
             </p> 
             <p style="font-size:25px;">
              Gender:
              <input type="radio" name="gender" value="Female" style="font-size:30px;">Female
              <input type="radio" name="gender" value="Male" style="font-size:30px;">Male
              <input type="radio" name="gender" value="Other" style="font-size:30px;">Other
              <span class="error" style="color: red;">* <?php echo $genderErr;?></span>
              <br><br>
              <input type="submit" name="submit" value="Submit" style="font-size:30px;">  
             </p>
             </form>
            
                <?php
                     $c = 'style="color: #FFFFFF"';
                     $aln = 'align="center"';

                         echo" <table ".$aln.">
                              <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Age</th>
                                <th>Gender</th>
                              </tr>
  
                              <tr>
                                <td ".$c.">".$fname."</td>";
                           echo"<td ".$c.">".$lname."</td>
                                <td ".$c.">".$age."</td>
                                <td ".$c.">".$gender."</td>

                              </tr>
                             </table>";
                  ?> 
           
      </body>
</html>