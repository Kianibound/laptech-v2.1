<?php // DoOp.php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];
global $mysqli;

// Start with the PHP code


$OpNo = $Quantity = $Scrapped = $Comments = $build_type = "";
$batchno = ($_GET["View"]);

if (isset($_POST['Build_type']))
        $Build_Type = fix_string($_POST['Build_type']);
if (!isset($_POST['Build_type']))
        $Build_Type = "Custom";
echo "$Build_Type";
if ($Build_Type == 'Full')
{
if (isset($_POST['OpNo']))
	$OpNo = fix_string($_POST['OpNo']);
if (isset($_POST['Quantity']))
	$Quantity = fix_string($_POST['Quantity']);
if (isset($_POST['Scrapped']))
	$Scrapped = fix_string($_POST['Scrapped']);
if (isset($_POST['Comments']))
	$Comments = fix_string($_POST['Comments']);
        
    //    echo "$Comments";
        
echo "$OpNo $Quantity $scrapped ";        
$fail  = validate_OpNo($OpNo);
$fail .= validate_Quantity($Quantity);
$fail .= validate_Scrapped($Scrapped);
//echo $OpNo;
        echo "$Comments";
//get staffno from bcpeople where username = $user
$query = "SELECT staffno FROM bcpeople WHERE username = '$user'";
$result = queryMysql($mysqli, $query);
$staffno  = mysqli_fetch_row($result);//this is obviously the wrong fetch but its working just now.
//echo '<br />Staff number returned   '.$staffno[0].'   ';

//search for the batch number and operation before the one being done(except 
// where operation is 1) and total the units available. Subtract units already 
//done at this operation and check that the number entered does not exceed the
//total for the batch
if ($OpNo !=1)
{
    $query = "SELECT OpNo FROM bcoperations";
    $result = queryMysql($mysqli, $query);
    $num = mysqli_num_rows($result);
    $lastopreq = 0;
    for ($j = 0; $j < $num; ++$j)
    {
        $opreq  = mysqli_fetch_row($result);
        if ($lastopreq < $opreq[0])
        {
            $lastopreq = $opreq[0];
        }
    }
    //echo 'operation requested '.$OpNo.' last operation on list '.$lastopreq.'</br>';
    If ($OpNo <= $lastopreq)
    {
    $lastop = $OpNo - 1;
   
    echo 'testing';    
    $query = "SELECT quantitycomplete,moved_from_stock FROM bcoperationsdone WHERE batchno = '$batchno'
                    AND operation = '$lastop'";
    $result = queryMysql($mysqli, $query);
    $num2 = mysqli_num_rows($result);
    $donelastop = 0;

        for ($j = 0; $j < $num2; ++$j)
        {
            $row2 = mysqli_fetch_row($result);
            $donelastop = $donelastop +$row2[0] +$row2[1];
        }
        echo 'number of units done last operation =   '.$donelastop.'  <br /> ';
    
    updatebcbacthinfo($batchno,$OpNo,$staffno,$Scrapped,$Quantity,$fail,$donelastop,$Comments);
    }
    
}
else 

{//available = qty to build
    
    updatebcbacthinfo($batchno,$OpNo,$staffno,$Scrapped,$Quantity,$fail,-1,$Comments);
}
}
else
{
    {
// The code that follows is similar to that above however this will be used to end operations that have custom orders.

if (isset($_POST['OpNo']))
	$OpNo = fix_string($_POST['OpNo']);
if (isset($_POST['globalopno']))
	$globalOpNo = fix_string($_POST['globalopno']);
if (isset($_POST['Quantity']))
	$Quantity = fix_string($_POST['Quantity']);
if (isset($_POST['Scrapped']))
	$Scrapped = fix_string($_POST['Scrapped']);
if (isset($_POST['Comments']))
	$Comments = fix_string($_POST['Comments']);
if (isset($_POST['oporderarray']))
	$oporder = explode("remove",$_POST['oporderarray']);
if (isset($_POST['opordercount']))
	$opcount = $_POST['opordercount'];
        
        //echo "$Comments";
//echo "global = $globalOpNo local = $OpNo";
$oporder_array = explode(",", isset($oporder[0]) ? $oporder[0] : "");
//print_r ($oporder_array);
for ($i = 0; $i != $opcount; ++$i)
{
    //echo @$oporder[$i];
    $opnumber = $i + 1;
    //echo $opnumber;
}
$fail  = validate_OpNo($OpNo);
$fail .= validate_Quantity($Quantity);
$fail .= validate_Scrapped($Scrapped);

        //echo "$Comments";
//get staffno from bcpeople where username = $user
$query = "SELECT staffno FROM bcpeople WHERE username = '$user'";
$result = queryMysql($mysqli, $query);
$staffno  = mysqli_fetch_row($result);//this is obviously the wrong fetch but its working just now.
//echo '<br />Staff number returned   '.$staffno[0].'   ';

//search for the batch number and operation before the one being done(except 
// where operation is 1) and total the units available. Subtract units already 
//done at this operation and check that the number entered does not exceed the
//total for the batch

if ($OpNo !=1)
{
    $query = "SELECT OpNo FROM bcoperations";
    $result = queryMysql($mysqli, $query);
    $num = mysqli_num_rows($result);
    $lastopreq = 0;
    for ($j = 0; $j < $num; ++$j)
    {
        $opreq  = mysqli_fetch_row($result);
        if ($lastopreq < $opreq[0])
        {
            $lastopreq = $opreq[0];
            //echo '!!! '.@$oporder[$j].' !!!';
            //echo "array $oporder_array[$j]";
            if ($oporder_array[$j] != 0 && $oporder_array[$j] < $OpNo-1)
            {
                $lastop = $j-2;
                //echo "<br />operation required = $OpNo";
                //echo "<br />last operation required = $lastop";
            }
        }
    }
    echo "testing <br />";    
    $lastop = findlastoplocal($mysqli, $OpNo,$batchno);
    echo "<br />last local operation required = $lastop";

    //echo 'operation requested '.$OpNo.' Global operation number '.$globalOpNo.' last operation on list '.$lastopreq.'</br>';
    If ($OpNo <= $lastopreq)
    {
    
    $OpNo = $globalOpNo;
    
    $query = "SELECT quantitycomplete,moved_from_stock FROM bcoperationsdone WHERE batchno = '$batchno'
                    AND operation = '$lastop'";
    $result = queryMysql($mysqli, $query);
    $num2 = mysqli_num_rows($result);
    $donelastop = 0;

        for ($j = 0; $j < $num2; ++$j)
        {
            $row2 = mysqli_fetch_row($result);
            $donelastop = $donelastop +$row2[0] +$row2[1];
        }
        echo '<br />number of units done last operation (global op'.$lastop.') =   '.$donelastop.'  <br /> ';
    
    updatebcbacthinfo($batchno,$OpNo,$staffno,$Scrapped,$Quantity,$fail,$donelastop,$Comments);
    }
    
}
else 

{//available = qty to build
$OpNo = $globalOpNo;
//echo "Global = $globalOpNo";
updatebcbacthinfo($batchno,$OpNo,$staffno,$Scrapped,$Quantity,$fail,-1,$Comments);
}
}
}
function updatebcbacthinfo($batchno,$OpNo,$staffno,$Scrapped,$Quantity,$fail,$donelastop,$Comments)
{
    global $mysqli;
    $query = "SELECT start FROM bcoperationsdone WHERE batchno = '$batchno'
                AND operation = '$OpNo' AND staffnumber = '$staffno[0]'
                AND start IS NOT NULL AND end IS NULL";
                echo "<br />staff no. $staffno[0], Batch $batchno Op $OpNo";
    $result = queryMysql($mysqli, $query);
    $num = mysqli_num_rows($result);
    if ($num > 0)
    {
    $row = mysqli_fetch_row($result);
    echo '<br />you stared this operation on '.$row[0].'<br />';
    $query = "SELECT quantitycomplete, scrap, moved_to_stock FROM bcoperationsdone WHERE batchno = '$batchno'
                AND operation = '$OpNo'";
    $result = queryMysql($mysqli, $query);
    $num2 = mysqli_num_rows($result);
    $donethisop = 0;
    $to_stock = 0;

        for ($j = 0; $j < $num2; ++$j)
        {
            $row2 = mysqli_fetch_row($result);
            $donethisop = $donethisop +$row2[0] +$row2[1];
            //$to_stock = $to_stock + $row2[2];
        }
        echo '<br />number of units done this operation =   '.$donethisop.'   ';
        
    $query = "SELECT qtystart,qtyadd FROM bcbatchinfo WHERE batchno = '$batchno'";
    $result = queryMysql($mysqli, $query);
    $num2 = mysqli_num_rows($result);
     //check there are units availabe either from start of moved in from stock
    $query8 = "SELECT * FROM bcstocklog WHERE operation_number = '$OpNo' AND batchno = '$batchno'";
        $result8 = queryMysql($mysqli, $query8);
        $num8 = mysqli_num_rows($result8);
        $From_Stock = 0;
        for ($j = 0; $j < $num8; ++$j)
        {
            $row8 = mysqli_fetch_row($result8);
            if ($row8[6] != 'out')
            {
                $From_Stock = $From_Stock + $row8[0];
            }
            else
            {
                $to_stock = $to_stock +$row8[0];
            }
        }
        echo '<br />number from stock = '.$From_Stock.'  ';
        echo '<br />number to stock = '.$to_stock.'  ';

        for ($j = 0; $j < $num2; ++$j)
        {
            $row2 = mysqli_fetch_row($result);
            $qtystart = $row2[0];
            $totalonline = $qtystart + $row2[1] + $From_Stock - $to_stock;
        }
        echo '<br />number of units online =   '.$totalonline.'   ';

        
            
            if ($donelastop == -1){
            $available = $totalonline - $donethisop + $From_Stock -$to_stock;}
            else{
            $available = $donelastop - $donethisop + $From_Stock -$to_stock;}
            echo '<br />donelastop = '.$donelastop.' ';
            echo '<br />donethisop = '.$donethisop.' ';
            echo '<br />number of units available for this operation =  '.$available.' <br />  ';
    echo "$Comments";

            if ($available >= ($Quantity + $Scrapped))
            
            {echo 'test point 1<br />';
                if ($fail == "")
                {
                    echo 'test point 2 <br />';
                    $now = date('c');
                    $status = queryMysql($mysqli, "UPDATE bcoperationsdone SET quantitycomplete = '$Quantity',
                    scrap = '$Scrapped', end = '$now', Comments = '$Comments' WHERE batchno = '$batchno' AND operation = '$OpNo'
                    AND staffnumber = '$staffno[0]' AND start IS NOT NULL AND end IS NULL");
                    // This is where you would enter the posted fields into a database
                    // go to this page on completion
                    //
                    if ($status == TRUE)
                    {
                        echo "</head><body><br /><br /><br />Quantity Entered successfully: $OpNo,
                            $Quantity, $Scrapped, $Comments.</body></html>";
                        
                        echo'
                        <script language="javascript">
                        location.replace("bcbatchinfo.php?view='.$batchno.'");
                        </script>';
                        echo '<a href="bcbatchinfo.php?view='.$batchno.'",target="_blank">Return to Batch</a>';
                        exit;
                    }
                    else
                    {
                        echo 'There has been a error encountered please go back and try again';
                        echo '<a href="bcbatchinfo.php?view='.$batchno.'",target="_blank">Return to Batch</a>';
                        exit;
                    }
               
                }
                
                echo "<br />failed? $fail";
                echo "<br />not following this bit!!";
            }
            else
            {
                echo "<br /><h2>not enough parts available for the quantities entered</h2>";
            }
        
    }
    else
    {
    echo '<br />You have not started this operation <br />';
    }
}





// Now output the HTML and JavaScript code
// else { alert(fail); return false }

echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 14px helvetica; color:#444444; }</style>
<script type="text/javascript">
function validate(form)
{
	fail  = validateOpNo(form.OpNo.value)
	fail += validateQuantity(form.Quantity.value)
	fail += validateScrapped(form.Scrapped.value)
		if (fail == "") return true
	
}
</script></head><body>


<h2>Please go back and try again.</h2> information entered 
<br />Operation number = $OpNo 
<br />Quantity complete = $Quantity
<br />Quantity Scrapped =  $Scrapped




<!-- The JavaScript section -->

<script type="text/javascript">
function validateOpNo(field) {
	if (field == "") return "No OpNo was entered.\\n"
        if (field <= "0") return "OpNo must be positive.\\n"
	return ""
}

function validateQuantity(field) {
	if (field == "") return "No Quantity was entered.\\n"
        if (field < "0") return "quantity must be positive.\\n"
	return ""
}

function validateScrapped(field) {
	if (field == "") return "No Scrapped was entered.\\n"
        if (field < "0") return "Scrapped must be positive.\\n"
		return ""
}




</script></body></html>
_END;

// Finally, here are the PHP functions

function validate_OpNo($field) {
	if ($field == "") return "No OpNo was entered<br />";
        if ($field < "0") return "OpNo must be greater than 0<br />";
	return "";
}

function validate_Quantity($field) {
	if ($field == "") return "No Quantity was entered<br />";
        if ($field < "0") return "Quantity must be positive<br />";
	return "";
}

function validate_Scrapped($field) {
	if ($field == "") return "No Scrapped was entered<br />";
        if ($field < "0") return "Scrapped must be positive<br />";
	return "";		
}




function fix_string($string) {
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return htmlentities ($string);
}
//I want to get back to the last page........
?>

