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
<title>Login</title>
<link rel="stylesheet" href="../assets/css/styles.css" />
<link href="../contactform/css/contactform.css" rel="stylesheet" type="text/css" />

</head>
<body style="background-image: url(../contactform/img/light_wood_texture.jpg);">
	<table align="center" width="900">
	 <tr>
	       <td width="75" align="left">
	       <a href="index.html"><img src="../img/logornd75.gif" alt="logo" align="absmiddle" /></a>
	       </td>
	       <td width="150" align="left">
	       <a href="index.html"><img src="../img/ini_wjc_rnd.gif" align="top" /></a>
	       </td>
	       <td width="100"></td>
	       <td width="555">
	            <nav>
	                <ul class="fancyNav">
	                    <li id="home"><a href="../index.html" class="homeIcon">Home</a></li>
	                    <li id="news"><a href="../about.html" class="homeIcon1">About WJC</a></li>
	                    <li id="about"><a href="../careers.html" class="homeIcon2">Careers</a></li>
	                    <li id="services"><a href="../contact.php" class="homeIcon3">Contact Us</a></li>
	                    <li id="contact"><a href="../memberregistration/login.php" class="homeIcon4">Log on</a></li>
	                </ul>
	            </nav>
	   	   </td>
	  </tr>
		<tr>
			<td colspan="4" align="center">
					<div id="formWrap" style="align: center;">
					<h2>Login</h2>
					<div id="form">
						<?php

						if ($username && $userid){
							echo "You are already logged in as <b>$username</b>. <a href='member.php'>Click here</a> to go to the member page.";
						}
						else
						{
							$form = "<form action='./login.php' method='post'>
							<div class='row'>
								<div class='label'>Username</div>
								<div class='input'>
									<input type='text' name='user'class='detail' />
								</div>
							</div>
							<div class='row'>
								<div class='label'>Password</div>
								<div class='input'>
									<input type='password' name='password'class='detail' />
								</div>
							</div>
							<div class='row'>
								<div>
									<a href='./register.php'>Register</a>   |
									<a href='./forgotpass.php'>Forgot your password</a>
							<div class='submit'>
								<input type='submit' id='submit' name='loginbtn' value='LOGIN' />
							</div>
							</form>";

							if ($_POST['loginbtn']){
								$user = $_POST['user'];
								$password = $_POST['password'];

								if ($user){
									if ($password){
										require_once("connect.php");

										$password = md5(md5("hihHLf".$password."DFSg846360"));

										//make sure login info correct
										$query = mysql_query("SELECT * FROM users WHERE username = '$user'");
										$numrows = mysql_num_rows($query);

										if ($numrows == 1){
											$row = mysql_fetch_assoc($query);
											$dbid =	$row['id'];
											$dbuser = $row['username'];
											$dbpass = $row['password'];
											$dbactive = $row['active'];

											if ($password == $dbpass){
												if ($dbactive == 1){
													//set session info
													$_SESSION['userid'] = $dbid;
													$_SESSION['username'] = $dbuser;

													echo "You have been logged in as <b>$dbuser</b>. <a href='member.php'>Click here</a> to go to the member page.";
												}
												else
												echo"You must activate your account to login. $form";
											}
											else
											echo" You did not enter the correct password. $form";
										}
										else
										echo "The username you entered was not found. $form";

										mysql_close();
									}
									else
									echo "You must enter your password. $form";
								}
								else
								echo "You must enter your username. $form";
							}
							else
							echo $form;
						}

						?>
					</div>
			</td>
		</tr>
	</table>


</body>
</html>
