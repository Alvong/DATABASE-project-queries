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

			$user =   $_SESSION['pid'] ;
			$stmt = $mysqli->prepare("DELETE  FROM person WHERE pid = ? ");
			$stmt->bind_param("s", $user);
			$stmt->execute();
			printf("%s  is deleted.", $user);
		   $stmt->close();
		   session_destroy();
		   echo "<H1>Your account has been deleted. You will be redirected in 1 second</H1>";
		   header("refresh: 1; login.php");

	
$mysqli->close();
	?>
			
