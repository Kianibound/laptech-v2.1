<?php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

$into_stock = $Notes = $row6 = NULL;

if (isset($_POST['batchno']))
	$batchno =($_POST['batchno']);
if (isset($_POST['OpNo']))
	$OpNo =($_POST['OpNo']);
if (isset($_POST['Into_Stock']))
	$into_stock = ($_POST['Into_Stock']);
if (isset($_POST['From_Stock']))
	$From_Stock = ($_POST['From_Stock']);
if (isset($_POST['location']))
	$Location = ($_POST['location']);
if (isset($_POST['Notes']))
	$Notes = ($_POST['Notes']);
if (isset($_POST['Product_code']))
	$Product_code =($_POST['Product_code']);
if (isset($_POST['qty_available']))
	$qty_available =($_POST['qty_available']);
        //echo $qty_available;
if (isset($_POST['description']))
	$description =($_POST['description']);
if (isset($_POST['current_OpNo']))
	$current_OpNo =($_POST['current_OpNo']);
if (isset($_POST['date_in']))
	$date_in =($_POST['date_in']);
if (isset($_POST['date_out']))
	$date_out =($_POST['date_out']);
if (isset($_POST['current_batchno']))
	$current_batchno =($_POST['current_batchno']);
if (isset($_POST['current_product_code']))
	$current_product_code =($_POST['current_product_code']);
else {$current_product_code = 0;}
if (isset($_POST['Stock_ID']))
	$Stock_ID =($_POST['Stock_ID']);
        //echo $Stock_ID;
$GlobalOp = 0;
     
//look for entries with the same batch number
$query5 = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno = '$batchno'");
$num5 = mysqli_num_rows($query5);

    for ($i = 0; $i < $num5; ++$i)
    {
        $row5 = mysqli_fetch_row($query5);
    }
$Product_code = $row5[1];

$build_type = $row5[9]; 
//echo $build_type;
//echo $Product_code;
$query10 = queryMysql($mysqli, "select * from bcproductoperations where Product_code = '$Product_code' and Build_type = '$build_type'");
$num10 = mysqli_num_rows($query10);
$desc_query = queryMysql($mysqli, "select * from bcoperations");
$desc_query_num = mysqli_num_rows($desc_query);
echo $desc_query_num;
if ($num10 != 0)
	{
	for ($ii = 0; $ii < $num10; ++$ii)
		{
			$row10 = mysqli_fetch_row($query10);
		}

//	echo $row10[0];
	$opcount = 0;
	unset ($row10[0]);
	unset ($row10[1]);
        $inc2 = 0;

		for ($iii = 3; $iii < $desc_query_num+2; ++$iii)
		{
                    $desc_query_row = mysqli_fetch_row($desc_query);/*$desc_query_num*/
			if($row10[$iii] != 0)
			{
                            //echo $iii; echo ','; echo $row10[$iii]; echo 'blah';
                            $globop[$inc2]= $iii-2;
                            $locop[$inc2]= $row10[$iii];
                            
                            $desc[$inc2] = $desc_query_row[1];
                            ++$inc2;
                            echo $inc2;
				$opcount = $opcount + 1;
                                if ($row10[$iii] == $OpNo)
                                {
                                    $GlobalOp = $opcount - 2;
                                    echo $GlobalOp;
                                }
			}
		}
	if ($GlobalOp == 0)
		{
				if ($current_product_code != $Product_code || $OpNo != $current_OpNo)
			{
			//	echo $opcount;
				$ops = 1;
			echo'
				</br></br>
				<table class="stock transfer" border="0" cellpadding="2"
						cellspacing="5" bgcolor="#eeeeee">
				<th colspan="2" align="center">You have entered an operation number which is not an operation in the batch you are trying to move the item/s to. please choose from a list of valid op numbers below</th>
				<form method="post" action="bcstocktransfer.php"
					onSubmit="return validate(this)">
				<tr><td>Destination Operation</td><td><select name = OpNo>';


		for ($ss = 0; $ss < $opcount; ++$ss)
			{
				echo '<option value='.$globop[$ss].'name = "Global'.$globop[$ss].' local'.$locop[$ss].'">
                                    (Global)'.$globop[$ss].' (local)'.$locop[$ss].' '.$desc[$ss].'</option>';
				++$ops;

			}

		                echo'</select></td></tr>';
				echo"<input type='hidden' value='$batchno' name='batchno' /></td>
				<input type='hidden' value='$current_product_code' name='Product_code2' /></td>    
				<input type='hidden' value='$Product_code' name='Product_code' /></td>      
				<input type='hidden' value='$into_stock' name='Into_Stock' /></td>
				<input type='hidden' value='$From_Stock' name='From_Stock' /></td>
				<input type='hidden' value='$Location' name='Location' /></td>
				<input type='hidden' value='$Notes' name='Notes' /></td>
				<input type='hidden' value='$current_OpNo' name='InitialOpNo' /></td>
				<input type='hidden' value='$qty_available' name='qty_available' />
				<input type='hidden' value='$Stock_ID' name='Stock_ID'  />
				<input type='hidden' value='1' name='Identifier' /></td>
				</tr><tr><td colspan='2' align='center'>
					<input type='submit' value='Yes' /></td>
				</tr></form></table>";
				exit;
			}
			else
			{
			//	echo $opcount;
				$ops = 1;
			echo'
				</br></br>
				<table class="stock transfer" border="0" cellpadding="2"
						cellspacing="5" bgcolor="#eeeeee">
				<th colspan="2" align="center">You have entered an operation number which is not an operation in the batch you are trying to move the item/s to. please choose from a list of valid op numbers below</th>
				<form method="post" action="bcstocktransfer.php"
					onSubmit="return validate(this)">
				<tr><td>Destination Operation</td><td><select name = OpNo>';


		for ($ss = 0; $ss < $opcount; ++$ss)
			{

				echo '<option value='.$globop[$ss].'name = "Global'.$globop[$ss].' local'.$locop[$ss].'">
                                    (Global)'.$globop[$ss].' (local)'.$locop[$ss].' '.$desc[$ss].'</option>';
				++$ops;

			}

		        echo'</select></td></tr>';
				echo"<input type='hidden' value='$batchno' name='batchno' /></td>
					 <input type='hidden' value='$current_product_code' name='Product_code2' /></td>    
					 <input type='hidden' value='$Product_code' name='Product_code' /></td>      
					 <input type='hidden' value='$into_stock' name='Into_Stock' /></td>
					 <input type='hidden' value='$From_Stock' name='From_Stock' /></td>
					 <input type='hidden' value='$Location' name='Location' /></td>
					 <input type='hidden' value='$Notes' name='Notes' /></td>
					 <input type='hidden' value='$OpNo' name='InitialOpNo' /></td>
					 <input type='hidden' value='$qty_available' name='qty_available' />
					 <input type='hidden' value='$Stock_ID' name='Stock_ID'  />
					 <input type='hidden' value='-1' name='Identifier' /></td>
					 </tr><tr><td colspan='2' align='center'>
					 <input type='submit' value='Yes' /></td>
					 </tr></form></table>";
				exit;
			}
		}
}
echo ">>>>>>";
echo $OpNo;   
echo "<<<<<<";
if ($current_product_code != $Product_code || $OpNo != $current_OpNo)
{

echo <<<_END
</br></br>
<table class="stock transfer" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">You are trying to move a product into a batch that uses a diffrent product are you sure you want to transfer it? (If not please go back to previous page)</th>
<form method="post" action="bcstocktransfer.php"
	onSubmit="return validate(this)">
        <tr><td>Destination Operations Available </td><td><select name = OpNo>'
        <option value=$globop[$OpNo]name = Global$globop[$OpNo] local$locop[$OpNo]">
                                    (Global)$globop[$OpNo] (local)$locop[$OpNo] $desc[$OpNo]</option>'
_END;
for ($ss = 0; $ss < $opcount; ++$ss)
			{

				echo '<option value='.$globop[$ss].'name = "Global'.$globop[$ss].' local'.$locop[$ss].'">
                                    (Global)'.$globop[$ss].' (local)'.$locop[$ss].' '.$desc[$ss].'</option>';
                        }
//</tr><tr><td>Please identify what operation it is going to</td><td><input type="text" maxlength="5" name="OpNo" value="$OpNo"/></td>
echo <<<_END

<input type="hidden" value="$batchno" name="batchno" /></td>
<input type="hidden" value="$current_product_code" name="Product_code2" /></td>    
<input type="hidden" value="$Product_code" name="Product_code" /></td>      
<input type="hidden" value="$into_stock" name="Into_Stock" /></td>
<input type="hidden" value="$From_Stock" name="From_Stock" /></td>
<input type="hidden" value="$Location" name="Location" /></td>
<input type="hidden" value="$Notes" name="Notes" /></td>
<input type="hidden" value="$OpNo" name="InitialOpNo" /></td>
<input type="hidden" value="$qty_available" name="qty_available" />
<input type="hidden" value="$Stock_ID" name="Stock_ID"  />
<input type="hidden" value= "1" name="Identifier" /></td>
</tr><tr><td colspan="2" align="center">
    <input type="submit" value="Yes" /></td>
</tr></form></table>

_END;
}
else
{

echo <<<_END
</br></br>

<table class="stock transfer" border="0" cellpadding="2"
	cellspacing="5" bgcolor="#eeeeee">
<th colspan="2" align="center">Please comfirm this stock transfer (If you didnt mean to initiate it please go back to previous page)</th>
<form method="post" action="bcstocktransfer.php"
	onSubmit="return validate(this)">
<input type="hidden" value="$batchno" name="batchno" /></td>
<input type="hidden" value="$current_product_code" name="Product_code2" /></td>    
<input type="hidden" value="$Product_code" name="Product_code" /></td>      
<input type="hidden" value="$into_stock" name="Into_Stock" /></td>
<input type="hidden" value="$From_Stock" name="From_Stock" /></td>
<input type="hidden" value="$Location" name="Location" /></td>
<input type="hidden" value="$Notes" name="Notes" /></td>
<input type="hidden" value="$current_OpNo" name="InitialOpNo" /></td>
<input type="hidden" value="$qty_available" name="qty_available" />
<input type="hidden" value="$Stock_ID" name="Stock_ID"  />
<input type="hidden" value= "-1" name="Identifier" /></td>
</tr><tr><td colspan="2" align="center">
	<input type="submit" value="comfirm" /></td>
</tr></form></table>

_END;
}
?>
