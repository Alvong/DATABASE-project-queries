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
<html>
<body>

<form action = "get-input.php" method="GET">
Choose a topic<br>
<select name='clubid'>

<?php

include "connect_db.php";

if ($stmt = $mysqli->prepare("select clubid, topic from club_topics")) {
  $stmt->execute();
  $stmt->bind_result($clubid, $topic);
  while($stmt->fetch()) {
	$clubid = htmlspecialchars($clubid);
	$topic = htmlspecialchars($topic);
	echo "<option value='$clubid'>$topic</option>\n";	
  }
  $stmt->close();
  $mysqli->close();
}

?>
	
	</select><input type = "submit" value = "Show infos">
</form>
</body>
</html>
