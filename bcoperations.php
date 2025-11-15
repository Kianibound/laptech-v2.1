<?php // bcoperations.php
include_once 'bcheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

$count = queryMysql($mysqli, "select * from meta_table where Table_name='bcproductoperations'");
$num1 = mysqli_num_rows($count);
 for ($i = 0; $i < ($num1); ++$i)
        {
            $row = mysqli_fetch_row($count);
        }

$count2 = querymysql ("select count(*) from bcoperations");
$num3 = mysqli_num_rows($count2);
 for ($i = 0; $i < ($num3); ++$i)
        {
            $row2 = mysqli_fetch_row($count2);
        }

if ($row[0] != NULL)
{
    echo $num1;
}
else
{
    echo $row[0];
    
    queryMysql($mysqli, "create table bcproductoperations (Product_code VARCHAR(64), Build_type VARCHAR(64))"); 
     
     
    for ($num = 0; $num < $row2[0]; ++$num)
        {
            $num2 = $num + 1;
            querymysql ("alter table bcproductoperations add operation_$num2 INT");
        }
        queryMysql($mysqli, "INSERT INTO  `publications`.`meta_table` (`Table_name`)
                    VALUES ('bcproductoperations');");
}

?>