<?php // bcworkdone.php
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
     $a_date = date('Y-m-d');
     /*$req_date = strtotime( $a_date, '-1 month')*/;
     $a_req_date = new DateTime($a_date);
     $a_req_date->sub(new DateInterval('P1M'));
     $req_date = $a_req_date->format ('Y-m-d');
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

if (isset($_GET['Arrange']))
    {$Arrange = ($_GET["Arrange"]);}
else $Arrange = 'staffnumber';        

if (isset($_GET['Search']))
    {$Search = ($_GET["Search"]);}
else if (isset($_POST["Search"]))
    {$Search = ($_POST["Search"]);}
else $Search = '';

if (isset($_GET['Op1']))
    {$Op1 = ($_GET["Op1"]);}
else if (isset($_POST["Op1"]))
    {$Op1 = ($_POST["Op1"]);}
else $Op1 = '47';
if (isset($_GET['Op2']))
    {$Op2 = ($_GET["Op2"]);}
else if (isset($_POST["Op2"]))
    {$Op2 = ($_POST["Op2"]);}
else $Op2 = '49';
if (isset($_GET['target']))
    {$target = ($_GET["target"]);}
else if (isset($_POST["target"]))
    {$target = ($_POST["target"]);}
else $target = 7;

$total_out = 0;
$Batch_total = 0;
$stamp = strtotime($req_date);
$to_stamp = strtotime($to_date);
//echo $Arrange;
//echo $Search;
//list of work done broken down by operator for a date
echo "<br />
<table class = floatleft border='4' cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
                        <th colspan='2' align='center'>Compare time taken between 2 Operations</th>
                        <form method='post' action='bccompareop2.php??'
                                onSubmit='return validate(this)'>
                        </tr><tr><td>Enter date required</td><td>";rfxlinecalendar2('work_done_date',$stamp);echo"
                        </td>
                        </tr><tr><td>Enter latest date required</td><td>";rfxlinecalendar2('work_done_date_2',$to_stamp);echo"
                        </tr><tr><td>Target</td><td><input type='int' name='target' value=$target> days</td>
                        </td>";
                       // </tr><tr><td>Enter something to search for (if required)</td><td><input type='text' maxlength='50'name='Search' /></td>";
                        //</tr><tr><td>Enter 1st operation number</td><td><input type='int' name='Op1' /></td>
             echo"           </tr><tr><td>1st Operation</td><td><select name = 'Op1'><option value=$Op1>$Op1 ".OpNotoOpName($Op1)." </option>";
$preset = queryMysql($mysqli, "select * From bcoperations");
$presetnum = mysqli_num_rows($preset);
For ($i = 0; $i < $presetnum; ++$i)
	{       
                $presetlist = mysqli_fetch_row($preset);
		if ($presetlist[0] == $Op1)
                {
                    $opname1 = $presetlist[1];
                }
                echo"   <option value=".$presetlist[0].">".$presetlist[0]." ".$presetlist[1]."</option>";
        }
                echo"   </select></td>
</tr><tr><td>2nd Operation</td><td><select name = 'Op2'><option value=$Op2>$Op2 ".OpNotoOpName($Op2)."</option>";
$preset = queryMysql($mysqli, "select * From bcoperations");
$presetnum = mysqli_num_rows($preset);
For ($i = 0; $i < $presetnum; ++$i)
	{
                $presetlist = mysqli_fetch_row($preset);
                if ($presetlist[0] == $Op2)
                {
                    $opname2 = $presetlist[1];
                }
                echo"   <option value=".$presetlist[0].">".$presetlist[0]." ".$presetlist[1]."</option>";
        }
                echo"   </select></td>";
                     //   </tr><tr><td>Enter 2nd operation number</td><td><input type='int' name='Op2' /></td>
                echo"        <input type ='hidden' name = 'Arrange' value = '$Arrange' />
                        </tr><tr><td colspan='2' align='center'>
                        <input type='submit' value='Go' /></td>
                        </tr></form></table>";


$result1 = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(end) BETWEEN '$req_date' AND '$to_date' AND operation ='$Op1' AND quantitycomplete != '0'ORDER BY $Arrange");
//$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) = '$req_date' ORDER BY '$Arrange'");
$num1 = mysqli_num_rows($result1);

//$result2 = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(end) BETWEEN '$req_date' AND '$to_date' AND operation ='$Op2' AND quantitycomplete != '0' ORDER BY $Arrange");
$result2 = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE quantitycomplete != '0' AND operation ='$Op2' ORDER BY $Arrange");
//$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) = '$req_date' ORDER BY '$Arrange'");
$num2 = mysqli_num_rows($result2);

echo"   <table class = tablefloatleft border='4'cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'><tr>
                        <th colspan='5' align='center'>Search results from ".$req_date." to ".$to_date."</th></tr>
                    <tr>
                    <th><a href='bccompareop2.php?Arrange=batchno&work_done_date=".$req_date."&Op1=".$Op1."&Op2=".$Op2."'>Batch Number</th>
                    ";
                    //<th><a href='bcwcompareop.php?Arrange=staffnumber&work_done_date=".$req_date."&Op1=".$Op1."&Op2=".$Op2."'>Operation 1</th>
                    //<th><a href='bcwcompareop.php?Arrange=staffnumber&work_done_date=".$req_date."&Op1=".$Op1."&Op2=".$Op2."'>Operation 2</th>
                    echo "
                    <th><a href='bccompareop2.php?Arrange=quantitycomplete&work_done_date=".$req_date."&Op1=".$Op1."&Op2=".$Op2."'>Quantity Completed</th>";
                    //<th><a href='bcwcompareop.php?Arrange=staffnumber&work_done_date=".$req_date."&Op1=".$Op1."&Op2=".$Op2."'># Scrapped</th>
                    echo "
                    <th><a href='bccompareop2.php?Arrange=DATE(end)&work_done_date=".$req_date."&Op1=".$Op1."&Op2=".$Op2."'>$Op1 ( $opname1 )end date/time</th>
                    <th>$Op2 ( $opname2 )end date/time</th>
                    <th>Time Taken (MM.DD.H.M.S)</th>";
                    //<th><a href='bccompareop.php?Arrange=staffnumber&work_done_date=".$req_date."&Op1=".$Op1."&Op2=".$Op2."'>Comments</th>
                    echo "</tr>";
            $total = $scraptotal = 0;
            $int_total = new DateTime;
            for ($ki = 0; $ki < $num1; ++$ki)
            {
                //$result2 = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(end) BETWEEN '$req_date' AND '$to_date' AND operation ='$Op2' AND quantitycomplete != '0'ORDER BY $Arrange");
                $result2 = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE quantitycomplete != '0' AND operation ='$Op2' ORDER BY $Arrange");
                //$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) = '$req_date' ORDER BY '$Arrange'");
                $num2 = mysqli_num_rows($result2);
                $row1 = mysqli_fetch_row($result1);
                $match = 0;
                for ($kx = 0; $kx < $num2; ++$kx)
                {
                    
                    $row2 = mysqli_fetch_row($result2);
                    if($row1[0] == $row2[0])
                    {
                        $match = 1;
                        if ($row2[8] == NULL)
                        {
                            $now = date('c');
                            $datetime2 = new DateTime($now);
                            //echo 'hahaha';
                        }
                        else
                        {
                            $datetime2 = new DateTime($row2[8]);
                            //echo "blah blah blah";
                        }
                    }                     
                    
                }
                if ($match != 1)
                {
                    $a_date = date('Y-m-d');
                    $datetime2 = new DateTime($a_date);
                    //echo "noooo";
                }
                $username = username($mysqli, $row1[2]);
                if ($row1[1] != 'NULL')
                {
                    $OpName = OpNotoOpName($row1[1]);
                    $Op2Name = OpNotoOpName($row2[1]);
                }
                else
                {
                    $OpName = 'Not a batch operation';
                }
                $datetime1 = new DateTime($row1[8]);
                
                $interval = $datetime1->diff($datetime2);
                $total = $total + $row1[5];
                $scraptotal = $scraptotal +$row1[6];
                $actual = $interval->format('%D');
                $month = $interval->format('%M');
            if ($actual > $target||$month != 0)
            {
                $background = 'salmon';
                $total_out += $row1[5];
                $Batch_total += 1;
            }
            else if($ki%2 == 1)
            {
                $background = '#E0FFEF';
            }
            else
            {
                $background = 'WHITE';
            }                                        
            echo"   <tr bgcolor=$background>
                    <td><a href='bcbatchinfo.php?view=$row1[0]'> ".$row1[0]."</td>";
                    //<td> ".$row1[1]." ".$OpName."</td>
                    //<td> ".$row2[1]." ".$Op2Name."</td>
                    echo "
                    <td> ".$row1[5]."</td>
                    ";//<td> ".$row1[6]."</td>
                    echo "<td> ".$datetime1->format('Y-m-d h.i.s')."</td>";
                if ($match == 1)
                {
                    echo"<td> ".$datetime2->format('Y-m-d h.i.s')."</td>";
                }
                else
                {
                    echo"<td> incomplete or not on batch </td>";
                }
                echo"
                    <td> ".$interval->format('%M.%D.%h.%i.%s')."</td>";
                    //<td> ".$row1[11]."</td>
                    echo "</tr>";
            }
            $per = round($total_out/$total*100,2);
            $batch_per = round($Batch_total/$num1*100,2);
            echo "<br />Percentage missing target = $per % <br /> 
            Total through operation $Op1 ( $opname1 ) = $total <br />
            Total missing target for completion of operation $Op2 ( $opname2 ) = $total_out<br /><br />
            Number of Batches = $num1 <br />
            Number of Batches missing target = $Batch_total<br />
            Percentage of Batches missing target = $batch_per %";

?>