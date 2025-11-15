<?php // bcmembers.php
if (!isset($_SESSION)) session_start();



$Start = $Stop = $Comment = 0;
$stat = 3;
if (isset($_GET['disp']))
{
    $disp = ($_GET["disp"]);
   // $_SESSION['disp'] = $disp;
    $_SESSION['disp'] = $disp;
}
else {$disp = $_SESSION['disp'];}
if (isset($_GET['dept']))
{
    $dept = ($_GET["dept"]);
   // $_SESSION['disp'] = $disp;
    $_SESSION['dept'] = $dept;
}
else if (isset($_SESSION['dept']))
    {$dept = $_SESSION['dept'];}
else
{$dept = 0;}
if (isset($_GET['Show']))
{$stat = ($_GET["Show"]);}
else {$stat = 1;}
if (isset($_GET['Stop']))
{$Stop = 1;}
if (isset($_GET['Start']))
{$Start = 1;}
if (isset($_GET['Eng']))
{$Eng = ($_GET["Eng"]);}
if (isset($_GET['Comment']))
{$Comment = ($_GET["Comment"]);}
if (isset($_GET['search']))
{$Search = ($_GET["search"]);}
else
{$Search = '';}
if (isset($_GET['Arrange']))
{$Arrange = ($_GET["Arrange"]);}
else
{$Arrange = 'batchno';}
if (isset($_GET['opcheck']))
{$OpCheck = ($_GET["opcheck"]);}
else
{$OpCheck = 0;}
if (isset($_GET['view']))
{$view = ($_GET["view"]);}
else {$view = 1;}
$prev = 0;
if (@$disp != 1)
{
    include_once 'bcheader.php';
    if (!isset($_SESSION['user']))
            die("<br /><br />You must be logged in to view this page");
    $user = $_SESSION['user'];
    //$_SESSION['disp'] = $disp;
}
else
{
    include_once 'bcfunctions.php';
    $user = 1000;
    $staffno = 1000;
    $check = '';
    //session_start();
    //$disp = $_SESSION['disp'];
    //$_SESSION['disp'] = $disp;
}
//$disp = $_SESSION['disp'];
/*
 $operations = queryMysql($mysqli, "SELECT * FROM bcoperations ORDER BY OpNo");
    $opcount = mysqli_num_rows($operations);
     $total_count = 0;
    do
    {
    echo"<table class = floatright border='1'>
         <tr>
         <th>Op No</th>
         <th>desription</th>
         </tr>
         <tr>";
        for ($j = 0; $j < 10; ++$j)
        { 
		$oprow = mysqli_fetch_row($operations);
                
                    if ($oprow[0] != NULL)
                    {
                            echo"<td> $oprow[0]</td>";
                            echo"<td> $oprow[1]</td></tr>";
                            ++$total_count;
                    }
                    else
                    {
                            echo"<td> &nbsp; </td>";
                            echo"<td> &nbsp; </td></tr>";
                            ++$total_count;
                    }
                
		
        }
        echo "</table>"; 
    }
    while ($total_count <= $opcount); 

*/

echo $Search;
$result = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno LIKE '%$Search%' OR productcode LIKE '%$Search%' 
            OR productdescription LIKE '%$Search%' OR qtystart LIKE '%$Search%' OR qtyreq LIKE '%$Search%' OR started LIKE '%$Search%'
            OR completed LIKE '%$Search%' or build_type LIKE '%$Search%' ORDER BY $Arrange"); 
$num = mysqli_num_rows($result);
//echo "</ul ><h3>Batches</h3><ul>";

//input or scan the batch number you want
//simple form should do it


// want to add a switch in here for open,closed,unstarted or all batches and show 
// only the one selected (where status = switch ouput)just need to worry about 
//what I can put in the where to get them all again will then get back to one function
switch ($stat)
{
        case "3":
        $select3 = "selected";
        $select0 = "";
        $select2 = "";
        $select1 = "";
        break;
    case "1":
        $select1 = "selected";
        $select0 = "";
        $select2 = "";
        $select3 = "";
        break;
    case "2":
        $select2 = "selected";
        $select0 = "";
        $select1 = "";
        $select3 = "";
        break;
    default:
        $select0 = "selected";
        $select1 = "";
        $select2 = "";
        $select3 = "";
        break;
    
}
$Staffno = Staff_no($mysqli, $user);

if ($Start == 1)
{
     $now = date('c');
     queryMysql($mysqli, "INSERT INTO bcoperationsdone VALUES('NULL','NULL',
                '$Staffno',NULL,NULL,NULL,NULL,'$now',NULL,NULL,NULL,'$Comment')");
    echo'
    <script language="javascript">
    location.replace("bcbatches.php?");
    </script>';
}

if ($Stop == 1)
{
     $now = date('c');
     queryMysql($mysqli, "UPDATE bcoperationsdone SET end = '$now' WHERE batchno = 'NULL' AND operation = 'NULL'
                AND staffnumber = '$Staffno' AND start IS NOT NULL AND end IS NULL");
}


if ($disp == 5)
{

    $result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE operation = 'NULL' AND batchno = 'NULL'
                            AND staffnumber = '$Staffno' AND end IS NULL");
    $num = mysqli_num_rows($result);
    if ($num > 0)
        {
            for ($j = 0; $j < $num; ++$j)
            {
                $row = mysqli_fetch_row($result);
                echo "Currently working on $row[11]";
            }
            echo '
            
            <form name="input" action="bcbatches.php?" method="get">
            Stop a task NOT associated with a batch
            <input type="Submit" value="Stop" name="Stop"/>
            </form>';
        }
    else
        {
            echo'<form name="input" action="bcbatches.php?" method="get">
            start a task NOT associated with a batch and enter any comments here <br /> 
            <input type="uncontrolled_text" name="Comment" size = "75"/>
            <input type="Submit" name="Start" value="Start" size="7"  />
            </form>';
        }
}

if ($disp != 1)
{
    $break = queryMysql($mysqli, "SELECT break FROM bcpeople WHERE staffno = '$Staffno'");
    $breaknum = mysqli_num_rows($break);
    for($i = 0; $i < $breaknum; ++$i)
    {
            $check = mysqli_fetch_row($break);
    }
}


if (@$check[0] != NULL)
{ 

if ($disp == 2)
    {
        echo <<<_END

        <form name="input" class='centre' action="bcbatchinfo.php?" method="get">
        Enter Batch Number to be taken<br /> directly to that batch: <input type="text" name="view" />
        <input type="submit" value="Submit" />
        </form>
_END;
    }

if ($disp == 3)
    {
    echo <<<_END

    <form name='end' class = 'centre' action='bcbreak.php' method='post'>
            Break box (enter comments before going on break)<input type='text' name='comment' length='255'/>  
            <input type='submit' value='start all batches for $user'> 
            </form>

_END;
    }
if ($disp == 4)
    {
    echo <<<_END

    <form action=""bcmembers.php" class='centre' method="GET">Search this page for (leave blank for all)<input type="text" name="search" value = $Search >
    <input type = hidden name="Arrange" value='$Arrange'/>
    From :
    <select name="Show">
    <option value="3" $select3>All Batches </option>
    <option value="1" $select1>Open Batches</option>
    <option value="2" $select2> Closed Batches</option>
    <option value="0" $select0>Unstarted Batches</option>
    </select>
    <input type="submit"  value="submit" />
    </form>

_END;
    }
}
else
{

if ($disp == 2)
    {
    echo <<<_END

    <form name="input" class='centre' action="bcbatchinfo.php?" method="get">
    Enter Batch Number to be taken directly to that batch: <input type="text" name="view" />
    <input type="submit" value="Submit" />
    </form>
_END;
}

if ($disp == 3)
    {
    echo <<<_END

    <form name='end' class = 'centre' action='bcbreak.php' method='post'>
            Break box (enter comments before going on break)<input type='text' name='comment' length='255'/>  
            <input type='submit' value='stop all batches for $user'> 
            </form>
_END;
    }

if ($disp == 4)
    {
    
    echo <<<_END

    <form action=""bcmembers.php" class='centre' method="GET">Search this page for (leave blank for all)<input type="text" name="search" value = $Search >
    <input type = hidden name="Arrange" value='$Arrange'/>
    From :
    <select name="Show">
    <option value="3" $select3>All Batches </option>
    <option value="1" $select1>Open Batches</option>
    <option value="2" $select2>Closed Batches</option>
    <option value="0" $select0>Unstarted Batches</option>
    </select>
    <input type="submit"  value="submit" />
    </form>

_END;
    }
}

$operations = queryMysql($mysqli, "SELECT * FROM bcoperations ORDER BY OpNo");
    $opcount = mysqli_num_rows($operations);
//set up table headings
    echo"<table class = 'tablefloatleft'>
         <tr>
         <th><a href='bcbatches.php?Arrange=batchno&search=$Search&Show=$stat'>Batch #</a></th>
         <th><a href='bcbatches.php?Arrange=productcode&search=$Search&Show=$stat'>Product Code</a></th>
         <th><a href='bcbatches.php?Arrange=productdescription&search=$Search&Show=$stat'>Description</a></th>
         <th>Qty Expected</th>
         <th>Ship Date</th>
         <th>Customer</th>";
    if ($disp == 1)  
    {   
        for ($j = 0; $j < $opcount; ++$j)
        {
            $oprow = mysqli_fetch_row($operations);
            $err = $oprow[4] - 100;
            //echo "$err  $oprow[4]<br />      ";
            if (@$oprow[4] == $dept || $err == $dept ||$dept == 0 ||$oprow[4] == 100 || ($dept >= 100 && $oprow[4] >=100))
            {
                //echo"<th font-size:50% class='rotated_cell' width='1' ><a href='bcbatches.php?Arrange=batchno&search=$Search&Show=$stat&opcheck=$oprow[0]'><div class='rotate_text'> $oprow[1]</div></a></th>";
                echo"<th   width='1' ><h5><a href='bcbatches.php?Arrange=batchno&search=$Search&Show=$stat&opcheck=".($oprow[0]-1)."'>$oprow[1]($oprow[0])</a></h5></th>";
            
            }
           /* else
            {
                //echo"<th font-size:50% class='rotated_cell' width='1' ><a href='bcbatches.php?Arrange=batchno&search=$Search&Show=$stat&opcheck=$oprow[0]'><div class='rotate_text'> $oprow[1]</div></a></th>";
                echo"<th   width='1' ><h5><a href='bcbatches.php?Arrange=batchno&search=$Search&Show=$stat&opcheck=$oprow[0]'>$oprow[1]</a></h5></th>";
            
            }*/
        }
    }
    echo "</tr>";

if ($stat == 1)
{ 
    $batchdata = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE (status = 1 OR status = 3) AND (batchno LIKE '%$Search%' OR productcode LIKE '%$Search%' 
            OR productdescription LIKE '%$Search%' OR qtystart LIKE '%$Search%' OR qtyreq LIKE '%$Search%' OR started LIKE '%$Search%'
            OR completed LIKE '%$Search%' or build_type LIKE '%$Search%') ORDER BY $Arrange");
}
else If ($stat != 3 )
{ 
    $batchdata = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE status = '$stat' AND (batchno LIKE '%$Search%' OR productcode LIKE '%$Search%' 
            OR productdescription LIKE '%$Search%' OR qtystart LIKE '%$Search%' OR qtyreq LIKE '%$Search%' OR started LIKE '%$Search%'
            OR completed LIKE '%$Search%' or build_type LIKE '%$Search%') ORDER BY $Arrange");
}
else
{
    $batchdata = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE (batchno LIKE '%$Search%' OR productcode LIKE '%$Search%' 
            OR productdescription LIKE '%$Search%' OR qtystart LIKE '%$Search%' OR qtyreq LIKE '%$Search%' OR started LIKE '%$Search%'
            OR completed LIKE '%$Search%' or build_type LIKE '%$Search%') ORDER BY $Arrange");
}
$numbatch = mysqli_num_rows($batchdata);

for ($j = 0; $j < $numbatch; ++$j)
{
    $prev = !$prev;
    $batchrow = mysqli_fetch_row($batchdata);
    if ($OpCheck != 0)
    {
        //check if the $OpCheck is in bcoperations done for the productcode and build type
        $chkop = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE Product_code = '$batchrow[1]' 
        AND build_type = '$batchrow[9]'");
        $num_chkop = mysqli_num_rows($chkop);
        for ($k = 0; $k < $num_chkop; ++$k)
        {
            $chkoprow = mysqli_fetch_row($chkop);
            if ($chkoprow[$OpCheck+1] != 0)
            {//only display the entries which are
    $labelcolor = 'WHITE';
    $Eng = 0;
    //echo $batchrow[11];
    if ($j < 4)
    {
        $labelcolor = 'Pearly Gates';
        echo "<tr bgcolor = $labelcolor>";
    }
    else if ($batchrow[11] != 1)
    {
        $labelcolor = 'white';
        echo "<tr bgcolor = $labelcolor>";
        }
    else 
    {
        $labelcolor = 'CYAN';
        $Eng = 1;
    } 
    echo "
            <td bgcolor = $labelcolor><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[0]</td>
    <td bgcolor = $labelcolor><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[1]</td>
    <td bgcolor = $labelcolor><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[2]</td>
    <td>$batchrow[5]</td>";
    //ship date 
    //search batch number on bcsalestobatch
    $shipbatch = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE batch = '$batchrow[0]' ");
    $numshipbatch = mysqli_num_rows($shipbatch);
    if ($numshipbatch != 0)
    {
        $t=time();
        $shipdate = "2100-01-01";
        $actual_ship = 0; 
        $late = 0;
        for ($ij = 0; $ij < $numshipbatch; ++$ij)
        {
            //for each entry get the date for the salesorder and item from bcsales order
            //when the ship date is null
            $shipbatchrow = mysqli_fetch_row($shipbatch);
            $itemdate = queryMysql($mysqli, "SELECT expectedshipdate, customer, actualshipdate FROM bcsalesorders 
            WHERE salesorder = '$shipbatchrow[0]' AND item = '$shipbatchrow[1]'");
            $numitemdate = mysqli_num_rows($itemdate);
            if ($numitemdate != 0)
            {
                for ($ik = 0; $ik < $numitemdate; ++$ik)
                {
                    $itemdaterow = mysqli_fetch_row($itemdate);
                    $cust = $itemdaterow[1];
                    $actual_ship = $itemdaterow[2];
                    //find the earliest date and post to table
                    if ($itemdaterow[0] < $shipdate && $itemdaterow[0] > 1)
                    {
                        $shipdate = $itemdaterow[0];
                        $cust = $itemdaterow[1];
                        $actual_ship = $itemdaterow[2];
                        $now = date('c');
                        $late = timeDiff($shipdate,$now);
                        //echo $late;
                    }
                    
                }
            }
        }
        if ($late >0 && $actual_ship == 0)
    {
        echo "<td bgcolor='salmon'>$shipdate </td>";
        
    }
    else if($late <0 && $actual_ship == 0)
    {
        echo "<td>$shipdate</td>";
    }
    //else if ($shipdate == "2100-01-01")
    else if ($actual_ship != 0)
    {
        $shipdate = "Shipped";
        echo "<td>$shipdate </td>";
    }
    }
    else
    {
        $shipdate = '';
        $cust = '';
        echo "<td>$shipdate</td>";
    }
    echo "<td>$cust</td>";
    $lastop = 0;
    $lastopused = -1;
    $globallastopused = 0;
    $locallastopused = 0;
    $firstop = 0;
    $opused = 1;
    $thisop = 0;
    $numprod_opdata = 0;
    if ($batchrow[9] != 'Full')
    {
        $prod_opdata = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE Product_code = '$batchrow[1]' 
        AND build_type = '$batchrow[9]'");
        //get custom build if applicable
        $numprod_opdata = mysqli_num_rows($prod_opdata);
        $prod_opdatarow = mysqli_fetch_row($prod_opdata);
        
        for ($globalop = 0; $globalop < $opcount; ++$globalop)
        { //find first operation
            if ($prod_opdatarow[$globalop+2] != '0')
            {
                $batcharray[$globalop] = $prod_opdatarow[$globalop+2];//local operations in order
                $lastlocalop =$prod_opdatarow[$globalop+2];
            } 
            else
            {
                $batcharray[$globalop] = 0;
            }
           // array_pad($lastlocalop,-26,0);
        }
       // print_r( $batcharray);
       // echo '<br>';
    }
    else
    {//what to do if it is a full build
        for ($globalop = 0; $globalop < $opcount; ++$globalop)
        {
            $batcharray[$globalop] = $globalop + 1;
        }
        //print_r($localoplist);
        //echo '<br>';
    }   
    //get totals for each operation and insert
    if ($disp == 1)  
    {   
        for ($i = 0; $i < $opcount; ++$i)
        {
            $k = $i + 1;
            //for this operation and batch search operations done
            $opdata = queryMysql($mysqli, "SELECT quantitycomplete, DATE(end) FROM bcoperationsdone WHERE batchno = '$batchrow[0]' 
            AND operation = '$k'");
            $numopdata = mysqli_num_rows($opdata);
            $optotal = 0;
            if ($numopdata != 0)
            {
                //only do the total loop if there is data returned
                for ($a = 0; $a < $numopdata; ++$a)
                {
                    $oprow = mysqli_fetch_row($opdata);
                    $optotal = $optotal + $oprow[0];
                }
                
            }
            if (/*$dispop == 0 ||*/ $batcharray[$i] == 0 /*||$numlastop != $i-1*/ )
            {
                
                if ($prev = 0)
                    {
                        echo "<td bgcolor='wheat'> </td>";
                    }
                    else
                    {
                        echo "<td bgcolor='#FEF5CA'> </td>";
                    }
            }
            else if ($optotal < 0)
            {
                echo "<td bgcolor='salmon'> </td>";
            }
            else if ($batchrow[8]==3)
            {
                echo "<td bgcolor='orange'>$optotal  </td>";
            }
            else
            {
                echo "<td >$optotal </td>";
            }
            
            $lastop = $optotal;
            $numlastop = $i;
            $opused = 1;
            //echo "<td>$optotal</td>";
        }
    }
        
    echo "</tr>";
}}}
else
    {
    $labelcolor = 'WHITE';
    $Eng = 0;
    //echo $batchrow[11];
    if ($batchrow[11] != 1 && $j%2 == 1)
    {
        $labelcolor = '#E0FFEF';
        echo "<tr bgcolor = $labelcolor>";
    }
    else if ($batchrow[11] != 1)
    {
        $labelcolor = 'WHITE';
        echo "<tr bgcolor = $labelcolor>";
        }
    else if ($j%2 == 1)
    {
        $labelcolor = '#00EEEE';
        $Eng = 1;
    }
    else
    {
        $labelcolor = 'CYAN';
        $Eng = 1;
    } 
    echo "<tr>
            <td bgcolor= $labelcolor><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[0]</td>
    <td bgcolor= $labelcolor><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[1]</td>
    <td bgcolor= $labelcolor><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[2]</td>
    <td bgcolor= $labelcolor>$batchrow[5]</td>";
    //ship date 
    //search batch number on bcsalestobatch
    $shipbatch = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE batch = '$batchrow[0]' ");
    $numshipbatch = mysqli_num_rows($shipbatch);

    // To prevent php warnings (2 lines added by rouhollah@gmail.com)
    $shipdate2 = "";
    $cust = '';

    if ($numshipbatch != 0)
    {
        $t=time();
        $shipdate = "2100-01-01"; 
        $shipdate2 = "";
        $actual_ship = 0;
        $late = 0;
        //echo " <td";    
        for ($ij = 0; $ij < $numshipbatch; ++$ij)
        {
            //for each entry get the date for the salesorder and item from bcsales order
            //when the ship date is null
            $shipbatchrow = mysqli_fetch_row($shipbatch);
            $itemdate = queryMysql($mysqli, "SELECT expectedshipdate, customer, actualshipdate FROM bcsalesorders 
            WHERE salesorder = '$shipbatchrow[0]' AND item = '$shipbatchrow[1]'");
            $numitemdate = mysqli_num_rows($itemdate);
            if ($numitemdate != 0)
            {
                for ($ik = 0; $ik < $numitemdate; ++$ik)
                {
                    $itemdaterow = mysqli_fetch_row($itemdate);
                    $cust = $itemdaterow[1];
                    $actual_ship = $itemdaterow[2];
                    //find the earliest date and post to table
                    if ($itemdaterow[0] < $shipdate && $itemdaterow[0] > 1)
                    {
                        $shipdate = $itemdaterow[0];
                        $cust = $itemdaterow[1];
                        $actual_ship = $itemdaterow[2];
                        $now = date('c');
                        $late = timeDiff($shipdate,$now);
                        //echo $late;
                    }
                
                }
            }
        
    
            if ($late >0 && $actual_ship == 0)
            {
                $labelcolor = 'salmon';
                $shipdate2 = $shipdate2 . $shipdate . "<BR />";
                
            }
            else if($late <0 && $actual_ship == 0)
            {
                $shipdate2 = $shipdate2 . $shipdate . "<BR />";
            }
            //else if ($shipdate == "2100-01-01")
            else if ($actual_ship != 0)
            {
                $shipdate2 = $shipdate2 . " Shipped on $shipdate <BR />";
                //echo " bgcolor= $labelcolor>$shipdate2 ";
            }
            //}
            else
            {
                $shipdate = '';
                $cust = '';
                //echo " bgcolor= $labelcolor>$shipdate";
            }
        }
        
        }
    echo "<td bgcolor= $labelcolor>".$shipdate2."</td>";
    //echo ' sign '.$cust.''.$actual_ship.'';
    echo "<td bgcolor= $labelcolor>$cust</td>";
    $lastop = 0;
    $lastopused = -1;
    $globallastopused = 0;
    $locallastopused = 0;
    $firstop = 0;
    $opused = 1;
    $thisop = 0;
    $numprod_opdata = 0;
    if ($batchrow[9] != 'Full')
    {
        $prod_opdata = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE Product_code = '$batchrow[1]' 
        AND build_type = '$batchrow[9]'");
        //get custom build if applicable
        $numprod_opdata = mysqli_num_rows($prod_opdata);
        $prod_opdatarow = mysqli_fetch_row($prod_opdata);
        
        for ($globalop = 0; $globalop < $opcount; ++$globalop)
        { //find first operation
            if (@$prod_opdatarow[$globalop+3] != '0')
            {
                $batcharray[$globalop] = $prod_opdatarow[$globalop+3];//local operations in order
                $lastlocalop =$prod_opdatarow[$globalop+3];
            } 
            else
            {
                $batcharray[$globalop] = 0;
            }
           // array_pad($lastlocalop,-26,0);
        }
       // print_r( $batcharray);
       // echo '<br>';
    }
    else
    {//what to do if it is a full build
        for ($globalop = 0; $globalop < $opcount; ++$globalop)
        {
            $batcharray[$globalop] = $globalop + 1;
        }
        //print_r($localoplist);
        //echo '<br>';
    }   
    //get totals for each operation and insert
    //echo $batchrow[0];
    $operations = queryMysql($mysqli, "SELECT * FROM bcoperations ORDER BY OpNo");
    $opcount = mysqli_num_rows($operations);
    //echo $opcount;
    $total_count = 0;
    if ($disp == 1)  
    {   
        for ($i = 0; $i < $opcount; ++$i)
        {
        
            $k = $i + 1;
            $oprow = mysqli_fetch_row($operations);
            $err = $oprow[4] - 100;
            if (@$oprow[4] == $dept || $err == $dept ||$dept == 0 ||$oprow[4] == 100 || ($dept >= 100 && $oprow[4] >=100))
            {
               // echo "$i, $oprow[4], $dept <br />";
                //for this operation and batch search operations done
                $opdata = queryMysql($mysqli, "SELECT quantitycomplete, end FROM bcoperationsdone WHERE batchno = '$batchrow[0]' 
                AND operation = '$k'");
                $numopdata = mysqli_num_rows($opdata);
                //echo $numopdata;
                $optotal = '';
                $open = 0;
                $workedon_in_24 = 0;
               // if ($numopdata != 0)
               // {
                    //only do the total loop if there is data returned
                    for ($a = 0; $a < $numopdata; ++$a)
                    {
                        $oprow = mysqli_fetch_row($opdata);
                        $optotal = $optotal + $oprow[0];
                        $yesterday = date('Y-m-d', strtotime('-1 day'));
                        if ($yesterday <= $oprow[1])
                        {
                            $workedon_in_24 = 1;
                        }
                        if ($oprow[1] == NULL)
                        {
                            $open = 1;
                        }
                    }
                    
                //}
                if (/*$dispop == 0 ||*/ $batcharray[$i] == 0 /*||$numlastop != $i-1*/ )
                {
                    if ($prev == 0)
                    {
                        echo "<td bgcolor='#FEF4AD'> </td>";
                    }
                    else
                    {
                        echo "<td bgcolor='#FEF5CA'> </td>";
                    }
                }
                else if ($optotal < 0)
                {
                    echo "<td bgcolor='salmon'> </td>";
                }
                else if ($batchrow[8]==3)
                {
                    echo "<td bgcolor='orange'>$optotal  </td>";
                }
                else if ($open ==1)
                {
                    echo "<td bgcolor='greenyellow'>$optotal  </td>";
                }
                else if ($workedon_in_24 ==1)
                {
                    echo "<td bgcolor='lightgreen'>$optotal  </td>";
                }
                
                else
                {
                    echo "<td bgcolor= $labelcolor >$optotal </td>";
                }
                
                $lastop = $optotal;
                $numlastop = $i;
                $opused = 1;
                //echo "<td>$optotal</td>";
            }
        }
    }
    echo "</tr>";
}}
echo "</table>";
echo '</ul>';

if ($disp == 1)
{
    echo <<<_END
    <form class = center name="Edit" action="bcbatches.php?disp=0" method="post">
    RETURN TO MAIN MENU   
    <input type="submit" name="Edit" value="RETURN" />
    </form>
_END;
}


?>


