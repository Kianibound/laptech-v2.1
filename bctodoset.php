<?php //bctodoset.php

/*
 *
 *	This file takes the data entered in the bctodo assign task form and
 *	then enters it into the database before taking the user back to
 *	bctodoset.php.
 *
 */

include_once 'bcheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

if (isset($_POST['username']))
    {$Username = ($_POST["username"]);}
    
if (isset($_POST['batchno']))
    {$Batch = ($_POST["batchno"]);}
    
if (isset($_POST['OpNo']))
    {$OpNo = ($_POST["OpNo"]);}
    
if (isset($_POST["date"]))
    {$Due = ($_POST["date"]);}
    
if (isset($_POST["priority"]))
    {$Priority = ($_POST["priority"]);}
    
if (isset($_POST["units"]))
    {$Units = ($_POST["units"]);}
    
$now = date('c');

$OpNo += 1;

echo $Username;
echo "\r\n";
echo $Batch;
echo "\r\n";
echo $OpNo;
echo "\r\n";
echo $now;
echo "\r\n";  


queryMysql($mysqli, "insert into bctodo VALUES ('$Username', '$Batch', '$OpNo', '$Units', '$now', '$Due', '$Priority', NULL, NULL)");
    
    
echo "<a href='bcmembers.php'>Go back</a>";

?>