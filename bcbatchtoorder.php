<?php // bcmembers.php
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
    queryMysql($mysqli, "INSERT INTO bcsalestobatch VALUES('$Assigned_order',
				   '$Assigned_item', '$Batch',NULL)");
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
$assigned = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE batch = '$Batch' ORDER BY salesorder");
$numassigned = mysqli_num_rows($assigned);
echo $numassigned;
$total_assigned = 0;
echo 'Orders already assigned to this Batch <br />';
for ($ki = 0; $ki < $numassigned; ++$ki)
{
    $row = mysqli_fetch_row($assigned);
    //use assigned to call bcsalesorders and total the quantity assigned
    $order = $row[0];
    $item = $row[1];
    $previously_assigned_order_info = queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE salesorder = '$order'
        AND item = '$item' ORDER BY salesorder");
    $numpreviouslyassigned = mysqli_num_rows($previously_assigned_order_info);
    for ($i = 0; $i < $numpreviouslyassigned; ++$i)
    {
        $previouslyassignedrow = mysqli_fetch_row($previously_assigned_order_info);
        $total_assigned = $total_assigned + $previouslyassignedrow[2];
        //output information on previously assigned batches
        echo''.$order.' Item '.$item.' Quantity '.$previouslyassignedrow[2].'<br />';
    }
    
}
$available = $expected - $total_assigned;
echo 'units available from this batch = '.$available.'<br /><H4>Orders suitable for this batch </H4>';
//show orders that have the same product code and unassigned units 
$orderinfo = queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE productcode = '$product'
                ORDER BY salesorder"); // AND actualshipdate IS NULL
$num = mysqli_num_rows($orderinfo);
for ($ki = 0; $ki < $num; ++$ki)
{
    $row = mysqli_fetch_row($orderinfo);
    $alreadyused = '0';
    $assigned = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE batch = '$Batch' ORDER BY salesorder");
    $numassigned = mysqli_num_rows($assigned);
    for ($i = 0; $i < $numassigned; ++$i)
    {
        $assignedrow = mysqli_fetch_row($assigned);
        If ($row[0] == $assignedrow[0] && $row[1] == $assignedrow[1])
        {
            $alreadyused = '1';
        }
    }
    If ($available > '0')
    {
        If ($alreadyused == '0')
        {
            echo "$Batch
            ".$row[0]." item  ".$row[1]." quantity = ".$row[2]."
            <form name='Assign' method='post' action='bcbatchtoorder.php'>
            Assign this Sales order.
            <input type='submit' name = 'Assigned_order' value = ".$row[0].">
            <input type='hidden' name = 'Assigned_item' value = ".$row[1].">
            <input type='hidden' name = 'Assigned_qty' value = ".$row[2].">
            <input type='hidden' name = 'Assign' value = '$Batch'>
            </form>

            ";
        }
    }
    
}
if ($available <= '0')
    {
        echo 'No more orders may be assigned to this batch';
    }

?>