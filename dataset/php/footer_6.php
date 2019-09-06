<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
</section><!--/ #content-->

<?php get_sidebar() ?>
	
</section><!--/ .main -->

<!-- - - - - - - - - - - - - end Main - - - - - - - - - - - - - - - - -->


<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->

<?php $hide_footer = get_option(TMM_THEME_PREFIX . "hide_footer"); ?>

<?php if (!$hide_footer): ?>
    <footer id="footer">

        <div class="container clearfix">


            <div class="four columns">
                <?php if (function_exists('dynamic_sidebar') AND dynamic_sidebar('Footer Sidebar 1')):else: ?>
                    <div class="widget widget_text">

                        <h3 class="widget-title">About Our Church</h3>

                        <div class="textwidget">

                            <p>
                                Mollis malesuada primis in faucibus luctus ultrces posuere cubilia nis velit porttitor euismod
                                pharetra interetiam laoreet gitis placerat magna sit amet massa posuere pretium.
                            </p>

                        </div><!--/ .textwidget-->

                    </div><!--/ .widget-->

                    <div class="widget widget_contacts">

                        <div class="vcard">
                            <span class="contact street-address">Address: 12 Street, Los Angeles, CA, 94101</span>
                            <span class="contact tel">Phone:  +1 800 123 4567</span>
                            <span class="contact email">E-mail: testmail@sitename.com</span>
                        </div><!--/ .vcard-->

                    </div><!--/ .widget-->
                <?php endif; ?>
            </div><!--/ .four-->



            <div class="four columns">
                <?php if (function_exists('dynamic_sidebar') AND dynamic_sidebar('Footer Sidebar 2')):else: ?>
                    <div class="widget widget_custom_recent_entries">

                        <h3 class="widget-title">Recent Posts</h3>

                        <ul>
                            <li>                               
                                <h6><a href="#">Conseq uuntur magn</a></h6>
                                <div class="entry-meta">Sep, 18,  <a href="#">1 Comments</a></div>
                            </li>
                            <li>                              
                                <h6><a href="#">Gravida eget metus</a></h6>
                                <div class="entry-meta">Sep, 17,  <a href="#">2 Comments</a></div>
                            </li>
                            <li>                               
                                <h6><a href="#">Nulla vitae elit libero</a></h6>
                                <div class="entry-meta">Sep, 16,  <a href="#">4 Comments</a></div>
                            </li>
                            <li>                               
                                <h6><a href="#">Vitae elit libero</a></h6>
                                <div class="entry-meta">Sep, 15,  <a href="#">1 Comments</a></div>
                            </li>
                        </ul>

                    </div><!--/ .widget-->
                <?php endif; ?>
            </div><!--/ .four-->

            <div class="four columns">
                <?php if (function_exists('dynamic_sidebar') AND dynamic_sidebar('Footer Sidebar 3')):else: ?>
                    <div class="widget widget_nav_menu">

                        <h3 class="widget-title">Theme Features</h3>

                        <ul>
                            <li><a href="#">Responsive Design</a></li>
                            <li><a href="#">HTML5 &AMP; CSS3</a></li>
                            <li><a href="#">Google Fonts</a></li>
                            <li><a href="#">Unique &AMP; Clean Design</a></li>
                            <li><a href="#">Amazing Customer Support</a></li>
                            <li><a href="#">Flexible Layouts</a></li>
                            <li><a href="#">10 Color Variations</a></li>
                        </ul>

                    </div><!--/ .widget-->
                <?php endif; ?>
            </div><!--/ .four-->

            <div class="four columns">
                <?php if (function_exists('dynamic_sidebar') AND dynamic_sidebar('Footer Sidebar 4')):else: ?>
                    <div class="widget widget_contact_form">

                        <h3 class="widget-title">Our church</h3>

                        <p>
                            Euismod pharetra interetiam laoreet gitis placerat magna sit amet massa posuere pretium.
                        </p>
                        
                        <p>
                            Mollis malesuada primis in faucibus luctus ultrces posuere cubilia nis velit porttitor euismod
                            pharetra interetiam laoreet gitis placerat magna sit amet massa pretium posuere.
                        </p>
                        

                    </div><!--/ .widget-->
                <?php endif; ?>
            </div><!--/ .four-->

        </div><!--/ .container-->

    </footer><!--/ #footer-->
<?php endif; ?>
<!-- - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - -->

<!-- - - - - - - - - - - - - Bottom Footer - - - - - - - - - - - - - - -->

<footer id="bottom-footer" class="clearfix">

    <div class="container">

        <div class="copyright"><?php echo get_option(TMM_THEME_PREFIX . 'copyright_text') ?></div>
        <div class="developed"><?php _e('Developed by', TMM_THEME_FOLDER_NAME); ?> <a target="_blank" href="http://webtemplatemasters.com">ThemeMakers</a></div>

    </div><!--/ .container-->

</footer><!--/ #bottom-footer-->

<!-- - - - - - - - - - - - - end Bottom Footer - - - - - - - - - - - - - -->
<?php wp_footer(); ?>
</body>
</html>
