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
        // Check bcmembers table first
        $stmt = $mysqli->prepare("SELECT user,pass FROM bcmembers WHERE user=? AND pass=?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) == 0)
        {
            // Check bcpeople table as fallback
            $stmt2 = $mysqli->prepare("SELECT username,password FROM bcpeople WHERE username=? AND password=?");
            $stmt2->bind_param("ss", $user, $pass);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if (mysqli_num_rows($result2) == 0)
            {
                $error = "Username/Password invalid<br />";
            }
            else
            {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                header("Location: bcbatches.php?disp=0");
                exit();
            }
            $stmt2->close();
        }
        else
        {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            header("Location: bcmembers.php?view=" . urlencode($user));
            exit();
        }
        $stmt->close();

        // Handle message deletion if requested
        if (isset($_GET['erase']))
        {
            $erase = filter_input(INPUT_GET, 'erase', FILTER_VALIDATE_INT);
            if ($erase !== false) {
                $stmt3 = $mysqli->prepare("DELETE FROM bcmessages WHERE id=? AND recip=?");
                $stmt3->bind_param("is", $erase, $user);
                $stmt3->execute();
                $stmt3->close();
            }
        }
        
        // Display messages
        $result = queryMysql($mysqli, "SELECT * FROM bcmessages ORDER BY time DESC");
        $num = mysqli_num_rows($result);
        
        for ($j = 0 ; $j < $num ; ++$j)
        {
                $row = mysqli_fetch_row($result);

                if ($row[3] == 0 || $row[1] == $user || $row[2] == $user)
                {
                        echo date('M jS \'y g:ia:', $row[4]);
                        echo " <a href='bcmessages.php?";
                        echo "view=$row[1]'>$row[1]</a> ";

                        if ($row[3] == 0)
                        {
                                echo 'wrote: "' . htmlspecialchars($row[5]) . '" ';
                        }
                        else
                        {
                                echo 'whispered: <i><font color="#006600">"' . htmlspecialchars($row[5]) . '"</font></i> ';
                        }

                        if ($row[1] == $user || $row[2] == $user)
                        {
                                echo "[<a href='bcmessages.php?";
                                echo "&erase=$row[0]'>erase</a>]";
                        }
                        echo "<br>";
                }
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
