<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
<meta http-equiv="cache-control" content="no-cache"/>
<title>360 Mobile Themes</title>
<script src="js/jquery.js" type="text/javascript"/></script>
<script src="js/jquery.mobile-1.0.min.js" type="text/javascript"/></script>
<!--ToTop-->
<script type="text/javascript" src="js/totop/totop.js"></script>
<script type="text/javascript" src="js/totop/jquery_004.js"></script>
<link href="css/layout.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<!--Toggle Menu-->
<script type="text/javascript">
			$(function() {
				$('#navigation').click(function() {
					$('.navigation').slideToggle('fast');
					return false;
				});
			});
</script>
</head>
<body>
<div data-role="page" data-theme="a" id="contact-us">
	<!--Header Starts -->
	<div id="header">
		<div class="strip">
			<!--Logo and Icons-->
			<div class="icons f_left" id="navigation">
				<img src="images/icon-menu.png" alt="Menu" border="0"/>
			</div>
			<span><a href="index.html" rel="external"><img src="images/logo.png" alt="Logo" width="196" height="38"/></a></span>
			<div class="icons f_right">
				<a href="#" data-transition="slide" data-icon="arrow-l" data-direction="reverse" data-rel="back"><img src="images/icon-back.png" alt="back" border="0"/></a>
			</div>
			<!--/Logo and Icons-->
			<div class="clear">
			</div>
			<!-- Navigation Starts -->
			<div class="navigation" style="display:none;">
				<ul class="ui-grid-b">
					<li class="ui-block-a"><a href="about-us.html" rel="external"><img src="images/icon-about-us.png" alt="About Us" border="0"/><br>
					 ABOUT US </a></li>
					<li class="ui-block-b"><a href="services.html" rel="external"><img src="images/icon-services.png" alt="Services" border="0"/><br>
					 SERVICES</a></li>
					<li class="ui-block-c"><a href="blog.html" rel="external"><img src="images/icon-blog.png" alt="Blog" border="0"/><br>
					 BLOG</a></li>
					<li class="ui-block-a"><a href="gallery.html" rel="external"><img src="images/icon-portfolio.png" alt="Portfolio" border="0"/><br>
					 GALLERY</a></li>
					<li class="ui-block-b"><a href="typography.html" rel="external"><img src="images/icon-typography.png" alt="Typography" border="0"/><br>
					 TYPOGRAPHY</a></li>
					<li class="ui-block-c"><a href="contact.php" rel="external"><img src="images/icon-contact.png" alt="Contact Us" border="0"/><br>
					 CONTACT US</a></li>
				</ul>
			</div>
			<!-- /Navigation -->
		</div>
		<div class="clear">
			 &nbsp;
		</div>
	</div>
	<!-- /Header -->
	<div class="clear">
	</div>
	<div data-role="content">
		<div>
			<div class="f_left">
				<h2>Postal Address</h2>
				<strong>Envato</strong><br>
				 PO Box 21177 <br>
				 Little Lonsdale St, Melbourne <br>
				 Victoria 8011 Australia<br>
				<br>
				 Tel: +61 (0) 3 8376 6284 <br>
				 Fax: +61 (0) 3 8376 6284 <br>
				 Email: <a href="mailto:abc@abc.com" target="_blank">abc@abc.com</a>
			</div>
			
			<div class="f_right"><br>
				<a href="map.html" rel="external"><img src="images/map.jpg" alt="" style="max-width:100%"/></a>
			</div>
		</div>
            <div class="clear"></div>
		<h2>General Inquiries</h2>
            <?php if(isset($emailSent) && $emailSent == true) { ?>
                <p class="info">Thanks for your email.</p>
            <?php } else { ?>
            
				
				<div id="contact-form">
					<?php if(isset($hasError) || isset($captchaError) ) { ?>
                        		<p class="alert">Error submitting the form</p>
                    		<?php } ?>
				
					<form id="contact-us" action="contact.php" method="post">
						* Required Fields.<br><br>
                                    <div style="margin-bottom:12px">
							<label >Name *</label>
							<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="txt requiredField" placeholder="Name:" />
							<?php if($nameError != '') { ?>
								<br /><span class="error"><?php echo $nameError;?></span> 
							<?php } ?>
						</div>
                        
						<div style="margin-bottom:12px">
							<label >Email *</label>
							<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="txt requiredField email" placeholder="Email:" />
							<?php if($emailError != '') { ?>
								<br /><span class="error"><?php echo $emailError;?></span>
							<?php } ?>
						</div>
                        
						<div style="margin-bottom:12px">
							<label >Message *</label>
							 <textarea name="comments" id="commentsText" class="txtarea requiredField" placeholder="Message:"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
							<?php if($commentError != '') { ?>
								<br /><span class="error"><?php echo $commentError;?></span> 
							<?php } ?>
						</div>
                        
							<button name="submit" type="submit" class="subbutton">Send</button>
							<input type="hidden" name="submitted" id="submitted" value="true" />
					</form>			
				</div>
				
			<?php } ?>
	</div>
	<!-- /Contents -->
	<div class="clear">
	</div>
	<div id="footer">
		<div class="strip">
			<strong>Envato</strong><br>
			 PO Box 21177 <br>
			 Little Lonsdale St, Melbourne <br>
			 Victoria 8011 Australia<br>
			<br>
			<div class="f_left">
				<img src="images/icon-footer-phone.png" alt="" border="0"/>
			</div>
			<div class="f_left">
				+61 (0) 3 8376 6284
			</div>
			<br>
			<div class="clear">
			</div>
			<div class="f_left">
				<img src="images/icon-footer-contacts.png" alt="" border="0"/>
			</div>
			<div class="f_left">
				<a href="mailto:abc@abc.com" target="_blank">abc@abc.com</a>
			</div>
			<br>
			<br>
			 © 2012 Mobile Theme | <a href="privacy-policy.html" rel="external">Privacy Policy</a>
                   <br>
			<br>
                   <!--ToTop Starts-->
          		<div id="scroll-to-top"><a href="#top" id="top-link"><img src="images/to-top.png" alt="" border="0"/></a></div>
          		<!--ToTop Ends-->
		</div>
	</div>
</div>
<!-- /footer -->
</div>
<!-- / page -->
<script type="text/javascript" src="js/contact.js"></script>
</body>
</html>
<?php 
error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {
	
	// require a name from user
	if(trim($_POST['contactName']) === '') {
		$nameError =  'Forgot your name!'; 
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}
	
	// need valid email
	if(trim($_POST['email']) === '')  {
		$emailError = 'Forgot to enter in your e-mail address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
		
	// we need at least some content
	if(trim($_POST['comments']) === '') {
		$commentError = 'You forgot to enter a message!';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}
		
	// upon no failure errors let's email now!
	if(!isset($hasError)) {
		
		$emailTo = 'youremailhere@googlemail.com';
		$subject = 'Submitted message from '.$name;
		$sendCopy = trim($_POST['sendCopy']);
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
        
        // set our boolean completion value to TRUE
		$emailSent = true;
	}
}
?>