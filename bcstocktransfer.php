<?php // bcstocktransfer.php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

// This is the page that will allow the user to set the location the item is heading for
// in stock and if needed enter a note about the item 


$In_Stock = $OpNo = $Date_In = $Date_out = $Batchno = $Product_code = $Stock_ID = $Location = $Notes = $Stock = $From_Stock = $Date = $Product_code2 = $InitialOpNo = $Initialbatchno = "";

if (isset($_POST['batchno']))
	$batchno =($_POST['batchno']);
        echo $batchno;
if (isset($_POST['OpNo']))
	$OpNo =($_POST['OpNo']);
		echo ">>>>>";
        echo $OpNo;
if (isset($_POST['Into_Stock']))
	$into_stock = ($_POST['Into_Stock']);
        //echo $into_stock;
if (isset($_POST['From_Stock']))
	$From_Stock = ($_POST['From_Stock']);
        //echo $From_Stock;
if (isset($_POST['Location']))
	$Location = ($_POST['Location']);
        //echo $Location;
if (isset($_POST['Notes']))
	$Notes = ($_POST['Notes']);
        //echo $Notes;
if (isset($_POST['Product_code']))
	$Product_code =($_POST['Product_code']);
        //echo $Product_code;
if (isset($_POST['Product_code2']))
	$Product_code2 =($_POST['Product_code2']);
        //echo $Product_code2;
if (isset($_POST['Identifier']))
	$Identifier =($_POST['Identifier']);
        //echo $Identifier;
if (isset($_POST['InitialOpNo']))
	$InitialOpNo =($_POST['InitialOpNo']);
		echo "<<<<<<<";
        echo $InitialOpNo;
if (isset($_POST['qty_available']))
	$qty_available =($_POST['qty_available']);
        //echo $qty_available;
if (isset($_POST['Stock_ID']))
	$Stock_ID =($_POST['Stock_ID']);
        //echo $Stock_ID;
        
if ($OpNo == 0)       
{
    $OpNo = $InitialOpNo;
}

$In_Stock = $qty_available;
$Date_In = date('c');
$Date_out = date('c');
$Date = date('c');

If ($In_Stock >= $From_Stock)
{
        if ($From_Stock != 0)
            {
                $In_Stock = $In_Stock - $From_Stock;
                //echo "hello again";
                if ($In_Stock < 0)
                {
                    Die ("There where not enough items at that stock location to complete your request");
                }
                else
                {
                    //if ($Identifier == 1)
                    //{
                        $query = queryMysql($mysqli, "SELECT * FROM bcstock WHERE operation_number = '$OpNo' AND product_code = '$Product_code2' AND location = '$Location'");

                        if($Identifier != -1)
                        {
                            updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code ,  $OpNo,  $user,   $Location,  $Date,  $batchno);
                            //queryMysql($mysqli, "update bcstock SET quantity = '$In_Stock' , date_out = '$Date_out' WHERE location = '$Location' AND operation_number = '$OpNo' AND product_code = '$Product_code2' ");
                            queryMysql($mysqli, "update bcstock SET quantity = '$In_Stock' , date_out = '$Date_out' WHERE Stock_ID = '$Stock_ID' ");
                        }
                        else
                        {    
                            updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code2 ,  $OpNo,  $user,   $Location,  $Date,  $batchno);
                           // queryMysql($mysqli, "INSERT INTO  `publications`.`bcstock` (`quantity` ,`description` ,`location` ,`operation_number` ,`date_in` ,
                           //                                     `date_out` ,`batchno` ,`product_code` ,`Stock_ID`)
                           // VALUES ('$From_Stock', '$Notes' ,  '$Location',  '$OpNo',  '$Date_In',  '$Date_out',  '$batchno',  '$Product_code2', NULL);");
                            queryMysql($mysqli, "update bcstock SET quantity = '$In_Stock' , date_out = '$Date_out' WHERE Stock_ID = '$Stock_ID' ");
                        }
                    //}
                    //else
                    //{
                    //        updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code ,  $OpNo,  $user,   $Location,  $Date,  $batchno);
                    //        queryMysql($mysqli, "update bcstock SET quantity = '$In_Stock' , date_out = '$Date_out' WHERE location = '$Location' AND operation_number = '$OpNo' AND product_code = '$Product_code' ");
                    //}
                }
            }
}
else
{
  echo "An error has occured please go back and try again";   
}




echo '<br /><a href="bcbatchinfo.php?view='.$batchno.'",target="_blank">Return to Batch</a>';
exit;




echo <<<_END
</br></br>
<table class="Stock Transfer (to stock)" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Stock Transfer (To stock)</th>
<form method="post" action=""
	onSubmit="return validate(this)">
</tr><tr><td>Location</td><td><input type="text" maxlength="150"
	name="Location" /></td>
</tr><tr><td>Notes</td><td><input type="text" maxlength="16"
	name="Notes" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="Go" /></td>
</tr></form></table>

_END;

?>
