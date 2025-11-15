<?php // bclogout.php
include_once 'bcheader.php';
echo "<h3>Log out</h3>";

if (isset($_SESSION['user']))
{
	destroySession();
	echo "You have been logged out. Please
	<a href='index.php'>click here</a> to refresh the screen.";
        echo '<meta http-equiv="Refresh" content=".1;url= index.php" />';
}
else echo "You are not logged in";
?>
