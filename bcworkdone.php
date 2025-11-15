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
     $req_date= date('Y-m-d');
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
$stamp = strtotime($req_date);
$to_stamp = strtotime($to_date);
//echo $Arrange;
//echo $Search;
//list of work done broken down by operator for a date
echo "<br />
<table class = floatleft border='4' cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
                        <th colspan='2' align='center'>Search Workdone</th>
                        <form method='post' action='bcworkdone.php??'
                                onSubmit='return validate(this)'>
                        </tr><tr><td>Enter date required</td><td>";rfxlinecalendar2('work_done_date',$stamp);echo"
                        </td>
                        </tr><tr><td>Enter latest date required</td><td>";rfxlinecalendar2('work_done_date_2',$to_stamp);echo"
                        </td>
                        </tr><tr><td>Enter something to search for (if required)</td><td><input type='text' maxlength='50'name='Search' /></td>
                        <input type ='hidden' name = 'Arrange' value = '$Arrange' />
                        </tr><tr><td colspan='2' align='center'>
                        <input type='submit' value='Go' /></td>
                        </tr></form></table>";


$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) BETWEEN '$req_date' AND '$to_date' AND (batchno LIKE '%$Search%' OR operation LIKE '%$Search%'
            OR staffnumber LIKE '%$Search%' OR quantitycomplete LIKE '%$Search%' OR end LIKE '%$Search%' or Comments LIKE '%$Search%') ORDER BY $Arrange");
//$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE DATE(start) = '$req_date' ORDER BY '$Arrange'");
$num = mysqli_num_rows($result);

echo"   <table class = tablefloatleft border='4'cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'><tr>
                        <th colspan='4' align='center'>Search results for ".$req_date."</th></tr>
                    <tr>
                    <th><a href='bcworkdone.php?Arrange=staffnumber&work_done_date=".$req_date."'>Username</th>
                    <th><a href='bcworkdone.php?Arrange=batchno&work_done_date=".$req_date."'>Batch Number</th>
                    <th><a href='bcworkdone.php?Arrange=operation&work_done_date=".$req_date."'>Operation</th>
                    <th><a href='bcworkdone.php?Arrange=operation&work_done_date=".$req_date."'>OpName</th>
                    <th><a href='bcworkdone.php?Arrange=quantitycomplete&work_done_date=".$req_date."'>Quantity Completed</th>
                    <th><a href='bcworkdone.php?Arrange=scrap&work_done_date=".$req_date."'># Scrapped</th>
                    <th><a href='bcworkdone.php?Arrange=start&work_done_date=".$req_date."'>start date/time</th>
                    <th><a href='bcworkdone.php?Arrange=end&work_done_date=".$req_date."'>end date/time</th>
                    <th>Time Taken</th>
                    <th><a href='bcworkdone.php?Arrange=Comments&work_done_date=".$req_date."'>Comments</th>
                    </tr>";
            $total = $scraptotal = 0;
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
                $total = $total + $row[5];
                $scraptotal = $scraptotal +$row[6];
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
            
$result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE END IS NULL ORDER BY $Arrange");
$num = mysqli_num_rows($result);

echo" </table><table class = tablefloatleft border='4'cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'><tr>
                        <th colspan='4' align='center'>Open Operations</th></tr>
                    <tr>
                    <th><a href='bcworkdone.php?Arrange=staffnumber&work_done_date=".$req_date."'>Username</th>
                    <th><a href='bcworkdone.php?Arrange=batchno&work_done_date=".$req_date."'>Batch Number</th>
                    <th><a href='bcworkdone.php?Arrange=operation&work_done_date=".$req_date."'>Operation</th>
                    <th><a href='bcworkdone.php?Arrange=operation&work_done_date=".$req_date."'>OpName</th>
                    <th><a href='bcworkdone.php?Arrange=quantitycomplete&work_done_date=".$req_date."'>Quantity Completed</th>
                    <th><a href='bcworkdone.php?Arrange=scrap&work_done_date=".$req_date."'># Scrapped</th>
                    <th><a href='bcworkdone.php?Arrange=start&work_done_date=".$req_date."'>start date/time</th>
                    <th><a href='bcworkdone.php?Arrange=end&work_done_date=".$req_date."'>end date/time</th>
                    <th>Time Taken</th>
                    <th><a href='bcworkdone.php?Arrange=Comments&work_done_date=".$req_date."'>Comments</th>
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
                $datetime2 = new DateTime($row[8]);
                if ($row[8] == NULL)
                {
                    $now = date('c');
                    $datetime2 = new DateTime($now);
                }
                $interval = $datetime1->diff($datetime2);
                $int_total ->add($interval);
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
                    <td><a href='bcbatchinfo.php?view=$row[0]'>  ".$row[0]."</td>
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
            //echo "total number of units completed = $total";
           //echo " total time taken = ".$int_total->format('d.h.i.s')." (Total in seconds ";
           $time = $int_total->format('d') * 24 * 60 * 60;
           $time = $time + ($int_total->format('h') * 60 * 60);
           $time = $time + ($int_total->format('i') * 60);
           $time = $time + $int_total->format('s');
           //echo $time;
           //echo ") Seconds per completed unit = ".$time / $total."";
           echo" </table><table class = floatleft border='4'cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
           <tr><th colspan='3' align='center'>Search summary</th></tr>
           <tr>
           <th>Total Number of units completed at each operation</th>
           <th>Total Number of units scrapped</th>
           <th>Total Time taken</th>
           <th>seconds taken per unit per operation</th>
           </tr>
           <tr>
           <td>$total</td>
           <td>$scraptotal</td>
           <td>".$int_total->format('m.d.h.i.s')." $time</td>
           <td>".$time/($total+$scraptotal)."</td>
           </tr>
           </table>";            
            



?>