<?php // addbatch.php
include_once 'bcheader.php';

// Start with the PHP code

$batchno = $productcode = $description = $qtystart = $qtyreq = "";

if (isset($_POST['batchno']))
	$batchno = fix_string($_POST['batchno']);
if (isset($_POST['productcode']))
	$productcode = fix_string($_POST['productcode']);
if (isset($_POST['description']))
	$description = fix_string($_POST['description']);
if (isset($_POST['qtystart']))
	$qtystart = fix_string($_POST['qtystart']);
if (isset($_POST['qtyreq']))
	$qtyreq = fix_string($_POST['qtyreq']);
if (isset($_POST['build_type']))
	$build_type = ($_POST['build_type']);
if (isset($_POST['Eng']))
    $Eng = ($_POST['Eng']);
//else
   // $Eng = 0;
echo $Eng;
if (isset($_POST['Link']))
	$Link = ($_POST['Link']);
echo $Link;

$fail  = validate_batchno($batchno);
$fail .= validate_productcode($productcode);
$fail .= validate_description($description);
$fail .= validate_qtystart($qtystart);
$fail .= validate_qtyreq($qtyreq);

echo "<html><head><title>Add or Edit a Batch complete</title>";
$now = date('c');
if ($fail == "") {
    $Batch_query = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno = '$batchno'");
    $numbatch = mysqli_num_rows($Batch_query);
    If ($numbatch == 1)
    {
        echo "</head><body><br /><br /><br />Batch Updated successfully: $batchno,
		$productcode, $description, $qtystart, $qtyreq, $build_type, $Link.</body></html>";
        queryMysql($mysqli, "UPDATE bcbatchinfo SET productcode = '$productcode',productdescription = '$description',
            qtystart = '$qtystart',qtyreq = '$qtyreq',build_type = '$build_type',Link = '$Link',Eng = '$Eng'
            WHERE batchno = '$batchno'");
             echo'
                        <script language="javascript">
                        location.replace("bcbatchinfo.php?view='.$batchno.'");
                        </script>';
            echo '<a href="bcbatchinfo.php?view='.$batchno.'",target="_blank">Go to Batch</a>';
            exit;
    }
    else if($numbatch == 0)
    {
	echo "</head><body><br /><br /><br />New Batch Entered successfully: $batchno,
		$productcode, $description, $qtystart, $qtyreq, $build_type, $Link.</body></html>";
        queryMysql($mysqli, "INSERT INTO bcbatchinfo VALUES('$batchno','$productcode',
				   '$description','$qtystart',NULL, '$qtyreq',NULL, NULL,0,'$build_type','$Link','$Eng','$now')");
	// This is where you would enter the posted fields into a database
         echo'
                        <script language="javascript">
                        location.replace("bcbatchinfo.php?view='.$batchno.'");
                        </script>';
        echo '<a href="bcbatchinfo.php?view='.$batchno.'",target="_blank">Go to Batch</a>';
	exit;
    }
    else
    {
        echo "There was a problem with the Batch Number please try again";
    }
}
else
{
    querymysql ("delete from bcproductoperations where Product_code = '$productcode' and build_type = '$build_type'"); 
}

// Now output the HTML and JavaScript code

echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 14px helvetica; color:#444444; }</style>
<script type="text/javascript">
function validate(form)
{
	fail  = validatebatchno(form.batchno.value)
	fail += validateproductcode(form.productcode.value)
	fail += validatedescription(form.description.value)
	fail += validateqtystart(form.qtystart.value)
	fail += validateqtyreq(form.qtyreq.value)
	if (fail == "") return true
	else { alert(fail); return false }
}
</script></head><body>
<table class="signup" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Signup Form</th>

<tr><td colspan="2">Sorry, the following errors were found<br />
in your form: <p><font color=red size=1><i>$fail</i></font></p>
</td></tr>

<form method="post" action="bcoperationchoice.php"
	onSubmit="return validate(this)">
     <tr><td>Batch Number</td><td><input type="text" maxlength="32"
	name="batchno" value="$batchno" /></td>
</tr><tr><td>Product Code</td><td><input type="text" maxlength="32"
	name="productcode" value="$productcode" /></td>
</tr><tr><td>Description</td><td><input type="text" maxlength="32"
	name="description" value="$description" /></td>
</tr><tr><td>Start Quantity</td><td><input type="text" maxlength="12"
	name="qtystart" value="$qtystart" /></td>
</tr><tr><td>Quantity Required</td><td><input type="text" maxlength="12"
	name="qtyreq" value="$qtyreq" /></td>
</tr><tr><td>Link to docs</td><td><input type="text" maxlength="255"
	name="Link" value="$Link" /></td>
</tr><tr><td>Engineering intensive?</td><td><input type="checkbox" name="Eng"/></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="Add New" /></td>
</tr></form></table>

<!-- The JavaScript section -->

<script type="text/javascript">
function validatebatchno(field) {
	if (field == "") return "No batchno was entered.\\n"
	return ""
}

function validateproductcode(field) {
	if (field == "") return "No productcode was entered.\\n"
	return ""
}

function validatedescription(field) {
	if (field == "") return "No description was entered.\\n"
		return ""
}

function validateqtystart(field) {
	if (field == "") return "No qtystart was entered.\\n"
		return ""
}

function validateqtyreq(field) {
	if (field == "") return "No qtystart was entered.\\n"
		return ""
}


</script></body></html>
_END;

// Finally, here are the PHP functions

function validate_batchno($field) {
	if ($field == "") return "No batchno was entered<br />";
	return "";
}

function validate_productcode($field) {
	if ($field == "") return "No productcode was entered<br />";
	return "";
}

function validate_description($field) {
	if ($field == "") return "No description was entered<br />";
	return "";		
}

function validate_qtystart($field) {
	if ($field == "") return "No start quantity was entered<br />";
		return "";
}

function validate_qtyreq($field) {
	if ($field == "") return "No quantity required was entered<br />";
	return "";
}



function fix_string($string) {
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return htmlentities ($string);
}
?>
