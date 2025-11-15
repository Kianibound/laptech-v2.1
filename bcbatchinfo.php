<?php // bcbatchinfo.php
$batchinfo = 1;
include_once 'bcheader.php';
$batchinfo = 0;

if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];
$op = $Total_in_Batch = 0;
$Close = $hold = 0;

if (isset($_GET['Show']))
{$stat = ($_GET["Show"]);}


if (isset($_GET["view"]))
{
    $view = ($_GET["view"]);
    $_SESSION['batch'] = $view;
}

$batch = $_SESSION['batch'];
if (isset($_GET['op']))
    {$op = ($_GET["op"]);}

if (isset($_GET['Close']))
    {$Close = ($_GET["Close"]);}
    
if (isset($_GET['hold']))
    {$hold = ($_GET["hold"]);}

//echo $hold;
if ($Close == 1)
{
    $now = date('c');
    queryMysql($mysqli, "UPDATE bcbatchinfo SET completed = '$now', status = '2'
                 WHERE batchno = '$batch'");
}

if ($hold == 1)
{
    $now = date('c');
    queryMysql($mysqli, "UPDATE bcbatchinfo SET status = '3'
                 WHERE batchno = '$batch'");
}
if ($hold == 2)
{
    $now = date('c');
    queryMysql($mysqli, "UPDATE bcbatchinfo SET status = '1'
                 WHERE batchno = '$batch'");
}
//myWindow.document.write("<p>This is 'myWindow'</p>");
//myWindow.focus();

 $result4 = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno = '$batch' ORDER BY batchno");
    $num4 = mysqli_num_rows($result4);
    echo"<A name = '0'></A>    <table border='1'>
         <tr background = 'images/nav_bg.png'>
         <th background = 'images/nav_bg.png' >Batch #</th>
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
         <th>Assigned Sales Orders</th>
         <th>Assigned Works Orders</th>
         </tr>";

	// outputs the batch information
    // To prevent php warning, added by rouhollah@gmail.com
    $row4 = [];
    $Build_Type = '';
    $Product_code = '';
    $status = 0;

    for ($j = 0; $j < $num4; ++$j)
    {
        $row4 = mysqli_fetch_row($result4);
        echo "<tr>
            <td>$row4[0]</td>
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
                case 3:
                    echo "<td bgcolor='salmon'>ON HOLD</td>";    
                Break;
            }
            echo"<td>$row4[9]</td>
	    	 <td><a href='$row4[10]',target='_blank'>Link ($row4[10])</a></td>";
        $Product_code = $row4[1];
        $Build_Type = $row4[9];
        $qtyToBuild = $row4[3];
        $qtyadd = $row4[4];
        $status = $row4[8];
    }
    $assigned = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE batch = '$batch' ORDER BY salesorder");
    $numassigned = mysqli_num_rows($assigned);
    echo "<td>";
    for ($ki = 0; $ki < $numassigned; ++$ki)
    {
        $assignedrow = mysqli_fetch_row($assigned);
        //use assigned to call bcsalesorders and total the quantity assigned
        $order = $assignedrow[0];
        $item = $assignedrow[1];
        //output information on previously assigned batches
        echo "<a href='bcsalesview.php?item=$item&order=$order&Show=0'>$order item $item <br />";
        
    }
    echo "</td>";
    $assigned = queryMysql($mysqli, "SELECT * FROM bcworksordertobatch WHERE batch = '$batch' ORDER BY worksorder");
    $numassigned = mysqli_num_rows($assigned);
    for ($ki = 0; $ki <= $numassigned; ++$ki)
    {
        $assignedrow = mysqli_fetch_row($assigned);
        //use assigned to call bcsalesorders and total the quantity assigned
        $order = '';
        if($assignedrow != null && count($assignedrow) > 0) {
            $order = $assignedrow[0];
        }
        //output information on previously assigned batches
        echo "<td>$order</td>";
        
    }
    echo" </tr></table>";

    if (count($row4) > 11 && $row4[11] == 1)
    {
        echo "<h2> This batch requires close engineering support </h2>";
    } 
    

// sets up the table for information to do with operation progress within batch    

    echo"<br /><table border='1'>
         <tr>
         <th width = 3%>Op# (Local)</th>
         <th width = 3%>Op# (Global)</th><th></th>
         <th width = 20%>description</th><th></th>
         <th width = 15%>info</th>
         <th width = 3%>Completed</th>
         <th width = 3%>Scrapped</th>
         <th width = 3%>Available</th>
         <th width = 3%>Removed to stock/ rework</th>
         <th width = 3%>Moved from stock/ rework</th>
         <th width = 3%>Number In stock/ rework </th>
         <th width = 3%>In progress</th>
         <th width = 5%>Actual yield</th>
         <th width = 5%>Efficiency</th>
         </tr>";


// list operations then add details from operations carried out later.
$totallastop = -1;
$in_progress = "";
$to_stock = "";
$From_Stock ="";
$In_Stock = "";
$yield = "";
$efficiency = "";

// the code that sorts out the order of the operations and what operations are included
$order = 0;
$valid_number = 0;


// To prevent php warning, added by rouhollah@gmail.com
$opcount = 0;

if ($Build_Type == "Full")
{
    $oporderquery = queryMysql($mysqli, "Select OpNo From bcoperations ORDER BY OpNo");
    $opordercount = mysqli_num_rows($oporderquery);
    // this will require a change if adding or removing operations.
    $opcount = $opordercount;
    $oporder[0] = 1;
    $oporder[1] = 1;
    for ($i = 2; $i <= $opordercount; ++$i)
    {
        $oporder[$i] = $i - 1;
        //echo $oporder[$i];
    }
    //print_r($oporder);
    unset ($oporder[0]);
    unset ($oporder[1]);
    $arraytransfer = implode(",",$oporder);
    //echo $arraytransfer;
}
else
{
    $oporderquery = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE Product_code ='$Product_code' and Build_type ='$Build_Type'");
    $opordercount = mysqli_num_rows($oporderquery);
    for ($j = 0; $j < $opordercount; ++$j)
        {
            $oporder = mysqli_fetch_row($oporderquery);
            $opcount = count($oporder)-2;
        }
    for ($o = 0; $o < $opcount; ++$o)
        {
            if ($oporder[$o] != 0)
                {
                    ++$valid_number;
                }
        }
}
//echo '��'.$opcount.'��';
$Global_loop_counter = 0;

for ($f2 = 3; $f2 <= $opcount+1; ++$f2)
    {
        
        $oporder2 = mysqli_fetch_row($oporderquery);
        if ($oporder[$f2] != 0 || $Build_Type == "Full")
            {
                //echo '%'.$f2.'/'.$oporder[$f2].'%';
                if ($Build_Type == "Full")
                {
                    $operation_number = $oporder2[0];
                }
                else
                {
                    for ($c = 3; $c <= $opcount+1; ++$c)
                    {
                        if ($oporder[$c] == $Global_loop_counter + 1)
                        {
                            //echo "order $oporder[$c] global loop $Global_loop_counter c $c";
                            ++$order;
                            $operation_number = $c-2;
                            //$oparray[$order];
                            //echo "local op = $operation_number <br />";
                        }
                    }
                }
            if($Build_Type != 'Full')
            {
                $Local_loop_counter = $f2 - 1;
            }
            else
            {
                $Local_loop_counter = $f2 + 1;
            }
            $result2 = queryMysql($mysqli, "SELECT * FROM bcoperations WHERE OpNo ='$operation_number'");
            $num2 = mysqli_num_rows($result2);
            //echo '!'.$num2.'!';
            $labelcolor = 'WHITE';
    $Eng = 0;
    //echo $batchrow[11];
    if ($Global_loop_counter%2 == 1)
    {
        $labelcolor = '#E0FFEF';
        echo "<tr bgcolor = $labelcolor>";
    }
    else 
    {
        $labelcolor = 'WHITE';
        echo "<tr bgcolor = $labelcolor>";
    }
            
            $row2 = mysqli_fetch_row($result2);
            if ($Build_Type != 'Full')
            {
				$Global_loop_counter = $Global_loop_counter + 1;
                echo "<td><A name = $Global_loop_counter></A><a  href='bcbatchinfo.php?op=$row2[0]#$Global_loop_counter'>$Global_loop_counter</td>";
                $Glob_op = $Global_loop_counter;
            }
            else
            {
				$Global_loop_counter = $Global_loop_counter + 1;
                echo "<td><a href='bcbatchinfo.php?op=$row2[0]#$Global_loop_counter'>$row2[0]</td>";
                $Glob_op = $row2[0];
            }
            // echo $row2[0];
            
            echo "<td><a href='bcbatchinfo.php?op=$row2[0]#$Global_loop_counter'>$operation_number</td>";// global op no
            echo <<<_END
            <td>
_END;
            If ($status != 2 &&$status != 3 )
    {
        echo <<<_END
            <form method="post" action="StartOp.php?View=$batch"
            onSubmit="return validate(this)">
            <input type="hidden" maxlength="3"
            name="OpNo" value=$operation_number />
            <input type="hidden" maxlength="3"
            name="localOpNo" value=$Global_loop_counter>
            <input type="hidden" maxlength="32"
            name="Build_Type" value='$Build_Type'>
            <input type="hidden" maxlength="32"
            name="Product_code" value=$Product_code>
    
            <input type="submit" value="Start" />
            </form>
_END;
}
echo"</td>";

            echo "<td><a href='bcbatchinfo.php?op=$row2[0]#$Global_loop_counter'>$row2[1]</td>";
            echo'<td>';
            
    if ($Build_Type != 'Full')
    {
    unset ($oporder[0]);
    unset ($oporder[1]);
    //print_r($oporder);
    //echo $valid_number;
    $arraytransfer = implode(",",$oporder);
    //echo $arraytransfer;
    $Global_Op = $Global_loop_counter -1;
    //echo $operation_number;
    //echo ' '.$Glob_op.'';
    }

            If ($status != 2 &&$status != 3 )
            {
        echo <<<_END
            
           
    <form method="post" action="ToDoOp.php?View=$batch "
            onSubmit="return validate(this)">
             <input type="hidden" maxlength="3"
            name="OpNo2" value=$operation_number>
      <input type="hidden" name="Build_type" value='$Build_Type' />
      <input type="hidden" maxlength="3" name="globalopno" value=$Glob_op>
      <input type="hidden" name="oporderarray" value='$arraytransfer' />
      <input type="hidden" name="opordercount" value='$valid_number' />
 
            <input type="submit" value="Stop"/></form>
   
_END;
            }
            echo'</td>';
            echo "<td><a href='$row2[3]',target='_blank'>$row2[2]</a></td>";
            //get information about what has been don from bc operations doneand add here.
            //echo "local = $Local_loop_counter Global = $Global_loop_counter";
            $result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE operation = '$operation_number' AND batchno = '$batch'");
            $num = mysqli_num_rows($result);
            $totalcomplete = 0;
            $totalscrap = 0;
            $in_progress = "no";
            $to_stock = 0;
            $From_Stock = 0;
            
            for ($i = 0; $i < ($num); ++$i)
            {
                $row = mysqli_fetch_row($result);
                if ($row[5] != NULL){
                $totalcomplete = $totalcomplete + $row[5];}
                if ($row[6] != NULL){
                $totalscrap = $totalscrap + $row[6];}
                if ($row[8] == NULL) {
                $in_progress = "yes";}
                if ($row[9] != NULL){
                $to_stock = $to_stock + $row[9] ;}
                if ($row[10] != NULL){
                $From_Stock = $From_Stock + $row[10] ;}
            }
          
              $result3 = queryMysql($mysqli, "SELECT * FROM bcstock 
                    WHERE operation_number = '$operation_number ' AND product_code = '$row4[1]'");
                $In_Stock = 0;
                $num3 = mysqli_num_rows($result3);
               for ($i = 0; $i < ($num3); ++$i)
            {
                $row3 = mysqli_fetch_row($result3);
                if ($row3[0] != NULL){
                $In_Stock = $In_Stock + $row3[0] ;}
                
            }
            // sets how much is available
            if ($totallastop == -1){
                $available = $qtyToBuild - ($totalcomplete +$totalscrap +$to_stock - $From_Stock);}
            else{
                $available = $totallastop - ($totalcomplete +$totalscrap +$to_stock - $From_Stock);}
            if ($available < "0") echo "<h3>Not enough parts to complete expected quantity please add parts from stock<h3 />";
            $totallastop = $totalcomplete;
            
            // gets data from bcstock
            $result7 = queryMysql($mysqli, "SELECT * FROM bcstock 
            WHERE operation_number = '$Local_loop_counter' AND product_code = '$row4[1]' AND batchno = '$row4[0]'");
            $num7 = mysqli_num_rows($result7);
            $to_stock = 0;        
            for ($i = 0; $i < ($num7); ++$i)
            {
                $row7 = mysqli_fetch_row($result7);
                
              //  if ($row3[6] == $row4[0] && $row3[3] == $row2[0])
              //  {
              //  $available = $available - $row7[0];
                
                //$to_stock = $to_stock + $row7[0];
               // }
                
            }
            // gets data from the database bcstocklog
            $result8 = queryMysql($mysqli, "SELECT * FROM bcstocklog
            WHERE operation_number = '$operation_number' AND product_code = '$row4[1]' AND batchno = '$row4[0]'");
            $num8 = mysqli_num_rows($result8);
            $From_Stock = 0;        
            for ($i = 0; $i < ($num8); ++$i)
            {
                
                $row8 = mysqli_fetch_row($result8);

            
               /* if ($row8[6] == "In" && $row8[7] == $row4[0])
                {
                    $available = $available - $row8[0];
                }*/
                
                if ($row8[1]/*product code stocklog*/ == $row4[1]/*product code batch info */ 
                            && $row8[2]/*Operation number stck log */ == $operation_number/*Op No bcoperations */
                            && $row8[7] == $row4[0] && $row8[6] == "In")
                {
                //$available = $available - $row8[0];          
                        }
                 if ($row8[1]/*product code stocklog*/ == $row4[1]/*product code batch info */ 
                && $row8[2]/*Operation number stck log */ == $operation_number/*Op No bcoperations */)
                {
                        if ($row8[6] == "Out")
                        {
                            $From_Stock = $From_Stock + $row8[0];
                             $available = $available + $row8[0];
                        }
                         if ($row8[6] == "In")
                        {
                            $to_stock = $to_stock + $row8[0];
                             $available = $available - $row8[0];
                        }	    
                        //echo "op $operation_number av $available to $to_stock from $From_Stock";
                }
            }
            $Total_in_Batch = $row4[3] + $From_Stock + $Total_in_Batch;
            If ($Total_in_Batch != 0) 
            {
                $yield = ($totalscrap / $Total_in_Batch) * 100 ;
                $yield = 100 - $yield  ;
            }
            else
            {
                $yield = 100;
            }
            
            if ($totalscrap + $to_stock != 0)
            {
            $efficiency = $totalcomplete/ ($totalcomplete + $totalscrap + $to_stock) * 100;
            }
            else
            {
            $efficiency = 100;
            }
            if ($totalcomplete >= 0)
            {echo "<td>$totalcomplete</td>";}
            else
            {echo "<td bgcolor='salmon'>$totalcomplete</td>";}
            if ($totalscrap >= 0)
            {echo "<td>$totalscrap</td>";}
            else
            {echo "<td bgcolor='salmon'>$totalscrap</td>";}
            if ($available >= 0)
            {echo "<td>$available</td>";}
            else
            {echo "<td bgcolor='salmon'>$available</td>";}
            echo "<td>$to_stock</td>";
            echo "<td>$From_Stock</td>";
            echo "<td>$In_Stock</td>";
            echo "<td>$in_progress</td>";
            echo "<td>".number_format($yield,2)." %</td>";
            echo "<td>".number_format($efficiency,2)." %</td>";
            echo "</tr>";
            // I want to hide the stuff below unless the link is pressed 
            // and add a button so I can hide it again
            if ($row2[0] == $op)
            {
                 If ($status != 2 &&$status != 3 )
    {
echo <<<_END
    </table>
    <table class = "floatleft" border="0" cellpadding="2"
            cellspacing="5" bgcolor="#eeeeee">
    <th colspan="2" align="center">Start Operation</th>
    <form method="post" action="StartOp.php?View=$batch"
            onSubmit="return validate(this)">
             <tr><td>Operation (Global)</td><td><input type="text" maxlength="3"
            name="OpNo" value=$op /></td>
            <input type="hidden" maxlength="3"
            name="localOpNo" value=$Global_loop_counter></td>
            <input type="hidden" maxlength="32"
            name="Build_Type" value='$Build_Type'></td>
            <input type="hidden" maxlength="32"
            name="Product_code" value=$Product_code></td>
    </tr><tr><td colspan="2" align="center">
            <input type="submit" value="Go" /></td>
    </tr></form></table>

_END;
    if ($Build_Type != 'Full')
    {
    unset ($oporder[0]);
    unset ($oporder[1]);
    unset ($oporder[2]);
    //print_r($oporder);
    //echo $valid_number;
    $arraytransfer = implode(",",$oporder);
    //echo $arraytransfer;
    }
    if ($Build_Type == "Full")
    {
echo <<<_END
    <table class="floatleft" border="0" cellpadding="2"
            cellspacing="5" bgcolor="#eeeeee">
    <th colspan="2" align="center">End Operation</th>
    <form method="post" action="DoOp.php?View='$batch'"
            onSubmit="return validate(this)">
             <tr><td>Operation (Global)</td><td><input type="text" maxlength="3"
            name="OpNo" value=$op></td>
    </tr><tr><td>Quantity Completed</td><td><input type="text" maxlength="16"
            name="Quantity" /></td>
    </tr><tr><td>Quantity Scrapped</td><td><input type="text" maxlength="16"
            name="Scrapped" /></td>
    </tr><tr><td>comments</td><td><input type="text" maxlength="128"
            name="Comments" /></td>
    <input type="hidden" name="Build_type" value='$Build_Type' />
    </tr><tr><td colspan="2" align="center">
            <input type="submit" value="Go" /></td>
    </tr></form></table>

_END;
    }
    else
    {
    echo <<<_END
    <table class="floatleft" border="0" cellpadding="2"
            cellspacing="5" bgcolor="#eeeeee">
    <th colspan="2" align="center">End Operation</th>
    <form method="post" action="DoOp.php?View=$batch"
            onSubmit="return validate(this)">
    <tr><td>Operation Number (Local)</td><td><input type="text" maxlength="3"
            name="OpNo" value=$Global_loop_counter></td>
    <input type="hidden" maxlength="3"
            name="globalopno" value=$op></td>
    </tr><tr><td>Quantity Completed</td><td><input type="text" maxlength="16"
            name="Quantity" /></td>
    </tr><tr><td>Quantity Scrapped</td><td><input type="text" maxlength="16"
            name="Scrapped" /></td>
    </tr><tr><td>comments</td><td><input type="text" maxlength="128"
            name="Comments" /></td>
    <input type="hidden" name="oporderarray" value='$arraytransfer' />
    <input type="hidden" name="opordercount" value='$valid_number' />
    </tr><tr><td colspan="2" align="center">
            <input type="submit" value="Go" /></td>
    </tr></form></table>

_END;
    }
    echo <<<_END

    <table class = "floatleft" border="0" cellpadding="2"
            cellspacing="5" bgcolor="#eeeeee">
    <th colspan="2" align="center">Transfer to Stock/rework</th>
    <form method="post" action="bcmccomfirm.php"
            onSubmit="return validate(this)">
    </tr><tr><td>Operation (Global)</td><td><input type="text" maxlength="16"
            name="OpNo" value=$op /></td>
    </tr><tr><td>Quantity to move to stock</td><td><input type="text" maxlength="16"
            name="Into_Stock" /></td>
    </tr><tr><td>New Location</td><td><input type="text" maxlength="50"
            name="Location" /></td>
    </tr><tr><td>Notes (for items being moved to stock)</td><td><input type="text" maxlength="150"
            name="Notes" /></td>
    </tr><tr><td colspan="2" align="center">
            <input type="submit" value="Go" /></td>
    <input type="hidden" name="Product_code" value='$Product_code' />
    <input type="hidden" name="available" value='$available' />
    <input type="hidden" name="batchno" value='$batch' />
    </tr></form></table>


_END;

    }
    else if ($status == 3)
    {
        echo "<H1h>This batch is on HOLD No operations can be carried out<H1h><br />";
    }
    else 
    {

        echo "<H2>This batch is closed No operations can be carried out<H2><br />";
    }
                $result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone 
                            WHERE batchno = '$batch' AND operation = '$op' ORDER BY starttime");
                $num = mysqli_num_rows($result);
                echo"   <table class = floatleft border='4'>
                        <tr>
                        <th>Staff #</th>
                        <th>Username</th>
                        <th>Start date/time</th>
                        <th>End date/time</th>
                        <th>Quantity</th>
                        <th># Scrapped</th>
                        <th>Comments</th>
                        </tr>";
                for ($ki = 0; $ki < $num; ++$ki)
                {
                    $row = mysqli_fetch_row($result);
                echo"   <tr>
                        <td> ".$row[2]." </td>
                        <td> ".username($mysqli, $row[2])."</td>
                        <td> ".$row[7]."</td>
                        <td> ".$row[8]."</td>
                        <td> ".$row[5]."</td>
                        <td> ".$row[6]."</td>
                        <td> ".$row[11]."</td>
                        </tr>";
                }
                if ($Local_loop_counter != $num2 || $Local_loop_counter == 1)
                {
                echo" </table>";
                echo" <table class = tablefloatleft border='1'>
                 <tr>
                 <th width = 4%>Op# (Local)</th>
                 <th width = 4%>Op# (Global)</th>
                 <th></th>
                 <th width = 28%>description</th>
                 <th></th>
                 <th width = 28%>info</th>
                 <th width = 4%>Completed</th>
                 <th width = 4%>Scrapped</th>
                 <th width = 4%>Available</th>
                 <th width = 4%>Removed to stock/rework</th>
                 <th width = 4%>Moved from stock/rework</th>
                 <th width = 4%>Number In Stock/rework </th>
                 <th width = 4%>In progress</th>
                 <th width = 4%>Actual yield</th>
                 <th width = 4%>Efficiency</th>
                 </tr>";
                 }
                echo "<form name='input' action='bcbatchinfo.php' method='get'>
                    <input type='submit' value='Hide' />
                    </form>";
                
            }
  }
}

    echo "</table></li><br />";
// send batch number to remove operation and return
// list operations, applicable documents and work carried out

 If ($status != 2 && $status != 3)
{/*
echo <<<_END

<form class = floatleft name="close" action="bccloseconfirm.php?Close=1" method="post">
Close this batch. Note all operations will be locked after this action.
<input type="submit" name="close" value='$batch' />
</form>

<form class = floatleft name="hold" action="bcholdconfirm.php?Hold=2" method="post">
Put This Batch on HOLD. Note all operations will be locked after this action.
<input type="submit" name="hold" value='$batch' />
</form>
_END;*/
$_SESSION['Hold'] = 2;
}
else if ($status == 3) 
{
/*
echo "</br><H3>This batch is ON HOLD</H3><br />";
echo <<<_END
<form class = floatleft name="hold" action="bcholdconfirm.php?Hold=3" method="post">
release this batch from HOLD.
<input type="submit" name="hold" value='$batch' />
</form>
_END;*/
$_SESSION['Hold'] = 3;
}
else 
{

    echo "<H2>This batch is closed No operations can be carried out</H2><br />";
}/*
echo <<<_END
<form class = floatleft name="Assign" method="post" action="bcbatchtoworksorder.php">
Assign this batch to a Works order.
<input type="submit" name = "Assign" value = '$batch'>
</form>

<form class = floatleft name="Assign" method="post" action="bcbatchtoorder.php">
Assign this batch to a Sales order.
<input type="submit" name = "Assign" value = '$batch'>
</form> 

<form class = floatleft name="Feedback" method="post" action="bcworkdonebatch.php">
View and search work carried out on this batch.
<input type="submit" name = "batch" value = '$batch'>
</form> 
_END;
echo <<<_END

<form class = floatright name="Edit" action="bceditbatch.php?" method="post">
Press here to edit the batch information
<input type="submit" name="Edit" value="$batch" />
</form>

_END;*/


?>
