<?php

include_once 'bcheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

if (isset($_POST['threshhold']))
    {$threshhold = ($_POST["threshhold"]);}

print'
<form method="post" action="yield.php"
            onSubmit="return validate(this)">
            <input type="text" maxlength="32"
            name="threshhold">please enter percentage threshhold</input>
            <input type="submit" value="Start" />
            </form>';
print '<table class = tablefloatleft border="1">
	<tr><th>Product Code</th><th>Batch Number</th><th>Operation number</th>
	<th>Operation</th><th>Yield</th></tr>';
$product_code_query = queryMysql($mysqli, "SELECT DISTINCT `productcode` from bcbatchinfo");
$product_code_num = mysqli_num_rows($product_code_query);



if($threshhold != NULL)
{
for($i = 0; $i < $product_code_num; $i++)
{

	$product_code_row = mysqli_fetch_row($product_code_query);
	
	$product_code = $product_code_row[0];


	$operations_query = queryMysql($mysqli, "SELECT `OpNo` from bcoperations");
	$operations_num = mysqli_num_rows($operations_query);
	

	
	for($j = 0; $j < $operations_num; $j++)
	{
		$operation_row = mysqli_fetch_row($operations_query);
		$operation = $operation_row[0];



		$batchno_query = queryMysql($mysqli, "SELECT `batchno`, `qtystart` from `bcbatchinfo` where `productcode` = '$product_code'");
		$batchno_num = mysqli_num_rows($batchno_query);
		
		for($k = 0; $k < $batchno_num; $k++)
		{

			$batchno_row = mysqli_fetch_row($batchno_query);
			$batchno = $batchno_row[0];
			$quantity_start = $batchno_row[1];
			

		
		
			/*$stock_log_query = queryMysql($mysqli, "SELECT `quantity` FROM `bcstocklog`
								where `batchno` = '$batchno' AND `operation_number` = '$operation' AND `Direction` = 'Out'");
			$stock_log_num = mysqli_num_rows($stock_log_query);
		
			$From_Stock = 0;
		
			for($l = 0; $l < $stock_log_num; $l++)
			{
		
				$stock_log_row = mysqli_fetch_row($stock_log_query);
			
				$From_Stock = $stock_log_row[0] + $From_Stock;
		
			}*/
			
			$stock_in_query = queryMysql($mysqli, "SELECT `quantity` FROM `bcstocklog`
								where `batchno` = '$batchno' AND `operation_number` = '$operation' AND `Direction` = 'In'");
			$stock_in_num = mysqli_num_rows($stock_in_query);
						
			$into_stock = 0;
			
			for($l = 0; $l < $stock_in_num; $l++)
			{
		
				$stock_in_row = mysqli_fetch_row($stock_in_query);
			
				$into_stock = $stock_in_row[0] + $into_stock;
		
			}
		
			$operations_done_query = queryMysql($mysqli, "SELECT `quantitycomplete`, `scrap` from `bcoperationsdone` 
								where `batchno` = '$batchno' AND `operation` = '$operation' AND `end` IS NOT NULL");
		
			$operations_done_num = mysqli_num_rows($operations_done_query);
			
			$totalscrap = 0;
			
			$complete = 0;
			
			for($m = 0; $m < $operations_done_num; $m++)
			{

				$operations_done_row = mysqli_fetch_row($operations_done_query);
				
				$totalscrap = $operations_done_row[1] + $totalscrap;
				
				$complete = $operations_done_row[0] + $complete;
		
			}
			
			$Total_in_Batch = 0;
			$yield = 100;
			
			$Total_in_Batch = $complete + $into_stock + $totalscrap;
			/*if($i == 1)
			{
			//echo $Total_in_Batch;
			}*/
			If ($Total_in_Batch != 0) 
			{
				$yield = ($totalscrap / $Total_in_Batch) * 100 ;
				$yield = 100 - $yield  ;
			}
			
			$operation_name_query = queryMysql($mysqli, "SELECT `operation` FROM `bcoperations` WHERE `OpNo` = '$operation'");
			$operation_name_row = mysqli_fetch_row($operation_name_query);
			$operation_name = $operation_name_row[0];
			
			if($yield <= $threshhold)
			{
			print "<tr><td>".$product_code."</td>";
			print "<td>".$batchno."</td>";
			print "<td>".$operation."</td>";
			print "<td>".$operation_name."</td>";
			print "<td>".number_format($yield,2)." %"."</td></tr>";
			
			/*<td>".$into_stock."</td><td>".$totalscrap."</td><td>".$stock_in_row[0]."</td><td>".$quantity_start."</td></tr>";*/
			}

	
		}


	}
}
}

print "</table>";

?>