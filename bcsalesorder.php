<?php // bcsalesorder.php
include_once 'bcheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

$inputdata = 1;

if (isset($_GET["date"]))
{
    $req_date = ($_GET["date"]);
}
else 
{
    $req_date = date('Y-m-d');
}
$Order=$item=$Quantity=$Productcode=$Customer=$Description=$requested_ship_date=$expected=$showitem = 0;


if (isset($_GET["Order"]))
{
    $Order = ($_GET["Order"]);
}
if (isset($_POST["split"]))
{
    $split = ($_POST["split"]);
}
else
{
    $split = 0;
}

if (isset($_POST["item"]))
{
    $item = ($_POST["item"]);
    if ($item == 0){
    $inputdata = 0;}
}
if (isset($_POST["Quantity"]))
{
    $Quantity = ($_POST["Quantity"]);
}
if (isset($_POST["Productcode"]))
{
    $Productcode = ($_POST["Productcode"]);
}
if (isset($_POST["Customer"]))
{
    $Customer = ($_POST["Customer"]);
}
if (isset($_POST["Description"]))
{
    $Description = ($_POST["Description"]);
    $add_requested_ship_date = (isset($_POST["add_req_ship_date"]) ? $_POST["add_req_ship_date"] : "");
    $change_requested_ship_date = (isset($_POST["change_req_ship_date"]) ? $_POST["change_req_ship_date"] : "");
    $split_requested_ship_date = (isset($_POST["split_req_ship_date"]) ? $_POST["split_req_ship_date"] : "");
    $new_item_req = (isset($_POST["new_item_req"]) ? $_POST["new_item_req"] : "");
    $new_item_expected = (isset($_POST["new_item_expected"]) ? $_POST["new_item_expected"] : "");
}
if (isset($_POST["add_expected"]))
{
    $add_expected = date($_POST["add_expected"]);
}

if (isset($_POST["change_expected"]))
{
   $change_expected = date($_POST["change_expected"]);
}

if (isset($_POST["split_expected"]))
{
  $split_expected = date($_POST["split_expected"]);
}
$row = 0;

//echo $split; echo $item;

If ($item != 0)//a dataset to input has been set
{
    if($item == -1)
    {
        $result = queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE salesorder = '$Order' ORDER BY item");
        $num = mysqli_num_rows($result);
         for ($ki = 0; $ki < $num; ++$ki)
                {
                    $row = mysqli_fetch_row($result);
                }
        $item = $row[1]+1;
        $now = date('c');
        queryMysql($mysqli, "INSERT INTO bcsalesorders(salesorder,item,quantity,productcode,
                customer,description,requestedshipdate,expectedshipdate, 
                actualshipdate,comments,Op_entered,Date_Entered) VALUES ('$Order','$item','$Quantity','$Productcode',
                '$Customer','$Description','$add_requested_ship_date','$add_expected',NULL,NULL,'$user','$now')");
    }
    else if ($split == 1)//tell page it is doing a split
    {   //get all the entries from the database for the item to be split
        $result = queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE salesorder = '$Order' ORDER BY item");
        $num = mysqli_num_rows($result);
        $kj = 0;
         for ($ki = 0; $ki < $num; ++$ki)
                {
                    $row = mysqli_fetch_row($result);
                    //echo "!!$row[1]"; echo "%%$item"; 
                    if ($row[1] == $item)
                    {
                        //echo "��$row[2]";
                        $split_Quantity = $row[2] - $Quantity;
                        //check for associated batches
                        $sales_batch = queryMysql($mysqli, "SELECT batch FROM bcsalestobatch WHERE salesorder = '$Order' AND item = '$item'");
                        $kj = 0;
                        while($row_sales_batch=mysqli_fetch_array($sales_batch))
                        {
                        ++$kj;
                        $batch[$kj]=$row_sales_batch['batch'];
                        echo "come on". $row_sales_batch['batch']."and ".$kj."? so ".$batch[$kj]."";
                        }
                    }
                }
        //subtract the quantity to be moved and check that 1 or more remains in the existing item
        
        //update the existing item with teh new total and the new datews passed        
        queryMysql($mysqli, "UPDATE bcsalesorders SET quantity = '$split_Quantity', productcode = '$Productcode',
                customer = '$Customer', description = '$Description', requestedshipdate = '$split_requested_ship_date',
                expectedshipdate = '$split_expected' WHERE salesorder = '$Order' AND item = '$item'");
        //find the next new item number for this order
        $item = $row[1]+1;
        $now = date('c');
        //insert the new item
        queryMysql($mysqli, "INSERT INTO bcsalesorders(salesorder,item,quantity,productcode,
                customer,description,requestedshipdate,expectedshipdate, 
                actualshipdate,comments,Op_entered,Date_Entered) VALUES ('$Order','$item','$Quantity','$Productcode',
                '$Customer','$Description','$new_item_req','$new_item_expected',NULL,NULL,'$user','$now')");
        //associate new item with the same batches as the old item
        echo "this is $kj";
        if ($kj != 0)
        {
            echo "this is $kj";
            for ($kl = 0; $kl < $kj; ++$kl)
            {
                echo "this is $kj";
                echo "!$kj%$kl&".$batch[$kl+1]."";
                $kk = $kl +1;
                queryMysql($mysqli, "INSERT INTO bcsalestobatch VALUES('$Order',
                                       '$item', '$batch[$kk]',NULL)");
            }
        }
    }   
    
    
    
    
    
    else
    {
        queryMysql($mysqli, "UPDATE bcsalesorders SET quantity = '$Quantity', productcode = '$Productcode',
                customer = '$Customer', description = '$Description', requestedshipdate = '$change_requested_ship_date',
                expectedshipdate = '$change_expected' WHERE salesorder = '$Order' AND item = '$item'");
    }
}

echo "<br /><br />Sales Order #.<h3> $Order</h3>"; 
$result = queryMysql($mysqli, "SELECT DISTINCT salesorder FROM bcsalesorders ORDER BY salesorder");
$num = mysqli_num_rows($result);
for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                if ($row[0] == $Order)
                    {$showitem = 1;}
            }                  
//if not new show order details and give next new item# and show change options
//then add item
    //
    //


if ($showitem != 0)
{
    $result = queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE salesorder = '$Order' ORDER BY item");
    $num = mysqli_num_rows($result);
    echo"   <table class=tablefloatleft border='4'>
                    <tr>
                    <th>Item #</th>
                    <th>Quantity</th>
                    <th>Product Code</th>
                    <th>Description</th>
                    <th>Date expected at Customer</th>
                    <th>Date expected to ship</th>
                    <th>Actual ship date</th>
                    <th>Comments</th>
                    </tr>";
            for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                                                                
            echo "
                    <tr>
                    <td> ".$row[1]."</td>
                    <td> ".$row[2]."</td>
                    <td> ".$row[3]."</td>
                    <td> ".$row[5]."</td>
                    <td> ".$row[6]."</td>
                    <td> ".$row[7]."</td>
                    <td> ".$row[8]."</td>
                    <td> ".$row[9]."</td>
                    </tr>
                    ";
            }
            $nextItem = $row[1]+1;
            $customer = $row[4];
            echo "Customer.<h3> $customer </H3>";
}
else
{
    $nextItem = 1;
}


                    
                        //show add item and change item boxes
echo '
<table class="floatleft" border="0" cellpadding="2"
cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Add Item</th>
<form method="post" action="bcsalesorder.php?Order='.$Order.'">
</tr><tr><td>Quantity</td><td><input type="text" maxlength="16"
        name="Quantity" /></td>
</tr><tr><td>Product code</td><td><input type="text" maxlength="16"
        name="Productcode" /></td>
</tr><tr><td>Customer</td><td><input type="text" maxlength="128"
        name="Customer" value="'.$Customer.'" /></td>
</tr><tr><td>Description</td><td><input type="text" maxlength="128"
        name="Description" /></td>
</tr><tr><td>requested ship date</td><td>';rfxlinecalendar('add_req_ship_date');
echo'</td>
</tr><tr><td>Expected ship date</td><td>';rfxlinecalendar('add_expected');
echo'</td>
<input type="hidden" name="Order" value='.$Order.' />
<input type="hidden" name="item" value= -1 />        
</tr><tr><td colspan="2" align="center">
        <input type="submit" value="Go" />
</tr></form></table>';

echo '
<form name="input" action = "bcsalesview.php" method="get">
<input type="submit" value="Return to previous page" />
</form>
';
/*</tr><tr><td>Date requested at Customer</td><td><input type="text" maxlength="128"
        name="req_ship_date"  /></td>
</tr><tr><td>Expected ship date</td><td><input type="text" maxlength="128"
        name="expected" /></td>*/
?>