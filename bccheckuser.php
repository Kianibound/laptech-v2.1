<?php // bccheckuser.php
include_once 'bcfunctions.php';

if (isset($_POST['user']))
{
	$user = sanitizeString($mysqli, $_POST['user']);
	$query = "SELECT * FROM bcmembers WHERE user='$user'";

	if (mysqli_num_rows(queryMysql($mysqli, $query)))
		echo "<font color=red>&nbsp;&larr;
			 Sorry, already taken</font>";
	else echo "<font color=green>&nbsp;&larr;
			 Username available</font>";
}
?>
