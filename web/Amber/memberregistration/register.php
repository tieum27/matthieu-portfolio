<?php
error_reporting (E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member System - Register</title>
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
						<h2>Register</h2>
						<div id="form">
							<?php
							if ($_POST['registerbtn'])
								{
								$getuser = $_POST['user'];
								$getemail = $_POST['email'];
								$getpass = $_POST['pass'];
								$getretypepass = $_POST['retypepass'];

								if($getuser)
									{
									if ($getemail)
										{
										if($getpass)
											{
											if($getretypepass)
												{
												if ($getpass === $getretypepass)
													{
													if ((strlen($getemail) >= 7) && (strstr($getemail, "@")) && (strstr($getemail, "." )))
														{
														require("./connect.php");

														$query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
														$numrows = mysql_num_rows($query);

														if($numrows == 0)
															{
															$query = mysql_query("SELECT * FROM users WHERE email='$getemail'");
															$numrows = mysql_num_rows($query);

															if($numrows == 0)
																{
																$password = md5(md5("hihHLf".$password."DFSg846360"));
																$date = date("F d, Y");
																$code = md5(rand());

																mysql_query("INSERT INTO users VALUES ( '', '$getuser', '$password', '$getemail', '0', '$code', '$date')");

																$query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
																$numrows = mysql_num_rows($query);

																if ($numrows == 1)
																	{
																	$site = "http://127.0.0.1/tieumcorp/memberregistration";
																	$webmaster = "WFC <tieum27@hotmail.com>";
																	$headers = "From: $webmaster";
																	$subject = "Activate Your Account";
																	$message = "Thank you for registering your account. Click the link below to active your account. \n";
																	$message .= "$site/activate.php?user=$getuser&code=$code \n";
																	$message .= "You must activate your account to login.";

																	if (mail($getemail, $subject, $message, $headers))
																		{
																		$errormsg = "You have been registered. You must activate your account from the activation link sent to <b>$getemail</b>";
																		$getuser = "";
																		$getemail = "";
																		}
																		else
																			$errormsg = " An error as occured. Your activation email was not sent.";
																	}
																	else
																		$errormsg = "An error as occured. Your account was not created.";
																}
																else
																	$errormsg = "There is already a user with that email.";
																}
															else
																$errormsg = "There is already a user with that username.";
														mysql_close();
														}
														else
															$errormsg = "You must enter a valid email address to register.";
													}
													else
														$errormsg = "Your password did not match.";
												}
												else
													$errormsg = "You must retype your Password to register.";
											}
											else
												$errormsg = "You must enter your Password to register.";
										}
										else
											$errormsg = "You must enter your Email to register.";
									}
									else
										$errormsg = "You must enter your Username to register.";
								}

							$form = "<form action='./register.php' method='post'>
											<div>
												<font color='red'>$errormsg</font>
											</div>
											<div class='row'>
												<div class='label'>Username</div>
												<div class='input'>
													<input type='text' name='user' value='$getuser' class='detail'/>
												</div>
											</div>
											<div class='row'>
												<div class='label'>Email</div>
												<div class='input'>
													<input type='text' name='email' value='$getemail' class='detail'/>
												</div>
											</div>
											<div class='row'>
												<div class='label'>Password</div>
												<div class='input'>
													<input type='password' name='pass' value='' class='detail'/>
												</div>
											</div>
											<div class='row'>
												<div class='label'>Retype Password</div>
												<div class='input'>
													<input type='password' name='retypepass' value='' class='detail'/>
												</div>
											</div>
											<div class='submit'>
												<input type='submit' id='submit' name='registerbtn' value='register' />
											</div>
									 </form>";
							echo "$form";
							?>
						</div>
					</div>
			</td>
		</tr>
</body>
</html>
