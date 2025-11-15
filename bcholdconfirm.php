<?php
include_once 'bcheader.php';
if (!isset($_SESSION['user']))
	die("<br /><br />You need to login to view this page");
$user = $_SESSION['user'];
$Batch = $_SESSION['batch'];
echo '<H3><a href="bcbatchinfo.php?view='.$Batch.'">Batch to be placed on hold '.$Batch.'</a></H3>';
if (isset($_GET['Hold']))
    {$hold = ($_GET["Hold"]);}
$hold = $_SESSION['Hold'];

if ($hold == 2)
{               
    echo <<<_END
    </br></br>

    <form name="hold" action="bcbatchinfo.php?hold=1" method="post">
    <h3>Continuing will put this batch on HOLD no operations may be carried out</h3>
    <input type="submit" name="hold" value="hold" />
    </form>

_END;
}
else
{
    echo <<<_END
    </br></br>

    <form name="hold" action="bcbatchinfo.php?hold=2" method="post">
    <h3>Continuing will release this batch from HOLD</h3>
    <input type="submit" name="hold" value="hold" />
    </form>

_END;
}
?>