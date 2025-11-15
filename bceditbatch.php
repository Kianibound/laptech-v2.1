<?php // bcmessages.php
include_once 'bcheader.php';

   
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

if (isset($_GET['view'])) $view = sanitizeString($mysqli, $_GET['view']);
else $view = $user;

if (isset($_POST['Edit'])) {$Batchno = ($_POST['Edit']);}
else if (!isset($_SESSION['batch']))
    {$Batchno = $_SESSION['batch'];}
else {$Batchno = 0;}
echo $Batchno;
$Batchno = $_SESSION['batch'];
$Batch_query = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno = '$Batchno'");
$numbatch = mysqli_num_rows($Batch_query);
If ($numbatch != 1)
{
    echo "there is an issue with the batch number passes please contact the 
    administrator with the Batch Number";
}
else
{
    $Batch_query_row = mysqli_fetch_row($Batch_query);

echo <<<_END
<br/> <br/>
<table class="" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Edit Batch $Batchno</th>
<form method="post" action="bcoperationchoice.php"
	onSubmit="return validate(this)">
	 <tr><td>Batch Number $Batchno</td><td><input type="hidden" maxlength="32"
	name="batchno" value = "$Batchno" /></td>
</tr><tr><td>product code</td><td><input type="text" maxlength="32"
	name="productcode" value = "$Batch_query_row[1]" /></td>
</tr><tr><td>description</td><td><input type="text" maxlength="32"
	name="description" value = "$Batch_query_row[2]"/></td>
</tr><tr><td>start quantity</td><td><input type="text" maxlength="12"
	name="qtystart"value = "$Batch_query_row[3]" /></td>
</tr><tr><td>quantity required</td><td><input type="text" maxlength="12"
	name="qtyreq" value = "$Batch_query_row[5]"/></td>
</tr><tr><td>link to docs</td><td><input type="text" maxlength="255"
	name="Link"value = "$Batch_query_row[10]" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" Name = "Update" value="Update" /></td>
</tr></form></table>

<table class="" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="3" align="center">Edit Batch $Batchno</th>
<form method="post" 
	onSubmit="return validate(this)">
	 <tr><td>Batch Number $Batchno</td><td><input type="text" maxlength="32"
	name="batchno" value="$Batchno" /></td><td></td>
</tr><tr><td>product code</td><td><input type="text" maxlength="32"
	name="productcode" value="$Batch_query_row[1]" /></td><td></td>
</tr><tr><td>description</td><td><input type="text" maxlength="32"
	name="description" value="$Batch_query_row[2]" /></td><td></td>
</tr><tr><td>start quantity</td><td><input type="text" maxlength="12"
	name="qtystart" value="$Batch_query_row[3]" /></td><td></td>
</tr><tr><td>quantity required</td><td><input type="text" maxlength="12"
	name="qtyreq" value ="$Batch_query_row[5]" /></td><td></td>
</tr><tr><td>link to docs</td><td><input type="text" maxlength="255"
	name="Link" value='$Batch_query_row[10]' /></td>
        <input type='hidden' value='1' name='id' /></td>
<td align="left">
	<input type="submit" formaction="bcbrowser.php" value="browse" /> </td>
</tr><tr><td colspan="3" align="center">
	<input type="submit" formaction="bcoperationchoice.php" value="add new" /></td>
</tr></form></table>


</br>

<table class="" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Browse the server</th>
<form method="post" action="bcbrowser.php"
	onSubmit="return validate(this)">
<textarea rows ="10" cols ="50">
Please click on the button below to browse the shared filesystem. once you find the file you wish to link in please right click and chose copy link location, paste it into the Link to docs back on the create page and then remove the http://127.0.0.1 from the start of the link </textarea>
	<td><input type="submit" value="browse" /></td>
</tr></form></table>

</br>
 
_END;
}

?>
