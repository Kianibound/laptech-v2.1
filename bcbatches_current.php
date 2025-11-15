<?php // bcmembers.php
include_once 'bcheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You must be logged in to view this page");
$user = $_SESSION['user'];
$Start = $Stop = $Comment = 0;
$stat = 3;
if (isset($_GET['Show']))
{$stat = ($_GET["Show"]);}
else {$stat = 1;}
if (isset($_GET['Stop']))
{$Stop = 1;}
if (isset($_GET['Start']))
{$Start = 1;}
if (isset($_GET['Comment']))
{$Comment = ($_GET["Comment"]);
$Start =1;}

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
            echo"<td> $oprow[0]</td>";
            echo"<td> $oprow[1]</td></tr>";
            ++$total_count;
        }
        echo "</table>"; 
    }
    while ($total_count <= $opcount); 

$result = queryMysql($mysqli, "SELECT * FROM bcbatchinfo ORDER BY batchno");
$num = mysqli_num_rows($result);
echo "</ul ><h3>Batches</h3><ul>";

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
}

if ($Stop == 1)
{
     $now = date('c');
     queryMysql($mysqli, "UPDATE bcoperationsdone SET end = '$now' WHERE batchno = 'NULL' AND operation = 'NULL'
                AND staffnumber = '$Staffno' AND start IS NOT NULL AND end IS NULL");
}
   
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
        echo '<form name="input" action="bcbatches.php?" method="get">
        Stop a task NOT associated with a batch
        <input type="Submit" value="Stop" name="Stop"/>
        </form>';
    }
else
    {
        echo'<form name="input" action="bcbatches.php?" method="get">
        start a task NOT associated with a batch and enter any comments here <br /> 
        <input type="uncontrolled_text" name="Comment" size = "75"/>
        <input type="Submit" value="Start" size="500"  />
        </form>';
    }
echo <<<_END

<form name="input" action="bcbatchinfo.php?" method="get">
Enter Batch Number: <input type="text" name="view" />
<input type="submit" value="Submit" />
</form>

<form action=""bcmembers.php" method="GET">
<select name="Show">
<option value="3" $select3>All Batches </option>
<option value="1" $select1>Open Batches</option>
<option value="2" $select2> Closed Batches</option>
<option value="0" $select0>Unstarted Batches</option>
</select>
<input type="submit"  value="submit" />
</form>

_END;




$operations = queryMysql($mysqli, "SELECT * FROM bcoperations ORDER BY OpNo");
    $opcount = mysqli_num_rows($operations);
//set up table headings
    echo"<table class= tablefloatleft border='1'>
         <tr>
         <th>Batch #</th>
         <th>Product Code</th>
         <th>Description</th>
         <th>Qty Expected</th>
         <th>Ship Date</th>";
         
    for ($j = 0; $j < $opcount; ++$j)
    {
        $oprow = mysqli_fetch_row($operations);
        echo"<th width='1' >op# $oprow[0]</th>";
    }
    echo "</tr>";
    
If ($stat != 3 )
{ 
    $batchdata = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE status = '$stat' ORDER BY batchno");
}
else
{
    $batchdata = queryMysql($mysqli, "SELECT * FROM bcbatchinfo ORDER BY batchno");
}
$numbatch = mysqli_num_rows($batchdata);

for ($j = 0; $j < $numbatch; ++$j)
{
    $batchrow = mysqli_fetch_row($batchdata);
    echo "<tr>
            <td><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[0]</td>
    <td><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[1]</td>
    <td><a href='bcbatchinfo.php?view=$batchrow[0]'>$batchrow[2]</td>
    <td>$batchrow[5]</td>";
    //ship date 
    //search batch number on bcsalestobatch
    $shipbatch = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE batch = '$batchrow[0]' ");
    $numshipbatch = mysqli_num_rows($shipbatch);
    if ($numshipbatch != 0)
    {
        $t=time();
        $shipdate = "2100-01-01"; 
        for ($ij = 0; $ij < $numshipbatch; ++$ij)
        {
            //for each entry get the date for the salesorder and item from bcsales order
            //when the ship date is null
            $shipbatchrow = mysqli_fetch_row($shipbatch);
            $itemdate = queryMysql($mysqli, "SELECT expectedshipdate FROM bcsalesorders 
            WHERE salesorder = '$shipbatchrow[0]' AND item = '$shipbatchrow[1]' AND actualshipdate IS NULL");
            $numitemdate = mysqli_num_rows($itemdate);
            if ($numitemdate != 0)
            {
                for ($ik = 0; $ik < $numshipbatch; ++$ik)
                {
                    $itemdaterow = mysqli_fetch_row($itemdate);
                
                    //find the earliest date and post to table
                    if ($itemdaterow[0] < $shipdate)
                    {
                        $shipdate = $itemdaterow[0];
                    }
                }
            }
        }
        if ($shipdate == "2100-01-01")
        {
            $shipdate = "Shipped";
        }
    }
    else
    {
        $shipdate = '';
    }
    echo "<td>$shipdate</td>";
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
    for ($i = 0; $i < $opcount; ++$i)
    {
        $k = $i + 1;
        //for this operation and batch search operations done
        $opdata = queryMysql($mysqli, "SELECT quantitycomplete FROM bcoperationsdone WHERE batchno = '$batchrow[0]' 
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
            echo "<td bgcolor='wheat'> </td>";
        }
        else
        {
            echo "<td >$optotal</td>";
        }
        
        $lastop = $optotal;
        $numlastop = $i;
        $opused = 1;
        //echo "<td>$optotal</td>";
    }
        
    echo "</tr>";
}

echo '</ul>';

?>


