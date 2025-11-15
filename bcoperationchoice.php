<?php //bcoperationchoice.php
include_once 'bcheader.php';

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
if (isset($_POST['Eng']))
	$Eng = 1;
else 
    $Eng = 0;
//echo $Eng;
if (isset($_POST['Link']))
	$Link = ($_POST['Link']);
else $Link = "";
//echo $description;<input type = 'hidden' name = operation_count value = '$operation'>
//echo $Link;
$result = queryMysql($mysqli, "select * from bcoperations");
$num = mysqli_num_rows($result);

For ($i = 0; $i < $num; ++$i)
    {
        $row = mysqli_fetch_row($result);
    }
echo"<br /><br /><table class = 'floatleft' border='0' cellpadding='2'
      cellspacing='5' bgcolor='#eeeeee'>
<th colspan='2' align='center'>Pick an already used Build Type</th>
<FORM METHOD='POST' ACTION='bcoperationchoicecomfirm.php'>

<input type='hidden' name='batchno' value='$batchno' />
<input type='hidden' name='productcode' value='$productcode' />
<input type='hidden' name='description' value='$description' />
<input type='hidden' name='qtystart' value='$qtystart' />
<input type='hidden' name='qtyreq' value='$qtyreq' />
<input type='hidden' name='Link' value='$Link' />
<input type='hidden' name='Eng' value='$Eng' />
<input type='hidden' name='identifier' value='1' ";

$preset = queryMysql($mysqli, "select * From bcproductoperations where Product_code = '$productcode'");
$presetnum = mysqli_num_rows($preset);
echo "</tr><tr><td>Build Type</td><td><select name = Build_type>";
For ($i = 0; $i < $presetnum; ++$i)
	{
		$presetlist = mysqli_fetch_row($preset);
	//}


/*
for ($kj = 0; $kj < $presetnum; ++$kj)
	{*/
		echo '<option value="'.$presetlist[1].'">'.$presetlist[1].' '.$presetlist[2].'</option>';
	}
                    echo '<option value="FULL">FULL</option>';
                    echo"</select></td></tr>";

echo"<td><input type='submit' value='Go' /></td></form>";

        echo"<FORM METHOD='POST' ACTION='bcoperationchoicecomfirm.php'>
        <table border='1'>
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

        echo "<td><input type='text' name='position($i)'/></td></tr>";

    }      
    echo"<input type = 'hidden' name = operation_count value = '$operation'>
    <input type='hidden' name='batchno' value='$batchno' />
    <input type='hidden' name='productcode' value='$productcode' />
    <input type='hidden' name='description' value='$description' />
    <input type='hidden' name='qtystart' value='$qtystart' />
    <input type='hidden' name='qtyreq' value='$qtyreq' />
    <input type='hidden' name='Link' value='$Link' />
    <input type='hidden' name='Eng' value='$Eng' />
	<input type='hidden' name='identifier' value='0' />";
	echo "<tr><td><input type ='submit' value = 'submit' name='submit'></table>"; 
	echo "</form>";
	//echo $description;

?>
