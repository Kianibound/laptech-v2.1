<?php // bcsalesview.php
$salesview = 0;

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
$sortmode = 'salesorder';
if (isset($_GET["date"]))
{
    $req_date = ($_GET["date"]);
}
else 
{
    $req_date = date('Y-m-d');
}
$Order = 0;
if (isset($_GET["order"]))
{
    $Order = ($_GET["order"]);
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
if (isset($_POST["Select_Order"]))
{
    $Select_Order = ($_POST["Select_Order"]);
}

else{$Select_Order = '%';}

if (isset($_GET["Select_Order"]))
{
    $Select_Order = ($_GET["Select_Order"]);
    $salesview = 1;
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
if ($Order != '0')
{
    $Select_Order = $Order;
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
    queryMysql($mysqli, "UPDATE bcsalesorders SET actualshipdate = '$Ship_Date' 
        WHERE salesorder = '$Order' AND item = '$item'");
}

if ($Comment != '0')
{
    queryMysql($mysqli, "UPDATE bcsalesorders SET comments = '$Comment' 
        WHERE salesorder = '$Order' AND item = '$item'");
}

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
        $select = "IS NULL OR actualshipdate IS NOT NULL";
        $check_action = 1;
        break;
    default:
        $select0 = "selected";
        $select1 = "";
        $select2 = "";
        $select3 = "";
        $select = "IS NULL OR actualshipdate IS NOT NULL";
        $check_action = 0;
        break;
    
}
//echo "show = $stat <br /> disp = $disp <br />";

if ($disp == 1)
{
    echo <<<_END
    <div id="main-container">
    <br />
    <form class = floatleft name="input" action="bcsalesorder.php?" method="get">
    <h3>Enter new sales order #</h3><input type="text" name="Order" />
    <input type="submit" value="Create" />
    </form>
_END;
}

if ($disp == 2)
{
    echo <<<_END
    <form class = floatleft name="input" action="bcsalesview.php?" method="post">
    <h3> Search orders</h3><input type="text" name="Select_Order" />
    View <select name="Show">
    <option value="1" $select1>Open Orders</option>
    <option value="2" $select2>Shipped Orders</option>
    <option value="3" $select3>Unactioned Orders</option>
    <option value="0" $select0>All Orders</option>
    <input type="submit" value="Search" />
    </select>
    </form>
_END;
}

if ($disp == 3)
{
    echo <<<_END
    <form class = floatleft name="input" action="bcsalespriority.php?" method="get">
    <h3>Set Order Priority </h3>
    <input type="submit" name = "Set" value="Set Priorities" />
    </form>
_END;
}
//list of work done broken down by operator for a date

$result = queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE (salesorder LIKE '%$Select_Order%' OR item LIKE '%$Select_Order%'
            OR productcode LIKE '%$Select_Order%' OR customer LIKE '%$Select_Order%' OR description LIKE '%$Select_Order%'
            OR requestedshipdate LIKE '%$Select_Order%' or expectedshipdate LIKE '%$Select_Order%' 
            OR actualshipdate LIKE '%$Select_Order%' OR comments LIKE '%$Select_Order%')
            AND (actualshipdate $select) ORDER BY $sortmode");
$num = mysqli_num_rows($result);

echo"   <table class = tablefloatleft border='4'>
                    <tr>
                    <th width= 5%><a href='bcsalesview.php?sortmode=salesorder&Show=$stat'>Sales Order</th>
                    <th width= 4%><a href='bcsalesview.php?sortmode=item&Show=$stat'>Item #</th>
                    <th width= 4%><a href='bcsalesview.php?sortmode=quantity&Show=$stat'>Quantity</th>
                    <th width= 10%><a href='bcsalesview.php?sortmode=productcode&Show=$stat'>Product Code</th>
                    <th width= 13%><a href='bcsalesview.php?sortmode=customer&Show=$stat'>Customer</th>
                    <th width= 13%><a href='bcsalesview.php?sortmode=description&Show=$stat'>Description</th>
                    <th width= 4%>Ass. Batch</th>
                    <th width= 4%><a href='bcsalesview.php?sortmode=requestedshipdate&Show=$stat'>Date expected at Customer</th>
                    <th width= 4%><a href='bcsalesview.php?sortmode=expectedshipdate&Show=$stat'>Date expected to ship</th>
                    <th width= 4%><a href='bcsalesview.php?sortmode=actualshipdate&Show=$stat'>Actual ship date</th>
                    <th width= 25%>Comments</th>
                    <th width= 5%><a href='bcsalesview.php?sortmode=Op_entered&Show=$stat'>Order entered By</th>
                    <th width= 5%><a href='bcsalesview.php?sortmode=Date_Entered&Show=$stat'>Order entered on</th>
                    <th width= 4%><a href='bcsalesview.php?sortmode=Priority&Show=$stat'>Priority</th>
                    </tr>";
                    $bgcol = 0;
            for ($ki = 0; $ki < $num; ++$ki)
            {
                
                $row = mysqli_fetch_row($result);
                //enter if statement here to check action status
                if ($check_action == 1)
                {
                    //go to orders to batch table and check for an entry
                    $action_check = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE salesorder = '$row[0]' AND item = '$row[1]'");
                    //$action_check = queryMysql($mysqli, "SELECT * FROM bcsalestobatch WHERE (salesorder = '$row[0]' AND item = '$row[1]' ORDER BY '$row[0]'")
                    $num_action_check = mysqli_num_rows($action_check);
                    if ($num_action_check == 0)
                    {
                        //only show lines that do not have an entry
                        show($mysqli, $row, $item, $Order, $Select_Order, $stat,$bgcol);
                        $bgcol = $bgcol +1;
                    }
                }
                else
                {
                    show($mysqli, $row, $item, $Order, $Select_Order, $stat,$bgcol);
                    $bgcol = $bgcol +1;
                }
                
            }
 /*<input type="submit" value="Search" />
</form>


<form class = floatleft action=""bcsalesview.php" method="post"*/  
if ($disp == 4)
{
    echo <<<_END
    <form class = center name="Edit" action="bcsalesview.php?disp=0" method="post">
    RETURN TO MAIN MENU   
    <input type="submit" name="Edit" value="RETURN" />
    </form>
_END;
}         
echo '</div>';

?>

