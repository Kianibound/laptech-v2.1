<?php
$mysql_hostname = "localhost";
//$mysql_user = "Sparky";
$mysql_user = "root";
$mysql_password = "stars";
$mysql_database = "publications";
// $bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password)
// or die("Opps some thing went wrong");
// mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");

$mysqli = new mysqli("localhost", "root", "maz", "laptech");
// For production, update values, comment the line above, and uncomment the line below
//$mysqli = new mysqli($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);