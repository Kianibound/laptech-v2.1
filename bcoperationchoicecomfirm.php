<?php //bcoperationchoicecomfirm.php
include_once 'bcheader.php';

if (isset($_POST['operation_count']))
	$operation_count = ($_POST['operation_count']);
if (isset($_POST['batchno']))
	$batchno = ($_POST['batchno']);
if (isset($_POST['productcode']))
	$productcode = ($_POST['productcode']);
if (isset($_POST['description']))
	$description = ($_POST['description']);
if (isset($_POST['qtystart']))
	$qtystart = ($_POST['qtystart']);
if (isset($_POST['qtyreq']))
	$qtyreq = ($_POST['qtyreq']);
if (isset($_POST['identifier']))
	$identifier = ($_POST['identifier']);
if (!isset($_POST['identifier']))
	$identifier = 0;
if (isset($_POST['Link']))
	$Link = ($_POST['Link']);
if (isset($_POST['Eng']))
	$Eng = ($_POST['Eng']);
else
    $Eng = 0;
if (isset($_POST['Build_type']))
			$Build_type = ($_POST['Build_type']);
else $Build_type = "";
    echo $Eng;
echo $Link;
echo $identifier;

if ($identifier == 1 && $identifier != 0 && $Build_type != 'FULL')
	{
		
	
		$order_query = queryMysql
    	("select * from bcproductoperations where Build_type = '$Build_type' and Product_code = '$productcode'");

        $order_num = mysqli_num_rows($order_query);

        For ($ki = 0; $ki < $order_num; ++$ki)
            {
                $position2 = mysqli_fetch_row($order_query);
            }

		unset ($position2[0]);
		unset ($position2[1]);
                unset ($position2[2]);
		$position = array_values($position2);
		echo $position[1];

	}  
else if ($Build_type == 'FULL')
{   
    //echo 'full build thing hit';
    $operation_count = 80; 
    for ($i = 0; $i < $operation_count; ++$i)
    	{
        	$position[$i] = $i+1;
       		//echo $position[$i];
    	}
}
else
	{    
		for ($i = 0; $i < $operation_count; ++$i)
    	{
        	if (isset($_POST["position($i)"]))
        	   { $position[$i] = ($_POST["position($i)"]);}
       		echo $position[$i];
    	}
	}
$result = queryMysql($mysqli, "select * from bcoperations");
$num = mysqli_num_rows($result);

For ($i = 0; $i < $num; ++$i)
    {
        $row = mysqli_fetch_row($result);
    }


        echo"<h3>please ensure this information is correct and enter a name for this build type</h3>";
        echo"<FORM METHOD='POST' ACTION='bcoperationchoice2.php'>
        <table class = floatleft border='1'>
        <tr>
        <th>Operation #</th>
        <th>Description</th>
        <!--<th>Included in batch?</th>-->
        <th>Position (leave blank if not included)</th>
        </tr>";
        
        
For ($i = 0; $i < $num; ++$i)
    {
        $operation = $i + 1;
        echo" <tr><td>$operation</td>";
        $operation_details = queryMysql($mysqli, "select operation from bcoperations where OpNo = $operation");
        $num2 = mysqli_num_rows($operation_details);

        For ($ki = 0; $ki < $num2; ++$ki)
            {
                $row2 = mysqli_fetch_row($operation_details);
            }
        echo "<td>$row2[0]</td>";
        
 //       echo "<td><input type='checkbox' name='operation' value='$operation'/></td>";

        echo "<td><input type='text' name='position($i)' value = '".$position[$i]."'></td></tr>";
        
    }      
    echo"</table>";

	{
		echo"
    	<h2> Please enter a name for this build type</h2>
    	<input type = 'text' name='build_type' value ='$Build_type'/>
    	<input type = 'hidden' name = operation_count value = '$operation'>
    	<input type='hidden' name='batchno' value='$batchno' />
    	<input type='hidden' name='productcode' value='$productcode' />
    	<input type='hidden' name='description' value='$description' />
    	<input type='hidden' name='qtystart' value='$qtystart' />
    	<input type='hidden' name='qtyreq' value='$qtyreq' />
	<input type='hidden' name='Link' value='$Link' />
        <input type='hidden' name='Eng' value='$Eng' />";
		echo "<p><input type ='submit' value = 'submit' name='submit'></p>"; 
		echo "</form>";
	}

?>
