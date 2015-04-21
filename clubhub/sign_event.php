<!DOCTYPE html>
<html>
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

include ("connect_db.php");
//check if user signed in
if(!isset($_SESSION["pid"])) {
	echo "Welcome to the clubhub, you are not logged in. <br /><br >\n";
	echo '<a href="login.php">login</a>  or <a href="register.php">register</a> if you don\'t have an account yet.';
	echo "\n";
}
$pid=htmlspecialchars($_SESSION["pid"]);
//exclude the events user already signed up
if ($stmt = $mysqli->prepare("select ename,eid from event where  (eid not in (select eid from sign_up where pid=$pid ) &&event.is_public_e=1)or (sponsored_by in (select clubid from member_of where pid=$pid))order  by edatetime")) {
	$stmt->execute();
	$stmt->bind_result($ename,$eid);
	while ($stmt->fetch()) {
		$ename = htmlspecialchars($ename);
		$eid = htmlspecialchars($eid);
		echo "$eid. $ename.<br />";
		
	}
	$stmt->close();
	
}
if(isset($_POST["eid1"]) ) {
    //check if eid is valid
    if ($stmt = $mysqli->prepare("select eid from event where eid not in(select eid from sign_up where pid=$pid ) and eid=?")) {
		$stmt->bind_param("i", $_POST["eid1"]);
		$stmt->execute();
		$stmt->bind_result($eid); 
        if ($stmt->fetch()) {
			$stmt->close();
		   if ($stmt = $mysqli->prepare("insert into sign_up (pid,eid) values (?,?)")) {
              $stmt->bind_param("ii", $pid, $eid);
              $stmt->execute();
			  echo "Registration complete, click <a href=\"menu.php\">here</a> to return to homepage."; 
			  header("refresh: 1; menu.php");
        }
		}
		else{
		echo "The event does not exist or you already signed up.<br />";	
		echo "click <a href=\"menu.php\">here</a> to return to homepage."; 
		header("refresh: 3; sign_event.php");
			
				
			}
		$stmt->close();
		$mysqli->close();
	}
	
			
        	 
	
  }
	echo "<br />";
	echo "Enter the event ID that you want to sign up: <br /><br />\n";
    echo '<form action="sign_event.php" method="POST">';
    echo "\n";	
    echo 'Event ID: <input type="integer" name="eid1" /><br />';
	echo '<input type="submit" value="Submit" />';
	echo ' <br/><br /><a href="menu.php">Main Menu</a>';

?>

</html>
