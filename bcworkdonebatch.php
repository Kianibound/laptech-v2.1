<?php // bcworkdone.php
include_once 'bcheader.php';
//include_once 'bcfeedbackheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

  
if (isset($_POST["work_done_date"]))
{
    $req_date = ($_POST["work_done_date"]);
}
else if (isset($_GET["work_done_date"]))
{
    $req_date = ($_GET["work_done_date"]);
}
else 
{
    $req_date = date('Y-m-d');
}

if (isset($_POST["batch"]))
{
    $batchno = ($_POST["batch"]);
}
else if (isset($_GET["batch"]))
{
    $batchno = ($_GET["batch"]);
}
else 
{
    $batchno = '%';
}
$batchno = $_SESSION['batch'];

if (isset($_GET['Arrange']))
    {$Arrange = ($_GET["Arrange"]);}
else $Arrange = 'staffnumber';        

if (isset($_GET['Search']))
    {$Search = ($_GET["Search"]);}
else if (isset($_POST["Search"]))
    {$Search = ($_POST["Search"]);}
else $Search = '';
$stamp = strtotime($req_date);
//echo $Arrange;
//echo $Search;
//list of work done broken down by operator for a date
/*echo "<br />
<table class = floatleft border='4' cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
                        <th colspan='2' align='center'>Search Workdone</th>
                        <form method='post' action='bcworkdone.php??'
                                onSubmit='return validate(this)'>
                        </tr><tr><td>Enter date required</td><td>";rfxlinecalendar2('work_done_date',$stamp);echo"
                        </td>
                        </tr><tr><td>Enter something to search for (if required)</td><td><input type='text' maxlength='50'name='Search' /></td>
                        <input type ='hidden' name = 'Arrange' value = '$Arrange' />
                        </tr><tr><td colspan='2' align='center'>
                        <input type='submit' value='Go' /></td>
                        </tr></form></table>";

*/
echo "<h3>Batch Selected <a href='bcbatchinfo.php?view=$batchno'>$batchno</a></h3>";
 $result4 = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno = '$batchno' ORDER BY batchno");
    $num4 = mysqli_num_rows($result4);
    echo"    <table border='1'>
         <tr>
         <th>Batch #</th>
         <th>Product Code</th>
         <th>Description</th>
         <th>Start Qty</th>
         <th>Qty Added</th>
         <th>Qty Expected</th>
         <th>Start Date</th>
         <th>End Date</th>
         <th>Status</th>
         <th>Build Type</th>
	 <th>Documentation</th>	
         </tr>";

	// outputs the batch information

    for ($j = 0; $j < $num4; ++$j)
    {
        $row4 = mysqli_fetch_row($result4);
        echo "<tr>
            <td><a href='bcbatchinfo.php?view=$row4[0]'>$row4[0]</a></td>
            <td>$row4[1]</td>
            <td>$row4[2]</td>
            <td>$row4[3]</td>
            <td>$row4[4]</td>
            
            <td>$row4[5]</td>
            <td>$row4[6]</td>
            <td>$row4[7]</td>";
            switch ($row4[8])
            {
                case 0:
                    echo "<td>Unstarted</td>";    
                Break;
                case 1:
                    echo "<td>Started</td>";    
                Break;
                case 2:
                    echo "<td>Closed</td>";    
                Break;
            }
            echo"<td>$row4[9]</td>
	    	 <td><a href='$row4[10]',target='_blank'>Link</a></td></tr>";
        $Product_code = $row4[1];
        $Build_Type = $row4[9];
        $qtyToBuild = $row4[3];
        $qtyexpected = $row4[5];
        //echo $qtyexpected;
        $qtyadd = $row4[4];
        $status = $row4[8];
    }
    echo" </table>";
$now = date('c');
$startstamp = $now;
$end_stamp = 0;
//$startstamp = new DateTime($now);
$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE batchno = '$batchno' AND (operation LIKE '%$Search%'
            OR staffnumber LIKE '%$Search%' OR quantitycomplete LIKE '%$Search%' OR end LIKE '%$Search%' or Comments LIKE '%$Search%') ORDER BY $Arrange");
//$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) = '$req_date' ORDER BY '$Arrange'");
$num = mysqli_num_rows($result);

echo"   <table class = tablefloatleft border='4'cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'><tr>
                        <th colspan='4' align='center'>Operations carried out on ".$batchno."</th></tr>
                    <tr>
                    <th><a href='bcworkdonebatch.php?Arrange=staffnumber&batch=".$batchno."'>Username</a></th>
                    <th><a href='bcworkdonebatch.php?Arrange=batchno&batch=".$batchno."'>Batch Number</a></th>
                    <th><a href='bcworkdonebatch.php?Arrange=operation&batch=".$batchno."'>Operation</a></th>
                    <th><a href='bcworkdonebatch.php?Arrange=operation&batch=".$batchno."'>OpName</a></th>
                    <th><a href='bcworkdonebatch.php?Arrange=quantitycomplete&batch=".$batchno."'>Quantity Completed</a></th>
                    <th><a href='bcworkdonebatch.php?Arrange=scrap&batch=".$batchno."'># Scrapped</a></th>
                    <th><a href='bcworkdonebatch.php?Arrange=start&batch=".$batchno."'>start date/time</a></th>
                    <th><a href='bcworkdonebatch.php?Arrange=end&batch=".$batchno."'>end date/time</a></th>
                    <th>Time Taken</th>
                    <th><a href='bcworkdonebatch.php?Arrange=Comments&batch=".$batchno."'>Comments</a></th>
                    </tr>";
            for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $username = username($mysqli, $row[2]);
                if ($row[1] != 'NULL')
                {
                    $OpName = OpNotoOpName($row[1]);
                }
                else
                {
                    $OpName = 'Not a batch operation';
                }
                $datetime1 = new DateTime($row[7]);
                if ($row[7] < $startstamp)
                {
                    $startstamp = $row[7];
                }
                $datetime2 = new DateTime($row[8]);
                if ($row[8] > $end_stamp)
                {
                    $end_stamp = $row[8];
                }
                if ($row[8] == NULL)
                {
                    $now = date('c');
                    $datetime2 = new DateTime($now);
                    $end_stamp = $now;
                }
                $interval = $datetime1->diff($datetime2);
                                                
                if($ki%2 == 1)
            {
                $background = '#E0FFEF';
            }
            else
            {
                $background = 'WHITE';
            }                                        
            echo"   <tr bgcolor=$background>  
                    <td> ".$username." </td>
                    <td><a href='bcbatchinfo.php?view=$row[0]'> ".$row[0]."</td>
                    <td> ".$row[1]."</td>
                    <td> ".$OpName."</td>
                    <td> ".$row[5]."</td>
                    <td> ".$row[6]."</td>
                    <td> ".$row[7]."</td>
                    <td> ".$row[8]."</td>
                    <td> ".$interval->format('%D.%h.%i.%s')."</td>
                    <td> ".$row[11]."</td>
                    </tr>";
            }
            echo "</table>";
//Add Gantt chart to page
//using coding hint from www.jlion.com/docs/gantt.aspx

//get operations for batch

$gant_time = diff_sec_convert($startstamp, $end_stamp);
echo '
<table bgcolor="white" style="width: 100%;">
<tr>
	<td colspan="7">
		GANT chart
	</td>
</tr>
<tr>
	<td style="width: 15%; vertical-align: bottom;">description</td>
	<td style="width: 5%; vertical-align: bottom;">Begin Date/time</td>
	<td style="width: 3%; vertical-align: bottom;">iduration (M.D.H.M.S)</td>
	<td style="width: 77%; vertical-align: bottom;">
		<table style="width: 100%;">
		<tr>
			<td colspan="2" style="text-align: center; width:100%;">GANT Indicator</td>
		</tr>
		<tr>
			<td style="text-align: left; width: 50%;">'.$startstamp.'</td>
			<td style="text-align: right;width: 50%;">'.$end_stamp.'</td>
		</tr>
		</table>
	</td>
</tr>
';

$sql = $mysqli->query("SELECT * FROM `bcproductoperations` WHERE `Product_code` = '$Product_code'
    AND `Build_type` = '$Build_Type'");


while($row=mysqli_fetch_array($sql))
{
    $num = count($row,1)/2;
    //echo $num;
    for ($i = 2; $i < $num; ++$i)
    {
        //$i  = global operation
        $op = $i - 1;
        $ops = $mysqli->query("SELECT 'operation_".$op."' FROM `bcproductoperations` WHERE `Product_code` = '$Product_code'
            AND `Build_type` = '$Build_Type'");
        //$ops = $mysqli->query("SELECT 'operation".$op."' FROM `bcproductoperations` WHERE `Product_code` = '$productcode'
        //    AND `Build_type` = '$build_type'");
        while($row_ops=mysqli_fetch_array($ops))
        {
            $num_ops = count($row_ops,1);
            $thisop = $row_ops[0]-1;
            for ($j = 2; $j < $num; ++$j)
            {
                $once = 0;
                if ($row[$j] != '0' && $row[$j] == $op)
                {
                    $thisop = $j-1;
                    $op1 = $op-1;
                    //$op is the local op 
                    //$thisop is the global op
                    $ops = $mysqli->query("SELECT * FROM `bcoperations` WHERE `OpNo` = '$thisop'");
                    while($row_ops=mysqli_fetch_array($ops))
                    {
                        //echo ' Local Op'.$op.' Global op '.$thisop.' '.$row_ops[1].''; 
                        // we now have the operations in local order at this point get the first start ime and the last stop time or now if a null iss present
                        //$first = mysql_query ("SELECT * FROM `bcoperationsdone` WHERE `batchno` = 'AA1222/4' AND `operation` = '9'");//asc limit 1
                        $first = $mysqli->query("SELECT * FROM `bcoperationsdone` WHERE `batchno` = '$batchno' AND `operation` = '$thisop' ORDER BY 'start'");
                        $num_first = mysqli_num_rows($first);
                        //echo $num_first;
                        $qty_complete = 0;
                        $op_start = $now;
                        for ($k = 0; $k < $num_first; ++$k)
                        {
                            
                            $row_first = mysqli_fetch_row($first);
                            if ($op_start > $row_first[7])
                            {
                                $op_start = $row_first[7];
                            }
                        }
                        //echo "$thisop started at ".$op_start."";
                        $offset = diff_sec_convert($startstamp, $op_start);
                        $last = $mysqli->query("SELECT * FROM `bcoperationsdone` WHERE `batchno` = '$batchno' AND `operation` = '$thisop' ORDER BY 'end'");
                        $num_last = mysqli_num_rows($last);
                        //echo $num_first;
                        $op_end = $op_start;
                        for ($k = 0; $k < $num_last; ++$k)
                        {
                            
                            $row_last = mysqli_fetch_row($last);
                            $qty_complete = $qty_complete + $row_last[5];
                            //echo $row_last[5];
                            //echo '%%';
                            if ($op_end < $row_last[8])
                            {
                                $op_end = $row_last[8];
                            }
                        }
                        //echo " ended at ".$op_end."";
                        $isnull = $mysqli->query("SELECT * FROM `bcoperationsdone` WHERE `batchno` = '$batchno' AND `operation` = '$thisop' AND `end` IS NULL");
                        $num_isnull = mysqli_num_rows($isnull);
                        if ($num_isnull != 0)
                        {
                            $op_end = $now;
                        }
                        $duration = diff_sec_convert($op_start,$op_end);
                        //echo ' duration = '.$duration.'';
                        $per_offset = ($offset/$gant_time) * 100;
                        $per_duration = ($duration/$gant_time) * 100;
                        if ($per_offset > 100)
                        {
                            $per_offset = 100;
                        }
                        if ($per_offset + $per_duration > 100)
                        {
                            $per_duration = $per_duration - (($per_offset + $per_duration)-100);
                        }
                        $balance = 0;
                        if ($qtyexpected > $qty_complete)
                        {
                            $balance = 100 - $per_offset + $per_duration;
                        }
                        if ($per_offset + $per_duration + $balance > 100)
                        {
                            $balance = $balance - (($per_offset + $per_duration + $balance)-100);
                        }
                        $datetime2 = new DateTime($op_end);
                        $datetime1 = new DateTime($op_start);
                        $time_duration = $datetime1->diff($datetime2);
                        echo '
                        <tr>
                        <td>Local Op'.$op.' Global op '.$thisop.' '.$row_ops[1].'</td>
                        <td>'.$row_first[7].'</td>
                        <td>'.$time_duration->format("%m.%D.%h.%i.%s").'</td>
                        <td style="border: solid 1px grey;">
                        <img src="images/shim.gif" height="15px;" width="'.$per_offset.'%;"><img src="images/busy.gif" height="15px;" width="'.$per_duration.'%;"><img src="images/blue-line.gif" height="15px;" width="'.$balance.'%;">
                        </td>
                        </tr>';
                    }
                    //echo "<option value='.$op.'>$op,$row[$j],$j</option>";
                }
                
            } 
            
        }
        
    }

}
 
   

//for each operation find the first start time and the last finish time (or now if null)
//first start time for the first op will be the baseline

//the last finish time - the base line time will give 100% spread

//work out the delta from baseline for each operation and convert to a % of the spread
//work out the time taken for each opeation and convert to a % of the spread

//build chart/table and populate it 




                        
            



?>