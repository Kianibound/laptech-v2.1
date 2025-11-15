<?php // bclogin.php
include_once 'bcheader.php';
echo "<h3>Member Log in</h3>";
$error = $user = $pass = "";

if (isset($_POST['user']))
{
	$user = sanitizeString($mysqli, $_POST['user']);
	$pass = sanitizeString($mysqli, $_POST['pass']);
	
	if ($user == "" || $pass == "")
	{
		$error = "Not all fields were entered<br />";
	}
	else
        {
		$query = "SELECT user,pass FROM bcmembers
				  WHERE user='$user' AND pass='$pass'";

		if (mysqli_num_rows(queryMysql($mysqli, $query)) == 0)
		{
			$error = "Username/Password invalid<br />";
		}
		else
		{
			$_SESSION['user'] = $user;
			$_SESSION['pass'] = $pass;
			/*die*/("You are now logged in. Please
			   <a href='bcmembers.php?view=$user'>click here</a>.\n");
                           if (isset($_GET['erase']))
                            {
                                    $erase = sanitizeString($mysqli, $_GET['erase']);
                                    queryMysql($mysqli, "DELETE FROM bcmessages WHERE id=$erase
                                                        AND recip='$user'");
                            }
                            
                            $query = "SELECT * FROM bcmessages 
                                              ORDER BY time DESC";//WHERE recip='$view'
                            $result = queryMysql($mysqli, $query);
                            $num = mysqli_num_rows($result);
                            
                            for ($j = 0 ; $j < $num ; ++$j)
                            {
                                    $row = mysqli_fetch_row($result);

                                    if ($row[3] == 0 ||
                                        $row[1] == $user ||
                                        $row[2] == $user)
                                    {
                                            echo date('M jS \'y g:ia:', $row[4]);
                                            echo " <a href='bcmessages.php?";
                                            echo "view=$row[1]'>$row[1]</a> ";

                                            if ($row[3] == 0)
                                            {
                                                    echo "wrote: &quot;$row[5]&quot; ";
                                            }
                                            else
                                            {
                                                    echo "whispered: <i><font
                                                    color='#006600'>&quot;$row[5]&quot;</font></i> ";
                                            }

                                            if ($row[1] == $user || $row[2] == $user)
                                            {
                                                    echo "[<a href='bcmessages.php?";
                                                    echo "&erase=$row[0]'>erase</a>]";
                                            }
                                            echo "<br>";
                                    }
                            }
                          //echo '<meta http-equiv="Refresh" content="0;url = bcbatches.php?disp=0" />';
                }
                $query = "SELECT username,password FROM bcpeople
				  WHERE username='$user' AND password='$pass'";

		if (mysqli_num_rows(queryMysql($mysqli, $query)) == 0)
		{
			$error = "Username/Password invalid<br />";
		}
		else
		{
			$_SESSION['user'] = $user;
			$_SESSION['pass'] = $pass;
			die("You are now logged in. Please
			   <a href='bcbatches.php?disp=0'>click here</a>.");
                           if (isset($_GET['erase']))
                            {
                                    $erase = sanitizeString($mysqli, $_GET['erase']);
                                    queryMysql($mysqli, "DELETE FROM bcmessages WHERE id=$erase
                                                        AND recip='$user'");
                            }
                            
                            $query = "SELECT * FROM bcmessages 
                                              ORDER BY time DESC";//WHERE recip='$view'
                            $result = queryMysql($mysqli, $query);
                            $num = mysqli_num_rows($result);
                            
                            for ($j = 0 ; $j < $num ; ++$j)
                            {
                                    $row = mysqli_fetch_row($result);

                                    if ($row[3] == 0 ||
                                        $row[1] == $user ||
                                        $row[2] == $user)
                                    {
                                            echo date('M jS \'y g:ia:', $row[4]);
                                            echo " <a href='bcmessages.php?";
                                            echo "view=$row[1]'>$row[1]</a> ";

                                            if ($row[3] == 0)
                                            {
                                                    echo "wrote: &quot;$row[5]&quot; ";
                                            }
                                            else
                                            {
                                                    echo "whispered: <i><font
                                                    color='#006600'>&quot;$row[5]&quot;</font></i> ";
                                            }

                                            if ($row[1] == $user || $row[2] == $user)
                                            {
                                                    echo "[<a href='bcmessages.php?";
                                                    echo "&erase=$row[0]'>erase</a>]";
                                            }
                                            echo "<br>";
                                    }
                            }
                          // echo '<meta http-equiv="Refresh" content="0;url = bcbatches.php?disp=0" />';
		}
	}
}

echo <<<_END
<form method='post' action='bclogin.php'>$error
Username <input type='text' maxlength='16' name='user'
	value='$user' /><br />
Password <input type='password' maxlength='16' name='pass'
	value='$pass' /><br />
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input type='submit' value='Login' />
</form>
_END;
?>
