<!DOCTYPE html>

<html>
<title>Logout</title>

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
session_start();
session_destroy();
echo "You are logged out. You will be redirected in 1 seconds";
  header("refresh: 1; login.php");
?>

</html>