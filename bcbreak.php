<?php
include_once 'bcheader.php';

echo "hello world";

if (!isset($_SESSION['user']))
	die("<br /><br />You must be logged in to view this page");
$user = $_SESSION['user'];
$Staffno = Staff_no($mysqli, $user);

if (isset($_POST['comment']))
	$comment = ($_POST['comment']);

$now = date('c');

echo $now;

$end = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE staffnumber = '$Staffno' AND start IS NOT NULL AND end IS NULL");

$num = mysqli_num_rows($end);

if($num > 0)
{
	for ($i = 0; $i < $num; ++$i)
	{
		$to_end = mysqli_fetch_row($end);
                echo 'old comment = '.$to_end[11].'';
                $comment = $to_end[11] .' '. $comment;
                echo 'new comment = '.$comment.'';
		queryMysql($mysqli, "UPDATE bcoperationsdone SET end = '$now', Comments = '$comment' WHERE staffnumber = '$Staffno' AND start IS NOT NULL AND end IS NULL");
		queryMysql($mysqli, "UPDATE bcpeople SET break = '$now' WHERE staffno = '$Staffno'");
		echo "ending '$to_end[0]' operation '$to_end[1]'";
	}
}

if($num==NULL)
{

$query = queryMysql($mysqli, "SELECT * FROM bcpeople WHERE staffno = '$Staffno'");
$num2 = mysqli_num_rows($query);
	
	for ($j = 0; $j < $num2; ++$j)
	{
		$break = mysqli_fetch_row($query);
		
	}

$break_time = $break[5];

$start = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE staffnumber = '$Staffno' AND start IS NOT NULL AND end = '$break_time'");
$num3 = mysqli_num_rows($start);
	
	for ($k = 0; $k < $num3; ++$k)
	{
		$to_start = mysqli_fetch_row($start);
		
	//}
	$batchno   = $to_start[0];
	$operation = $to_start[1];
        $comment   = $to_start[11];



	//for ($l = 0; $l < $num3; ++$l)
	//{
		echo "starting '$batchno' operation '$operation'";
		queryMysql($mysqli, "INSERT INTO bcoperationsdone VALUES('$batchno','$operation','$Staffno',NULL,NULL,NULL,NULL,'$now',NULL,NULL,NULL,'$comment')");
		queryMysql($mysqli, "UPDATE bcpeople SET break = NULL where staffno = '$Staffno'");
	}
	


}
echo'
                        <script language="javascript">
                        location.replace("bcbatches.php");
                        </script>';
echo "<a href = 'bcbatches.php'> Go back </a>";

?>
