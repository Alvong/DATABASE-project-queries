<!DOCTYPE html>
<html>
<title>Register</title>
<style>
{ margin: 0; padding: 0; }
html { 
        background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRNx1vZqUhZUSBAngeCxXzmQjAqFGPcFzP-LHJIUgXL0yt-lF4IXA') no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
}
</style>

<?php

include "connect_db.php";

//if the user is already logged in, redirect them back to homepage
if(isset($_SESSION["pid"])) {
  echo "You are already logged in. ";
  echo "You will be redirected in 3 seconds or click <a href=\"menu.php\">here</a>.";
  header("refresh: 3; menu.php");
}
else {
  //if the user have entered _all_ entries in the form, insert into database
  if(isset($_POST["pid"]) && isset($_POST["password"])&& isset($_POST["fname"]) &&isset($_POST["lname"])) {

    //check if username already exists in database
    if ($stmt = $mysqli->prepare("select pid from person where pid= ?")) {
      $stmt->bind_param("s", $_POST["pid"]);
      $stmt->execute();
      $stmt->bind_result($pid);
        if ($stmt->fetch()) {
          echo "That id already exists. ";
          echo "You will be redirected in 3 seconds or click <a href=\"register.php\">here</a>.";
          header("refresh: 3; register.php");
		  $stmt->close();
        }
		//if not then insert the entry into database, note that user_id is set by auto_increment
		else {

			//if the pid is int
			if(is_numeric ($_POST["pid"]))
			{
			$pid=$_POST["pid"];
			$passwd=md5($_POST["password"]);
			$fname=$_POST["fname"];
			$lname=$_POST["lname"];
		    $stmt->close();
		    if ($stmt = $mysqli->prepare("insert into person (pid,passwd,fname,lname) values (?,?,?,?)")) {
              $stmt->bind_param("isss", $pid, $passwd,$fname, $lname);
              $stmt->execute();
              $stmt->close();
              echo "Registration complete, click <a href=\"login.php\">here</a> to return to homepage."; 
          }	
			}
			else{
			echo "ID must be integers only. ";
			echo "You will be redirected in 3 seconds or click <a href=\"register.php\">here</a>.";
			header("refresh: 3; register.php");
			$stmt->close();
				
			}
			
        }	 
	}
  }
  //if not then display registration form
  else {
    echo "Enter your information below: <br /><br />\n";
    echo '<form action="register.php" method="POST">';
    echo "\n";	
    echo 'ID: <input type="integer" name="pid" /><br />';
    echo "\n";
	echo 'Password: <input type="password" name="password" /><br />';
	echo 'First Name: <input type="text" name="fname" /><br />';
	echo 'Last Name: <input type="text" name="lname" /><br />';
    echo "\n";
	echo '<input type="submit" value="Submit" />';
    echo "\n";
	echo '</form>';
	echo "\n";
	echo '<br /><a href="login.php">Go back</a>';

  }
}
$mysqli->close();


?>


</html>