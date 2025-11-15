<?php //bctodo.php

/*
 *	This file is used to both generate the ToDo list for each user aswell as
 *	give links to set new tasks todo.
 */
echo <<<_END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(".batchno").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "ajax_city_MC.php",
data: dataString,
cache: false,
success: function(html)
{
$(".OpNo").html(html);
} 
});

});
});

</script>
</head>
<body>
_END;

// includes the headers aswell as the functions due to bcheader including bcfunctions within itself. 
include_once 'bcheader.php';
include_once 'bcfeedbackheader.php';
//checks to see if user is logged in and if they are sets the variable user to use the current users username. if not logged in it prompts 
//for the user to log in and denies access to the page.
if (!isset($_SESSION['user']))
	die("<br /><br />You must be logged in to view this page");
$user = $_SESSION['user'];


//queries mysql for data from the table bctodo which contains the data needed to generate the users todo 
//table
$tableinfoquery	= queryMysql		("select * from bctodo where user='$user'");

$tablenum 	= mysql_num_rows	($tableinfoquery);

echo '<table class = "tablefloatleft" border="1" cellpadding="5" cellspacing="5" bgcolor="#eeeeee">
      <th>Batch</th><th>Op</th><th>number of units</th><th>created</th><th>Due</th><th>priority</th><th>are prerequisite there?</th><th>Started</th>
      <th>Finished</th><th>start task</th><th>end task</th>';

//this loop goes through each table entry and prints it into the tableinfo array.
for($i = 0; $i < $tablenum; ++$i)
{
  $tableinfo = mysqli_fetch_row($tableinfoquery);
  
  if ($tableinfo[7] == NULL)
  {
    $tableinfo[7] = "Not started yet";
  }
  
  if ($tableinfo[8] == NULL)
  {
    $tableinfo[8] = "Not finished yet";
  }
  
  if ($tableinfo[6] == 3)
  {
    $tableinfo[6] = "Low";
  }
  
  if ($tableinfo[6] == 2)
  {
    $tableinfo[6] = "Normal";
  }
  
  if ($tableinfo[6] == 1)
  {
    $tableinfo[6] = "High";
  }
  
  echo "<tr><td>$tableinfo[1]</td><td>$tableinfo[2]</td><td>$tableinfo[3]</td>
	<td>$tableinfo[4]</td><td>$tableinfo[5]</td><td>$tableinfo[6]</td><td>maybe</td><td>$tableinfo[7]</td><td>$tableinfo[8]</td>
	
	<td><form method='post' action='bctodobc.php'>
	<input type='hidden' name='batch' value=$tableinfo[1]>
	<input type='hidden' name='operation' value=$tableinfo[2]>
	<input type='hidden' name='id' value='1'>
	<input type='submit' value='start'/></form></td>
	
	<td><form method='post' action='bctodobc.php'>
	<input type='hidden' name='batch' value=$tableinfo[1]>
	<input type='hidden' name='operation' value=$tableinfo[2]>
	<input type='hidden' name='id' value='2'>
	<input type='submit' value='stop'/></form></td></tr>";
}

$req_date= date('Y-m-d');
$stamp = strtotime($req_date);
echo '


<table class = "floatleft" border="0" cellpadding="2" cellspacing="5" bgcolor="#eeeeee">

<th colspan="2" align="center">assign task to user</th>

<form method="post" action="bctodoset.php" onSubmit="return validate(this)">
            <tr>
            <td>Username:</td>	<td><select name="username">';
            
            $name_query 	= queryMysql($mysqli, 'SELECT firstname,lastname,username from bcpeople');
            $name_query_num = mysqli_num_rows($name_query);
            
            for($i = 0; $i < $name_query_num; ++$i)
            {
	      $name = mysqli_fetch_row($name_query);
	      $full_name = $name[0] . ' ' . $name[1];
	      echo "<option value=$name[2]>$full_name</option>";
            }
            
            echo '</select></td>
            </tr>
	    <tr>
	  <td>Batch :</td><td> <select name="batchno" class="batchno">
                <option selected="selected">--Select Batch--</option>';
            
           
	    
	    $inf_result = $mysqli->query("SELECT batchno, productdescription, productcode FROM bcbatchinfo WHERE (status = 1 OR status = 0)");
                $num_inf_result = mysqli_num_rows($inf_result);
                while($row=mysqli_fetch_array($inf_result))
                {
                //$sql=$mysqli->query("select productcode,productdescription from bcbatchinfo where status !=1");
                //while($row=mysqli_fetch_array($sql))

                $id = $batch=$row['batchno'];
                $data=$row['productdescription'];
                $code=$row['productcode'];
                echo '<option value="'.$batch.'">'.$batch.' '.$data.' '.$code.'</option>';
                 } 
                echo '</td></tr></select> <br/><br/>
                <tr><td>Operation :</td> <td><select name="OpNo" class="OpNo">
                <option selected="selected">--Select Destination Operation--</option>

                </select></td></tr>';                  
	    echo '
	    <tr>
	    <td>Units to do:</td>
	    <td><input type="text" name="units"></input>
	    </td>
	    </tr>
	    <tr>
	    <td>date due:</td>	<td>';rfxlinecalendar2('date',$stamp);echo'
	    </td>
	    </tr>
	    <tr>
	    <td>Priority:</td>
	    <td>
	    <select name="priority">
	    <option value="1">High</option>
	    <option value="2">Normal</option>
	    <option value="3">Low</option>
	    </select>
	    </td>
	    </tr>
            <td><input type="submit" value="assign"/></td>
            </tr>
</form>
</table>
';

?>