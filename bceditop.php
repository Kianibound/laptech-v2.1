<?php // bcmessages.php
include_once 'bcheader.php';

   
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

if (isset($_GET['view'])) $view = sanitizeString($mysqli, $_GET['view']);
else $view = $user;

if (isset($_GET['Edit'])) $Batchno = ($_GET['Edit']);
else $Batchno = 0;


echo <<<_END

<form method='post' action='bcmessages.php?view=$view'>
Type here to leave a message:<br />
<textarea name='text' cols='40' rows='3'></textarea><br />
Public<input type='radio' name='pm' value='0' checked='checked' />
Private<input type='radio' name='pm' value='1' />
<input type='submit' value='Post Message' /></form>


<table class="newbatch" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Create New Batch</th>
<form method="post" action="bcoperationchoice.php"
	onSubmit="return validate(this)">
	 <tr><td>Batch Number</td><td><input type="text" maxlength="32"
	name="batchno" /></td>
</tr><tr><td>product code</td><td><input type="text" maxlength="32"
	name="productcode" /></td>
</tr><tr><td>description</td><td><input type="text" maxlength="32"
	name="description" /></td>
</tr><tr><td>start quantity</td><td><input type="text" maxlength="12"
	name="qtystart" /></td>
</tr><tr><td>quantity required</td><td><input type="text" maxlength="12"
	name="qtyreq" /></td>
</tr><tr><td>link to docs</td><td><input type="text" maxlength="255"
	name="Link" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="add new" /></td>
</tr></form></table>

</br>

<table class="newoperation" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Create New Operation</th>
<form method="post" action="addop.php"
	onSubmit="return validate(this)">
	 <tr><td>Operation Number</td><td><input type="text" maxlength="3"
	name="OpNo" /></td>
</tr><tr><td>Operation</td><td><input type="text" maxlength="16"
	name="operation" /></td>
</tr><tr><td>related Docs</td><td><input type="text" maxlength="64"
	name="relateddocs" /></td>
</tr><tr><td>Link to docs</td><td><input type="text" maxlength="255"
	name="Link" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="add new" /></td>
</tr></form></table>

</br>

<table class="browser" border="0" cellpadding="2"
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

	if (isset($_GET['erase']))
	{
		$erase = sanitizeString($mysqli, $_GET['erase']);
		queryMysql($mysqli, "DELETE FROM bcmessages WHERE id=$erase
				    AND recip='$user'");
	}
	
	$query = "SELECT * FROM bcmessages WHERE recip='$view'
			  ORDER BY time DESC";
	$result = queryMysql($mysqli, $query);
	$num = mysqli_num_rows($result);
	
	for ($j = 0 ; $j < $num ; ++$j)
	{
		$row = mysqli_fetch_row($result);

		if ($row[3] == 0 ||
		    $row[1] == $user ||
		    $row[2] == $user)
		{
			echo date('M jS \'y g:sa:', $row[4]);
			echo " <a href='bcmessages.php?";
			echo "view=$row[1]'>$row[1]</a> ";

			if ($row[3] == 0)
			{
				echo "wrote: &quot;$row[5]&quot; ";
			}
			else
			{
				echo "whispered: <i><font
				color='#006600'>&quot;$row[5]&quot;</font></i> ";
			}

			if ($row[2] == $user)
			{
				echo "[<a href='bcmessages.php?view=$view";
				echo "&erase=$row[0]'>erase</a>]";
			}
			echo "<br>";
		}
	}
}

if (!$num) echo "<li>No messages yet</li><br />";

echo "<br><a href='bcmessages.php?view=$view'>Refresh messages</a>";
echo " | <a href='bcfriends.php?view=$view'>View $name2 friends</a>";
?>
