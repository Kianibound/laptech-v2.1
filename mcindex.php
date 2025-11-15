<?php // index.php
include_once 'bcheader.php';
if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$loggedin = TRUE;
        echo "
        <head>
        <meta http-equiv='Refresh' content='5;bcmembers.php' />
        </head>

        <body>
        <h1>Sorry! you are already logged in!</h1>
        <h2>You should be: <a href='bcmembers.php'>bcmembers.php</a></h2>
        <p>You will be redirected to the new address in five seconds.</p>
        <p>If you see this message for more than 5 seconds, please click on the link above!</p>
        </body>
        ";
}
else $loggedin = FALSE;
echo "<h3>Home page</h3>
	  Welcome, please Sign up and/or Log in to join in.";
?>