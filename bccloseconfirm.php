<?php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];
$batchno = $_SESSION['batch'];
if (isset($_POST['close']))
	$batchno = ($_POST['close']);
//add code to check that the batch is fit to be closed 
//check that the quantity expected has been met at the final operation
//check that there is no stock left on batch and that all goods are complete, scrapped 
//or moved to stock/rework
//report suitable error messages if these conditions have not been met#
//get start quantity
$START = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno = '$batchno'");

$num_START = mysqli_num_rows($START);

if($num_START > 0)
{
	for ($i = 0; $i < $num_START; ++$i)
	{
            $row_START = mysqli_fetch_row($START);
            $start = $row_START[3] + $row_START[4];
            $productcode = $row_START[1];
            $build_type = $row_START[9];
        }
}
$stock_in = queryMysql($mysqli, "SELECT * FROM bcstocklog WHERE batchno = '$batchno' AND Direction = 'Out'");

$num_stock_in = mysqli_num_rows($stock_in);
$Moved_from_stock = 0;
if($num_stock_in > 0)
{
	for ($i = 0; $i < $num_stock_in; ++$i)
	{
            $row_stock_in = mysqli_fetch_row($stock_in);
            $Moved_from_stock = $Moved_from_stock + $row_stock_in[0];
        }
}

$stock_out = queryMysql($mysqli, "SELECT * FROM bcstocklog WHERE batchno = '$batchno' AND Direction = 'In'");

$num_stock_out = mysqli_num_rows($stock_out);
$Moved_to_stock = 0;
if($num_stock_out > 0)
{
	for ($i = 0; $i < $num_stock_out; ++$i)
	{
            $row_stock_out = mysqli_fetch_row($stock_out);
            $Moved_to_stock = $Moved_to_stock + $row_stock_out[0];
        }
}

$scrap = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE batchno = '$batchno' AND scrap IS NOT NULL AND scrap != '0'");

$num_scrap = mysqli_num_rows($scrap);
$Scrap_total = 0;
if($num_scrap > 0)
{
	for ($i = 0; $i < $num_scrap; ++$i)
	{
            $row_scrap = mysqli_fetch_row($scrap);
            $Scrap_total = $Scrap_total + $row_scrap[6];
        }
}
// find last global op required in the batch
$last = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE Product_code = '$productcode' AND Build_type = '$build_type'");

$num_last = mysqli_num_rows($last);
$last_op = 0;
if($num_last > 0)
{
	for ($i = 0; $i < $num_last; ++$i)
	{
            $row_last = mysqli_fetch_row($last);
            $num_global_ops = count($row_last);
            for ($j = 3; $j < $num_global_ops; ++$j)
                {
                    if ($row_last[$j] > $last_op)
                    {
                        $last_op = $row_last[$j];
                        $last_global_op = $j-2;
                    }
                }
        }
}

//Now we can find the number of units comnpleted at the last operation
$last = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE batchno = '$batchno' AND operation = '$last_global_op'");

$num_last = mysqli_num_rows($last);
$Completed_last_op = 0;
if($num_last > 0)
{
	for ($i = 0; $i < $num_last; ++$i)
	{
            $row_last = mysqli_fetch_row($last);
            $Completed_last_op = $Completed_last_op + $row_last[5];
        }
}

//find the number completed for that operation
If (($start + $Moved_from_stock) == ($Completed_last_op + $Scrap_total + $Moved_to_stock))
{
    echo <<<_END
    </br></br>

    <form name="close" action="bcbatchinfo.php?Close=1" method="post">
    <h3>Close this batch. Note all operations will be locked after this action.</h3>
    <input type="submit" name=value="close" />
    </form>

_END;
}
else if (($start + $Moved_from_stock) > ($Completed_last_op + $Scrap_total + $Moved_to_stock))
{
    echo <<<_END
    <br /><br />
    Batch Number = $batchno<br />
    Start Quantity = $start<br />
    Quantity moved on to the batch = $Moved_from_stock<br />
    <br />
    Quantity completed at the last operation = $Completed_last_op<br />
    Quantity scrapped on the batch = $Scrap_total<br />
    Quantity moved to stock/rework = $Moved_to_stock<br />
    <br />
    <h2>There are still items on the batch please return to the batch and finish the items, move them to stock or scrap them as appropriate</h2>
    <a href="bcbatchinfo.php?view=$batchno",target="_blank">Return to Batch</a>
                        
_END;
exit;
}
else
{
    echo <<<_END
    <br /><br />
    Batch Number = $batchno<br />
    Start Quantity = $start<br />
    Quantity moved on to the batch = $Moved_from_stock<br />
    <br />
    Quantity completed at the last operation = $Completed_last_op<br />
    Quantity scrapped on the batch = $Scrap_total<br />
    Quantity moved to stock/rework = $Moved_to_stock<br />
    <br />
    <h2>There are less items on the batch than required please go back and identify the cause if required contact the database administrator for assistance</h2>
_END;
}

?>