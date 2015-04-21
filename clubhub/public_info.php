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

if(!isset($_SESSION["pid"])) {
	echo "Welcome to Clubhub. You are not logged in. <br /><br >\n";
	echo '<a href="login.php">login</a> to sign up for the events listed below.  <br /> <a href="register.php">register</a> if you don\'t have an account yet.';
	echo "\n";
}
else {
	$username = htmlspecialchars($_SESSION["pid"]);
	echo "Welcome. You are logged in.<br /><br />\n";
	echo 'You may view the events detail listed below: ';
	
	echo "\n";
}

echo "<br /><br />\n";

if ($stmt = $mysqli->prepare("select topic from club_topics")) {
	$stmt->execute();
	$stmt->bind_result($topics);
	echo "<u><b>Club topics</b></u>";	
	echo "<br />";
	while ($stmt->fetch()) {
		$topics = htmlspecialchars($topics);
		echo "$topics</a> <br />";
	}
}

echo ' <br /><a href="public_topics.php">View club topic info</a>';


echo "<br /><br />\n";
if ($stmt = $mysqli->prepare("select ename, edatetime from event  where is_public_e = 1 order by edatetime")) {
	$stmt->execute();
	$stmt->bind_result($events, $date);
	echo "<u><b>Upcoming events</b></u>";	
	echo "<br />";
	while ($stmt->fetch()) {
		$events = htmlspecialchars($events);
		$date = htmlspecialchars($date);
		echo "$events</a> ($date)<br />";
	}
	echo ' <br /><a href="menu.php">Main Menu</a>';
	$stmt->close();
	$mysqli->close();
}

?>


</html>

