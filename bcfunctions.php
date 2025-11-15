<?php // bcfunctions.php
// we are going to do most of the manipulation work in here
// looking forward to it??
if (!isset($_SESSION)) session_start();
// include('calendar/calendar/classes/tc_calendar.php');
echo <<<_END
<!doctype html public "-//W3C//DTD HTML 4.1 Transitional//EN">
<html>
<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<link rel="stylesheet" type="text/css" href="bcrfxstyle.css">
<script type='text/javascript'src="calendar/calendar/calendar.js"></script>
<script src="http://yui.yahooapis.com/3.8.1/build/yui/yui-min.js"></script>

_END;
//<script type='text/javascript'src="yui/build/yui/yui.js"></script>
//$dbhost  = 'localhost';    // Unlikely to require changing
$dbhost  = '127.0.0.1';    // Unlikely to require changing
$dbname  = 'publications'; // Modify these...
//$dbuser  = 'root';     // ...variables according
$dbuser  = 'Sparky';     // ...variables according
$dbpass  = 'stars';     // ...to your installation
$appname = "Laptech Batch Control System"; // ...and preference
//$appname = "RFX Batch Control System"; // ...and preference


$mysqli = new mysqli("localhost", "root", "maz", "laptech");
// For production, update values, comment the line above, and uncomment the line below
//$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// mysql_connect($dbhost, $dbuser, $dbpass) or die("Query failed: " . $mysqli->error);
// mysql_select_db($dbname) or die("Query failed: " . $mysqli->error);

function createTable($mysqli, $name, $query)
{
	if (tableExists($mysqli, $name))
	{
		echo "Table '$name' already exists<br />";
	}
	else
	{
		queryMysql($mysqli, "CREATE TABLE $name($query)");
		echo "Table '$name' created<br />";
	}
}

function tableExists($mysqli, $name)
{
	$result = queryMysql($mysqli, "SHOW TABLES LIKE '$name'");
	return mysqli_num_rows($result);
}

function queryMysql($mysqli, $query)
{
	$result = $mysqli->query($query) or die("Query failed: " . $mysqli->error);
	return $result;
}

function destroySession()
{
	$_SESSION=array();
	
	if (session_id() != "" || isset($_COOKIE[session_name()]))
	    setcookie(session_name(), '', time()-2592000, '/');
		
	session_destroy();
}

function sanitizeString($mysqli, $var)
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return mysqli_real_escape_string($mysqli, $var);
}

function showProfile($mysqli, $user)
{
	if (file_exists("$user.jpg"))
		echo "<img src='$user.jpg' border='1' align='left' />";
		
	$result = queryMysql($mysqli, "SELECT * FROM bcprofiles WHERE user='$user'");
	
	if (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		echo stripslashes($row[1]) . "<br clear=left /><br />";
	}
}

function username($mysqli, $staff_no)
{
    $username = " ";
    $result = queryMysql($mysqli, "SELECT username FROM bcpeople WHERE staffno = '$staff_no'");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $username = $row[0];
            }
return $username;
}

/*
function diff_sec_convert($time1, $time2)
{
    $startsec = new datetime($time1);
    $endsec = new datetime($time2);
    $interval = $endsec->diff($startsec);
    //$interval = new DateInterval($interval);
    $gant_time = 0;
    $gant_time = $gant_time + $interval->format('%y') * 365 * 24 * 60 * 60;
    if ($interval->format('%m') == 2)
    {
        $gant_time = $interval->format('%m') * 28 * 24 * 60 * 60;
    }
    else if ($interval->format('%m') == 4 || 6 || 9 || 11)
    {
        $gant_time = $interval->format('%m') * 30 * 24 * 60 * 60;
    }
    else 
    {
        $gant_time = $interval->format('%m') * 31 * 24 * 60 * 60;
    }
    $gant_time = $gant_time + $interval->format('%d') * 24 * 60 * 60;
    $gant_time = $gant_time + ($interval->format('%h') * 60 * 60);
    $gant_time = $gant_time + $interval->format('%i') * 60;
    $gant_time = $gant_time + $interval->format('%s');
return $gant_time;
}
*/

function diff_sec_convert($time1, $time2)
{
    $startsec = new DateTime($time1);
    $endsec = new DateTime($time2);

    return $endsec->getTimestamp() - $startsec->getTimestamp();
}

function OpNotoOpName($OpNo)
{
    $OpName = " ";
    $result = queryMysql($mysqli, "SELECT operation FROM bcoperations WHERE OpNo = '$OpNo'");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $OpName = $row[0];
            }
return $OpName;
}

function findlastoplocal($mysqli, $localOpNo,$batchno)
{
    
    //find the previous local op no from the one entered $opNo is localop
    //get the build type and the productcode form batchinfo
    //echo $batchno;
       
    $result = queryMysql($mysqli, "SELECT productcode, build_type FROM bcbatchinfo WHERE batchno = '$batchno'");
    $num = mysqli_num_rows($result);
    //echo "testing <br />"; 
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $productcode = $row[0];
                $build_type = $row[1];
                //echo "<br />product code = $productcode";
                //echo "<br />build type = $build_type";
            }
    if ($localOpNo != 1)
    {
        //search for the previous op (local - 1) and return the global op number for the previoius operation
        $result = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE Product_code = '$productcode' AND Build_type = '$build_type'");
        $num = mysqli_num_rows($result);
        for ($ki = 0; $ki < $num; ++$ki)
                {
                    $row = mysqli_fetch_row($result);
                    $qty_ops = count ($row,1);
                    for ($x = 0; $x < $qty_ops; ++$x)
                    {
                        if ($row[$x] == $localOpNo - 1)
                        {
                            $globallastop = $x -2;
                            $locallastop = $row[$x];
                            //echo "<br />global last op = $globallastop";
                            //echo "<br />local last op = $locallastop";
                        }
                    }
                    
                }
    }
    else
    {
        $globallastop = -1;
    }
return $globallastop;
}

// no usage found
function findlastopglobal($OpNo,$batchno)
{
    //find the previous global op no from the one entered $opNo is globalop
    //get the build type and the productcode form batchinfo
    $result = queryMysql($mysqli, "SELECT productcode, build_type FROM bcbatchinfo WHERE batchno = '$batchno'");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $productcode = $row[0];
                $build_type = $row[1];
                echo "<br />product code = $productcode";
                echo "<br />build type = $build_type";
            }
    if ($OpNo != 1)
    {
        //search for the previous op (local - 1) and return the global op number for the previoius operation
        $result = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE Product_code = $productcode AND Build_type = $build_type");
        $num = mysqli_num_rows($result);
        for ($ki = 0; $ki < $num; ++$ki)
                {
                    $row = mysqli_fetch_row($result);
                    $qty_ops = count ($row,1);
                    $localop = $row[$OpNo + 1];
                    for ($x = 0; $x < $qty_ops; ++$x)
                    {
                        if ($row[$x] == $localop - 1)
                            $lastop = $x -2;
                    }
                    
                }
    }
return $lastop;
}

function updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code ,  $OpNo,  $user,   $Location,  $Date,  $batchno)
{
    if ($into_stock != 0 && $into_stock > -1)
    {
        $direction = "In";
        queryMysql($mysqli, "INSERT INTO  `publications`.`bcstocklog` (`quantity` ,`product_code` ,`operation_number` ,`user` ,`location` ,
                                                        `date/time` ,`Direction` ,`batchno`)
                    VALUES ('$into_stock', '$Product_code' ,  '$OpNo',  '$user',   '$Location',  '$Date',  '$direction',  '$batchno');");
    }
    if ($From_Stock != 0 && $From_Stock > -1)
    {
        $direction = "Out";
        queryMysql($mysqli, "INSERT INTO  `publications`.`bcstocklog` (`quantity` ,`product_code` ,`operation_number` ,`user` ,`location` ,
                                                        `date/time` ,`Direction`,`batchno`)
                    VALUES ('$From_Stock', '$Product_code' ,  '$OpNo',  '$user',   '$Location',  '$Date',  '$direction',  '$batchno');");
    }
    
}

function dropdown($table, $field, $Conditional_Field, $Condition, $Conditional_Value)
{
    $result = queryMysql($mysqli, "SELECT DISTINCT $field FROM $table WHERE $Conditional_Field $Condition $Conditional_Value");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $Output[$ki] = $row[0];
            }
return $Output;
}

function Staff_no($mysqli, $User)
{
    $staffno = 1000;
    $result = queryMysql($mysqli, "SELECT staffno FROM bcpeople WHERE username = '$User'");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $staffno = $row[0];
            }
return $staffno;
}


function rfxlinecalendar($variable_name)
{
    $myCalendar = new tc_calendar($variable_name,true);
    $myCalendar->setIcon("calendar/calendar/images/iconCalendar.gif");
    $myCalendar->setDate(date('d'), date('m'), date('Y'));
    $myCalendar->setPath("calendar/calendar/");
    $myCalendar->zindex = 150; //default 1
    $myCalendar->setYearInterval((date('Y')-1), (date('Y')+10));
    $myCalendar->setAlignment('right', 'bottom'); //optional
    $myCalendar->writeScript();
return;
}

function rfxlinecalendar2($variable_name,$stamp)
{
    $myCalendar = new tc_calendar($variable_name,true);
    $myCalendar->setIcon("calendar/calendar/images/iconCalendar.gif");
    $myCalendar->setDate(date('d',$stamp), date('m',$stamp), date('Y',$stamp));
    $myCalendar->setPath("calendar/calendar/");
    $myCalendar->zindex = 150; //default 1
    $myCalendar->setYearInterval((date('Y')-1), (date('Y')+10));
    $myCalendar->setAlignment('right', 'bottom'); //optional
    $myCalendar->writeScript();
return;
}

function rfxlinecalendarwithdate($variable_name,$datadate)
{
    $datadate = strtotime($datadate);
    $day = date('d',$datadate);
    $month = date('m',$datadate);
    $year = date('Y',$datadate);
    $myCalendar = new tc_calendar($variable_name,true);
    $myCalendar->setIcon("calendar/calendar/images/iconCalendar.gif");
    $myCalendar->setDate($day,$month,$year);
    $myCalendar->setPath("calendar/calendar/");
    $myCalendar->zindex = 150; //default 1
    $myCalendar->setYearInterval((date('Y')-1), (date('Y')+10));
    $myCalendar->setAlignment('right', 'bottom'); //optional
    $myCalendar->writeScript();
return;
}

function show($mysqli, $row, $item, $Order, $Select_Order, $stat,$bgcol)
{
    if (isset($_GET['action']))
    {
        $action = $_GET['action'];
    }
    else if (isset($_POST['action']))
    {
        $action = $_POST['action'];
    }
    else 
    {
        $action = 0;
    }
    if($bgcol%2 == 1)
    {
        $background = '#E0FFEF';
    }
    else
    {
        $background = 'WHITE';
    }    
    if ($row[8] == NULL)
    {
            $expected = $row[7];                                            
            $now = date('c');
            $late = timeDiff($expected,$now);
            //echo $late;
            if ($late >0)
            {
                $background ='salmon';
            }
            echo "<tr bgcolor=$background>";;
    }
    else if($row[8] != NULL)
    {
        $late = timeDiff($row[7],$row[8]);
        //echo $late;
        if ($late >0)
        {
            $background ='salmon';
        }
        echo "<tr bgcolor=$background>";
    }
    
            echo "
                    <td><a href='bcsalesview.php?item=$row[1]&order=$row[0]&Select_Order=$Select_Order&Show=$stat'>$row[0]</td>
                    <td><a href='bcsalesview.php?item=$row[1]&order=$row[0]&Select_Order=$Select_Order&Show=$stat'>$row[1]</td>
                    <td> ".$row[2]."</td>
                    <td> ".$row[3]."</td>
                    <td> ".$row[4]."</td>
                    <td> ".$row[5]."</td><td>";
                    $assigned = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE salesorder = '$row[0]' AND item = '$row[1]' ORDER BY salesorder");
                        $numassigned = mysqli_num_rows($assigned);
                        for ($ki = 0; $ki < $numassigned; ++$ki)
                        {
                            $assignedrow = mysqli_fetch_row($assigned); // list any orders associated with the batch
                            //use assigned to call bcsalesorders and total the quantity assigned
                            $batch = $assignedrow[2];
                            //output information on previously assigned batches
                            echo "
                            <a href='bcbatchinfo.php?view=$batch'>$batch ";
                            
                        }
                        //if ($numassigned == 0)
                        //{
                        //    echo "<td> </td>";
                        //}
                    echo"</td><td> ".$row[6]."</td>
                    <td> ".$row[7]."</td>
                    <td> ".$row[8]."</td>
                    <td> ".$row[9]."</td>
                    <td> ".$row[10]."</td>
                    <td> ".$row[11]."</td>
                    <td> ".$row[12]."</td>
                    </tr>
                    ";
                    if ($item == $row[1]&$Order == $row[0])
                    {
                        //add code to show a drop down of available actions
                        
                        If ($action == 0)
                        {
                            echo <<<_END
                            <table class="floatleft" border="0" cellpadding="2"
                            cellspacing="5" bgcolor="#eeeeee">
                            <th align="center">Select Action</th>
                            <form class = floatleft name="action" action="bcsalesview.php?item=$row[1]&order=$row[0]&Select_Order=$Select_Order&Show=$stat" method="post">
                            <tr><td><select name="action">
                            <option value="1" >Add Item</option>
                            <option value="2" >Change Item</option>
                            <option value="3" >Spilt Item</option>
                            <option value="4" >Edit Comment</option>
                            <option value="5" >Ship Item</option></td></tr>
                            <tr><td><input type="submit" value="Submit" /></td></tr>
                            </select>
                            </form></table>
_END;
                        }
                        //then reload page with only the action selected showing
                        //show add item and change item boxes
                        if ($action == 1)
                        {
                            echo '
                            
                            <table class="floatleft" border="0" cellpadding="2"
                            cellspacing="5" bgcolor="#eeeeee">
                            <th colspan="2" align="center">Add Item</th>
                            <form method="post" action="bcsalesorder.php?Order='.$row[0].'">
                            </tr><tr><td>Quantity</td><td><input type="text" maxlength="16"
                                    name="Quantity" /></td>
                            </tr><tr><td>Product code</td><td><input type="text" maxlength="16"
                                    name="Productcode" /></td>
                            </tr><tr><td>Description</td><td><input type="text" maxlength="128"
                                    name="Description" /></td>
                            </tr><tr><td>requested ship date</td><td>'; rfxlinecalendar("add_req_ship_date");
                            echo'</td>
                            </tr><tr><td>Expected ship date</td><td>'; rfxlinecalendar("add_expected");
                            echo'</td>
                            <input type="hidden" name="Order" value="'.$row[0].'" />
                            <input type="hidden" name="item" value= -1 />
                            <input type="hidden" name="Customer" value="'.$row[4].'" />
                            </tr><tr><td colspan="2" align="center">
                                    <input type="submit" value="Go" /></td>
                            </tr></form></table>';
                        }
                                                
                        if ($action == 2)
                        {
                            echo '         
                            <table class = floatleft border="0" cellpadding="2"
                            cellspacing="5" bgcolor="#eeeeee">
                            <th colspan="2" align="center">Change Item</th>
                            <form method="post" action="bcsalesorder.php?Order='.$row[0].'"
                                    onSubmit="return validate(this)">
                            </tr><tr><td>Quantity</td><td><input type="text" maxlength="16"
                                    name="Quantity" value = "'.$row[2].'" /></td>
                            </tr><tr><td>Product code</td><td><input type="text" maxlength="16"
                                    name="Productcode" value ="'.$row[3].'"  /></td>
                            </tr><tr><td>Customer</td><td><input type="text" maxlength="32"
                                    name="Customer" value = "'.$row[4].'" /></td>
                            </tr><tr><td>description</td><td><input type="text" maxlength="128"
                                    name="Description" value = "'.$row[5].'" /></td>
                            </tr><tr><td>requested ship date</td><td>';
                            rfxlinecalendarwithdate("change_req_ship_date",$row[6]);
                            echo '</td>
                            </tr><tr><td>expected ship date </td><td>';
                            rfxlinecalendarwithdate("change_expected",$row[7]);
                            echo '</td>
                            <input type="hidden" name="Order" value="'.$row[0].'" />
                            <input type="hidden" name="item" value="'.$item.'" />
                            </tr><tr><td colspan="2" align="center">
                            <input type="submit" value="Go" /></td>
                            </tr></form></table>';
                        }
                        
                        If ($action == 3)
                        {
                            echo '
                             <table class = floatleft border="0" cellpadding="2"
                            cellspacing="5" bgcolor="#eeeeee">
                            <th colspan="2" align="center">Split Item</th>
                            <form method="post" action="bcsalesorder.php?Order='.$row[0].'"
                                    onSubmit="return validate(this)">
                            </tr><tr><td>Quantity to move to new item</td><td><input type="text" maxlength="16"
                                    name="Quantity" value = "'.$row[2].'" /></td>
                            <input type="hidden" name="Productcode" value ="'.$row[3].'" />
                            <input type="hidden" name="Customer" value = "'.$row[4].'" />
                            <input type="hidden" name="Description" value = "'.$row[5].'"/>
                            <input type="hidden" name="item" value="'.$item.'" />
                            <input type="hidden" name="split" value= "1" />
                            </tr><tr><td>change ship date?</td><td>';rfxlinecalendarwithdate("split_req_ship_date",$row[6]);
                            echo '</td>
                            </tr><tr><td>change expected date? </td><td>';rfxlinecalendarwithdate("split_expected",$row[7]);
                            echo '</td>
                            </tr><tr><td>ship date of new item</td><td>';rfxlinecalendarwithdate("new_item_req",$row[6]);
                            echo '</td>
                            </tr><tr><td>expected date of new item </td><td>';rfxlinecalendarwithdate("new_item_expected",$row[7]);
                            echo '</td>
                            </tr><tr><td colspan="2" align="center">
                                    <input type="submit" value="Go" /></td>
                            </tr></form></table>';
                        }
                        
                        
                        echo '                        
                        <table class = floatright  border="1">
                                 <tr>
                                 <th>Assigned Batches</th>
                                 </tr>';
                        $assigned = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE salesorder = '$Order' AND item = '$item' ORDER BY salesorder");
                        $numassigned = mysqli_num_rows($assigned);
                        for ($ki = 0; $ki < $numassigned; ++$ki)
                        {
                            $assignedrow = mysqli_fetch_row($assigned); // list any orders associated with the batch
                            //use assigned to call bcsalesorders and total the quantity assigned
                            $batch = $assignedrow[2];
                            //output information on previously assigned batches
                            echo "<tr><td><a href='bcbatchinfo.php?view=$batch'>$batch </td></tr>";
                            
                        }
                        if ($numassigned == 0)
                        {
                            $batch = '0';
                        }
                        echo '</table>
                        <table class = floatright border="1">
                                 <tr>
                                 <th>Associated Works Orders</th>
                                 </tr>';
                        $assigned = queryMysql($mysqli, "SELECT * FROM bcworksordertobatch WHERE batch = '$batch' ORDER BY worksorder");
                        $numassigned = mysqli_num_rows($assigned); // list any Stock (works orders) associated with batch
                        for ($ki = 0; $ki < $numassigned; ++$ki)
                        {
                            $assignedrow = mysqli_fetch_row($assigned);
                            //use assigned to call bcsalesorders and total the quantity assigned
                            $order = $assignedrow[0];
                            //output information on previously assigned batches
                            echo "<tr><td><$order>$order</td></tr>";
                            
                        }
                        echo '</table>';
                  
                        if ($action == 5)
                        {
                            echo '
                            
                            <table class = floatleft border="0" cellpadding="2"
                            cellspacing="5" bgcolor="#eeeeee">
                            <th colspan="2" align="center">Ship Item</th>
                            <form method="post" action="bcsalesview.php?item='.$row[1].'&order='.$row[0].'"
                                    onSubmit="return validate(this)">
                            </tr><tr><td>Enter Date Shipped</td><td>';rfxlinecalendar("Ship_Date");
                            echo '</td>
                            </tr><tr><td colspan="2" align="center">
                            <input type="submit" value="Go" /></td>
                            </tr></form></table>';
                        }
                        
                        if ($action == 4)
                        { 
                            $comment = $row[9];
                            echo "
                            <table class = floatleft border='0' cellpadding='2'
                            cellspacing='5' bgcolor='#eeeeee'>
                            <th colspan='2' align='center'>Add/Edit Comment</th>
                            <form method='post' action='bcsalesview.php?item=".$row[1]."&order=".$row[0]."'
                                    onSubmit='return validate(this)'>
                            </tr><tr><td>Enter a comment</td><td><input type='text' maxlength='126'
                                    name='comment' value='$row[9]' /></td>
                            </tr><tr><td colspan='2' align='center'>
                            <input type='submit' value='Go' /></td> 
                            </tr></form></table>";
                            
                        }
                        echo'
                        
                        <form class = floatleft name="input" action = "bcsalesview.php" method="get">
                        <input type="submit" value="Back to open sales" />
                        </form>                        
                        
                        <table class = tablefloatleft border="4">
                        <tr>
                        <th><a href="bcsalesview.php?sortmode=salesorder&Show=$stat">Sales Order</th>
                    <th><a href="bcsalesview.php?sortmode=item&Show=$stat">Item #</th>
                    <th><a href="bcsalesview.php?sortmode=quantity&Show=$stat">Quantity</th>
                    <th><a href="bcsalesview.php?sortmode=productcode&Show=$stat">Product Code</th>
                    <th><a href="bcsalesview.php?sortmode=customer&Show=$stat">Customer</th>
                    <th><a href="bcsalesview.php?sortmode=description&Show=$stat">Description</th>
                    <th><a href="bcsalesview.php?sortmode=requestedshipdate&Show=$stat">Date expected at Customer</th>
                    <th><a href="bcsalesview.php?sortmode=expectedshipdate&Show=$stat">Date expected to ship</th>
                    <th><a href="bcsalesview.php?sortmode=actualshipdate&Show=$stat">Actual ship date</th>
                    <th>Comments</th>
                    <th><a href="bcsalesview.php?sortmode=Op_entered&Show=$stat">Order entered By</th>
                    <th><a href="bcsalesview.php?sortmode=Date_Entered&Show=$stat">Order entered on</th>
                    <th width= 4%><a href="bcsalesview.php?sortmode=Priority&Show=$stat">Priority</th>
                        </tr>';
                    }
                    }
return;


function timeDiff($firstTime,$lastTime)
{

// convert to unix timestamps
$firstTime=strtotime($firstTime);
$lastTime=strtotime($lastTime);

// perform subtraction to get the difference (in seconds) between times
$timeDiff=$lastTime-$firstTime;

// return the difference
return $timeDiff;
}

?>
