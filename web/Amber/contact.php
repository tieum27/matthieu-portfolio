<?php

// Set email variables
$email_to = 'admin@wjc.com';
$email_subject = "Form submission: 'subject'";

// Set required fields
$required_fields = array('fullname','email','comment');

// set error messages
$error_messages = array(
	'fullname' => 'Please enter a Name to proceed.',
	'email' => 'Please enter a valid Email Address to continue.',
	'comment' => 'Please enter your Message to continue.'
);

// Set form status
$form_complete = FALSE;

// configure validation array
$validation = array();

// check form submittal
if(!empty($_POST)) {
	// Sanitise POST array
	foreach($_POST as $key => $value) $_POST[$key] = remove_email_injection(trim($value));
	
	// Loop into required fields and make sure they match our needs
	foreach($required_fields as $field) {		
		// the field has been submitted?
		if(!array_key_exists($field, $_POST)) array_push($validation, $field);
		
		// check there is information in the field?
		if($_POST[$field] == '') array_push($validation, $field);
		
		// validate the email address supplied
		if($field == 'email') if(!validate_email_address($_POST[$field])) array_push($validation, $field);
	}
	
	// basic validation result
	if(count($validation) == 0) {
		// Prepare our content string
		$email_content = 'New Website Comment: ' . "\n\n";
		
		// simple email content
		foreach($_POST as $key => $value) {
			if($key != 'submit') $email_content .= $key . ': ' . $value . "\n";
		}
		
		// if validation passed ok then send the email
		mail($email_to, $email_subject, $email_content);
		
		// Update form switch
		$form_complete = TRUE;
	}
}

function validate_email_address($email = FALSE) {
	return (preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email))? TRUE : FALSE;
}

function remove_email_injection($field = FALSE) {
   return (str_ireplace(array("\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:","to:","cc:"), '', $field));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<!-- Contact Form Designed by James Brand @ dreamweavertutorial.co.uk -->
<!-- Covered under creative commons license - http://dreamweavertutorial.co.uk/permissions/contact-form-permissions.htm -->

<title>Contact Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="assets/css/styles.css" />
<link href="contactform/css/contactform.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="contactform/validation/validation.js"></script>
<script type="text/javascript">
var nameError = '<?php echo $error_messages['fullname']; ?>';
    var emailError = '<?php echo $error_messages['email']; ?>';
    var commentError = '<?php echo $error_messages['comment']; ?>';
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>


</head>

<body onload="MM_preloadImages('contactform/img/x.png')">

<table align="center" width="900">
 <tr>	
       <td width="75" align="left">
       <a href="index.html"><img src="img/logornd75.gif" alt="logo" align="absmiddle" /></a>
       </td>
       <td width="150" align="left">
       <a href="index.html"><img src="img/ini_wjc_rnd.gif" align="top" /></a>
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
  <tr>
  	<td colspan="4" align="center">
        <div id="formWrap">
        <h2>Contact Us</h2>
        <div id="form">
        <?php if($form_complete === FALSE): ?>
        
            <form action="contact.php" method="post" id="comments_form">
        
            <div class="row">
            <div class="label">Your Name</div><!-- end label -->
            <div class="input">
            <input type="text" id="fullname" class="detail" name="fullname" value="<?php echo isset($_POST['fullname'])? $_POST['fullname'] : ''; ?>" />
            <?php if(in_array('fullname',$validation)): ?><span class="error"><?php echo $error_messages['fullname']; ?></span><?php endif; ?>
            </div><!-- end input -->
        
            <div class="context"> e.g. John Smith or Jane Doe</div><!-- end context -->
            </div><!-- end row -->
        
            <div class="row">
            <div class="label">Your Email</div><!-- end label -->
            <div class="input">
            <input type="text" id="email" class="detail" name="email" value="<?php echo isset($_POST['email'])? $_POST['email'] : ''; ?>" />
            <?php if(in_array('email', $validation)): ?><span class="error"><?php echo $error_messages['email']; ?></span><?php endif; ?>
            </div><!-- end input -->
        
            <div class="context">We will not share your email with anyone or spam you with messages either.</div><!-- end context -->
            </div><!-- end row -->
        
            <div class="row">
            <div class="label">Subject </div><!-- end label -->
            <div class="input">
            <select name="subject" id="subject" class="detail"value="<?php echo isset($_POST['subject'])? $_POST['subject'] : ''; ?>">
                    <option value="" selected="selected"> - Choose -</option>
                    <option value="Question">Question</option>
                    <option value="Platinum">Platinum</option>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Quote">Quote</option>
                    <option value="Complaint">Complaint</option>
                  </select>
            </div><!-- end input -->
        
            <div class="context">The subject will not be shared.</div><!-- end context -->
            </div><!-- end row -->
        
            <div class="row">
            <div class="label">Your Message</div>
            <!-- end label -->
            <div class="input2">
              <textarea id="comment" name="comment" class="mess"><?php echo isset($_POST['comment'])? $_POST['comment'] : ''; ?></textarea>
              <?php if(in_array('comment', $validation)): ?><span class="error"><?php echo $error_messages['comment']; ?></span><?php endif; ?>
            </div>
            <!-- end input -->
            </div><!-- end row -->
            
            <div class="submit">
            <input type="submit" id="submit" name="submit" value="Send Message" />
            </div><!-- end submit -->
            </form>
            <?php else: ?>
            <p style="font-size:20px; font-family:Arial, Helvetica, sans-serif; color:#255E67; margin-left:25px; ">Thank you for your Message!</p>
        
            <script type="text/javascript">
            setTimeout('ourRedirect()', 5000)
            function ourRedirect(){
                location.href='index.html'
            }
            </script>
        
            <?php endif; ?>
        </div><!-- end form -->
        </div>
      <!-- end formWrap -->
  	</td>
  </tr>
</table>

</body>
</html>
