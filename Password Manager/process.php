<?php 
 // to get values passe from form in login.php file
 $username = "";

if(isset($_POST['username'])){
    $username = $_POST['username'];
}
 $password = "";
if(isset($_POST['username'])){
    $password = $_POST['password'];
 }
 // to prevent mysql injection
 $username = stripcslashes($username);
 $password = stripcslashes($password);
 $username = mysql_real_escape_string($username);
 $password = mysql_real_escape_string($username);

 //connect to the server select database
 mysql_connect("localhost", "root", "");
 mysql_select_db("login");

 // Query the database for user
 $result = mysql_query("select * from users where username = '$username' and password = '$password'")
  or die('Failed to query database'.mysql_error());
 $row = mysql_fetch_array($result);
 if ( $row['username'] == $username && $row['password'] == $password ) {
  echo "login success! Welcome".$row['username'];
 } else {
     echo "Failed to login!";
}

?>
