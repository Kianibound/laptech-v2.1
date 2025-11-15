<?php // bcmembers.php
include_once 'bcheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You must be logged in to view this page");
$user = $_SESSION['user'];

$stat = 3;
if (isset($_GET['Show']))
{$stat = ($_GET["Show"]);}


if (isset($_GET['view']))
{
	$view = sanitizeString($mysqli, $_GET['view']);
	
	if ($view == $user) $name = "Your";
	else $name = "$view's";
	
	echo "<h3>$name Page</h3>";
	showProfile($mysqli, $view);
	echo "<a href='bcmessages.php?view=$view'>Create</a><br />";
	echo("<a href='bcfriends.php?view=$view'>$name Collegues</a><br />");
        //echo "<body>$name assigned jobs</body><br />";
        echo "<a href='bcworkdoneoperator.php?view=$view'>$name's workdone</a><br />";
}

if (isset($_GET['add']))
{
	$add = sanitizeString($mysqli, $_GET['add']);
	$query = "SELECT * FROM bcfriends WHERE user='$add'
			  AND friend='$user'";
	
	if (!mysqli_num_rows(queryMysql($mysqli, $query)))
	{
		$query = "INSERT INTO bcfriends VALUES ('$add', '$user')";
		queryMysql($mysqli, $query);
	}
}
elseif (isset($_GET['remove']))
{
	$remove = sanitizeString($mysqli, $_GET['remove']);
	$query = "DELETE FROM bcfriends WHERE user='$remove'
			  AND friend='$user'";
	queryMysql($mysqli, $query);
}

$result = queryMysql($mysqli, "SELECT user FROM bcmembers ORDER BY user");
$num = mysqli_num_rows($result);
echo "<h3>Other Users</h3><ul>";

for ($j = 0 ; $j < $num ; ++$j)
{
	$row = mysqli_fetch_row($result);
	if ($row[0] == $user) continue;
	
	echo "<li><a href='bcmembers.php?view=$row[0]'>$row[0]</a>";
	$query = "SELECT * FROM bcfriends WHERE user='$row[0]'
			  AND friend='$user'";
	$t1 = mysqli_num_rows(queryMysql($mysqli, $query));
	
	$query = "SELECT * FROM bcfriends WHERE user='$user'
			  AND friend='$row[0]'";
	$t2 = mysqli_num_rows(queryMysql($mysqli, $query));
	$follow = "follow";

	if (($t1 + $t2) > 1)
	{
		echo " &harr; is a mutual friend";
	}
	elseif ($t1)
	{
		echo " &larr; you are following";
	}
	elseif ($t2)
	{
		$follow = "recip";
		echo " &rarr; is following you";
	}
	
	if (!$t1)
	{
		echo " [<a href='bcmembers.php?add=".$row[0] . "'>$follow</a>]";
	}
	else
	{
		echo " [<a href='bcmembers.php?remove=".$row[0] . "'>drop</a>]";
	}
}




?>


