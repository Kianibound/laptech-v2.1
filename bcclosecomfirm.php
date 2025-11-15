<?php // bcfunctions.php
// we are going to do most of the manipulation work in here
// looking forward to it??
echo <<<_END
<head>
<link rel="stylesheet" type="text/css" href="bcrfxstyle.css" />
</head>
_END;

$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'publications'; // Modify these...
$dbuser  = 'Sparky';     // ...variables according
$dbpass  = 'stars';     // ...to your installation
$appname = "RFX Batch Control System"; // ...and preference

mysql_connect($dbhost, $dbuser, $dbpass) or die("Query failed: " . $mysqli->error);
mysql_select_db($dbname) or die("Query failed: " . $mysqli->error);

function createTable($mysqli, $name, $query)
{
	if (tableExists($mysqli, $name))
	{
		echo "Table '$name' already exists<br />";
	}
	else
	{
		queryMysql($mysqli, "CREATE TABLE $name($query)");
		echo "Table '$name' created<br />";
	}
}

function tableExists($mysqli, $name)
{
	$result = queryMysql($mysqli, "SHOW TABLES LIKE '$name'");
	return mysqli_num_rows($result);
}

function queryMysql($mysqli, $query)
{
	$result = $mysqli->query($query) or die("Query failed: " . $mysqli->error);
	return $result;
}

function destroySession()
{
	$_SESSION=array();
	
	if (session_id() != "" || isset($_COOKIE[session_name()]))
	    setcookie(session_name(), '', time()-2592000, '/');
		
	session_destroy();
}

function sanitizeString($mysqli, $var)
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return mysqli_real_escape_string($mysqli, $var);
}

function showProfile($mysqli, $user)
{
	if (file_exists("$user.jpg"))
		echo "<img src='$user.jpg' border='1' align='left' />";
		
	$result = queryMysql($mysqli, "SELECT * FROM bcprofiles WHERE user='$user'");
	
	if (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		echo stripslashes($row[1]) . "<br clear=left /><br />";
	}
}

function username($mysqli, $staff_no)
{
    $result = queryMysql($mysqli, "SELECT username FROM bcpeople WHERE staffno = '$staff_no'");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $username = $row[0];
            }
return $username;
}

function Staff_no($mysqli, $User)
{
    $result = queryMysql($mysqli, "SELECT staffno FROM bcpeople WHERE username = '$User'");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $staffno = $row[0];
            }
return $staffno;
}

function OpNotoOpName($OpNo)
{
    $result = queryMysql($mysqli, "SELECT operation FROM bcoperations WHERE OpNo = '$OpNo'");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
        {
            $row = mysqli_fetch_row($result);
            $OpName = $row[0];
        }
    
return $OpName;
}

function updatestocklog($mysqli, $into_stock, $From_Stock, $Product_code ,  $OpNo,  $user,   $Location,  $Date,  $batchno)
{
    if ($into_stock != 0 && $into_stock > -1)
    {
        $direction = "In";
        queryMysql($mysqli, "INSERT INTO  `publications`.`bcstocklog` (`quantity` ,`product_code` ,`operation_number` ,`user` ,`location` ,
                                                        `date/time` ,`Direction` ,`batchno`)
                    VALUES ('$into_stock', '$Product_code' ,  '$OpNo',  '$user',   '$Location',  '$Date',  '$direction',  '$batchno');");
    }
    if ($From_Stock != 0 && $From_Stock > -1)
    {
        $direction = "Out";
        queryMysql($mysqli, "INSERT INTO  `publications`.`bcstocklog` (`quantity` ,`product_code` ,`operation_number` ,`user` ,`location` ,
                                                        `date/time` ,`Direction`,`batchno`)
                    VALUES ('$From_Stock', '$Product_code' ,  '$OpNo',  '$user',   '$Location',  '$Date',  '$direction',  '$batchno');");
    }
    
}

function dropdown($table, $field)
{
    $result = queryMysql($mysqli, "SELECT DISTINCT $field FROM $table");
    $num = mysqli_num_rows($result);
    for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $Output[$ki] = $row[0];
            }
return $Output;
}


?>
