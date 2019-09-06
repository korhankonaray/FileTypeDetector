<?
session_start();
if(isset($_POST['submitted'])) {

$name = trim($_POST['name']);
$select = trim($_POST['select']);
$email = trim($_POST['email']);
$comment = trim($_POST['comment']);

$emailTo = "bbbooogggs@gmail.com";
$subject = 'Contact message from '.$name;			
$body = "Name: $name \n\n Email: $email \n\n Option Selected: $select \n\n  Message: $comment";
$headers = 'From: '. $name .' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
@mail($emailTo, $subject, $body, $headers);						
$emailSent = true;

}?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="author" content="FamousThemes" />
<meta name="description" content="My Mobile Page Version 3 Template" />
<meta name="keywords" content="mobile templates, mobile wordpress themes, mobile themes, my mobile page, premium css templates, premium wordpress themes" />
<title>My Mobile Page V3</title>

<!-- Main CSS file -->
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<!-- Google web font -->
<link href='http://fonts.googleapis.com/css?family=Galdeano' rel='stylesheet' type='text/css'>
<!-- jQuery file -->
<script src="js/jquery.min.js"></script>
<!-- FlexSlider -->
<script src="js/jquery.flexslider.js"></script>
<!-- Main effects files -->
<script src="js/effects.js"></script>
<!-- jQuery Validate -->
<script type="text/javascript" src="js/jquery.validate.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#form1").validate({
        rules: {
          name: "required",// simple rule, converted to {required:true}
          email: {// compound rule
          required: true,
          email: true
        },
        comment: {
          required: true
        }
        },
        messages: {
          comment: "Please enter a message."
        }
      });
    });
</script>
<!-- Hide Mobiles Browser Navigation Bar -->
<script type="text/javascript">
	window.addEventListener("load",function() {
	// Set a timeout...
	setTimeout(function(){
	// Hide the address bar!
	window.scrollTo(0, 1);
	}, 0);
	});
</script>
</head>
<body id="page">

	<div id="pagecontainer">
    
    	<div id="header" class="black_gradient">
            <a href="index.html" class="back_button black_button">Home</a>
            <div class="page_title">Contact</div>
            <a href="#" id="menu_open" class="black_button">Menu</a>
            <a href="#" id="menu_close" class="black_button">Close</a>
            <div class="clear"></div>
        </div>
        
    	<div id="pages_nav">
            <div class="icons_nav">
                <div class="paginated"> <!--Remove this DIV if you want to remove the pagination-->
                    <ul class="slides">
                        <li>
                            <a href="about.html" class="icon"><img src="images/icons/icon_about.png" alt="" title="" border="0" /><span>About</span></a>
                            <a href="services.html" class="icon"><img src="images/icons/icon_services.png" alt="" title="" border="0" /><span>Services</span></a>
                            <a href="blog.html" class="icon"><img src="images/icons/icon_blog.png" alt="" title="" border="0" /><span>Blog</span></a>
                            <a href="portfolio.html" class="icon"><img src="images/icons/icon_portfolio.png" alt="" title="" border="0" /><span>Portfolio</span></a>
                        </li>
                        <li>
                            <a href="photos.html" class="icon"><img src="images/icons/icon_photos.png" alt="" title="" border="0" /><span>Photos</span></a>
                            <a href="videos.html" class="icon"><img src="images/icons/icon_video.png" alt="" title="" border="0" /><span>Videos</span></a>
                            <a href="clients.html" class="icon"><img src="images/icons/icon_clients.png" alt="" title="" border="0" /><span>Clients</span></a>
                            <a href="contact.html" class="icon"><img src="images/icons/icon_contact.png" alt="" title="" border="0" /><span>Contact</span></a>
                        </li>
                    </ul>
                </div>  <!--Remove this DIV if you want to remove the pagination-->

          </div>
      </div>
        
        
   	  <div class="content">
        <h1>Contact Us</h1>
        <span class="subtitle_descr">Consectetur adipisicing elit, sed do eiusmod tempor incididunt</span>
        
            <ul class="social">
			<li><a href="#"><img src="images/social/rss.png" alt="" title="" border="0" class="rounded-half" /></a></li>
            <li><a href="#"><img src="images/social/twitter.png" alt="" title="" border="0" class="rounded-half" /></a></li>
            <li><a href="#"><img src="images/social/facebook.png" alt="" title="" border="0" class="rounded-half" /></a></li>
            <li class="right"><a href="#"><img src="images/social/digg.png" alt="" title="" border="0" class="rounded-half" /></a></li>
            </ul>
            
            <a href="tel:123 456 789" class="call_button">Call Us Now!</a>
            
			<?php if(isset($emailSent) && $emailSent == true) { ?>
            
                    <h2>Thank you,</h2>
            
                    <p>Your message was sent successfully!</p>
            
            <?php } else {?>   
            
		    <h2>Send a <span class="tag">message</span></h2>
        
        
            <div class="form">
			<form id="form1" method="post" action="contact.php">
            <label>Name:</label>
            <input type="text" class="form_input" name="name"/>
            <label>Email:</label>
            <input type="text" class="form_input" name="email"/>
            
            <label>Select option:</label>
            <div class="select_container">
            <select class="form_select" name="select">
             <option>Option one</option>
             <option>Option two</option>
             <option>Option three</option>
            </select>
            </div>
            <label>Comment:</label>
            <textarea class="form_textarea" name="comment"></textarea>
            <input type="hidden" name="submitted" id="submitted" value="true" />
            <input type="submit" class="form_submit" value="Send" />
            </form>
            </div>
           
            <?php } ?>
            
        <div class="clear"></div>
		</div>
        
        
    	<div id="footer" class="black_gradient">
            <a href="index.html" class="back_button black_button">Home</a>
            <div class="page_title">My Mobile Page V3</div>
            <a onClick="jQuery('html, body').animate( { scrollTop: 0 }, 'slow' );"  href="javascript:void(0);" id="top" class="black_button">Top</a>
            <div class="clear"></div>
        </div>
        
        
	</div>
   
</body>
</html>