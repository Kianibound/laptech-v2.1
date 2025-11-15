<?php // bcbatchtoworksorder.php
include_once 'bcheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You must be logged in to view this page");
$user = $_SESSION['user'];
$Batch = $_SESSION['batch'];
echo '<H3><a href="bcbatchinfo.php?view='.$Batch.'">Batch to be assigned '.$Batch.'</a></H3>';
if (isset($_POST["Assign"]))
{
    $Batch = ($_POST["Assign"]);
    echo '<H3><a href="bcbatchinfo.php?view='.$Batch.'">Batch to be assigned '.$Batch.'</a></H3>';
}
if (isset($_POST["Assigned_order"]))
{
    $Assigned_order = ($_POST["Assigned_order"]);
}
else{$Assigned_order = '0';}
if (isset($_POST["Assigned_item"]))
{
    $Assigned_item = ($_POST["Assigned_item"]);
}
else{$Assigned_item = '0';}
if (isset($_POST["Assigned_qty"]))
{
    $Assigned_qty = ($_POST["Assigned_qty"]);
}
else{$Assigned_qty = '0';}
//assign a batch to an order
if ($Assigned_order != '0')
{
    queryMysql($mysqli, "INSERT INTO bcworksordertobatch VALUES('$Assigned_order','$Batch')");
}
//select a batch (posted from bcbatchinfo)
//get the product code from the bcbatchinfo table
$batchinfo = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno = '$Batch' ORDER BY batchno");
$num = mysqli_num_rows($batchinfo);
for ($ki = 0; $ki < $num; ++$ki)
{
    $row = mysqli_fetch_row($batchinfo);
    $product = $row[1];
    $expected = $row[5];
    echo '<h3> Product selected = '.$product.'</H3>';
}
//show number of units assigned for this batch to other assigned orders
$assigned = queryMysql($mysqli, "SELECT * FROM bcworksordertobatch WHERE batch = '$Batch' ORDER BY worksorder");
$numassigned = mysqli_num_rows($assigned);
echo $numassigned;
echo ' Works Orders already assigned to this Batch <br />';
for ($ki = 0; $ki < $numassigned; ++$ki)
{
    $row = mysqli_fetch_row($assigned);
    //use assigned to call bcsalesorders and total the quantity assigned
    $order = $row[0];
    $item = $row[1];
    //output information on previously assigned batches
    echo''.$order.' <br />';
    
}

echo '
<br />
<form name="Assign" method="post" action="bcbatchtoworksorder.php">
Assign this Works order.
<input type="text" name = "Assigned_order" value = Submit>
<input type="submit" name = "Assign" value = '.$Batch.'>
</form>

';

    



?>