<?php
error_reporting (E_ALL ^ E_NOTICE);

define('INCLUDE_CHECK',true);

require 'slidelogin/connect.php';
require 'slidelogin/functions.php';
// Those two files can be included only if INCLUDE_CHECK is defined


session_name('tzLogin');
// Starting the session

session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks

session_start();

if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// If you are logged in, but you don't have the tzRemember cookie (browser restart)
	// and you have not checked the rememberMe checkbox:

	$_SESSION = array();
	session_destroy();
	
	// Destroy the session
}


if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
	
	header("Location: login.php");
	exit;
}

if($_POST['submit']=='Login')
{
	// Checking whether the Login form has been submitted
	
	$err = array();
	// Will hold our errors
	
	
	if(!$_POST['username'] || !$_POST['password'])
		$err[] = 'All the fields must be filled in!';
	
	if(!count($err))
	{
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
		$_POST['password'] = mysql_real_escape_string($_POST['password']);
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];
		
		// Escaping all input data

		$row = mysql_fetch_assoc(mysql_query("SELECT id,usr FROM tz_members WHERE usr='{$_POST['username']}' AND pass='".md5(md5("hihHLf".$_POST['password']."DFSg846360"))."'"));

		if($row['usr'])
		{
			// If everything is OK login
			
			$_SESSION['usr']=$row['usr'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['rememberMe'] = $_POST['rememberMe'];
			
			// Store some data in the session
			
			setcookie('tzRemember',$_POST['rememberMe']);
		}
		else $err[]='Wrong username and/or password!';
	}
	
	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Save the error messages in the session

	header("Location: login.php");
	exit;
}
else if($_POST['submit']=='Register')
{
	// If the Register form has been submitted
	
	$err = array();
	
	if(strlen($_POST['username'])<4 || strlen($_POST['username'])>32)
	{
		$err[]='Your username must be between 3 and 32 characters!';
	}
	
	if(preg_match('/[^a-z0-9\-\_\.]+/i',$_POST['username']))
	{
		$err[]='Your username contains invalid characters!';
	}
	
	if(!checkEmail($_POST['email']))
	{
		$err[]='Your email is not valid!';
	}
	
	if(!count($err))
	{
		// If there are no errors
		
		$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6);
		// Generate a random password
		
		$_POST['email'] = mysql_real_escape_string($_POST['email']);
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
		// Escape the input data
		
		
		mysql_query("	INSERT INTO tz_members(usr,pass,email,regIP,dt)
						VALUES(
						
							'".$_POST['username']."',
							'".md5(md5("hihHLf".$_POST['password']."DFSg846360"))."',
							'".$_POST['email']."',
							'".$_SERVER['REMOTE_ADDR']."',
							NOW()
							
					)");
		
		if(mysql_affected_rows($link)==1)
		{
			send_mail(	'demo-test@tutorialzine.com',
						$_POST['email'],
						'Registration System Demo - Your New Password',
						'Your password is: '.$pass);

			$_SESSION['msg']['reg-success']='We sent you an email with your new password!';
		}
		else $err[]='This username is already taken!';
	}

	if(count($err))
	{
		$_SESSION['msg']['reg-err'] = implode('<br />',$err);
	}	
	
	header("Location: login.php");
	exit;
}

$script = '';

if($_SESSION['msg'])
{
	// The script below shows the sliding panel on page load
	
	$script = '
	<script type="text/javascript">
	
		$(function(){
		
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
	
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>WJC - Login Page</title>

<link rel="stylesheet" type="text/css" href="slidelogin/demo.css" media="screen" />
<link rel="stylesheet" type="text/css" href="slidelogin/login_panel/css/slide.css" media="screen" />
<link rel="stylesheet" href="assets/css/styles.css" />

<?php echo $script; ?>

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

</head>

<body>

<div id="wrapper">
<table align="center">
    <tr>	
        <td width="75" align="left" id="logoPart">
        	<a href="index.html"><img src="img/logo_ini_rnd.gif" border="0" alt="logo" align="absmiddle" /></a>
        </td>
        <td width="100"></td>                     
        <td width="555">
            <nav>
            <ul class="fancyNav">
            <li id="home"><a href="index.html" class="homeIcon">Home</a></li>
            <li id="news"><a href="about.html" class="homeIcon1">About WJC</a></li>
            <li id="about"><a href="careers.html" class="homeIcon2">Careers</a></li>
            <li id="services"><a href="contact.php" class="homeIcon3">Contact Us</a></li>
            <li id="contact"><a href="memberregistration/login.php" class="homeIcon4">Log on</a></li>
            </ul>
            </nav>
        </td>
    </tr>
 </table>

<?php

if(!$_SESSION['id']):

?>

<table>
	<tr>
    	<td width="281">
            <!-- Login Form -->
          <form action="" method="post">
            <table width="225" class="container">
                <tr>
                    <td colspan="2">
                        <h1>Member Login</h1>
                        
                        <?php
            
                        if($_SESSION['msg']['login-err'])
                        {
                            echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
                            unset($_SESSION['msg']['login-err']);
                        }
            
                        ?>
            
                    </td>
                </tr>
                <tr>
                    <td width="75">
                      <label class="grey" for="username">Username:</label>
                  </td>
                  <td width="815">
                    <input class="field" type="text" name="username" id="username" value="" size="23" />
                  </td>    
                </tr>
                <tr>
                    <td>
                        <label class="grey" for="password">Password:</label>
                    </td>
                    <td>
                        <input class="field" type="password" name="password" id="password" size="23" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label><input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Remember me</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Login" class="bt_login" />
                    </td>
                </tr>
            </table>
            </form>
        	
      </td>
        <td width="240">&nbsp;</td>
        <td>
        	<!-- Register Form -->
            <form action="" method="post">
            <table width="320" class="container">
              <tr>
                    <td colspan="2">
                        <h1>Not a member yet? Sign Up!</h1>
                        
                        <?php
            
                        if($_SESSION['msg']['reg-err'])
                            {
                                echo '<div class="err">'.$_SESSION['msg']['reg-err'].'</div>';
                                unset($_SESSION['msg']['reg-err']);
                            }
                            
                            if($_SESSION['msg']['reg-success'])
                            {
                                echo '<div class="success">'.$_SESSION['msg']['reg-success'].'</div>';
                                unset($_SESSION['msg']['reg-success']);
                            }
            
                        ?>
            
                    </td>
              </tr>
                <tr>
                    <td width="65">
                      <label class="grey" for="username">Username:</label>
                    </td>
                  <td width="223">
                    <input class="field" type="text" name="username" id="username" value="" size="23" />
                  </td>    
                </tr>
                <tr>
                    <td>
                        <label class="grey" for="email">Email:</label>
                    </td>
                    <td>
                        <input class="field" type="text" name="email" id="email" size="23" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>A password will be e-mailed to you.</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Register" class="bt_register" />
                    </td>
                </tr>
            </table>
            </form>
      </td>
    </tr>
</table>

<br />
<br />



<?php
			
else:

?>

<table width="900">
    <tr>
    	<td>
            <div class="left">
            <h1>Registration successful!</h1>
            <p>You can put member-only data here</p>
            <a href="slidelogin/registered.php">View your member page</a>
            <p>- or -</p>
            <a href="?logoff">Log off</a>
            </div>
            <div class="left right"></div>
            
            <?php
			endif;
			?>

        </td>
    </tr>
    <tr>
    	<td>
        <!--panel -->
        <div class="pageContent">
            <div id="main">
                <div class="container">
                <h1>A Cool Login System</h1>
                <h2>Easy registration management with PHP &amp; jQuery</h2>
                </div>
                
                <div class="container">
                    <p>This is a simple example site demonstrating the <a href="http://tutorialzine.com/2009/10/cool-login-system-php-jquery/">Cool Login System tutorial</a> on <strong>Tutorialzine</strong>. You can start by clicking the <strong>Log In | Register</strong> button above.  After registration, an email will be sent to you with your new password.</p>
                    <p><a href="registered.php" target="_blank">View a test page</a>, only accessible by <strong>registered users</strong>.</p>
                    <p>The sliding jQuery panel, used in this example, was developed by  <a href="http://web-kreation.com/index.php/tutorials/nice-clean-sliding-login-panel-built-with-jquery" title="Go to site">Web-Kreation</a>.</p>
                    <p>You are free to build upon this code and use it in your own sites.</p>
                    <div class="clear"></div>
                    </div>
                <div class="container tutorial-info">
                This is a tutorialzine demo. View the <a href="http://tutorialzine.com/2009/10/cool-login-system-php-jquery/" target="_blank">original tutorial</a>, or download the <a href="demo.zip">source files</a>.
                </div>
            </div>
        </div>
        <!--/panel -->
        </td>
    </tr>
</table>
</div>
</body>
</html>
