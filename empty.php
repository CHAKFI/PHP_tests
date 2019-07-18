<?php
                  // vérifier si les champs sont vides et aficher le tableau 
         if ($_SERVER["REQUEST_METHOD"] == "POST")
           {
           	 $nm = $_REQUEST['name'];
           	  $ag = $_REQUEST['age'];
           	   $c = 'style="color: #FFFFFF"';
                $aln = 'align="center"';
      
           	     // tester si les champs vides , et afficher un message si les champs sont vide
           	   if(empty($nm)){$nm = 0;} else{$nm = 1;}
                
               if(empty($ag)){$ag = 0;} else{$ag = 1;}    
                    
                    if($nm == 0)
                     {
                     	echo'<p style="font-size: 20px; color: red;">**The column of Name is empty**</p>';
                       if($ag == 0)
                        {
                       	 echo'<p style="font-size: 20px; color: red;">**The column of age is empty**</p>';
                        }
                     } 
                     elseif($nm == 1)
                          {
                     	          if($ag == 0)
                     	       	    {
                     	      	    	echo'<p style="font-size: 20px; color: red;">**The column of age is empty**</p>';
                     	     	      }
                          }
                    else {echo'action="Affich_forms.php"';}
           }
?>