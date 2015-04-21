<!DOCTYPE html>

<html>
<title>ClubHub</title>

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
	echo "Welcome to the clubhub, you are not logged in. <br /><br >\n";
	echo '<a href="login.php">login</a>  or <a href="register.php">register</a> if you don\'t have an account yet.';
	echo "\n";
}
else{
	echo '<H1>Welcome to ClubHub Homepage! </H1>';
	echo 'What would you like to do today?<br />';
	
	echo '<br/><br/><br/>';
	echo '<li><a href="public_info.php"> <font color="black">View Events</font></a><br /></li>';
	echo '<br/><br/>	';
	echo '<li><a href="sign_event.php"><font color="black">Sign Up Events</font></a><br /></li>';
	echo '<br/><br/>';
	echo '<li><a href="post_event.php"><font color="black">Post A New Event</font> </a><br /></li>';
	echo '<br/><br/>';
	echo '<li><a href="my_event.php"><font color="black">My Events</font></a><br /></li>';
	echo '<br/><br/>';
	echo '<li><a href="commentEvent.php"><font color="black">Comment on events</font></a><br /></li>';
	echo '<br/><br/>';
	echo '<li><a href="commentClub.php"><font color="black">Comment on clubs</font></a><br /></li>';
	echo '<br/><br/>';
	echo '<li><a href="ViewEventComment.php"><font color="black">View event comments</font></a><br /></li>';
	echo '<br/><br/>';
	echo '<li><a href="club_events.php"><font color="black">View Club Events</font></a><br /></li>';
	echo '<br/><br/>';
	echo '<li><a href="delete_user.php"><font color="black">Delete Account</a></font></li>';
	echo '<br/><br/>';
	echo '<li><a href="logout.php"><font color="black">Logout</a></font></li>';
	
}






?>

</html>



