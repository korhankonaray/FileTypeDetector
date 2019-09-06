<? include("includes/header.php") ?>
<div data-dom-cache="false" data-role="page" class="pages" id="home" data-theme="a">
	<div data-role="header">
            <div class="left">
                <a href="#" class="showMenu menu-button"><img src="images/menu-button.png" width="40" /></a>
            </div>
            <h1><p class="no-margin">Contact Us</p><p class="no-margin">Klassio RSV</p></h1>
            
	</div>
        <div class="header-shadow"></div>
        <!-- /header -->
	
	<div data-role="content" data-theme="a" class="minus-shadow">
		
		<div class="cherry-slider" style="height: 180px;">
			<div id="map" style="width: 100%; height: 180px;" class="prevent-swipe-menu absolute map" data-location="Champs Elysees Paris" ></div>
			<div anim="slide"anim-speed="300"anim-direction="left"anim-position-right="30"anim-position-top="115"  class="anim-item"><p class="little-padding white-bg gray-border">Located&nbsp;at&nbsp;the&nbsp;heart&nbsp;of&nbsp;Paris</p></div>
			<div anim="slide"anim-speed="300"anim-direction="left"anim-position-right="30"anim-position-top="140"  class="anim-item"><p class="little-padding white-bg gray-border">The&nbsp;City&nbsp;Of&nbsp;Love</p></div>
			
			<div anim="fade"anim-speed="3000" class="anim-item wait-item"></div>
			<div anim-action="break"anim="fade"anim-speed="700" class="anim-item"></div>
			
			<div anim="slide"anim-speed="300"anim-direction="left"anim-position-right="30"anim-position-top="115"  class="anim-item"><p class="little-padding white-bg gray-border">Visit&nbsp;Us</p></div>
			<div anim="slide"anim-speed="300"anim-direction="left"anim-position-right="30"anim-position-top="140"  class="anim-item"><p class="little-padding white-bg gray-border">Let&nbsp;Us&nbsp;Discuss</p></div>
			
			<div anim="fade"anim-speed="3000" class="anim-item wait-item"></div>
			<div anim-action="break"anim="fade"anim-speed="700" class="anim-item"></div>
			<div anim-action="restart"anim="fade"anim-speed="700" class="anim-item wait-item"></div>
		</div>
		
            <div class="white-content-box">
		<div class="address">
			<img class="absolute" src="images/content/post-it.png"/>
			<div class="address-info absolute content-padding">
				<br/><br/>
				<p><strong>ADDRESS</strong></p>
				<p>Trinity Towers,
				<br/>Champs Elysees,
				<br/>Paris
				<br/><strong>&nbsp;#:</strong> <a href="tel:1-800-HELLO">1-800-43556</a>
				<br/><strong>@:</strong> <a href="mailto:info@klassio.com">info@klassio.com</a></p>
			</div>
		</div>
			
			<div class="approved success-message hidden">
				<div class="typo-icon">
				  Your message has been received by us, we will get back to you at the earliest.
				</div>
			</div>
			<form class="ajax-form designed" action="submit_contact.php" method="post">
				<div class="form-element">
				  <label for="txtfullname">Full Name</label>
				  <input  id="txtfullname" name="fullname" type="text" placeholder="required" required />
				</div>
				<div class="form-element">
				  <label for="txtemail">Email</label>
				  <input  id="txtemail" name="email" type="email" placeholder="required" required  />
				</div>
				<div class="form-element">
				  <label for="txtcontact">Contact Number</label>
				  <input  id="txtcontact" name="contact" type="tel" placeholder="optional" />
				</div>
				<div class="form-element">
				  <label for="txtmessage">Message</label>
				  <textarea  id="txtmessage" name="message" placeholder="required" rows="5" required ></textarea>
				</div>
				<input type="reset" class="button button3" value="Reset" />
				<input data-theme="b" type="submit" class="button button2" value="Send Message" />
			</form>

		
            </div>
	</div><!-- /content -->
        
        <div class="bread-crumb">
            <ul>
                <li><a data-transition="pop" href="index.php"><img src="images/bc-home.png" width="16" /></a></li>
                <li><span>Contact Us</span></li>
            </ul>
        </div>
        <div data-role="footer"><p>&copy; Klassio RSV. All Rights Reserved. <span><a class="scroll-to-top"><img src="images/top.png" width="32"/></a></span></p></div>
</div><!-- /page -->
<? include("includes/footer.php") ?>