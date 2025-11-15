<?php // bcstocktransfer.php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

// This is the page that will allow the user to set the location the item is heading for
// in stock and if needed enter a note about the item 


//$In_Stock = $OpNo = $Date_In = $Date_out = $Batchno = $Product_code = $Stock_ID = $Location = $Notes = $Stock = $From_Stock = $Date = $Product_code2 = $InitialOpNo = $Initialbatchno = "";

if (isset($_POST['batch']))
	{$batchno =($_POST['batch']);
        echo "batchno = ";
        echo $batchno;}
if (isset($_POST['Current_OpNo']))
	{$OpNo =($_POST['Current_OpNo']);
	echo "</br>OpNo ";
        echo $OpNo;}
if (isset($_POST['Into_Stock']))
	{$into_stock = ($_POST['Into_Stock']);
        echo "</br>into stock = $into_stock";}
/*if (isset($_POST['From_Stock']))
	{$From_Stock = ($_POST['From_Stock']);
        echo "</br>From stock = $From_Stock";}*/
if (isset($_POST['Location']))
	{$Location = ($_POST['Location']);
        echo "</br>location = $Location";}
if (isset($_POST['Description']))
	$Notes = ($_POST['Description']);
        echo "</br> Notes = $Notes";
if (isset($_POST['product_code']))
	$Product_code =($_POST['product_code']);
        echo "</br>Product code = $Product_code";
if (isset($_POST['Product_code2']))
	{$Product_code2 =($_POST['Product_code2']);
        echo "</br>product code 2 = $Product_code2";}
if (isset($_POST['Identifier']))
	{$Identifier =($_POST['Identifier']);
        echo "</br>Identifier = $Identifier";}
if (isset($_POST['InitialOpNo']))
	{$InitialOpNo =($_POST['InitialOpNo']);
	echo "</br> initial op no <<<<<<<";
        echo "initial op number = $InitialOpNo";}
if (isset($_POST['qty_available']))
	{$qty_available =($_POST['qty_available']);
        echo "</br>qty available = $qty_available";}
if (isset($_POST['this_name']))
	{$batchno =($_POST['this_name']);
        echo "</br>Batch number = $batchno";}
if (isset($_POST['Stock_ID']))
	{$Stock_ID =($_POST['Stock_ID']);
        echo "</br>stock id = $Stock_ID";}
        

$In_Stock = $qty_available;
$Date_In = date('c');
$Date_out = date('c');
$Date = date('c');

$status = queryMysql($mysqli, "update bcstock SET quantity = '$qty_available',description = '$Notes',location = '$Location',operation_number = '$OpNo',batchno = '$batchno',product_code = '$Product_code' , date_out = '$Date_out' WHERE Stock_ID = '$Stock_ID' ");
echo "</br>status = $status";
if ($status == 1)
{
    echo "</br>Sucess!";
}
else
{
  echo "An error has occured please go back and try again";   
}




echo "<br /><a href='bcstock.php?ID=$Stock_ID&Arrange=Stock_Id'>Return to Sales</a>";
exit;




echo <<<_END
</br></br>
<table class="Stock Transfer (to stock)" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Stock Transfer (To stock)</th>
<form method="post" action=""
	onSubmit="return validate(this)">
</tr><tr><td>Location</td><td><input type="text" maxlength="150"
	name="Location" /></td>
</tr><tr><td>Notes</td><td><input type="text" maxlength="16"
	name="Notes" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="Go" /></td>
</tr></form></table>

_END;

?>
