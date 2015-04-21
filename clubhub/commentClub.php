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

else {
  //if the user have entered a message, insert it into database
  
  if(isset($_POST["message"])) {
	 $message=htmlspecialchars($_POST["message"]);
	if (empty($_POST["message"])) {
     echo "Message is required.";
	 header("refresh: 3; comment.php");
   }
    else if (!isset($_POST["public"])) {
     echo "choose the comment to be public or not.";
	 
   }
      else if (!isset($_POST["cname"])){
	  echo "You have no clubs.";
	echo ' <br /><a href="menu.php">Main Menu</a>';}

    //insert into database, note that message_id is auto_increment and time is set to current_timestamp by default
   else if($stmt = $mysqli->prepare("insert into comment (commenter, ctext,is_public_c) values (?,?,?)")) {
      $stmt->bind_param("isi", $_SESSION["pid"], $_POST["message"],$_POST["public"]);
      $stmt->execute();
      $stmt->close();
	  
      //header("refresh: 3; menu.php");
		if ($stmt = $mysqli->prepare("select comment.comment_id,club.clubid from comment, club where comment.ctext= ? &&comment.commenter =?&&club.cname=?")) {
	$stmt->bind_param("sis",$_POST["message"],$_SESSION["pid"],$_POST["cname"]);
	$stmt->execute();
	$stmt->bind_result($comment_id,$cid);
	 if($stmt->fetch()) {
	$comment_id = htmlspecialchars($comment_id);
	$cid = htmlspecialchars($cid);
	 }
	$stmt->close();
	
	if($stmt = $mysqli->prepare("insert into club_comment (comment_id, clubid) values (?,?)")) {
      $stmt->bind_param("ii", $comment_id, $cid);
      $stmt->execute();
      $stmt->close(); 
	  $cname = htmlspecialchars($_POST["cname"]);
	  echo "You comment is posted on ".$cname;
	  header("refresh: 3; menu.php");
    }  
	}
    }  

	
	
	 
	
  }

  //if not then display the form for posting message
  else {
    echo "Enter your message: <br /><br />\n";
    echo '<form action="commentClub.php" method="POST">';
    echo "\n";	
    echo '<textarea cols="40" rows="10" name="message" /></textarea><br />';
    echo "\n";
	echo "\n";
	echo '<input type="radio" name="public"  value="1">public';
	echo '<input type="radio" name="public"  value="0">private';
	echo "\n";
	echo '<br />';
	echo 'Choose a event:<br>';
	echo '<select name="cname">';
	//you can only comment on the clubs you are going 
	if ($stmt = $mysqli->prepare("select distinct club.cname from club natural join member_of where member_of.pid=?")) {
	$stmt->bind_param("i", $_SESSION["pid"]);
	$stmt->execute();
	$stmt->bind_result($cname);
	while($stmt->fetch()) {
	$cname = htmlspecialchars($cname);
	echo "<option value='$cname'>$cname</option>";
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
