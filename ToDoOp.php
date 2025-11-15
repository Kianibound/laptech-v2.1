<?php // ToDoOp.php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

// Start with the PHP code
//window.open html command


$OpNo = $Quantity = $Scrapped = $Comments = $build_type = "";
$batchno = ($_GET["View"]);

if (isset($_POST['OpNo2']))
	$OpNo = ($_POST['OpNo2']);
        echo 'OpNo = '.$OpNo.'';
if (isset($_POST['globalopno']))
	$globalOpNo = ($_POST['globalopno']);
        echo ' GlobalOpNo = '.$globalOpNo.'' ;
if (isset($_POST['Build_type']))
	$Build_Type = ($_POST['Build_type']);
        echo ' build type = '.$Build_Type.'' ;
if (isset($_POST['Quantity']))
	$Quantity = ($_POST['Quantity']);
if (isset($_POST['Scrapped']))
	$Scrapped = ($_POST['Scrapped']);
if (isset($_POST['Comments']))
	$Comments = ($_POST['Comments']);
if (isset($_POST['oporderarray']))
	$oporder = explode("remove",$_POST['oporderarray']);
if (isset($_POST['opordercount']))
	$opcount = $_POST['opordercount'];
$arraytransfer = implode(",",$oporder);        
Echo <<<_END
<table class="floatleft" border="0" cellpadding="2"
            cellspacing="5" bgcolor="#eeeeee">
    <th colspan="2" align="center">End Operation</th>
    <form method="post" action="DoOp.php?View=$batchno"
            onSubmit="return validate(this)">
             <tr><td>Operation (Global)</td><td><input type="text" maxlength="3"
            name="OpNo" value=$globalOpNo></td>
    </tr><tr><td>Quantity Completed</td><td><input type="text" maxlength="16"
            name="Quantity" /></td>
    </tr><tr><td>Quantity Scrapped</td><td><input type="text" maxlength="16"
            name="Scrapped" /></td>
    </tr><tr><td>comments</td><td><input type="text" maxlength="128"
            name="Comments" /></td>
    <input type="hidden" name="Build_type" value='$Build_Type' />
    <input type="hidden" name="oporderarray" value='$arraytransfer' />
     <input type="hidden" name="opordercount" value='$opcount' />
    <input type="hidden" maxlength="3" name="globalopno" value=$OpNo></td>
    </tr><tr><td colspan="2" align="center">
            <input type="submit" value="Go" /></td>
    </tr></form></table>
_END;


?>