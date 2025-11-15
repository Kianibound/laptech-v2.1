<?php //bcoperationchoice2.php
include_once 'bcheader.php';

if (isset($_POST['operation_count']))
	$operation_count = ($_POST['operation_count']);
if (isset($_POST['batchno']))
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
if (isset($_POST['Link']))
	$Link = ($_POST['Link']);
if (isset($_POST['Eng']))
	$Eng = ($_POST['Eng']);
echo $Link;        
for ($i = 0; $i < $operation_count; ++$i)
    {
        if (isset($_POST["position($i)"]))
           { $position[$i] = ($_POST["position($i)"]);}
        echo $position[$i];
    }
//check if this is a new build to be inserted
$now = date('c');
$new_check = queryMysql ("select * from bcproductoperations where 
            Product_code = '$productcode' AND Build_type = '$build_type'");
$new_check_rows = mysqli_num_rows($new_check);
if ($new_check_rows == 0)
{
       queryMysql ("INSERT INTO  `publications`.`bcproductoperations` (`Product_code` ,`Build_type` , `create_Date`, `operation_1` ,`operation_2` ,`operation_3` ,`operation_4` ,`operation_5` ,`operation_6` ,`operation_7` ,`operation_8` ,`operation_9` ,`operation_10` ,`operation_11` ,`operation_12` ,`operation_13` ,`operation_14` ,`operation_15` ,`operation_16` ,`operation_17` ,`operation_18` ,`operation_19` ,`operation_20` ,`operation_21` ,`operation_22` ,`operation_23` ,`operation_24` ,`operation_25`)
                            VALUES ('$productcode', '$build_type','$now', NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);");


        for ($i = 0; $i < $operation_count; ++$i)
            {
                $current_op = $i + 1;
                queryMysql ("update bcproductoperations set operation_$current_op = '$position[$i]' where Product_Code = '$productcode' AND Build_type = '$build_type' ");
            }
 }
 else
 {
     echo"<br><br><h4>This build type already exists to use it</h4>(without changes)<h4> press submit. If you have made 
     changes for your new/edited batch press back on the browser window and choose a new name for the build type</h4><br>";
 }    
////////////////////////////////////////////////////////////////////
    echo $build_type;
  echo  "<FORM METHOD='POST' ACTION='addbatch.php'>
        <input type='hidden' name='batchno' value='$batchno' />
        <input type='hidden' name='productcode' value='$productcode' />
        <input type='hidden' name='description' value='$description' />
        <input type='hidden' name='qtystart' value='$qtystart' />
        <input type='hidden' name='qtyreq' value='$qtyreq' />
        <input type='hidden' name='build_type' value='$build_type' />
	<input type='hidden' name='Link' value='$Link' />
        <input type='hidden' name='Eng' value='$Eng' />
        <h3>Please click the button below to continue the script</h3>
        <p><input type ='submit' value = 'submit' name='submit'></p>
        </form>";
        

?>
