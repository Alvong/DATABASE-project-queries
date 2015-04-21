<!DOCTYPE html>
<html>


<?php

include ("connect_db.php");
//check if user signed in
if(!isset($_SESSION["pid"])) {
	echo "Welcome to the clubhub, you are not logged in. <br /><br >\n";
	echo '<a href="login.php">login</a>  or <a href="register.php">register</a> if you don\'t have an account yet.';
	echo "\n";
}

else {
  //if the user have entered a message, insert it into database
  
  if(isset($_POST["ename"])) {
	
	if ($stmt = $mysqli->prepare("select comment.ctext from comment natural join event_comment natural join event where event.ename=? &&comment.is_public_c=1")) {
	$stmt->bind_param("s",$_POST["ename"]);
	$stmt->execute();
	$stmt->bind_result($comment);
	$ename = htmlspecialchars($_POST["ename"]);
	if($stmt->fetch()) {	
	$comment = nl2br(htmlspecialchars($comment));
	echo '<table border="2" width="30%"><tr><td>';
	echo "\n";
	echo "$ename:</td></tr><tr><td><br />$comment<br /><br /></td></tr></table><br />\n";
	 }
	$stmt->close();
	
	}
   
}
  
  //if not then display the form for posting message
  else {
     echo '<form action="ViewEventComment.php" method="POST">';
	echo '<br />';
	echo 'Choose a event:<br>';
	echo '<select name="ename">';
	//you can only see comment on the events you are going 
	if ($stmt = $mysqli->prepare("select distinct event.ename from event natural join sign_up where sign_up.pid=?")) {
	$stmt->bind_param("i", $_SESSION["pid"]);
	$stmt->execute();
	$stmt->bind_result($ename);
	while($stmt->fetch()) {
	$ename = htmlspecialchars($ename);
	echo "<option value='$ename'>$ename</option>";
	}
	$stmt->close();
	}
	echo '<input type="submit" value="Submit" />';
    echo "\n";
	echo '</form>';
	echo "\n";
	echo ' <br /><a href="menu.php">Main Menu</a>';
	

  }
}


$mysqli->close();
?>

</html>
