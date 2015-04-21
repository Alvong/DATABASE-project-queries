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
  echo "You are not logged in. ";
  echo "You will be returned to the menu page in 3 seconds or click <a href=\"menu.php\">here</a>.\n";
  header("refresh: 3; menu.php");
}
else {
	
	$user =  htmlspecialchars($_SESSION['pid']) ;
	if ($stmt = $mysqli->prepare("select role_in.clubid,club.cname from role_in,club where role_in.pid= ? and role_in.role = 'admin' ")) {
	$stmt->bind_param("i", $user);
	$stmt->execute();
	$stmt->bind_result($clubid,$cname);
    if ($stmt->fetch()) {
       echo "<H1>You are admin, you may check upcoming events.</H1>";
		
		$stmt->close();
		$cname=htmlspecialchars($cname);
		if ($stmt = $mysqli->prepare("select event.eid,  event.ename, count(sign_up.pid) from event natural left outer join sign_up where event.sponsored_by=6 group by  sign_up.eid")) {

		$stmt->execute();
		$stmt->bind_result($eid,$ename,$num);
		while ($stmt->fetch()) {
		echo "<br /><br />\n";
        echo $eid." - ".$ename." sponsored by ".$cname. ". ". $num ." people has signed up ".'<br />';
		
		}
	$stmt->close();
}
	}

else{
	echo "<H1>Error!!  You are not admin. You cannot check upcoming events.</H1>";
	echo '<br/><br/>	';
	echo "You will be returned to the menu page in 3 seconds \n";
	header("refresh: 3; menu.php");
}
	}
	echo ' <br/><br /><a href="menu.php">Main Menu</a>';
	
}
?>
