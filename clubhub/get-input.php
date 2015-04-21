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
<?php

include "connect_db.php";

//perform SQL query
if(isset($_GET["clubid"])) {
    $input_topic = $_GET["clubid"];
    if ($stmt = $mysqli->prepare("SELECT cname, descr FROM club WHERE clubid=?")) {
        $stmt->bind_param("s", $input_topic);
        $stmt->execute();
        $stmt->bind_result($cname, $descr);

        // Printing results in HTML
        echo "<table border = '1'>\n";
        while ($stmt->fetch()) {
	        echo "<tr>";
            echo "<td>$cname</td><td>$descr</td>";
	        echo "</tr>\n";
        }
        echo "</table>\n";
        $stmt->close();
	$mysqli->close();
    }
}
else {
    echo "topic is not set\n";
}
?>
</html>
