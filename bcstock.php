<?php // bcstock.php

//include 'jCombo.js';
echo <<<_END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(".batchno").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "ajax_city_MC.php",
data: dataString,
cache: false,
success: function(html)
{
$(".OpNo").html(html);
} 
});

});
});

</script>
</head>
<body>
_END;
//include_once('db.php');
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br><br>You need to login to view this page");

if (isset($_GET['Arrange']))
    {$Arrange = ($_GET["Arrange"]);}
else $Arrange = 'Stock_Id';        
                        
if (isset($_GET['ID']))
    {$ID = ($_GET["ID"]);}
else $ID = 0;

if (isset($_GET['Search']))
    {$Search = ($_GET["Search"]);}
else $Search = '';

echo <<<_END
<br>
<form class = floatleft name="input" action="bcstock.php?" method="get">
<b> Search</b><input type="text" name="Search" >
<input type="hidden" name = "ID" value = '$ID' >
<input type ="hidden" name = "Arrange" value = '$Arrange' >
<input type="submit" value="Search" >
</form>

_END;


echo"    <table class = tablefloatleft border='1'>
             <tr>
                 <th><a href='bcstock.php?Arrange=Stock_ID'>Stock ID</a></th>
                 <th><a href='bcstock.php?Arrange=product_code'>Product Code</a></th>
                 <th><a href='bcstock.php?Arrange=batchno'>Batch Number</a></th>
                 <th><a href='bcstock.php?Arrange=operation_number'>Operation Number</a></th>
                 <th><a href='bcstock.php?Arrange=quantity'>Quantity</a></th>
                 <th><a href='bcstock.php?Arrange=location'>Location</a></th>
                 <th><a href='bcstock.php?Arrange=description'>Notes</a></th>
                 <th><a href='bcstock.php?Arrange=date_in'>Date first item put in </a></th>
                 <th><a href='bcstock.php?Arrange=date_out'>Date latest item taken out</a></th>
             </tr>";
         
// displays items in stock


$Stock_ID = $Product_Code = $Batch_No = $OpNo = $Quantity = $Location = $Notes = $Date_in = $Date_out = "";

//echo $Arrange;
$result2 = $mysqli->query("SELECT * FROM bcstock WHERE (quantity LIKE '%$Search%' OR description LIKE '%$Search%'
            OR location LIKE '%$Search%' OR operation_number LIKE '%$Search%' OR date_in LIKE '%$Search%'
            OR date_out LIKE '%$Search%' or batchno LIKE '%$Search%' 
            OR product_code LIKE '%$Search%' OR Stock_ID LIKE '%$Search%') ORDER BY $Arrange");
// $result2 = $mysqli->query("SELECT * FROM bcstock ORDER BY $Arrange");
 $num2 = mysqli_num_rows($result2);
 //echo $num2;
    for ($j = 0; $j < $num2; ++$j)
    {
        $row2 = mysqli_fetch_row($result2);
        
        $Stock_ID = $row2[8];
        
        If ($row2[0] != "0")//do not show items which have zero left in stock
        {
            //echo $j;
            echo '<tr>
                        <td><A name = '.$row2[8].'></A><a href="bcstock.php?ID='.$row2[8].'&amp;Search='.$Search.'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[8].'</a></td>
                        <td><a href="bcstock.php?ID='.$row2[8].'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[7].'</a></td>
                        <td><a href="bcstock.php?ID='.$row2[8].'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[6].'</a></td>
                        <td><a href="bcstock.php?ID='.$row2[8].'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[3].'</a></td>
                        <td><a href="bcstock.php?ID='.$row2[8].'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[0].'</a></td>
                        <td><a href="bcstock.php?ID='.$row2[8].'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[2].'</a></td>
                        <td><a href="bcstock.php?ID='.$row2[8].'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[1].'</a></td>
                        <td><a href="bcstock.php?ID='.$row2[8].'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[4].'</a></td>
                        <td><a href="bcstock.php?ID='.$row2[8].'&amp;Arrange='.$Arrange.'#'.$row2[8].'">'.$row2[5].'</a></td>
                </tr>';
        
            if ($ID == $row2[8])
            {
                //stock adjustment 
               $Batch = $row2[6];
               echo"</table>
               <table class='floatleft'>
                   <form method='POST' action='bcstockupdate.php'>
                        
                            <th colspan='2' align='center'>Stock Adjustment</th>
                            <input type='hidden' name='date_in' value=".$row2[4].">
                            <input type='hidden' name='date_out' value=".$row2[5].">
                            <input type='hidden' name='Stock_ID' value=".$row2[8].">
                            <tr>
                                <td>Batch :</td>
                                <td><input type = 'text' name = 'batch' value = $Batch></td>
                            </tr>
                            <tr>
                                <td>Quantity :</td>
                                <td><input type = 'text' name = 'qty_available' value = ".$row2[0]."></td>
                            </tr>
                            <tr>
                                <td>Notes :</td>
                                <td><input type = 'text' name = 'Description' value = ".$row2[1]."></td>
                            </tr>
                            <tr>
                                <td>Location :</td>
                                <td><input type = 'text' name = 'Location' value = ".$row2[2]."></td>
                            </tr>
                            <tr>
                                <td>Current Operation :</td>
                                <td><input type = 'text' name = 'Current_OpNo' value = ".$row2[3]."></td>
                            </tr>
                            <tr>
                                <td>Product Code :</td>
                                <td><input type = 'text' name = 'product_code' value = ".$row2[7]."></td>
                            </tr>
                            <tr>
                                <td><input type='submit' value='Go'></td>
                                <td></td>
                            </tr>
                        
                    </form>
               </table> 
               ";
              //  <div style="margin:80px">
            echo '
               <table class="floatleft">            
                <form method="post" action="bccomfirm.php">
               
                    <th colspan="2" align="center">Stock Transfer to Batch</th>
                    <tr>
                        <td>Product :</td>
                        <td> <select name="batchno" class="batchno">
                                <option selected="selected">--Select Destination Batch--</option>'
                 ;
                                                       
                $inf_result = $mysqli->query("SELECT batchno, productdescription, productcode FROM bcbatchinfo WHERE (status = 1 OR status = 0)");
                $num_inf_result = mysqli_num_rows($inf_result);
                while($row=mysqli_fetch_array($inf_result))
                {
                //$sql=$mysqli->query("select productcode,productdescription from bcbatchinfo where status !=1");
                //while($row=mysqli_fetch_array($sql))

                $id = $batch=$row['batchno'];
                $data=$row['productdescription'];
                $code=$row['productcode'];
                echo '          <option value="'.$batch.'">'.$batch.' '.$data.' '.$code.'</option>';
                 } 
                echo '          </select> 
                        </td>
                    </tr> 
                    <tr>
                        <td>Destination Operation:</td> 
                        <td><select name="OpNo" class="OpNo">
                                <option selected="selected">--Select Destination Operation--</option>
                            </select>
                        </td>
                    </tr>';                     
                //echo "<tr><td>Destination Operation</td><td><select name='txtHint' id='txtHint'>";
                //echo"</select></td></tr>";     
                //echo'<tr><td>Destination Operation</td><td><div name = "txtHint" id="txtHint" >info will go here</div></td></tr>';<option value='0'>choose...</option>
                echo'
                    <tr>
                        <td>Quantity to Transfer</td><td><input type="text" maxlength="16"
                        name="From_Stock">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                        <input type="hidden" name="qty_available" value="'.$row2[0].'">
                        <input type="hidden" name="description" value="'.$row2[1].'">
                        <input type="hidden" name="location" value="'.$row2[2].'">
                        <input type="hidden" name="current_OpNo" value="'.$row2[3].'">
                        <input type="hidden" name="date_in" value="'.$row2[4].'">
                        <input type="hidden" name="date_out" value="'.$row2[5].'">
                        <input type="hidden" name="current_batchno" value="'.$row2[6].'">
                        <input type="hidden" name="current_product_code" value="'.$row2[7].'">
                        <input type="hidden" name="Stock_ID" value="'.$row2[8].'">
                        <input type="submit" value="Go">
                        </td>
                    </tr>
                
                 </form>
                </table>';
               //</div> echo 'blah blah blash';
               
               // echo $entries; echo $entries2; echo $entries3;echo $entries4;             
                        echo"    <table class = tablefloatleft border='1'>
                         <tr>
                         <th>Stock ID</th>
                         <th>Product Code</th>
                         <th>Batch Number</th>
                         <th>Operation Number</th>
                         <th>Quantity</th>
                         <th>Location</th>
                         <th>Notes</th>
                         <th>Date first item put in</th>
                         <th>Date latest item taken out</th>
                         </tr>";   
            }
        }  
    }
    
   echo "</table>
<br>";

echo '
<form method="post" action="bcmccomfirm.php"
	onSubmit="return validate(this)">
<table class="floatleft" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<tr><th colspan="2" align="center">Add existing parts to Stock</th>

</tr><tr><td>Batch number</td><td><input type="text" maxlength="16"
	name="batchno" ></td>
</tr><tr><td>Product code</td><td><input type="text" maxlength="16"
	name="Product_code" ></td>        
</tr><tr><td>Operation</td><td><input type="text" maxlength="16"
	name="OpNo" ></td>
</tr><tr><td>Quantity in stock</td><td><input type="text" maxlength="16"
	name="Into_Stock" ></td>
        
</tr><tr><td>Location</td><td><input type="text" maxlength="50"
	name="Location" ></td>
</tr><tr><td>Notes for items in stock</td><td><input type="text" maxlength="150"
	name="Notes" ></td>
</tr><tr><td colspan="2" align="center">
        <input type="hidden" maxlength="32"
        name="available" value=Into_Stock>
        <input type="hidden" maxlength="32"
        name="added" value=1>
	<input type="submit" value="Go" ></td>
</tr></table></form>
</body>
</html>
';

/*
<table class = "margin_only" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Transfer to Stock</th>
<form method="post" action="bcmccomfirm.php"
	onSubmit="return validate(this)">
</tr><tr><td>Operation</td><td><input type="text" maxlength="16"
	name="OpNo" value=$op /></td>
</tr><tr><td>Quantity to move to stock</td><td><input type="text" maxlength="16"
	name="Into_Stock" /></td>
</tr><tr><td>New Location</td><td><input type="text" maxlength="50"
	name="Location" /></td>
</tr><tr><td>Notes (for items being moved to stock)</td><td><input type="text" maxlength="150"
	name="Notes" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="Go" /></td>
<input type="hidden" name="Product_code" value="$Product_code" />
<input type="hidden" name="batchno" value="$batch" />
</tr></form></table>
*/

?>
