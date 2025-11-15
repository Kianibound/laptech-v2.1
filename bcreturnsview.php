<?php // bcreturnsview.php
$returnsview = 0;

if (!isset($_SESSION)) session_start();
if (isset($_GET['disp']))
{
    $disp = ($_GET["disp"]);
   // $_SESSION['disp'] = $disp;
    $_SESSION['disp'] = $disp;
}
if (isset($_POST['disp']))
{
    $disp = ($_POST["disp"]);
   // $_SESSION['disp'] = $disp;
    $_SESSION['disp'] = $disp;
}
if (isset($_SESSION['disp']))
{
    $disp = $_SESSION['disp'];
}
if (isset($_POST['action']))
{
    $action = ($_POST["action"]);
   /* $_SESSION['action'] = $action;*/
}
if (isset($_GET['action']))
{
    $action = ($_GET["action"]);
   /* $_SESSION['action'] = $action;*/
}

if (!isset($_SESSION['user']))
    {
    include_once 'bcheader.php';
    die("<br /><br />You need to login to view this page");
    }
$user = $_SESSION['user'];
$sortmode = 'return';
if (isset($_GET["date"]))
{
    $req_date = ($_GET["date"]);
}
else 
{
    $req_date = date('Y-m-d');
}
$return = 0;
if (isset($_GET["return"]))
{
    $return = ($_GET["return"]);
}
$item = 0;
if (isset($_GET["item"]))
{
    $item = ($_GET["item"]);
}
if (isset($_GET["sortmode"]))
{
    $sortmode = ($_GET["sortmode"]);
}
if (isset($_POST["Select_return"]))
{
    $Select_return = ($_POST["Select_return"]);
}

else{$Select_return = '%';}

if (isset($_GET["Select_return"]))
{
    $Select_return = ($_GET["Select_return"]);
    $returnsview = 1;
}

if (isset($_POST["Ship_Date"]))
{
    $Ship_Date = ($_POST["Ship_Date"]);
}
else{ $Ship_Date = 0;}

if (isset($_POST["comment"]))
{
    $Comment = ($_POST["comment"]);
}
else{ $Comment = '0';}

if (isset($_GET["Show"]))
{
    $stat = ($_GET["Show"]);
}
else if (isset($_POST["Show"]))
{
    $stat = ($_POST["Show"]);
}
else
{$stat = 1;}
if ($return != '0')
{
    $Select_return = $return;
}
if ($disp != 4)
{
include_once 'bcheader.php';
}
else
{
    include_once 'bcfunctions.php';
    $user = 1000;
    $staffno = 1000;
    $check = '';
    //session_start();
    //$disp = $_SESSION['disp'];
    //$_SESSION['disp'] = $disp;
}

if ($Ship_Date !=0)
{
    queryMysql($mysqli, "UPDATE `bcreturns` SET `date_closed` = '$Ship_Date' 
        WHERE `return` = '$return' AND `item` = '$item'");
}

if ($Comment != '0')
{
    queryMysql($mysqli, "UPDATE `bcreturns` SET `comments` = '$Comment' 
        WHERE `return` = '$return' AND `item` = '$item'");
}
//echo "stat = $stat <BR />";
switch ($stat)//sets up the View switch and prepares the string for the sql call
{

    case "1":
        $select1 = "selected";
        $select0 = "";
        $select2 = "";
        $select3 = "";
        $select = "IS NULL";
        $check_action = 0;
        break;
    case "2":
        $select2 = "selected";
        $select0 = "";
        $select1 = "";
        $select3 = "";
        $select = "IS NOT NULL";
        $check_action = 0;
        break;
    case "3":
        $select3 = "selected";
        $select0 = "";
        $select1 = "";
        $select2 = "";
        $select = "IS NULL OR date_closed IS NOT NULL";
        $check_action = 1;
        break;
    default:
        $select0 = "selected";
        $select1 = "";
        $select2 = "";
        $select3 = "";
        $select = "IS NULL OR date_closed IS NOT NULL";
        $check_action = 0;
        break;
    
}
//echo "show = $stat <br /> disp = $disp <br />";
//echo "select = $select<BR />";
if ($disp == 1)
{
    echo <<<_END
    <div id="main-container">
    <br />
    <form class = floatleft name="input" action="bcreturn.php?" method="get">
    <h3>Enter new sales return #</h3><input type="text" name="return" />
    <input type="submit" value="Create" />
    </form>
_END;
}

if ($disp == 2)
{
    echo <<<_END
    <form class = floatleft name="input" action="bcreturnsview.php?" method="post">
    <h3> Search returns</h3><input type="text" name="Select_return" />
    View <select name="Show">
    <option value="1" $select1>Open returns</option>
    <option value="2" $select2>Closed returns</option>
    <option value="3" $select3>Unactioned returns</option>
    <option value="0" $select0>All returns</option>
    <input type="submit" value="Search" />
    </select>
    </form>
_END;
}

if ($disp == 3)
{
    echo <<<_END
    <form class = floatleft name="input" action="bcsalespriority.php?" method="get">
    <h3>Set return Priority </h3>
    <input type="submit" name = "Set" value="Set Priorities" />
    </form>
_END;
}
//list of work done broken down by operator for a date
//echo "select_return = $Select_return <br />";
//echo "select = $select <br />";
//echo "sortmode = $sortmode<br />";

$result = queryMysql($mysqli, "SELECT * FROM `bcreturns` WHERE (`return` LIKE '%$Select_return%' OR `item` LIKE '%$Select_return%'
            OR `productcode` LIKE '%$Select_return%' OR `customer` LIKE '%$Select_return%' OR `description` LIKE '%$Select_return%'
            OR `date_opened` LIKE '%$Select_return%' OR `date_recieved` LIKE '%$Select_return%' 
            OR `date_closed` LIKE '%$Select_return%' OR `comments` LIKE '%$Select_return%')
            AND (`date_closed` $select) ORDER BY `$sortmode`");
            //AND (`date_closed` $select) ORDER BY '$sortmode'");/*'date_closed' $select)");*/
            

$num = mysqli_num_rows($result);
//echo "num = $num";
echo"   <table class = tablefloatleft border='4'>
                    <tr>
                    <th width= 5%><a href='bcreturnsview.php?sortmode=return&Show=$stat'>Return (DFN)</th>
                    <th width= 4%><a href='bcreturnsview.php?sortmode=item&Show=$stat'>Item #</th>
                    <th width= 4%><a href='bcreturnsview.php?sortmode=quantity&Show=$stat'>Quantity</th>
                    <th width= 10%><a href='bcreturnsview.php?sortmode=productcode&Show=$stat'>Product Code</th>
                    <th width= 13%><a href='bcreturnsview.php?sortmode=customer&Show=$stat'>Customer</th>
                    <th width= 13%><a href='bcreturnsview.php?sortmode=description&Show=$stat'>Description</th>
                    <th width= 4%>Ass. Batch</th>
                    <th width= 4%><a href='bcreturnsview.php?sortmode=date_opened&Show=$stat'>Date opened</th>
                    <th width= 4%><a href='bcreturnsview.php?sortmode=date_recieved&Show=$stat'>Date Recieved</th>
                    <th width= 4%><a href='bcreturnsview.php?sortmode=date_closed&Show=$stat'>Date Closed</th>
                    <th width= 25%>Comments</th>
                    <th width= 5%><a href='bcreturnsview.php?sortmode=Op_entered&Show=$stat'>return entered By</th>
                    <th width= 5%><a href='bcreturnsview.php?sortmode=Date_Entered&Show=$stat'>return entered on</th>
                    <th width= 4%><a href='bcreturnsview.php?sortmode=Priority&Show=$stat'>Priority</th>
                    </tr>";
                    $bgcol = 0;
            for ($ki = 0; $ki < $num; ++$ki)
            {
                
                $row = mysqli_fetch_row($result);
                //enter if statement here to check action status
                if ($check_action == 1)
                {
                    //go to returns to batch table and check for an entry
                    //echo "this bit?";
                    $action_check = queryMysql($mysqli, "SELECT * FROM `bcsalestobatch` WHERE `Return` = '$row[0]' AND `Return_item` = '$row[1]'");
                    //$action_check = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE (return = '$row[0]' AND item = '$row[1]' ORDER BY '$row[0]'")
                    $num_action_check = mysqli_num_rows($action_check);
                    if ($num_action_check == 0)
                    {
                        //only show lines that do not have an entry
                        //echo "there???";
                        show_return($row, $item, $return, $Select_return, $stat,$bgcol);
                        $bgcol = $bgcol +1;
                    }
                }
                else
                {
                    //echo "here???";
                    show_return($row, $item, $return, $Select_return, $stat,$bgcol);
                    $bgcol = $bgcol +1;
                }
                
            }
 /*<input type="submit" value="Search" />
</form>


<form class = floatleft action=""bcreturnsview.php" method="post"*/  
if ($disp == 4)
{
    echo <<<_END
    <form class = center name="Edit" action="bcreturnsview.php?disp=0" method="post">
    RETURN TO MAIN MENU   
    <input type="submit" name="Edit" value="RETURN" />
    </form>
_END;
}         
echo '</div>';

?>

