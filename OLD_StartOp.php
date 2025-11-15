<?php // startop.php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

// Start with the PHP code

$OpNo = $Quantity = $Scrapped = $Stock = $From_Stock = "";
$batchno = ($_GET["View"]);

if (isset($_POST['OpNo']))
	$OpNo = fix_string($_POST['OpNo']);
if (isset($_POST['localOpNo']))
	$localOpNo = fix_string($_POST['localOpNo']);
if (isset($_POST['Quantity']))
	$Quantity = fix_string($_POST['Quantity']);
if (isset($_POST['Scrapped']))
	$Scrapped = fix_string($_POST['Scrapped']);
if (isset($_POST['Stock']))
	$moved_to_stock = fix_string($_POST['Stock']);
if (isset($_POST['From_Stock']))
	$moved_from_stock = fix_string($_POST['From_Stock']);
if (isset($_POST['Build_Type']))
	$Build_Type = fix_string($_POST['Build_Type']);
if (isset($_POST['Product_code']))
	$Product_code = fix_string($_POST['Product_code']);


$fail  = validate_OpNo($OpNo);
//echo "build type = $Build_Type Product code = $Product_code";
//get staffno from bcpeople where username = $user
$query = "SELECT staffno FROM bcpeople WHERE username = '$user'";
$result = queryMysql($mysqli, $query);
$staffno  = mysqli_fetch_row($result);//this is obviously the wrong fetch but its working just now.
//echo 'Staff number returned   '.$staffno[0].'   ';
$query = "SELECT Build_type,qtystart FROM bcbatchinfo WHERE batchno = '$batchno'";
$result = queryMysql($mysqli, $query);
$Build_Type_Array= mysqli_fetch_row($result);
$Build_Type = $Build_Type_Array[0];
$Start_Quantity = $Build_Type_Array[1];
//echo "bulid_type $Build_Type";
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
    If ($Build_Type == 'Full')//if build is full
    {
        $lastop = $OpNo - 1;
    }
    else
    {//if build is not full
        $oporderquery = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE 
        Product_code ='$Product_code' and Build_type ='$Build_Type'");
        $opordercount = mysqli_num_rows($oporderquery);
        $oporder = mysqli_fetch_row($oporderquery);
        $opcount = count($oporder) - 2;
        $localop = $oporder[$OpNo+1];
        echo "op no = $OpNo";
        echo " local op = $localop";
        //lastop will be taken from the productoperations
        //find localop from opno
        $locallastop = $localop - 1;
        echo "last$locallastop count$opcount";
        //then find last op from local op -1
        //print_r($oporder);
        for ($i = 0; $i < $opcount+1; ++$i)
        {
            echo "% $i";
            echo "$ ".$oporder[$i+1]."";
            if ($oporder[$i+1] == $locallastop)
            {
                $lastop = $i;
                echo "last op $lastop";
            }
        }
    }
    $query = "SELECT quantitycomplete FROM bcoperationsdone WHERE batchno = '$batchno'
                    AND operation = '$lastop'";
    $result = queryMysql($mysqli, $query);
    $num2 = mysqli_num_rows($result);
    $donelastop = 0;

        for ($j = 0; $j < $num2; ++$j)
        {
            $row2 = mysqli_fetch_row($result);
            $donelastop = $donelastop +$row2[0];
        }
        //echo 'number of units done last operation =   '.$donelastop.'   ';
        
    $query = "SELECT quantitycomplete,moved_from_stock FROM bcoperationsdone WHERE batchno = '$batchno'
                    AND operation = '$OpNo'";
    $result = queryMysql($mysqli, $query);
    $num2 = mysqli_num_rows($result);
    $donethisop = 0;

        for ($j = 0; $j < $num2; ++$j)
        {
            $row2 = mysqli_fetch_row($result);
            $donethisop = $donethisop +$row2[0] +$row2[1];
        }
        //echo 'number of units done this operation =   '.$donethisop.'   ';
        
    $query = "SELECT qtystart,qtyadd FROM bcbatchinfo WHERE batchno = '$batchno'";
    $result = queryMysql($mysqli, $query);
    $num2 = mysqli_num_rows($result);

        for ($j = 0; $j < $num2; ++$j)
        {
            $row2 = mysqli_fetch_row($result);
            $qtystart = $row2[0];
            $totalonline = $qtystart + $row2[1];
        }
        //echo 'number of units online =   '.$totalonline.'   ';
        $query8 = "SELECT * FROM bcstocklog WHERE batchno = '$batchno' AND operation_number = '$OpNo' AND Direction = 'In'";
        
        $result8 = queryMysql($mysqli, $query8);
        $num8 = mysqli_num_rows($result8); 
        $tostock = 0;       
        for ($j = 0; $j < $num8; ++$j)
        {
            	$row8 = mysqli_fetch_row($result8);
		$tostock = $tostock + $row8[0];
        }
	//echo 'to stock = '.$tostock.'';
        
	$query9 = "SELECT * FROM bcstocklog WHERE batchno = '$batchno' AND operation_number = '$OpNo' AND Direction = 'Out'";
        
        $result9 = queryMysql($mysqli, $query9);
        $num9 = mysqli_num_rows($result9); 
        $fromstock = 0;        
        for ($j = 0; $j < $num9; ++$j)
        {
		$row9 = mysqli_fetch_row($result9);
            	$fromstock = $fromstock + $row9[0]; 
        }
	//echo 'fromstock = '.$fromstock.'';
        $query = "SELECT * FROM `bcoperationsdone` WHERE batchno = '$batchno' 
                AND operation = '$OpNo' AND staffnumber = '$staffno[0]' AND start IS NOT NULL 
                AND end IS NULL";
        $result = queryMysql($mysqli, $query);
        $num3 = mysqli_num_rows($result);
	//echo $num3;
        if ($num3 == 0)//check if this operator has not started this job already
        { 
            if ($localop == 1)
            {
                $available = $Start_Quantity - $donethisop - $tostock + $fromstock;
            }
            else
            {
                $available = $donelastop - $donethisop - $tostock + $fromstock;
            }
            echo '<br />start quantity = '.$Start_Quantity.'  ';
            echo '<br />number of units available for this operation =   '.$available.'   ';
            echo '<br />number of units donelastop =   '.$donelastop.'   ';
            echo '<br />number of units done this op =   '.$donethisop.'   ';
            echo '<br />number of units sent to stock =   '.$tostock.'   ';
            echo '<br />number of units brought from stock =   '.$fromstock.'   ';
            if ($available >= ($Quantity + $Scrapped ))
            {
              echo '<br />number of units available for this operation =   '.$available.'   ';
                if ($fail == "") 
                {
                    echo "</head><body><br /><br /><br />Quantity Entered successfully: $OpNo,
                            $Quantity, $Scrapped.</body></html>";
                    $now = date('c');
                    echo(date(DATE_RFC822) . "<br />");
                    queryMysql($mysqli, "INSERT INTO bcoperationsdone VALUES('$batchno','$OpNo',
                                    '$staffno[0]',NULL,NULL,NULL,NULL,'$now',NULL,NULL,NULL,NULL)");
                    $query = "SELECT status FROM bcbatchinfo WHERE batchno = '$batchno'";
                    $result = queryMysql($mysqli, $query);
                    $num2 = mysqli_num_rows($result);

                    for ($j = 0; $j < $num2; ++$j)
                    {
                        $row2 = mysqli_fetch_row($result);
                        $started = $row2[0];
                    }
                    if ($started == 0)
                    {
                        queryMysql($mysqli, "UPDATE bcbatchinfo SET started = '$now', status = '1'
                         WHERE batchno = '$batchno'AND status = '0'");
                    }
                    // This is where you would enter the posted fields into a database
                    // go to this page on completeion 
                    // 
                    echo '<a href="bcbatchinfo.php?view='.$batchno.'",target="_blank">Return to Batch</a>';
                    exit;
               
                }  
            }
        }
        else 
        {echo "<br />nae chance pal you started operation '$OpNo' already!<br />";}
    }
}
else 
{//available = qty to build
$query = "SELECT quantitycomplete FROM bcoperationsdone WHERE batchno = '$batchno'
                AND operation = '$OpNo'";
$result = queryMysql($mysqli, $query);
$num2 = mysqli_num_rows($result);
$donethisop = 0;

    for ($j = 0; $j < $num2; ++$j)
    {
        $row2 = mysqli_fetch_row($result);
        $donethisop = $donethisop +$row2[0];
    }
    //echo 'number of units done this operation =   '.$donethisop.'   ';
    
$query = "SELECT qtystart,qtyadd FROM bcbatchinfo WHERE batchno = '$batchno'";
$result = queryMysql($mysqli, $query);
$num2 = mysqli_num_rows($result);

    for ($j = 0; $j < $num2; ++$j)
    {
        $row2 = mysqli_fetch_row($result);
        $qtystart = $row2[0];
        $totalonline = $qtystart + $row2[1];
    }
    //echo 'number of units online =   '.$totalonline.'   ';
    $query = "SELECT * FROM `bcoperationsdone` WHERE batchno = '$batchno' 
                AND operation = 1 AND start IS NOT NULL 
                AND end IS NULL";
    $result = queryMysql($mysqli, $query);
    $num3 = mysqli_num_rows($result);
    if ($num3 == 0)
    {
        echo 'number of rows returned = '.$num3.' ';
        if ($totalonline > $donethisop)
        {
            $available = $totalonline - $donethisop;
            //echo 'number of units available for this operation =   '.$available.'   ';
            if ($available >= ($Quantity + $Scrapped))
            {
              //echo 'number of units available for this operation =   '.$available.'   ';
                    if ($fail == "") {
                echo "</head><body><br /><br /><br />Quantity Entered successfully: $OpNo,
                        $Quantity, $Scrapped.</body></html>";
                $now = date('c');
                    echo(date(DATE_RFC822) . "<br />");
                    queryMysql($mysqli, "INSERT INTO bcoperationsdone VALUES('$batchno','$OpNo',
                                '$staffno[0]',NULL,NULL,NULL,NULL,'$now',NULL,NULL,NULL,NULL)");
                    $query = "SELECT status FROM bcbatchinfo WHERE batchno = '$batchno'";
                    $result = queryMysql($mysqli, $query);
                    $num2 = mysqli_num_rows($result);

                    for ($j = 0; $j < $num2; ++$j)
                    {
                        $row2 = mysqli_fetch_row($result);
                        $started = $row2[0];
                    }
                    if ($started == 0)
                    {
                        queryMysql($mysqli, "UPDATE bcbatchinfo SET started = '$now', status = '1'
                         WHERE batchno = '$batchno'AND status = '0'");
                    }                // This is where you would enter the posted fields into a database
                // go to this page on completeion 
                // 
                echo '<a href="bcbatchinfo.php?view='.$batchno.'",target="_blank">Return to Batch</a>';
                exit;
               }
            }  
        }
    }
    else 
    { echo "<br /><br />nae chance pal you started operation '$OpNo' already!<br /><br />";}
}



// Now output the HTML and JavaScript code

echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 14px helvetica; color:#444444; }</style>
<script type="text/javascript">
function validate(form)
{
	fail  = validateOpNo(form.OpNo.value)
	if (fail == "") return true
        if(fail < "1") return true
	else { alert(fail); return false }
}
</script></head><body>
<table class="signup" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Start Oeration</th>

<tr><td colspan="2">Sorry, the following errors were found<br />
in your form: <p><font color=red size=1><i>$fail</i></font></p>
</td></tr>

<form method="post" action="StartOp.php?View=$batchno"
	onSubmit="return validate(this)">
     <tr><td>Operation Number</td><td><input type="text" maxlength="32"
	name="OpNo" value="$OpNo" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="Go" /></td>
</tr></form></table>

<!-- The JavaScript section -->

<script type="text/javascript">
function validateOpNo(field) {
	if (field == "") return "No OpNo was entered.\\n"
        if (field < "1") return "OpNo does not exist. \\n"
	return ""
}




</script></body></html>
_END;

// Finally, here are the PHP functions

function validate_OpNo($field) {
	if ($field == "") return "No OpNo was entered<br />";
        if ($field < "1") return "OpNo does not exist.<br />";
	return "";
}




function fix_string($string) {
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return htmlentities ($string);
}
//I want to get back to the last page........
?>

