<?php // bcsalesview.php
include_once 'bcheader.php';



if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

//get open orders
//get previous priorities
//show in a tabled form with the order number, item, productcode and description. and current priorities
//get the user to input 1 to x for priorities and set levels
//submit to go to a confirmation page and save the changes.
/* POPUP CODE
ECHO <<<_END
<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
</script>
<a href="JavaScript:newPopup('http://www.quackit.com/html/html_help.cfm');">Open a popup window</a>
_END;*/   
$i = 0;
//Get all the open and unstarted orders
$orders= queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE actualshipdate IS NULL ORDER BY Priority");
//display in a form with the order priority cell as an input
echo"   <form><table class = tablefloatleft border='4'>
                    <tr>
                    <th width= 5%>Sales Order</th>
                    <th width= 4%>Item #</th>
                    <th width= 4%>Quantity</th>
                    <th width= 10%>Product Code</th>
                    <th width= 15%>Customer</th>
                    <th width= 15%>Description</th>
                    <th width= 4%>Date expected at Customer</th>
                    <th width= 4%>Date expected to ship</th>
                    <th width= 25%>Comments</th>
                    <th width= 5%>Order entered By</th>
                    <th width= 5%>Order entered on</th>
                    <th width= 4%>Enter Priority</th>
                    </tr>";
 while($row_orders=mysqli_fetch_array($orders))
    {
        
        echo"<tr>
            <td>$row_orders[0]</td>
            <td>$row_orders[1]</td>
            <td>$row_orders[2]</td>
            <td>$row_orders[3]</td>
            <td>$row_orders[4]</td>
            <td>$row_orders[5]</td>
            <td>$row_orders[6]</td>
            <td>$row_orders[7]</td>
            <td>$row_orders[9]</td>
            <td>$row_orders[10]</td>
            <td>$row_orders[11]</td>
            <td><input name='priority($i)' value = $row_orders[12]></td>
            </tr>";
            
        ++$i;
    }
echo "</table></form>";
        
 /*<input type="submit" value="Search" />
</form> */

?>

