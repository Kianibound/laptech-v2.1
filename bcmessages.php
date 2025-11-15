<?php // bcmessages.php
include_once 'bcheader.php';

// checks for cookies then if found assigns them to their correct variable



if (isset($_COOKIE["batchno"]))
	{
		$batchno = $_COOKIE["batchno"];
		echo $_COOKIE['batchno'];
	}
else if (isset($_GET['batchno']))
	{
		$batchno = $_GET['batchno'];
	}

else
	{
		$batchno = '';
	}

if (isset($_COOKIE["productcode"]))
	{
		$productcode = $_COOKIE["productcode"];
		echo $_COOKIE['productcode'];
		echo $productcode;
	}
else if (isset($_GET['productcode']))
        {
                $productcode = $_GET['productcode'];
        }
else
	{
		$productcode = '';
	}

if (isset($_COOKIE["description"]))
	{
		$description = $_COOKIE["description"];
		echo $_COOKIE['description'];
	}
else if (isset($_GET['description']))
        {
                $description = $_GET['description'];
        }
else
	{
		$description = '';
	}

if (isset($_COOKIE["qtystart"]))
	{
		$qtystart = $_COOKIE["qtystart"];
		echo $_COOKIE['qtystart'];
	}
else
	{
		$qtystart = NULL;
	}

if (isset($_COOKIE["qtyreq"]))
	{
		$qtyreq = $_COOKIE["qtyreq"];
		echo $_COOKIE['qtyreq'];
	}
else if (isset($_GET['qtyreq']))
        {
                $qtyreq = $_GET['qtyreq'];
        }
else
	{
		$qtyreq = '';
	}

if (isset($_COOKIE["OpNo"]))
	{
		$OpNo = $_COOKIE["OpNo"];
		echo $_COOKIE['OpNo'];
	}
else
	{
		$OpNo = '';
	}

if (isset($_COOKIE["operation"]))
	{
		$operation = $_COOKIE["operation"];
		echo $_COOKIE['operation'];
	}
else
	{
		$operation = 0;
	}

if (isset($_COOKIE["relateddocs"]))
	{
		$relateddocs = $_COOKIE["relateddocs"];
		echo $_COOKIE['batchno'];
	}
else
	{
		$relateddocs = 0;
	}







   
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

if (isset($_GET['view'])) $view = sanitizeString($mysqli, $_GET['view']);
else $view = $user;

$link = 0;

if (isset($_POST['linkin'])) $link =($_POST['linkin']);


if (isset($_POST['text']))
{
	$text = sanitizeString($mysqli, $_POST['text']);

	if ($text != "")
	{
		$pm = substr(sanitizeString($mysqli, $_POST['pm']),0,1);
		$time = time();
		queryMysql($mysqli, "INSERT INTO bcmessages VALUES(NULL,
				   '$user', '$view', '$pm', $time, '$text')");
	}
}

// $batchno = $productcode = $description = $qtystart = $qtyreq = $build_type = $OpNo = $operation = $relateddocs = NULL;


/*if (isset($_POST['batchno']))
	$batchno = ($_POST['batchno']);
if (isset($_POST['productcode']))
	$productcode = ($_POST['productcode']);
if (isset($_POST['description']))
	$description = ($_POST['description']);
if (isset($_POST['qtystart']))
	$qtystart = ($_POST['qtystart']);
if (isset($_POST['qtyreq']))
	$qtyreq = ($_POST['qtyreq']);
if (isset($_POST['build_type']))
	$build_type = ($_POST['build_type']);

if (isset($_POST['OpNo']))
	($OpNo = $_POST['OpNo']);
if (isset($_POST['operation']))
	$operation = ($_POST['operation']);
if (isset($_POST['relateddocs']))
	$relateddocs = ($_POST['relateddocs']);
*/
if ($view != "")
{
	if ($view == $user)
	{
		$name1 = "Your";
		$name2 = "Your";
	}
	else
	{
		$name1 = "<a href='bcmembers.php?view=$view'>$view</a>'s";
		$name2 = "$view's";
	}

echo "<h3>$name1 Messages</h3>";
showProfile($mysqli, $view);

//get the next new operation number for the create operation form
$operations = queryMysql($mysqli, "SELECT * FROM bcoperations ORDER BY OpNo");
$OpNo = (mysqli_num_rows($operations)+1);


echo <<<_END

<form method='post' action='bcmessages.php?view=$view'>
Type here to leave a message:<br />
<textarea name='text' cols='40' rows='3'></textarea><br />
Public<input type='radio' name='pm' value='0' checked='checked' />
Private<input type='radio' name='pm' value='1' />
<input type='submit' value='Post Message' /></form>


<table class="newbatch" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="3" align="center">Create New Batch</th>
<form method="post" 
	onSubmit="return validate(this)">
	 <tr><td>Batch Number</td><td><input type="text" maxlength="32"
	name="batchno" value="$batchno" /></td><td></td>
</tr><tr><td>product code</td><td><input type="text" maxlength="32"
	name="productcode" value="$productcode" /></td><td></td>
</tr><tr><td>description</td><td><input type="text" maxlength="32"
	name="description" value="$description" /></td><td></td>
</tr><tr><td>start quantity</td><td><input type="text" maxlength="12"
	name="qtystart" value="$qtystart" /></td><td></td>
</tr><tr><td>quantity required</td><td><input type="text" maxlength="12"
	name="qtyreq" value ="$qtyreq" /></td><td></td>
</tr><tr><td>link to docs</td><td><input type="text" maxlength="255"
	name="Link" value='$link' /></td>
<td colspan="1" align="left">
	<input type="submit" formaction="bcbrowser.php" value="browse" /> </td>
</tr><tr><td>Engineering intensive?</td><td><input type="checkbox" name="Eng"/><td></td></td>
</tr><tr><td colspan="3" align="center">
	<input type="submit" formaction="bcoperationchoice.php" value="add new" /></td>
</tr></form></table>

</br>

<table class="newoperation" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="3" align="center">Create New Operation</th>
<form method="post" action="addop.php"
	onSubmit="return validate(this)">
<tr><td>Operation Number</td><td><input type="text" maxlength="3"
	name="OpNo" value="$OpNo" /></td><td> </td>
</tr><tr><td>Operation</td><td><input type="text" maxlength="16"
	name="operation" value="$operation" /></td><td></td>
</tr><tr><td>related Docs</td><td><input type="text" maxlength="64"
	name="relateddocs" value="$relateddocs" /></td><td></td>
</tr><tr><td>Link to docs</td><td><input type="text" maxlength="255"
	name="Link" value='$link' /></td>
<td colspan="1" align="left">
	<input type="submit" formaction="bcbrowser.php" value="browse" /> </td>
</tr><tr><td>Department and indicator</td><td><select name="Dept">
    <option value="100" >All and Indicator</option>
    <option value="1" >Lapping</option>
    <option value="101" >Lapping and Indicator</option>
    <option value="2" >Finishing</option>/>
    <option value="102" >Finishing and Indicator</option>/></td><td></td>
</tr><tr><td colspan="3" align="center">
	<input type="submit" value="add new" /></td>
</tr></form></table>

</br>



<!--<table class="browser" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Browse the server</th>
<form method="post" action="bcbrowser.php"
	onSubmit="return validate(this)">
<td>
<input type="hidden" maxlength="32" name="OpNo" value="'$OpNo'" />
<input type="hidden" maxlength="32" name="operation" value="'$operation'" />
<input type="hidden" maxlength="64" name="relateddocs" value="'$relateddocs'" />
<input type="hidden" maxlength="32" name="batchno" value="'$batchno'" />
<input type="hidden" maxlength="32" name="productcode" value="'$productcode'" />
<input type="hidden" maxlength="32" name="description" value="'$description'" />
<input type="hidden" maxlength="12" name="qtystart" value="'$qtystart'" />
<input type="hidden" maxlength="12" name="qtyreq" value="'$qtyreq'" />
</td>
<textarea rows ="10" cols ="50">
Please click on the button below to browse the shared file system. This will allow you to link in files relevant to the operation or batch you are creating. please click on the button next to the file you wish to open. this will take you back to this page and fill in the box with the required information. </textarea>
	<td><input type="submit" value="browse" /></td>
</tr></form></table>-->

</br>
 
_END;



	if (isset($_GET['erase']))
	{
		$erase = sanitizeString($mysqli, $_GET['erase']);
		queryMysql($mysqli, "DELETE FROM bcmessages WHERE id=$erase
				    AND (recip='$user' OR auth = '$user')");
	}
	
	$query = "SELECT * FROM bcmessages 
			  ORDER BY time DESC";//WHERE recip='$view'
	$result = queryMysql($mysqli, $query);
	$num = mysqli_num_rows($result);
	
	for ($j = 0 ; $j < $num ; ++$j)
	{
		$row = mysqli_fetch_row($result);

		if ($row[3] == 0 ||
		    $row[1] == $user ||
		    $row[2] == $user)
		{
                        $timey = new DateTime();
                        $timey->setTimestamp($row[4]);
                        echo $timey->format('M jS \'y g:ia:');
			//echo date('M jS \'y g:sa:', $row[4]);
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

			if ($row[1] == $user || $row[2] == $user)
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
