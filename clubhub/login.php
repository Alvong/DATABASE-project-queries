
<!DOCTYPE html>



<HTML lang="en">

<HEAD>

	<META charset="utf-8"/>
	<TITLE>Login Page</TITLE>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</HEAD>

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


<BODY><?php
    
    include ("connect_db.php");
	/* Check if the user is already logged in. */
	if(isset($_SESSION["pid"])  && ($SESSION["REMOTE_ADDR"] == $SERVER["REMOTE_ADDR"]))
    {
		echo '<META http-equiv="refresh" content="3; url=login.php"/>';
		echo 'You are already logged in.';
		echo '<BR/>You will be redirected in 3 seconds or click <a href="menu.php">here</a>.<BR/>';
	}
	else
	{
		/* Check if the user inputted data into the two input fields. */
		if(isset($_POST["pid"]) && isset($_POST["passwd"]))
		{
			$pid=$_POST["pid"];
			$passwd=md5($_POST["passwd"]);
		
			if($stmt = $mysqli->prepare("select pid, fname, passwd from person where pid = ? and passwd = ?"))
			{
				$stmt->bind_param("ss", $pid, $passwd);
				$stmt->execute();
				$stmt->bind_result($pid, $fname, $passwd);
				/* Login is a success. */
				if($stmt->fetch())
				{
					$_SESSION["pid"] = $pid;
					$_SESSION["fname"] = $fname;
                    $_SESSION["passwd"] = $passwd;
					$username = htmlspecialchars($fname);
					$_SESSION["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"];
                    
					echo '<META http-equiv="refresh" content="3; url=menu.php"/>';
                    echo "Hi $username";

					echo '<P>Login successful.</P>';
					echo '<BR/><P>You will be redirected in 3 seconds or click <A href="menu.php">here</A>.</P>';
				}
				/* Login is a failure. */
				else
				{
					sleep(1);
					echo '<P>Your ID or password is incorrect.</P>';
					echo '<P>Click <A href="login.php">here</A> to try again.</P>';
				}
				$stmt->close();
				$mysqli->close();
			}
		}
    
		else
		{
			echo '<H1>Login to ClubHub Application</H1>';
			echo '<FORM action="login.php" method="POST">';
			echo '<P><INPUT type="text" name="pid" value="" placeholder="ID"/></P>';
			echo '<P><INPUT type="password" name="passwd" value="" placeholder="Password"/></P>';
			echo '<P class="submit"><INPUT type="submit" name="submission" value="submit"/></P>';
		    echo '</FORM>';
			echo '<FOOTER>';
            echo '<a href="register.php">Register</a><br />';
			echo '<a href="public_info.php"><font color="black">Click here to view public info</font></a><br />';
		    echo '</BR>CS3083: Database Project';
		    echo '</BR>Sung Nho and Yuyong Dong' ;
			echo  '</BR>';
			
		
		    echo '</FOOTER>';
		}
    }
	
?></BODY>

</HTML>
