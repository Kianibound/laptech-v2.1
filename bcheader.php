<?php // bcheader.php
include 'bcfunctions.php';


if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$loggedin = TRUE;
}
else $loggedin = FALSE;

//echo "<title>$appname";


echo '</title>
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="-1">
        <font face="verdana" size="2">';
//echo "<h2><img class = rfximg src='laptechlogo.jpg' width='70' height='50'>$appname</h2></font>";
//echo "<h2><img class = rfximg src='rfx.png' width='70' height='50'>$appname</h2></font>";

echo <<<_END
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Quartz Crystals,OCXO, TCXO Precision Oscillators and Custom Wound Components by LapTech Precision</title>
<meta name="Description" content="Laptech Precision - manufacturer of precision quartz oscillators - 1MHz ~ 2.4GHz, OCXO, TCXO, VCXO, PLL, smd, GPS synchronised oscillators, GPS timing modules, GPS OCXO, GPS stabilised OCXO, low phase noise, base stations, precision quartz, rf, oven controlled crystal, precision, temperature compensated crystal and voltage controlled crystal oscillators" />
<meta name="keywords" content="TCXO, OCXO, VCXO, Microbalance, quartz crystal oscillators, Clock oscillators, QCM, Phase Noise, Crystal Oscillators, Quartz Wafer, Quartz Microbalance, HC43, Crystal oscillator, Quartz resonator, crystal quartz oscillator, Quartz Resonator, SC-Cut, HC43 Crystal, Low Noise Crystals, Precision crystal oscillator, Low noise crystal, Material lapping and polishing" />
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="main-styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="CSSMenuWriter/cssmw/menu.js"></script>

<style type="text/css" media="all">
<!--
@import url("CSSMenuWriter/cssmw/menu.css");
-->
</style>

<!-- InstanceBeginEditable name="menu_ie" -->
<!--[if lte IE 6]>
<style type="text/css" media="all">
@import url("../CSSMenuWriter/cssmw/menu_ie.css");
</style>

<style type="text/css" media="all">
img, div, ul, li, span, a {
  behavior: url("../CSSMenuWriter/cssmw_images/iepngfix.htc");
}
</style>

<![endif]-->
<!-- InstanceEndEditable -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21717191-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>
	<div id="main-container">

    	<div id="head-container">
        	<div id="head-col"><img src="images/logo.jpg" alt="LapTech" width="310" height="160" border="0" /></div>
            <div id="head-col"><div class="clock">
_END;
$now = date('c');
echo date('l jS \of F Y');
echo <<<_END
                    <span id=tick2>

</span>

<script>
<!--

/*By JavaScript Kit
http://javascriptkit.com
Credit MUST stay intact for use
*/

function show2(){
if (!document.all&&!document.getElementById)
return
thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2
var Digital=new Date()
var hours=Digital.getHours()
var minutes=Digital.getMinutes()
var seconds=Digital.getSeconds()
var dn="p.m."
if (hours<12)
dn="a.m."
if (hours>12)
hours=hours-12
if (hours==0)
hours=12
if (minutes<=9)
minutes="0"+minutes
if (seconds<=9)
seconds="0"+seconds
var ctime=hours+":"+minutes+":"+seconds+" "+dn
thelement.innerHTML=""+ctime+""
setTimeout("show2()",1000)
}
window.onload=show2
//-->
</script>
_END;
if (isset($_SESSION['user']))
{
        echo '<br />'.$user.' is currently logged in' ;
}
echo <<<_END
	    </div></div>

            <div id="head-col"><img src="images/index-main-img.jpg" alt="Telephone (905) 623-4101" width="310" height="160" border="0" usemap="#Map" />

              <map name="Map" id="Map">
                <area shape="rect" coords="136,109,309,130" href="mailto:sales@laptech.com" target="_blank" alt="email sales@laptech.com" />
              </map>
            </div>
           
      </div>
_END;

if ($loggedin)
{
    
echo <<<_END

<div id="navigation"><ul class="level-0" id="cssmw">
<li><span><a href="bcmembers.php?view=$user">HOME</a></span></li>
<li class="parent"><span><a href="bcbatches.php?disp=0">Batches</a></span>
  <ul class="level-1">
                  <li><a href="bcbatches.php?disp=2">Enter Batch Number</a></li>
          <li><a href="bcbatches.php?disp=4">Search Batches</a></li>
          <li><a href="bcbatches.php?disp=3">Stop all batches for $user</a></li>
           <li><a href="bcbatches.php?disp=5">Start/Stop a task not associated with a batch</a></li>
          <li><a href="bcmessages.php">Create</a></li>
<li><a href="bcbatches.php?disp=1&dept=1">Show lapping operations</a></li>
<li><a href="bcbatches.php?disp=1&dept=2">Show Finishing operations</a></li>
<li><a href="bcbatches.php?disp=1&dept=100">Show indicator operations</a></li>
<li><a href="bcbatches.php?disp=1&dept=0">show operations</a></li>
<li><a href="bcbatches.php?search=&Arrange=batchno&Show=0">Show unstarted batches</a></li>
</ul>
</li>
_END;
if (isset($batchinfo) && $batchinfo == 1)
{
if (isset($_GET["view"]))
{
    $view = ($_GET["view"]);
    $_SESSION['batch'] = $view;
}
echo <<<_END
   <li class="parent"><span><a>Actions</a></span>
<ul class="level-1">
          <li><a href="bccloseconfirm.php?Close=1">Close this batch</a></li>
          <li><a href="bceditbatch.php?">Edit Batch</a></li>
          <li><a href="bcbatchtoworksorder.php">Assign Batch to A works order</a></li>
          <li><a href="bcbatchtoorder.php">Assign Batch to A sales order</a></li>
          <li><a href="bcworkdonebatch.php">View and Search work on this batch</a></li>
          <li><a href="bcholdconfirm.php?">Hold/Release this batch </a></li>
</ul>
</li>
_END;
}




echo <<<_END
<li class="parent"><span><a href="bcsalesview.php?disp=0">Sales</a></span>
  <ul class="level-1">
          <li><a href="bcsalesview.php?disp=1">Enter new sales order</a></li>
          <li><a href="bcsalesview.php?disp=2">Search orders</a></li>
          <li><a href="bcsalespriority.php?disp=3">Set order priority</a></li>
          <li><a href="bcsalesview.php?disp=4">View with no header</a></li>
          <li><a href="bcsalesview.php?Show=3">Unactioned orders</a></li>
</ul>
</li>
_END;

if (isset($salesview) && $salesview == 1)
{
if (isset($_GET["action"]))
{
    $action = ($_GET["action"]);
   // $_SESSION['action'] = $action;
}
echo <<<_END
<li class="parent"><span><a>Actions</a></span>
<ul class="level-1">
          <li><a href="bcsalesview.php?item=$item&order=$Order&Select_Order=$Select_Order&Show=$stat&action=1">Add an Item</a></li>
          <li><a href="bcsalesview.php?item=$item&order=$Order&Select_Order=$Select_Order&Show=$stat&action=2">Change this Item</a></li>
          <li><a href="bcsalesview.php?item=$item&order=$Order&Select_Order=$Select_Order&Show=$stat&action=3">Split into two items</a></li>
          <li><a href="bcsalesview.php?item=$item&order=$Order&Select_Order=$Select_Order&Show=$stat&action=4">Edit/Enter comment</a></li>
          <li><a href="bcsalesview.php?item=$item&order=$Order&Select_Order=$Select_Order&Show=$stat&action=5">Ship item</a></li>
</ul>
</li>
_END;
}

echo <<<_END
<li><span><a href="bcmembers.php">Users</a></span></li>
<li class="parent"><span><a href="bcworkdone.php">Feedback</a></span>
<ul class="level-1">
          <li><a href="bcworkdone.php">Work Done</a></li>
          <li><a href="bcontime.php">On Time</a></li>
          <li><a href="bcontimesearch.php">On Time with breackdown</a></li>
          <li><a href="bccompareop2.php?Op1=47&Op2=49">Time between 2 operations</a></li>
          <li><a href="bccomparecreate.php?">Time between order and batch creation</a></li>
           <li><a href="yield.php?">Yield by Productcode - Batch - Operation</a></li>
</ul>
</li>
<li><span><a href="bcstock.php">Stock</a></span></li>

<li><span><a href="bclogout.php">Log Out</a></span></li>
</ul>

<script type="text/javascript">if(window.attachEvent) { window.attachEvent("onload", function() { cssmw.intializeMenu('cssmw',{select_current: 1, orientation: 1}); }); } else if(window.addEventListener) { window.addEventListener("load", function() { cssmw.intializeMenu('cssmw',{select_current: 1, orientation: 1}); }, true); }</script>
     <div id="lib"><a href="bcfriends.php">COLLEAGUES</a></div></div>
_END;
if (isset($batchinfo) && $batchinfo == 1)
{
echo <<<_END
   
_END;
}
}/*
if ($loggedin)
{
	echo "<b >$user</b>:

        
		 <a href='bcmembers.php?view=$user'>Home</a> |
		 <a href='bcmembers.php'>Users</a> |
                 <a href='bcbatches.php'>Batches</a> |
                 <a href='bcsalesview.php'>Sales</a> |
		 <a href='bcfriends.php'>Collegues</a> |
		 <a href='bcmessages.php'>Create</a> |
		 <a href='bcprofile.php'>Profile</a> |
                 <a href='bcstock.php'>Stock viewer</a> |
                 <a href='bcworkdone.php'>Feedback reports</a> |
		 <a href='bclogout.php'>Log out</a>";
                 
                 
}*/
else
{/*
	echo "<a href='index.php'>Home</a> |
		 <a href='bcsignup.php'>Sign up</a> |
		 <a href='bclogin.php'>Log in</a>
                 ";
   */              
echo <<<_END

<div id="navigation"><ul class="level-0" id="cssmw">
<li><span><a href="index.php">HOME</a></span></li>
<li><span><a href="bcsignup.php">SIGN UP</a></span></li>
<script type="text/javascript">if(window.attachEvent) { window.attachEvent("onload", function() { cssmw.intializeMenu('cssmw',{select_current: 1, orientation: 1}); }); } else if(window.addEventListener) { window.addEventListener("load", function() { cssmw.intializeMenu('cssmw',{select_current: 1, orientation: 1}); }, true); }</script>
     <div id="lib"><a href="bclogin.php">LOG IN</a></div></div> 
_END;
}
?>
