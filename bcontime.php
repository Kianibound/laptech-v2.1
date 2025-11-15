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
    float:right;
    margin:10px 10px 10px 10px;
    width:90%;
    max-width: 800px;
    height:400px;
}
</style>
<br /><br />
<div id="mychart"></div>


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
$Total_late_year = '0';

echo <<<_tableend
<table class = margin_only border='4'>
                    <tr>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Total Ordered</th>
                    <th>Total late</th>
                    <th>% Late</th>
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
    if ($total_month == '0')//stop potential div 0 errors
    {
        $percentage = '0';
    }
    else
    {
        $percentage = $total_late/$total_month * '100';
    }
    $Total_shipped_Year += $total_month;
    $Total_late_year += $total_late;
    
    echo "
            <tr>
            <td> ".$searchdate->format('M')." </td>
            <td> ".$searchdate->format('Y')." </td>
            <td> $total_month </td>
            <td> $total_late </td>
            <td> ".number_format($percentage,2)." </td>
            </tr>
    
    ";
    
    //$Year['percentage'][$i]=$percentage;
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
    }

echo "</table>
<table class = floatleft border='4' cellpadding='2'
                        cellspacing='5' bgcolor='#eeeeee'>
                        <tr><th colspan='2' align='center'>Previous 12 month Totals</th></tr>
            <tr>
            <th>Total Ordered</th>
            <th>Total late</th>
            <th>% Late</th>
            </tr>
            <tr>
            <td> $Total_shipped_Year </td>
            <td> $Total_late_year </td>
            <td> ".number_format($annual_percentage,2)." </td>
            </tr></table>
            <br />
";    
    
echo "
<form method='post' action='bcontime.php?'
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
";
echo "
<div id='mylastchart'>show me</div>
<script type='text/javascript'>
(function() {
    YUI().use('charts', function (Y) 
    { 
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
        
        var mylastchart = new Y.Chart({dataProvider:myDataValues, render:'#mylastchart'});
    });
})();
</script>";*/
echo "

<div id='mychart'></div>
<script type='text/javascript'>
(function() {
    YUI().use('charts', function (Y) 
    { 
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
        
        var mychart = new Y.Chart({dataProvider:myDataValues, render:'#mychart'});
    });
})();
</script>

";

?>