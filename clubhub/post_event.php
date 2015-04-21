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
	if ($stmt = $mysqli->prepare("select pid from role_in where pid= ? and role = 'admin' ")) {
	$stmt->bind_param("s", $user);
	$stmt->execute();
        if ($stmt->fetch()) {
          echo "<H1>You are admin, you may post an event.</H1>";
		  $stmt->close();
	 echo 'Post an Event';
	 echo '<br/><br/>	';
			echo '<FORM action="post_event.php" method="POST">';
			echo '<P><INPUT type="text" name="ename" value="" placeholder="Event Name"/></P>';
			echo '<P><INPUT type="text" name="edatetime" value="" placeholder="Date and Time"/></P>';
			echo '<P><INPUT type="text" name="description" value="" placeholder="Description"/><P>';
			echo '<P><INPUT type="text" name="location" value ="" placeholder="Location"/><P>';
		    echo '<P><INPUT type="text" name="is_public_e" value ="" placeholder="1 - Public or 0 - Private"/><P>';
			echo '<P><INPUT type="text" name="sponsored_by" value =""placeholder="Sponsorship (Input clubid)"/><P>' ;
			echo '<P class="submit"><INPUT type="submit" name="submission" value="Submit"/></P>';	
			echo '<br /><a href="menu.php">Main Menu</a>';
		    echo '</FORM>';
			echo '<FOOTER>';
		}
		else{
			echo "<H1>Error!!  You are not admin. You cannot post.</H1>";
			echo '<br/><br/>	';
			echo "You will be returned to the menu page in 3 seconds \n";
			header("refresh: 3; menu.php");
			echo ' <br/><br /><a href="menu.php">Main Menu</a>';
		}
	

  //if the user have entered an event, insert it into database
	if(isset($_POST["ename"])&& isset($_POST["edatetime"]) &&isset($_POST["description"])&&$_POST["location"]&&$_POST["is_public_e"]&&$_POST["sponsored_by"]) 
{

    //insert into database
    if ($stmt = $mysqli->prepare("insert into event (ename, description, edatetime,  location, is_public_e, sponsored_by) values (?,?,?,?,?,?)")) 
	{
      $stmt->bind_param("ssssii", $_POST["ename"], $_POST["description"], $_POST["edatetime"], $_POST["location"], $_POST["is_public_e"], $_POST["sponsored_by"]);
      $stmt->execute();
	  $stmt->close();
	  echo "Your event is posted. \n";
	}
	
}
  

  
}

		}
		
		
$mysqli->close();
?>
			
	
			
			