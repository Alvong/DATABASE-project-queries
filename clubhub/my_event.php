
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
$pid=htmlspecialchars($_SESSION["pid"]);
if(!isset($_SESSION["pid"])) {
	echo "Welcome to the clubhub, you are not logged in. <br /><br >\n";
	echo '<a href="login.php">login</a> to sign up for the events listed below.  <br /> <a href="register.php">register</a> if you don\'t have an account yet.';
	echo "\n";
}

else if ($stmt = $mysqli->prepare(("select ename,edatetime  from event where  (eid in (select eid from sign_up where pid=$pid ) or event.is_public_e=1)or (sponsored_by in (select clubid from member_of where pid=$pid))order  by edatetime"))) {
	$stmt->execute();
	$stmt->bind_result($ename,$time);
	//if the user has events print it 
	echo '<H1>View my public events and signed up events</H1>';
	while($stmt->fetch()) {
		echo "$ename--$time <br />";
	}
	
	$stmt->close();
	$mysqli->close();
	echo ' <br /><a href="menu.php">Main Menu</a>';
}


	
	?>
