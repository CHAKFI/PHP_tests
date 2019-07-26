<!DOCTYPE html>
		
			<html>
			<head>
				<title>~~PERSON INFORMAION~~</title>
			</head>
			<body>
                
                       <?php
                     //define a class PERSON who content information of a person 
                 class Person
                 {
                   private $fname;
                   private $lname;
                   private $age;
                              

                    /*          //default constructor
                    public function __Person()
                      {
                       echo"\r\nWELCOME TO DEFAULT CONSTRUCTOR\r\n";
                      }  
                    */

                              //initialization constructor
                    public function __Person($a, $b, $c)
                      {
                      	echo "\r\nWELCOME TO INITIALIZATION CONSTRUCTOR\r\n";
                         $fname = $a;
                          $lname = $b;
                       	   $age = $c;
                      }
                       
                         /*
                               //copy constructor
                    public function __Person( &$ob)
                      {

                       echo "\r\nWELCOME TO COPY CONSTRUCTOR\r\n";
                      }     
                      */
                        }
                         ?>        

			</body>
			</html>