<?php // bcreturn.php
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
if (isset($_POST["Order"]))
{
    $Order = ($_POST["Order"]);
}
//echo $Order;
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
    $Contact = (isset($_POST["Contact"]) ? $_POST["Contact"] : "");
    $Phone = (isset($_POST["Phone"]) ? $_POST["Phone"] : "");
    $Ref = (isset($_POST["Ref"]) ? $_POST["Ref"] : "");
    $Reason = (isset($_POST["Reason"]) ? $_POST["Reason"] : "");
    $Requests = (isset($_POST["Requests"]) ? $_POST["Requests"] : "");
    $Assigned = (isset($_POST["Assigned"]) ? $_POST["Assigned"] : "");
    $Priority = (isset($_POST["Priority"]) ? $_POST["Priority"] : "");
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
//echo $item;
//ECHO $Order;
If ($item != 0)//a dataset to input has been set
{
    if($item == -1)
    {
        $result = queryMysql($mysqli, "SELECT * FROM bcreturns WHERE `return` = '$Order' ORDER BY `item`");
        $num = mysqli_num_rows($result);
         for ($ki = 0; $ki < $num; ++$ki)
                {
                    $row = mysqli_fetch_row($result);
                }
        $item = $row[1]+1;
        //echo "num = $num item = $item";
        $now = date('c');
        queryMysql($mysqli, "INSERT INTO `bcreturns`(`return`, `item`, `quantity`, `productcode`, `customer`, `description`, `date_opened`, `date_recieved`
            , `date_closed`, `comments`, `Op_Entered`, `Date_Entered`, `Priority`,`Contact`,`Phone`,`Ref`,`Reason`,`Requests`,`Assigned`) 
                 VALUES ('$Order','$item','$Quantity','$Productcode','$Customer','$Description','$add_requested_ship_date',NULL,NULL,NULL,
                 '$user','$now',$Priority,'$Contact','$Phone','$Ref','$Reason','$Requests','$Assigned')");
    }
    else if ($split == 1)//tell page it is doing a split
    {   //get all the entries from the database for the item to be split
        $result = queryMysql($mysqli, "SELECT * FROM bcreturns WHERE return = '$Order' ORDER BY item");
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
                        $sales_batch = queryMysql($mysqli, "SELECT batch FROM bcsalestobatch WHERE return = '$Order' AND item = '$item'");
                        $kj = 0;
                        while($row_sales_batch=mysqli_fetch_array($sales_batch))
                        {
                        ++$kj;
                        $batch[$kj]=$row_sales_batch['batch'];
                        //echo "come on". $row_sales_batch['batch']."and ".$kj."? so ".$batch[$kj]."";
                        }
                    }
                }
        //subtract the quantity to be moved and check that 1 or more remains in the existing item
        
        //update the existing item with teh new total and the new datews passed        
        queryMysql($mysqli, "UPDATE bcreturns SET quantity = '$split_Quantity', productcode = '$Productcode',
                customer = '$Customer', description = '$Description', requestedshipdate = '$split_requested_ship_date',
                expectedshipdate = '$split_expected' WHERE return = '$Order' AND item = '$item'");
        //find the next new item number for this order
        $item = $row[1]+1;
        $now = date('c');
        //insert the new item
        queryMysql($mysqli, "INSERT INTO bcreturns(return,item,quantity,productcode,
                customer,description,requestedshipdate,expectedshipdate, 
                actualshipdate,comments,Op_entered,Date_Entered) VALUES ('$Order','$item','$Quantity','$Productcode',
                '$Customer','$Description','$new_item_req','$new_item_expected',NULL,NULL,'$user','$now')");
        //associate new item with the same batches as the old item
        //echo "this is $kj";
        if ($kj != 0)
        {
            //echo "this is $kj";
            for ($kl = 0; $kl < $kj; ++$kl)
            {
                //echo "this is $kj";
                //echo "!$kj%$kl&".$batch[$kl+1]."";
                $kk = $kl +1;
                queryMysql($mysqli, "INSERT INTO bcsalestobatch VALUES('$Order',
                                       '$item', '$batch[$kk]',NULL)");
            }
        }
    }   
    
    
    
    
    
    else
    {
        queryMysql($mysqli, "UPDATE `bcreturns` SET `quantity` = '$Quantity', `productcode` = '$Productcode',
                `customer` = '$Customer', `description` = '$Description', `Date_entered` = '$change_requested_ship_date',
                `date_recieved` = '$change_expected' WHERE `return` = '$Order' AND `item` = '$item'");
    }
}

//echo "<br /><br />Return #.<h3> $Order</h3>"; 
$result = queryMysql($mysqli, "SELECT DISTINCT 'return' FROM bcreturns WHERE `return` = '$Order' ORDER BY 'return'");
$num = mysqli_num_rows($result);
$showitem = 0;
if ($num != 0)
{
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                echo "Order = $Order <br />Row[0] = $row[0]<br />";
                $showitem = 1;
                if ($row[0] == $Order)
               
                    {$showitem = 1;}
            }                  
}
else
{
    $showitem = 0;
}
//if not new show order details and give next new item# and show change options
//then add item
    //
    //

//echo $showitem;
if ($showitem != 0)
{
    $result = queryMysql($mysqli, "SELECT * FROM bcreturns WHERE `return` = '$Order' ORDER BY `item`");
    $num = mysqli_num_rows($result);
    echo "num = $num<br />";
    echo"   <table class=tablefloatleft border='4'>
                    <tr>
                    <th>Item #</th>
                    <th>Quantity</th>
                    <th>Product Code</th>
                    <th>Description</th>
                    <th>Date reported by Customer</th>
                    <th>Date recieved from Customer ship</th>
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
            //echo "Customer.<h3> $customer </H3>";
}
else
{
    $nextItem = 1;
    $last_return = queryMysql($mysqli, "SELECT MAX(`return`) FROM bcreturns");
    $last_ret = mysqli_fetch_row($last_return);
    //echo "last DFN = $last_ret[0]";
    $Order = $last_ret[0] + 1;
}


                    
                        //show add item and change item boxes
echo '
<table class="floatleft" border="0" cellpadding="2"
cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Add Item '.$nextItem.'</th>
<form method="post" action="bcreturn.php?">
<tr><td>DFN number</td><td><input type="text" maxlength="16" name ="Order" value = '.$Order.' /></td>
</tr><tr><td>Quantity</td><td><input type="text" maxlength="16"
        name="Quantity" /></td>
</tr><tr><td>Product code</td><td><input type="text" maxlength="16"
        name="Productcode" /></td>
</tr><tr><td>Customer</td><td><input type="text" maxlength="128"
        name="Customer" value="'.$Customer.'" /></td>
</tr><tr><td>Description</td><td><input type="text" maxlength="128"
        name="Description" /></td>
</tr><tr><td>Contact Name</td><td><input type="text" maxlength="128"
        name="Contact" /></td>
</tr><tr><td>Telephone</td><td><input type="text" maxlength="128"
        name="Phone" /></td>
</tr><tr><td>Customer reference</td><td><input type="text" maxlength="128"
        name="Ref" /></td>
</tr><tr><td>Reason Given for Returns</td><td><input type="text" maxlength="128"
        name="Reason" /></td>
</tr><tr><td>Requests </td><td><select name="Requests">
    <option value="1" $select1>Repair/Replacement</option>
    <option value="2" $select2>Debit</option>
    <option value="3" $select3>Repair/Replacement and Report Required</option>
    <option value="4" $select4>Debit and Report Required</option>
    </select></td>
</tr><tr><td>Engineer assigned</td><td><input type="text" maxlength="128"
        name="Assigned" /></td>
</tr><tr><td>Date reported</td><td>';rfxlinecalendar('add_req_ship_date');
echo'</td>
</tr><tr><td>Priority</td><td><select name="Priority">
    <option value="1" $select1>HIGH</option>
    <option value="2" $select2>Medium</option>
    <option value="3" $select3>low</option>
    </select></td>

<input type="hidden" name="item" value= -1 />        
</tr><tr><td colspan="2" align="center">
        <input type="submit" value="Go" />
</tr></form></table>';

echo '
<form name="input" action = "bcreturnsview.php" method="get">
<input type="submit" value="Return to previous page" />
</form>
';
/*</tr><tr><td>Date requested at Customer</td><td><input type="text" maxlength="128"
        name="req_ship_date"  /></td>
</tr><tr><td>Expected ship date</td><td><input type="text" maxlength="128"
        name="expected" /></td>*/
?>