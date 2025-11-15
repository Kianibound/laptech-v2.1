<?php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

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
if (isset($_POST['available']))
	$available =($_POST['available']);
if (isset($_POST['added']))
	$added =($_POST['added']);
        
if ($available < $into_stock)
    echo '</br></br>Sorry there are not enough available units to do that please use the back button to return to previous page';

else
{
    echo'
    </br></br>

    <table class="stock transfer" border="0" cellpadding="2"
            cellspacing="5" bgcolor="#eeeeee">
    <th colspan="2" align="center">Please comfirm this stock transfer (If you didnt mean to initiate it please go back to previous page)</th>
    <form method="post" action="bctransfertostock.php"
            onSubmit="return validate(this)">
    <input type="hidden" value="'.$batchno.'" name="batchno" /></td>
    <input type="hidden" value="'.$Product_code.'" name="Product_code" /></td>        
    <input type="hidden" value="'.$into_stock.'" name="Into_Stock" /></td>
    <input type="hidden" value="'.$Location.'" name="Location" /></td>
    <input type="hidden" value="'.$Notes.'" name="Notes" /></td>
    <input type="hidden" value="'.$OpNo.'" name="OpNo" /></td>
    <input type="hidden" value= "0" name="Identifier" /></td>
    <input type="hidden" value= "'.$added.'" name="added" /></td>
    </tr><tr><td colspan="2" align="center">
            <input type="submit" value="comfirm" /></td>
    </tr></form></table>
    ';
}
?>