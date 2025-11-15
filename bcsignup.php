<?php // bcsignup.php
include_once 'bcheader.php';

echo <<<_END
<script>
function checkUser(user)
{
	if (user.value == '')
	{
		document.getElementById('info').innerHTML = ''
		return
	}

	params  = "user=" + user.value
	request = new ajaxRequest()
	request.open("POST", "bccheckuser.php", true)
	request.setRequestHeader("Content-type",
		"application/x-www-form-urlencoded")
	request.setRequestHeader("Content-length", params.length)
	request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				if (this.responseText != null)
				{
					document.getElementById('info').innerHTML =
						this.responseText
				}
				else alert("Ajax error: No data received")
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	request.send(params)
}

function ajaxRequest()
{
	try
	{
		var request = new XMLHttpRequest()
	}
	catch(e1)
	{
		try
		{
			request = new ActiveXObject("Msxml2.XMLHTTP")
		}
		catch(e2)
		{
			try
			{
				request = new ActiveXObject("Microsoft.XMLHTTP")
			}
			catch(e3)
			{
				request = false
			}
		}
	}
	return request
}
</script>
<h3>Sign up Form</h3>
_END;

$error = $user = $pass = $fname= $lname= $staff= $pass_length= "";
if (isset($_SESSION['user'])) destroySession();

if (isset($_POST['user']))
{
	$user = sanitizeString($mysqli, $_POST['user']);
	$pass = sanitizeString($mysqli, $_POST['pass']);
        $fname = sanitizeString($mysqli, $_POST['fname']);
        $lname = sanitizeString($mysqli, $_POST['lname']);
        $staff = sanitizeString($mysqli, $_POST['staff']);
        $pass_length = "";
        $error = "";
	
	if ($user == "" || $pass == "" || $fname == ""|| $lname == "")
	{
		die("Not all fields were entered<br /><br />");
	}
	else
	{
		$query = "SELECT * FROM bcpeople WHERE username='$user'";

		if (mysqli_num_rows(queryMysql($mysqli, $query)))
		{
			die("That username already exists<br /><br />");
		}
		else
		{
                    //$pass_length = count((array)$pass);
			$pass_length = strlen($pass);


                    if ($pass_length < 5)
                    {
                        die("Your password was not long enough. Passwords must be more than 5 characters in length");
                    }   
                    else
                    {
			$query = "INSERT INTO bcpeople VALUES('$fname','$lname'
                                    ,'$user','$staff','$pass', NULL)";
			queryMysql($mysqli, $query);
                    }
		}

                    $query = "SELECT * FROM bcmembers WHERE user='$user'";
            

                    if (mysqli_num_rows(queryMysql($mysqli, $query)) || $pass_length < 5)
                    {
			die("That username already exists or password is too short<br /><br />");
                    }
                    else
                    {
			$query = "INSERT INTO bcmembers VALUES('$user', '$pass')";
			queryMysql($mysqli, $query);
                        
                    }

                        die("<h4>Account created</h4>Please Log in.");


	}
}

echo <<<_END
<form method='post' action='bcsignup.php'>$error
First name <input type='text' maxlength='16' name='fname'
	value='$fname' /><br />
Last name <input type='text' maxlength='16' name='lname'
	value='$lname' /><br />
Username <input type='text' maxlength='16' name='user' value='$user'
	onBlur='checkUser(this)'/><span id='info'></span><br />
Staff No. <input type='text' maxlength='16' name='staff'
	value='$staff' /><br />
Password <input type='text' maxlength='16' name='pass'
	value='$pass' /><br />
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input type='submit' value='Signup' />
</form>
_END;
?>
