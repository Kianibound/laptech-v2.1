<?php // bcworkdoneoperator.php
include_once 'bcheader.php';
include_once 'bcfeedbackheader.php';
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
    //$req_date = strtotime ( '-1 day' , strtotime ( $now ) ) ;
    //$req_date = date ( 'Y-m-j' , $req_date );
}

if (isset($_POST["work_done_date_2"]))
{
    $to_date = ($_POST["work_done_date_2"]);
}
else if (isset($_GET["work_done_date_2"]))
{
    $to_date = ($_GET["work_done_date_2"]);
}
else 
{
    $to_date = date('Y-m-d');
}

if (isset($_POST["view"]))
{
    $name = ($_POST["view"]);
}
else if (isset($_GET["view"]))
{
    $name = ($_GET["view"]);
}
else 
{
    $name = $user;
}

if (isset($_POST["batch"]))
{
    $batchno = ($_POST["batch"]);
    batch($batchno);
}
else if (isset($_GET["batch"]))
{
    $batchno = ($_GET["batch"]);
    batch($batchno);
}


if (isset($_GET['Arrange']))
    {$Arrange = ($_GET["Arrange"]);}
else $Arrange = 'staffnumber';        

$Staffno = Staff_no($mysqli, $name);

if (isset($_GET['Search']))
    {$Search = ($_GET["Search"]);}
else if (isset($_POST["Search"]))
    {$Search = ($_POST["Search"]);}
else $Search = "";
$stamp = strtotime($req_date);
$today = date('Y-m-d');
$start_time = new DateTime (date('Y-m-d'));
$end_time = new DateTime ($req_date);

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
echo "<h3>Operator report for <a href='bcmembers.php?view=$name'>$name (Staff Number $Staffno)</a></h3>";

$stamp = strtotime($req_date);
$to_stamp = strtotime($to_date);
$stamp1 = new DateTime($req_date);//strtotime($req_date);
//echo $stamp1->format('m.d.h.i.s');
$to_stamp1 = new DateTime($to_date);//strtotime($to_date);
//echo $to_stamp1->format('m.d.h.i.s');
$interval = $to_stamp1->diff($stamp1);
if ($interval->format('%m') == 2)
{
    $gant_time = $interval->format('%m') * 28 * 8 * 60 * 60;
}
else if ($interval->format('%m') == 4 || 6 || 9 || 11)
{
    $gant_time = $interval->format('%m') * 30 * 8 * 60 * 60;
}
else 
{
    $gant_time = $interval->format('%m') * 31 * 8 * 60 * 60;
}
$gant_time = $gant_time + $interval->format('%d') * 8 * 60 * 60;
$gant_time = $gant_time + (($interval->format('%h')+8) * 60 * 60);
$gant_time = $gant_time + $interval->format('%i') * 60;
$gant_time = $gant_time + $interval->format('%s');
//echo $interval->format('%m.%d.%h.%i.%s');
//echo $gant_time;
//list of work done broken down by operator for a date
echo "<br />
<table class = floatleft border='4' cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
                        <th colspan='2' align='center'>Search Workdone</th>
                        <form method='post' action='bcworkdoneoperator.php?Arrange=staffnumber&view=".$name."'
                                onSubmit='return validate(this)'>
                        </tr><tr><td>Enter earliest date required</td><td>";rfxlinecalendar2('work_done_date',$stamp);echo"
                        </td>
                        </tr><tr><td>Enter latest date required</td><td>";rfxlinecalendar2('work_done_date_2',$to_stamp);echo"
                        </td>
                        </tr><tr><td>Enter something to search for (if required)</td><td><input type='text' maxlength='50'name='Search' /></td>
                        <input type ='hidden' name = 'Arrange' value = '$Arrange' />
                        </tr><tr><td colspan='2' align='center'>
                        <input type='submit' value='Go' /></td>
                        </tr></form></table>";

$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) BETWEEN '$req_date' AND '$to_date' AND staffnumber = '$Staffno' AND (batchno LIKE '%$Search%' OR operation LIKE '%$Search%'
            OR quantitycomplete LIKE '%$Search%' OR end LIKE '%$Search%' or Comments LIKE '%$Search%') ORDER BY $Arrange");
/* */
//$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) = '$req_date' ORDER BY '$Arrange'");
$num = mysqli_num_rows($result);
//echo $num; echo $today;

echo"   <table class = tablefloatleft border='4'cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'><tr>
                        <th colspan='4' align='center'>Search results for ".$req_date."</th></tr>
                    <tr>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=staffnumber&work_done_date=".$req_date."'>Username</th>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=batchno&work_done_date=".$req_date."'>Batch Number</th>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=operation&work_done_date=".$req_date."'>Operation</th>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=operation&work_done_date=".$req_date."'>OpName</th>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=quantitycomplete&work_done_date=".$req_date."'>Quantity Completed</th>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=scrap&work_done_date=".$req_date."'># Scrapped</th>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=start&work_done_date=".$req_date."'>start date/time</th>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=end&work_done_date=".$req_date."'>end date/time</th>
                    <th>Time Taken</th>
                    <th><a href='bcworkdoneoperator.php?view=".$name."&Arrange=Comments&work_done_date=".$req_date."'>Comments</th>
                    </tr>";
            $total = $int_time = $int_time_total = 0;
            $int_total = new DateTime;
            for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $username = $name;//username($mysqli, $row[2]);
                if ($row[1] != 'NULL')
                {
                    $OpName = OpNotoOpName($row[1]);
                }
                else
                {
                    $OpName = 'Not a batch operation';
                }
                $datetime1 = new DateTime($row[7]);
                //get earliswet entry
                if ($datetime1 < $start_time)
                {
                    $start_time = $datetime1;
                }
                $datetime2 = new DateTime($row[8]);
                if ($datetime2 > $end_time)
                {
                    $end_time = $datetime2;
                }
                if ($row[8] == NULL)
                {
                    $now = date('c');
                    $datetime2 = new DateTime($now);
                }
                //get latest entry
                $interval = $datetime1->diff($datetime2);
                $int_time = $interval->format('%d') * 24 * 60 * 60;
                $int_time = $int_time + ($interval->format('%h') * 60 * 60);
                $int_time = $int_time + $interval->format('%i') * 60;
                $int_time = $int_time + $interval->format('%s');
                $int_total ->add($interval);
                $int_time_total = $int_time_total + $int_time;
                                                
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
                    <td> ".$interval->format('%D.%h.%i.%s')." or ".$int_time."</td>
                    <td> ".$row[11]."</td>
                    </tr>";
             $total = $total + $row[5];
            }
            echo "</table>";
           //echo "total number of units completed = $total";
           //echo " total time taken = ".$int_total->format('d.h.i.s')." (Total in seconds ";
           $int_time_total = $int_time_total + $int_time;
           $time = $int_total->format('%d') * 24 * 60 * 60;
           $time = $time + ($int_total->format('%h') * 60 * 60);
           $time = $time + ($int_total->format('%i') * 60);
           $time = $time + $int_total->format('%s');
           //echo $time;
           //echo ") Seconds per completed unit = ".$time / $total."";
           echo" <table class = floatleft border='4'cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
           <tr><th colspan='3' align='center'>Search summary</th></tr>
           <tr>
           <th>Total Number of units completed</th>
           <th>Total Time taken</th>
           <th>seconds taken per unit</th>
           <th>Start Time</th>
           <th>End time</th>
           </tr>
           <tr>
           <td>$total</td>";
           if ($total == 0)
           {
               $total = 1;
           }
           echo"
           <td>".$int_total->format('d.h.i.s')." or ".$int_time_total."</td>
           <td>".$int_time_total/$total."</td>
           <td>".$start_time->format('h.i.s')." </td>
           <td>".$end_time->format('h.i.s')." </td>
           </tr>
           </table>";
           
//add a gantt chart here 
//difference between 2 search dates will make up 100% of the spread

$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) BETWEEN '$req_date' AND '$to_date' AND staffnumber = '$Staffno' AND (batchno LIKE '%$Search%' OR operation LIKE '%$Search%'
            OR quantitycomplete LIKE '%$Search%' OR end LIKE '%$Search%' or Comments LIKE '%$Search%') ORDER BY start");

echo"   <table bgcolor='white' style='width: 1150px;'>
<tr>
	<th colspan='7'>
		GANT chart
	</th>
</tr>
<tr>
	<td style='width: 200px; vertical-align: bottom;'>description</td>
	<td style='width: 150px; vertical-align: bottom;'>begintime</td>
	<td style='width: 100px; vertical-align: bottom;'>duration (seconds)</td>
	<td style='width: 200px; vertical-align: bottom;'>
		<table style='width: 700px;'>
		<tr>
			<td colspan='2' style='text-align: center; width:700px;'>GANT Indicator</td>
		</tr>
		<tr>
			<td style='text-align: left; width: 450px;'>$req_date</td>
			<td style='text-align: right;width: 450px;'>$to_date</td>
		</tr>
		</table>
	</td>
</tr>";
            $total = $int_time = $int_time_total = 0;
            $int_total = new DateTime;
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
                $datetime2 = new DateTime($row[8]);
                if ($row[8] == NULL)
                {
                    $now = date('c');
                    $datetime2 = new DateTime($now);
                }
                $interval = $datetime1->diff($datetime2);
                $int_time = $interval->format('%m') * 20 * 8 * 60 * 60;
                $int_time = $interval->format('%d') * 8 * 60 * 60;
                $int_time = $int_time + ($interval->format('%h') * 60 * 60);
                $int_time = $int_time + $interval->format('%i') * 60;
                $int_time = $int_time + $interval->format('%s');
                $int_total ->add($interval);
                $int_time_total = $int_time_total + $int_time;
                //$int_time is the duration in seconds
                //work out as a percentage of gant_time
                $per_gant = $int_time/$gant_time;
                //echo "$per_gant!!";
                //convert to a number of pixels
                
                //echo "$duration pix ";
                //work out offset
                $offset = $stamp1->diff($datetime1);
                if ($offset->format('%m') == 2)
                {
                    $off_time = $offset->format('%m') * 28 * 8 * 60 * 60;
                }
                else if ($offset->format('%m') == 4 || 6 || 9 || 11)
                {
                    $off_time = $offset->format('%m') * 30 * 8 * 60 * 60;
                }
                else 
                {
                    $off_time = $offset->format('%m') * 31 * 8 * 60 * 60;
                }
                $off_time = $off_time + $offset->format('%d') * 8 * 60 * 60;
                $off_time = $off_time + (($offset->format('%h')-7) * 60 * 60);
                $off_time = $off_time + $offset->format('%i') * 60;
                $off_time = $off_time + $offset->format('%s');
                //work out as a percentage of gant_time
                $off_gant = $off_time/$gant_time;
                //echo "$off_gant &&";
                //convert to a number of pixels
                if ($off_gant + $per_gant >= 1)
                {
                    $per_gant = $per_gant + (1 - ($off_gant + $per_gant));
                }
                $duration = 700 * $per_gant;
                $off_pix = 700 * $off_gant;
                //echo "$off_pix pix ";
                echo "                                             
                <tr>
                <td>$row[0] #$row[1] $OpName</td>
                <td>$row[7]</td>
                <td>$int_time</td>
	
                <td style='border: solid 1px grey;'>
                <img src='images/shim.gif' height='15px;' width='$off_pix px;'><img src='images/busy.gif' height='15px;' width='$duration px;'>
                </td>
                </tr>
                ";
                $total = $total + $row[5];
            }
           echo "</table>";
           

            
function batch($batchno)
{
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
            <td><a href='bcbatchinfo.php?view=$row4[0]'>$row4[0]</td>
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
                    echo "<td>Closed</td>;";    
                Break;
            }
            echo"<td>$row4[9]</td>
	    	 <td><a href='$row4[10]',target='_blank'>Link</a></td></tr>";
        $Product_code = $row4[1];
        $Build_Type = $row4[9];
        $qtyToBuild = $row4[3];
        $qtyadd = $row4[4];
        $status = $row4[8];
    }
    echo" </table>";
return;
}
                        
            



?>