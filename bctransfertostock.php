<?php // bctransfertostock.php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

// This is the page that will allow the user to set the location the item is heading for
// in stock and if needed enter a note about the item 


$In_Stock = $into_stock = $OpNo = $Date_In = $Date_out = $Batchno = $Product_code = $Stock_ID = ""; 
$Location = $Notes = $Stock = $From_Stock = $Date = $Product_code2 = $InitialOpNo = $Initialbatchno = "";

if (isset($_POST['batchno']))
	$batchno =($_POST['batchno']);
if (isset($_POST['OpNo']))
	$OpNo =($_POST['OpNo']);
if (isset($_POST['Into_Stock']))
	$into_stock = ($_POST['Into_Stock']);
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
if (isset($_POST['added']))
	$added =($_POST['added']);

$query = queryMysql($mysqli, "SELECT quantity FROM bcstock WHERE operation_number = '$OpNo' 
    AND product_code = '$Product_code' AND location = '$Location'");
$In_Stock = 0;    
$num = mysqli_num_rows($query);

        for ($i = 0; $i < ($num); ++$i)
        {
            $row = mysqli_fetch_row($query);
            $In_Stock = $In_Stock + $row[0];
        }
$Date_In = date('c');
$Date_out = date('c');
$Date = date('c');

/*echo $Location;
echo $In_Stock;
echo $OpNo;
echo $Identifier;
echo $InitialOpNo;*/

If ($into_stock != 0)
{
        
//echo $Product_code;
    $query = queryMysql($mysqli, "SELECT * FROM bcstock WHERE operation_number =
        '$OpNo' AND product_code = '$Product_code' AND location = '$Location'");

        if(mysqli_num_rows($query) != 0)
        {
                      
          //  echo "hello";
            updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code ,  $OpNo, 
                $user,   $Location,  $Date,  $batchno);
                
            $into_stock = $into_stock + $In_Stock;    
            
            /*queryMysql($mysqli, "update bcstock SET quantity = '$into_stock' 
                WHERE location = '$Location' AND operation_number = '$OpNo' 
                AND product_code = '$Product_code' "); replaced with a new entry evry time product is added to stock */
                
            queryMysql($mysqli, "INSERT INTO  `publications`.`bcstock` (`quantity` 
                ,`description` ,`location` ,`operation_number` ,`date_in` ,
                `date_out` ,`batchno` ,`product_code` ,`Stock_ID`)
                
            VALUES ('$into_stock', '$Notes' ,  '$Location',  '$OpNo',
                '$Date_In',  0,  '$batchno',  '$Product_code', NULL);");
           
        }
        else
        {
          //  echo"goodbye";     
            updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code ,  $OpNo,
                $user,   $Location,  $Date,  $batchno);
                
            queryMysql($mysqli, "INSERT INTO  `publications`.`bcstock` (`quantity` 
                ,`description` ,`location` ,`operation_number` ,`date_in` ,
                `date_out` ,`batchno` ,`product_code` ,`Stock_ID`)
                
            VALUES ('$into_stock', '$Notes' ,  '$Location',  '$OpNo',
                '$Date_In',  0,  '$batchno',  '$Product_code', NULL);");
        }
        
}
else
{
  echo "An error has occured please go back and try again";   
}


echo $added;
if (@$added != 1)
{
echo '<br /><a href="bcbatchinfo.php?view='.$batchno.'",target="_blank">Return to Batch</a>';
}
else
{
    echo '<br /><a href="bcstock.php?">Return to Stock Viewer</a>';
}
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
