<?php // bcheader.php
include 'bcfunctions.php';
session_start();

if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$loggedin = TRUE;
}
else $loggedin = FALSE;

echo "<title>$appname";
if ($loggedin) echo " ($user)";

echo "</title><font face='verdana' size='2'>";
echo "<h2><img class = rfximg src='laptechlogo.jpg' width='70' height='50'>$appname</h2></font>";
//echo "<h2><img class = rfximg src='rfx.png' width='70' height='50'>$appname</h2></font>";

if ($loggedin)
{
	echo "<b >$user</b>:

        
		 <a href='bcmembers.php?view=$user'>Home</a> |
		 <a href='bcmembers.php'>Users</a> |
                 <a href='bcbatches.php'>Batches</a> |
                 <a href='bcsalesview.php'>Sales</a> |
		 <a href='bcfriends.php'>Collegues</a> |
		 <a href='bcmessages.php'>Create</a> |
		 <a href='bcprofile.php'>Profile</a> |
                 <a href='bcstock.php'>Stock viewer</a> |
                 <a href='bcworkdone.php'>Feedback reports</a> |
		 <a href='bclogout.php'>Log out</a>";
                 
                 
}
else
{
	echo "<a href='index.php'>Home</a> |
		 <a href='bcsignup.php'>Sign up</a> |
		 <a href='bclogin.php'>Log in</a>
                 ";
}
?>
