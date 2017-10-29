<?php
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>WJC - Forgot Password</title>

<style>
body {
        text-align:center;
}

#wrapper {
        margin: 0 auto;
        width: 900px;
        text-align:left;
}

</style>
<link rel="stylesheet" href="../assets/css/styles.css" />
<link href="../contactform/css/contactform.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="center" width="900">
    <tr>
        <td width="75" align="left" id="logoPart">
        	<a href="index.html"><img src="../img/logo_ini_rnd.gif" border="0" alt="logo" align="absmiddle" /></a>
        </td>
        <td width="100"></td>
        <td width="555">
            <nav>
            <ul class="fancyNav">
            <li id="home"><a href="../index.html" class="homeIcon">Home</a></li>
            <li id="news"><a href="../about.html" class="homeIcon1">About WJC</a></li>
            <li id="about"><a href="../careers.html" class="homeIcon2">Careers</a></li>
            <li id="services"><a href="../contact.php" class="homeIcon3">Contact Us</a></li>
            <li id="contact"><a href="../login.php" class="homeIcon4">Log on</a></li>
            </ul>
            </nav>
        </td>
    </tr>
</table>
<table align="center">
	<tr>
		<td>
      <div id="formWrap" style="align: center;">
        <h2>Forgot Password</h2>
        <div id="form">
    			<?php
            if(!$username && !$userid)
                {
                if ($_POST['resetbtn'])
                    {
                    // get the form data
                    $user = $_POST['user'];
                    $email = $_POST['email'];

                    //make sure info provided
                    if ($user)
                        {
                        if ($email)
                            {
                            if ((strlen($email) >= 7) && (strstr($email, "@")) && (strstr($email, "." )))
                                {
                                require("./connect.php");

                                $query = mysql_query("SELECT * FROM users WHERE username='$user'");
                                $numrows = mysql_num_rows($query);

                                if ($numrows ==1)
                                    {
                                    // get info about the account
                                    $row = mysql_fetch_assoc($query);
                                    $dbemail = $row['email'];

                                    // make sure email is correct
                                    if ($email == $dbemail)
                                        {
                                        // generate password
                                        $pass = rand();
                                        $pass = md5($pass);
                                        $pass = substr($pass, 0, 15);
                                        $password = md5(md5("hihHLf".$pass."DFSg846360"));

                                        // update db with new pass
                                        mysql_query("UPDATE users SET password='$password' WHERE username='$user'");

                                        // make sure password was changes
                                        $query = mysql_query("SELECT * FROM users WHERE username='$user' AND password='$password'");
                                        $numrows = mysql_num_rows($query);

                                        if ($numrows == 1)
                                            {
                                            // create email variables
                                            $site = "http://127.0.0.1/tieumcorp/memberregistration";
                                            $webmaster = "WFC <tieum27@hotmail.com>";
                                            $headers = "From: $webmaster";
                                            $subject = "Your new Password";
                                            $message = "Hello. Your password has been reset. Your new password is below. \n";
                                            $message .= "Password: $password \n";
                                            $message .= "If you did not request a password reset, please notify the webmaster $webmaster.";

                                            // echo $pass."<br />";
                                            if (mail($getemail, $subject, $message, $headers))
                                                {
                                                echo "$pass <br />";
                                                echo "Your password has been reset. An email has been sent with your new password.";
                                                }
                                                else
                                                    echo " An error as occured. Your email was not sent containing your new password.";
                                            }
                                            else
                                                echo "An error has occured and the password was not reset.";

                                        }
                                        else
                                            echo "You have enter the wrong email address";
                                    }
                                    else
                                        echo "The username was not found.";

                                mysql_close();
                                }
                                else
                                    echo "Please enter a invalid email address.";
                            }
                            else
                                echo "Please enter your email.";
                        }
                        else
                            echo "Please enter your username.";
                    }
                    echo "<form action='./forgotpass.php' method='post'>
                          <div class='row'>
                            <div class='label'>Username</div>
            								<div class='input'>
            									<input type='text' name='user' />
            								</div>
              						</div>
            							<div class='row'>
            								<div class='label'>Email</div>
            								<div class='input'>
            									<input type='text' name='email' /></div>
              							</div>
                            <div class='submit'>
              								<input type='submit' id='submit' name='resetbtn' value='Reset Password' class='bt_lost_pwd' />
                            </div>
                          </div>
                          </form>";
                }
                else
                    echo "Please logout to view this page. <a href='./logout.php'>Logout</a>";
          ?>
        </div>
      </div>
		</td>
	</tr>
</table>
</body>
</html>
