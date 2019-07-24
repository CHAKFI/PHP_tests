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
                   $fname;
                    $lname;
                     $age;

                  public : 
                    Person();         //default constructor 
                    Person($, $, $);    //initialization constructor
                    Person(& );     //copy constructor
                 }
                     //definition of default constructor
                      Person::Person()
                      {
                       echo "\r\nWELCOME TO DEFAULT CONSTRUCTOR\r\n";
                      }

                     //definition of initialization constructor
                      Person::Person($a, $b, $c)
                      {
                      	echo "\r\nWELCOME TO INITIALIZATION CONSTRUCTOR\r\n";
                         $fname = $a;
                          $lname = $b;
                       	   $age = $c;
                      }

                     //definition of copy constructor 
                      Person::Person( &$ob)
                      {
                       echo "\r\nWELCOME TO COPY CONSTRUCTOR\r\n";
                        
                      }


                      

               ?>        

			</body>
			</html>