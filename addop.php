<?php // addop.php
include_once 'bcheader.php';

// Start with the PHP code

$Link = $OpNo = $operation = $relateddocs = "";

if (isset($_POST['OpNo']))
	$OpNo = fix_string($_POST['OpNo']);
if (isset($_POST['operation']))
	$operation = fix_string($_POST['operation']);
if (isset($_POST['relateddocs']))
	$relateddocs = fix_string($_POST['relateddocs']);
if (isset($_POST['Link']))
	$Link = ($_POST['Link']);
if (isset($_POST['Dept']))
	$Dept = ($_POST['Dept']);

$fail  = validate_OpNo($OpNo);
$fail .= validate_operation($operation);
$fail .= validate_relateddocs($relateddocs);

echo "<html><head><title>An Example Form</title>";

if ($fail == "") {
    $ops = queryMysql($mysqli, "SELECT * FROM bcoperations WHERE OpNo = '$OpNo'");
    $numops = mysqli_num_rows($ops);
    if ($numops == 0)
    {
	
        $stat = queryMysql($mysqli, "INSERT INTO bcoperations VALUES('$OpNo','$operation',
				   '$relateddocs', '$Link',$Dept)");
        if ($stat >= 0)
        {
            echo "</head><body><br /><br /><br />New Operation Entered successfully: $OpNo,
		$operation, $relateddocs, $Link, $Dept.</body></html>";
        }
        $LastOpNo = $OpNo - 1;
        $LastOpNo = "operation_$LastOpNo";
        $OpNo = "operation_$OpNo";
        queryMysql($mysqli, "ALTER TABLE bcproductoperations ADD $OpNo int(11) NOT NULL AFTER $LastOpNo");
	// This is where you would enter the posted fields into a database

	exit;
    }
    else if ($numops == 1)
    {
        echo "</head><body><br /><br /><br />Operation Edited successfully: $OpNo,
		$operation, $relateddocs, $Link.</body></html>";
        queryMysql($mysqli, "UPDATE bcoperations SET OpNo = '$OpNo',operation = '$operation',
            relateddocs = '$relateddocs',Link = '$Link',department = '$Dept' WHERE OpNo = '$OpNo'");
        
	// This is where you would enter the posted fields into a database

	exit;
    }
    else
    {
        echo "There is a problem withthe Operation Number please contact your system administrator";
    }
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
	fail += validateoperation(form.operation.value)
	fail += validaterelateddocs(form.relateddocs.value)
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

<form method="post" action="addop.php"
	onSubmit="return validate(this)">
     <tr><td>Batch Number</td><td><input type="text" maxlength="32"
	name="OpNo" value="$OpNo" /></td>
</tr><tr><td>Product Code</td><td><input type="text" maxlength="32"
	name="operation" value="$operation" /></td>
</tr><tr><td>relateddocs</td><td><input type="text" maxlength="64"
	name="relateddocs" value="$relateddocs" /></td>
</tr><tr><td>Link to document</td><td><input type="text" maxlength="255"
	name="Link" value="$Link" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="Add New" /></td>
</tr></form></table>

<!-- The JavaScript section -->

<script type="text/javascript">
function validateOpNo(field) {
	if (field == "") return "No OpNo was entered.\\n"
	return ""
}

function validateoperation(field) {
	if (field == "") return "No operation was entered.\\n"
	return ""
}

function validaterelateddocs(field) {
	if (field == "") return "No relateddocs was entered.\\n"
		return ""
}



</script></body></html>
_END;

// Finally, here are the PHP functions

function validate_OpNo($field) {
	if ($field == "") return "No OpNo was entered<br />";
	return "";
}

function validate_operation($field) {
	if ($field == "") return "No operation was entered<br />";
	return "";
}

function validate_relateddocs($field) {
	if ($field == "") return "No relateddocs was entered<br />";
	return "";		
}



function fix_string($string) {
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return htmlentities ($string);
}
?>
