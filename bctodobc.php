<?php
include_once 'bcheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

$now = date('c');

$querystaffno = queryMysql($mysqli, "select staffno from bcpeople where username = '$user'");

$staffnumber = mysqli_fetch_row($querystaffno);
$staffno = $staffnumber[0];
    
if (isset($_POST['batch']))
    {$batch = ($_POST["batch"]);}
    
if (isset($_POST['operation']))
    {$operation = ($_POST["operation"]);}
    
if (isset($_POST['id']))    
    {$id = ($_POST['id']);}
    
//echo ($_POST['id']);    

$batchquery = queryMysql($mysqli, "select batchno, productcode, build_type, status from bcbatchinfo where `batchno` = '$batch'");
$batchinfo = mysqli_fetch_row($batchquery);


$operationquery = queryMysql($mysqli, "select * from bcproductoperations where Product_code = '$batchinfo[1]' and Build_type = '$batchinfo[2]'");
$operationarray = mysqli_fetch_row($operationquery);
	
$globalop = 0;


$operationnum = mysqli_num_rows($operationquery);
$operationfields = mysql_num_fields($operationquery);

for ($j = 0; $j < $operationfields; $j++)
{
	
	if ($operationarray[$j] == $operation)
	{
		
		$globalop = $j - 1;
		
		
	}
	
}


if($id == 1)
{
	
	
	$opdonequery = queryMysql($mysqli, "select * from bcoperationsdone where batchno = '$batch' and operation = '$globalop' and staffnumber = '$staffno'");
	$querynum = mysqli_num_rows($opdonequery);
	
	echo $querynum;
	
	if(mysqli_num_rows($opdonequery) == 0)
	{
		//decided the loop was unneeded as there should only ever be one result to these queries 
		
		
		if ($batchinfo[3] == 0)
		{
			queryMysql($mysqli, "UPDATE bcbatchinfo SET started = '$now', status = '1'
				WHERE batchno = '$batch' AND status = '0'");
		}  
		
		if($batchinfo[2] == "Full")
		{
			
			queryMysql($mysqli, "INSERT INTO bcoperationsdone VALUES('$batch','$operation',
				'$staffno',NULL,NULL,NULL,NULL,'$now',NULL,NULL,NULL,NULL)");
			
		}
		else
		{
			
			
			queryMysql($mysqli, "INSERT INTO bcoperationsdone VALUES('$batch','$globalop',
				'$staffno',NULL,NULL,NULL,NULL,'$now',NULL,NULL,NULL,NULL)");

				
			queryMysql($mysqli, "update bctodo set date_start = '$now' WHERE batchno = '$batch' and opno = '$operation' and username = '$user' ");
			
			
		}
		
		
		echo "Started operation $operation in batch $batch";
	}
	else
	{
		echo "you have already started this operation";
	}
}

if($id == 2)
{
	
	$opdonequery = queryMysql($mysqli, "select * from bcoperationsdone where batchno = '$batch' and operation = '$operation' and staffnumber = '$staffno' and end = NULL");
	$querynum = mysqli_num_rows($opdonequery);
	
	
	
	echo "Stopped operation $operation in batch $batch";
}

?>
