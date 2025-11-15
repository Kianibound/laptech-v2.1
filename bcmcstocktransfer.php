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
if (isset($_POST['OpNo']))
	$OpNo =($_POST['OpNo']);
if (isset($_POST['Into_Stock']))
	$into_stock = ($_POST['Into_Stock']);
if (isset($_POST['From_Stock']))
	$From_Stock = ($_POST['From_Stock']);
if (isset($_POST['Location']))
	$Location = ($_POST['Location']);
if (isset($_POST['Notes']))
	$Notes = ($_POST['Notes']);
if (isset($_POST['Product_code']))
	$Product_code =($_POST['Product_code']);
if (isset($_POST['Product_code2']))
	$Product_code2 =($_POST['Product_code2']);
if (isset($_POST['Identifier']))
	$Identifier =($_POST['Identifier']);
if (isset($_POST['InitialOpNo']))
	$InitialOpNo =($_POST['InitialOpNo']);
if (!isset($_POST['Identifier']))
	$Identifier = 0;

//If ($Identifier == 1)
//{
    $query2 = queryMysql($mysqli, "SELECT batchno FROM bcstock WHERE operation_number = '$InitialOpNo' AND product_code = '$Product_code' AND location = '$Location'");
    $num2 = mysqli_num_rows($query2);
                
        for ($i = 0; $i < ($num2); ++$i)
        {
            $row2 = mysqli_fetch_row($query2);
        }
    $Initialbatchno = $row2[0];
    queryMysql($mysqli, "UPDATE bcstock SET product_code = '$Product_code' WHERE product_code = '$Product_code2' AND location = '$Location'");
    $query = queryMysql($mysqli, "SELECT quantity FROM bcstock WHERE operation_number = '$InitialOpNo' AND product_code = '$Product_code' AND location = '$Location'");
    $num = mysqli_num_rows($query);
                
        for ($i = 0; $i < ($num); ++$i)
        {
            $row = mysqli_fetch_row($query);
        }
//}
//else
//{
$query = queryMysql($mysqli, "SELECT quantity FROM bcstock WHERE operation_number = '$OpNo' AND product_code = '$Product_code' AND location = '$Location'");
$num = mysqli_num_rows($query);

        for ($i = 0; $i < ($num); ++$i)
        {
            $row = mysqli_fetch_row($query);
        }
//}
$In_Stock = $row[0];
$Date_In = date('c');
$Date_out = date('c');
$Date = date('c');

/*echo $Location;
echo $In_Stock;
echo $OpNo;
echo $Identifier;
echo $InitialOpNo;*/

If ($In_Stock >= $From_Stock)
{
        
//echo $Product_code;
        if ($From_Stock != 0)
            {
		$In_Stock = /*$In_Stock +*/ $row[0];
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

                        if(mysqli_num_rows($query) != 0)
                        {
                            updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code ,  $OpNo,  $user,   $Location,  $Date,  $batchno);
                            //queryMysql($mysqli, "update bcstock SET quantity = '$In_Stock' , date_out = '$Date_out' WHERE location = '$Location' AND operation_number = '$OpNo' AND product_code = '$Product_code2' ");
                            queryMysql($mysqli, "update bcstock SET quantity = '$In_Stock' , date_out = '$Date_out' WHERE location = '$Location' AND operation_number = '$InitialOpNo' AND product_code = '$Product_code' ");
                        }
                        else
                        {    
                            updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code2 ,  $OpNo,  $user,   $Location,  $Date,  $batchno);
                           // queryMysql($mysqli, "INSERT INTO  `publications`.`bcstock` (`quantity` ,`description` ,`location` ,`operation_number` ,`date_in` ,
                           //                                     `date_out` ,`batchno` ,`product_code` ,`Stock_ID`)
                           // VALUES ('$From_Stock', '$Notes' ,  '$Location',  '$OpNo',  '$Date_In',  '$Date_out',  '$batchno',  '$Product_code2', NULL);");
                            queryMysql($mysqli, "update bcstock SET quantity = '$In_Stock' , date_out = '$Date_out' WHERE location = '$Location' AND operation_number = '$InitialOpNo' AND product_code = '$Product_code' ");
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
