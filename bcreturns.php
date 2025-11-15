<?php // bcontime.php
include_once 'bcheader.php';
//include_once 'bcfeedbackheader.php';

if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];

  
if (isset($_POST["search_date"]))
{
    $search_date = ($_POST["search_date"]);
}
else 
{
    $search_date = date('Y-m-d');
}
echo <<<_END

<style>

#mylastchart {
    position:relative;
    float:left;
    margin:10px 10px 10px 10px;
    width:90%;
    max-width: 1800px;
    height:400px;
}
</style>
<br /><br />



_END;
//start with the current month
$searchdate = new DateTime($search_date);
$search_date = $searchdate->format('Y-m');
//echo $search_date;
$search_date =  strtotime('-11 month', strtotime($search_date));
$search_date = date('Y-m',$search_date);
$searchdate = new DateTime($search_date);
//echo $search_date;
$Total_shipped_Year = '0';
$Total_late_year = $Total_returned_year = $total_lots = $total_new=$total_scrap= $total_built ='0';

echo <<<_tableend
<table class = margin_only border='4'>
                    <tr>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Total Ordered <br />to be shipped</th>
                    <th>Total late</th>
                    <th># Lots<br />Returned</th>
                    <th>Total<br />Returned</th>
                    <th>% Late</th>
                    <th>% Returned</th>
                    <th>Total New <br />Orders Recieved</th>
                    <th>Total units <br />built</th>
                    <th>Scrap</th>
                    <th>Yield</th>
                    </tr>
_tableend;

//get dates and work outpercentage each month starting with searchdate and working back for a year
for ($i = 0; $i < 12; ++$i)
{
    $result = queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE DATE(expectedshipdate) LIKE '$search_date%'ORDER BY DATE(expectedshipdate) desc");
    $num = mysqli_num_rows($result);
    $total_late = $total_month = 0;
     
            for ($ki = 0; $ki < $num; ++$ki)
            {
                $row = mysqli_fetch_row($result);
                $datetime1 = new DateTime($row[7]);
                $datetime2 = new DateTime($row[8]);
                if ($row[8] == NULL)
                {
                    $interval = $datetime1->diff($datetime1);
                }
                if ($datetime1 < $datetime2)
                {
                    $interval = $datetime1->diff($datetime2);
                    $total_late = $total_late + $row[2];
                }
                else 
                {
                    $interval = $datetime1->diff($datetime1);
                }
                $total_month = $total_month + $row[2];
                
           
            }
            
    $built_result = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE DATE(completed) LIKE '$search_date%'ORDER BY DATE(completed) desc");
    $built_num = mysqli_num_rows($built_result);
    $built_month = $scrap_month = $scrap_num = 0;
     
            for ($ki = 0; $ki < $built_num; ++$ki)
            {
                $built_row = mysqli_fetch_row($built_result);
                $built_month = $built_month + $built_row[5];
               // echo $built_row[5];
               $scrap_result = queryMysql($mysqli, "SELECT * FROM bcoperationsdone WHERE batchno = '$built_row[0]'");
               $scrap_num = mysqli_num_rows($scrap_result);
               $scrap_batch = 0;
               for ($kj = 0; $kj < $scrap_num; ++$kj)
               {
                    $scrap_row = mysqli_fetch_row($scrap_result);
                    $scrap_batch = $scrap_batch + $scrap_row[6];
                }
                $scrap_month += $scrap_batch;
                
           
            }
    //echo $scrap_month;
    $new_result = queryMysql($mysqli, "SELECT * FROM bcsalesorders WHERE DATE(Date_Entered) LIKE '$search_date%'ORDER BY DATE(Date_Entered) desc");
    $new_num = mysqli_num_rows($new_result);
    $new_month = 0;
     
            for ($ki = 0; $ki < $new_num; ++$ki)
            {
                $new_row = mysqli_fetch_row($new_result);
                $new_month = $new_month + $new_row[2];
                
           
            }
    
    $return_result = queryMysql($mysqli, "SELECT * FROM bcreturns WHERE DATE(date_recieved) LIKE '$search_date%'ORDER BY DATE(date_recieved) desc");
    $return_num = mysqli_num_rows($return_result);
    $total_returned_month = 0;
    //echo $return_num;
            for ($ki = 0; $ki < $return_num; ++$ki)
            {
                $return_row = mysqli_fetch_row($return_result);
                //echo $row[2];
                $datetime1 = new DateTime($row[7]);
                $datetime2 = new DateTime($row[8]);
                if ($row[8] == NULL)
                {
                    $interval = $datetime1->diff($datetime1);
                }
                if ($datetime1 < $datetime2)
                {
                    $interval = $datetime1->diff($datetime2);
                   // $total_late = $total_late + $row[2];
                }
                else 
                {
                    $interval = $datetime1->diff($datetime1);
                }
                //echo $return_row[2];
                $total_returned_month = $total_returned_month + $return_row[2];
                
           
            }
    if ($total_month == '0')//stop potential div 0 errors
    {
        $percentage = '0';
    }
    else
    {
        $percentage = $total_late/$total_month * '100';
        $return_percentage = $total_returned_month/$total_month * '100';
        $yield = 100 - ($scrap_month/$built_month * 100);
    }
    
    $Total_shipped_Year += $total_month;
    $Total_late_year += $total_late;
    $Total_returned_year += $total_returned_month;
    $total_lots += $return_num;
    $total_new += $new_month;
    $total_built += $built_month;
    $total_scrap += $scrap_month;
    $total_yield = 100 - ($total_scrap/$total_built * 100);
    
    echo "
            <tr>
            <td> ".$searchdate->format('M')." </td>
            <td> ".$searchdate->format('Y')." </td>
            <td> $total_month </td>
            <td> $total_late </td>
            <td>$return_num</td>
            <td> $total_returned_month </td>
            <td> ".number_format($percentage,2)." %</td>
            <td> ".number_format($return_percentage,2)." %</td>
            <td>$new_month</td>
            <td>$built_month</td>
            <td>$scrap_month</td>
            <td>".number_format($yield,2)." %</td>
            
            </tr>
    
    ";
    
    //$Year['percentage'][$i]=$percentage;
     $ret_Year[1][$i]=$return_percentage;
     $Year[1][$i]=$percentage;
    //$Year['search_date'][$i]=$searchdate->format('M-Y'); 
     $Year[0][$i]=$searchdate->format('M-Y'); 
       
    $search_date =  strtotime('+1 month', strtotime($search_date));
    $search_date = date('Y-m',$search_date);
    $searchdate = new DateTime($search_date);
}
if ($Total_shipped_Year == '0')//stop potential div 0 errors
    {
        $annual_percentacge = '0';
    }
    else
    {
        $annual_percentage = $Total_late_year/$Total_shipped_Year * '100';
        $annual_return_percentage = $Total_returned_year/$Total_shipped_Year * '100';
    }
    

echo "
<tr bgcolor='#eeeeee'>
            <td>Totals</td>
            <td></td>
            <td> $Total_shipped_Year </td>
            <td> $Total_late_year </td>
            <td> $total_lots</td>
            <td> $Total_returned_year</td>
            <td> ".number_format($annual_percentage,2)." % </td>
            <td> ".number_format($annual_return_percentage,2)." %</td>
            <td>$total_new</td>
            <td>$total_built</td>
            <td>$total_scrap</td>
            <td>".number_format($total_yield,2)." %</td>
            </tr>
</table>";

/*
echo "
<table class = margin_only border='4' cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
                        <tr><th colspan='10' align='center'>Previous 12 month Totals</th></tr>
            <tr>
            <th>Total Ordered<br />to be shipped</th>
            <th>Total late</th>
            <th>Total lots <br />returned</th>
            <th>Total<br />Returned</th>
            <th>% Late</th>
            <th>% Returned</th>
            <th>Total New<br />Orders Recieved</th>
            <th>Total Units Built</th>
            <th>Total Scrap</th>
            <th>Yield</th
            </tr>
            <tr>
            <td> $Total_shipped_Year </td>
            <td> $Total_late_year </td>
            <td> $total_lots</td>
            <td> $Total_returned_year</td>
            <td> ".number_format($annual_percentage,2)." </td>
            <td> ".number_format($annual_return_percentage,2)." </td>
            <td>$total_new</td>
            <td>$total_built</td>
            <td>$total_scrap</td>
            <td>".number_format($total_yield,2)." %</td>
            </tr></table>
            <br />
";    
*/    
echo "
<form method='post' action='bcreturns.php?'
                                onSubmit='return validate(this)'>
<table class = left border='4' cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
                        <tr><th colspan='2' align='center'>Ontime search</th></tr>
                        
                        <tr><td>Enter date required</td><td>";rfxlinecalendar('search_date');echo"
                        </td>
                        </tr><tr><td colspan='2' align='center'>
                        <input type='submit' value='Go' /></td>
                        </tr></table></form>

";



//print_r($Year);
/*
echo "
<script type='text/javascript'>
(function() {
// Create a new YUI instance and populate it with the required modules.
YUI().use('charts', function (Y) {
    // Charts is available and ready for use. Add implementation
    // code here.
    
var myDataValues = [ 
            {category:'".$Year[0][0]."', values:".$Year[1][0]."},
            {category:'".$Year[0][1]."', values:".$Year[1][1]."},
            {category:'".$Year[0][2]."', values:".$Year[1][2]."},
            {category:'".$Year[0][3]."', values:".$Year[1][3]."},
            {category:'".$Year[0][4]."', values:".$Year[1][4]."},
            {category:'".$Year[0][5]."', values:".$Year[1][5]."},
            {category:'".$Year[0][6]."', values:".$Year[1][6]."},
            {category:'".$Year[0][7]."', values:".$Year[1][7]."},
            {category:'".$Year[0][8]."', values:".$Year[1][8]."},
            {category:'".$Year[0][9]."', values:".$Year[1][9]."},
            {category:'".$Year[0][10]."', values:".$Year[1][10]."},
            {category:'".$Year[0][11]."', values:".$Year[1][11]."}
        ];
    

     var myotherchart = new Y.Chart({dataProvider:myDataValues,
                                render:'#myotherchart',
                                categoryKey:'category'});
    });
})();
</script>
";*/

/*
echo "

<div id='mylastchart'></div>
<script type='text/javascript'>
(function() {
    YUI().use('charts', function (Y) 
    { 
        var myDataValues = [ 
            {category:'".$Year[0][0]."', values:},
            {category:'".$Year[0][1]."', values:".$Year[1][1]."},
            {category:'".$Year[0][2]."', values:".$Year[1][2]."},
            {category:'".$Year[0][3]."', values:".$Year[1][3]."},
            {category:'".$Year[0][4]."', values:".$Year[1][4]."},
            {category:'".$Year[0][5]."', values:".$Year[1][5]."},
            {category:'".$Year[0][6]."', values:".$Year[1][6]."},
            {category:'".$Year[0][7]."', values:".$Year[1][7]."},
            {category:'".$Year[0][8]."', values:".$Year[1][8]."},
            {category:'".$Year[0][9]."', values:".$Year[1][9]."},
            {category:'".$Year[0][10]."', values:".$Year[1][10]."},
            {category:'".$Year[0][11]."', values:".$Year[1][11]."}
        ];
        
        var mychart = new Y.Chart({dataProvider:myDataValues, render:'#mychart'});
    });
})();
</script>

";
*/
echo "
<div id='mylastchart'>
<script type='text/javascript'>
(function() {
    YUI().use('charts-legend', function (Y) 
    { 
        var myDataValues = [ 
            {Date:'".$Year[0][0]."', returns:".$ret_Year[1][0].", Late:".$Year[1][0]."},
            {Date:'".$Year[0][1]."', returns:".$ret_Year[1][1].", Late:".$Year[1][1]."},
            {Date:'".$Year[0][2]."', returns:".$ret_Year[1][2].", Late:".$Year[1][2]."},
            {Date:'".$Year[0][3]."', returns:".$ret_Year[1][3].", Late:".$Year[1][3]."},
            {Date:'".$Year[0][4]."', returns:".$ret_Year[1][4].", Late:".$Year[1][4]."},
            {Date:'".$Year[0][5]."', returns:".$ret_Year[1][5].", Late:".$Year[1][5]."},
            {Date:'".$Year[0][6]."', returns:".$ret_Year[1][6].", Late:".$Year[1][6]."},
            {Date:'".$Year[0][7]."', returns:".$ret_Year[1][7].", Late:".$Year[1][7]."},
            {Date:'".$Year[0][8]."', returns:".$ret_Year[1][8].", Late:".$Year[1][8]."},
            {Date:'".$Year[0][9]."', returns:".$ret_Year[1][9].", Late:".$Year[1][9]."},
            {Date:'".$Year[0][10]."', returns:".$ret_Year[1][10].", Late:".$Year[1][10]."},
            {Date:'".$Year[0][11]."', returns:".$ret_Year[1][11].", Late:".$Year[1][11]."}
        ];
        
        var mylastchart = new Y.Chart({
                    legend: {
                            position: 'right',
                            width: 300,
                            height: 300,
                            styles: {
                                hAlign: 'center',
                                hSpacing: 4
                            }
                        },
                        axes: {
                            category: {
                                keys: ['Date'],
                                type: 'category',
                                styles: {
                                    label: {
                                        rotation: -90
                                    }
                                }
                            }
                        },
                        categoryKey: 'Date',
            dataProvider:myDataValues, horizontalGridlines: true,
                        verticalGridlines: true,render:'#mylastchart'});
    });
})();
</script></div>";

?>