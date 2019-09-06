<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $parse_uri[0] . 'wp-load.php';
require_once($wp_load);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Subject goes here</title>
        <link rel='stylesheet' href='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/css/styles.css' type='text/css' media='all' />

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type='text/javascript' src='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/js/tiny_mce/tiny_mce.js'></script>
        <script type='text/javascript' src='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/js/tiny_mce/jquery.tinymce.js'></script>
        <script type='text/javascript' src='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/js/tiny_mce/tiny_mce_src.js'></script>
        <script type='text/javascript' src='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/js/mail_subscriber_template.js'></script>

        <script type="text/javascript">
            var mail_subscriber_app_uri="<?php echo Application_Mail_Subscriber::get_application_uri() ?>";
            var mail_subscriber_ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>";
        </script>

    </head>


    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#edf9ff" style="padding:0; margin:0; background:#edf9ff">
            <tr>
                <td align="center" valign="top">
                    <table width="614" border="0" cellspacing="0" cellpadding="5" bgcolor="#d6edf9">
                        <tr>
                            <td>
                                <table width="614" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                    <tr>
                                        <td>
                                            <table width="590" border="0" cellspacing="17" cellpadding="0">
                                                <tr>
                                                    <td>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td style="font-family: Arial; font-size:10px; line-height:12px; text-align:center; color:#888888;">
                                                                    <div id="php_header_info"></div>
                                                                    <br />
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td bgcolor="#7bbcde" >
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="10">
                                                                        <tr>
                                                                            <td style="color:#fff; font-size:11px; font-weight:bold; font-family:Arial; text-transform:uppercase; font-style:italic;" align="right">
                                                                                <div class="content_area_simple" id="edit_area_0"><?php echo date("F j, Y") ?></div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:0; line-height:0;">
                                                                    <div class="content_area" id="edit_area_1">
                                                                        <a href="#"><img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/logo.gif" border="0" alt="" /></a><br />
                                                                    </div>
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td>
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td width="241" valign="top">
                                                                                <div class="content_area" id="edit_area_2">

                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                        <tr>
                                                                                            <td style="font-family: Arial; font-size:14px; line-height:19px; text-align:left; color:#666;">
                                                                                                <br />
                                                                                                <div style="font-family: Georgia; font-size:19px; line-height:20px; color:#582b00; font-weight:normal; text-align:left;">Dolor sit amet, consectetur</div>
                                                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras bibendum magna id velit fringilla eu vulputate dui euismod. Vestibulum ante ipsum primis in faucibus orci luctus.</p>
                                                                                                <a href="#" style="color:#2f81ac; text-decoration:underline;"><strong>Read more</strong></a><br /><br />
                                                                                                <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/hr-small.gif" width="241" height="11" alt="" />
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="font-family: Arial; font-size:14px; line-height:19px; text-align:left; color:#666;">
                                                                                                <br />
                                                                                                <div style="font-family: Georgia; font-size:19px; line-height:20px; color:#582b00; font-weight:normal; text-align:left;">Dolor sit amet, consectetur</div>
                                                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras bibendum magna id velit fringilla eu vulputate dui euismod. Vestibulum ante ipsum primis in faucibus orci luctus.</p>
                                                                                                <a href="#" style="color:#2f81ac; text-decoration:underline;"><strong>Read more</strong></a>
                                                                                                <br /><br />
                                                                                                <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/hr-small.gif" width="241" height="11" alt="" />
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="font-family: Arial; font-size:14px; line-height:19px; text-align:left; color:#666;">
                                                                                                <br />
                                                                                                <div style="font-family: Georgia; font-size:19px; line-height:20px; color:#582b00; font-weight:normal; text-align:left;">Dolor sit amet, consectetur</div>
                                                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras bibendum magna id velit fringilla eu vulputate dui euismod. Vestibulum ante ipsum primis in faucibus orci luctus.</p>
                                                                                                <a href="#" style="color:#2f81ac; text-decoration:underline;"><strong>Read more</strong></a>
                                                                                                <br /><br />
                                                                                                <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/hr-small.gif" width="241" height="11" alt="" />
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="font-family: Arial; font-size:14px; line-height:19px; text-align:left; color:#666;">
                                                                                                <br />
                                                                                                <div style="font-family: Georgia; font-size:15px; line-height:18px; color:#2879a4; font-weight:bold; text-align:left; ">Forward to Friend</div>
                                                                                                Know someone who might be interested in the email? Why not <a href="#" style="color:#2f81ac; text-decoration:underline;">forward this email</a> to them.<br /><br />
                                                                                                <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/hr-small.gif" width="241" height="11" alt="" />
                                                                                            </td>
                                                                                        </tr>                                                                                        
                                                                                    </table>
                                                                                </div>
                                                                            </td>
                                                                            <td valign="top">&nbsp;</td>
                                                                            <td width="320" valign="top">
                                                                                <div class="content_area" id="edit_area_3">
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                        <tr>
                                                                                            <td style="font-family: Arial; font-size:14px; line-height:19px; text-align:left; color:#666;">
                                                                                                <br />
                                                                                                <div style="font-family: Georgia; font-size:26px; line-height:30px; color:#3399cc; font-weight:normal; text-align:left; ">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                                                                                                <p>
                                                                                                    <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/image.jpg" align="left" hspace="10" vspace="5" alt="" />
                                                                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras bibendum magna id velit fringilla eu vulputate dui euismod. Vestibulum ante ipsum primis in faucibus orci luctus.</p>
                                                                                                <p>Mauris suscipit mauris nec ipsum vehicula vel pulvinar arcu elementum. Duis fermentum scelerisque cursus. Mauris egestas ante sed mauris venenatis nec congue sem pulvinar. </p>
                                                                                                <a href="#" style="color:#2f81ac; text-decoration:underline;"><strong>Read more</strong></a>
                                                                                                <br /><br />
                                                                                                <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/hr-middle.gif" width="320" height="11" alt="" />
                                                                                            </td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td style="font-family: Arial; font-size:14px; line-height:19px; text-align:left; color:#666;">
                                                                                                <br />
                                                                                                <div style="font-family: Georgia; font-size:26px; line-height:30px; color:#3399cc; font-weight:normal; text-align:left; ">Maecenas vulputate faucibusmagna tempus </div>
                                                                                                <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer dictum tortor eget orci commodo fermentum. </p>
                                                                                                <p>Mauris suscipit mauris nec ipsum vehicula vel pulvinar arcu elementum. Duis fermentum scelerisque cursus. Mauris egestas ante sed mauris venenatis nec congue sem pulvinar. </p>

                                                                                                <a href="#" style="color:#2f81ac; text-decoration:underline;"><strong>Read more</strong></a>
                                                                                                <br /><br />
                                                                                                <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/hr-middle.gif" width="320" height="11" alt="" />
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="font-family: Arial; font-size:14px; line-height:19px; text-align:left; color:#666666;">
                                                                                                <br />
                                                                                                <div style="font-family: Georgia; font-size:26px; line-height:30px; color:#3399cc; font-weight:normal; text-align:left; ">More Articles</div>
                                                                                                <p>
                                                                                                    <a href="#" style="color:#582b00; text-decoration:underline;">Vestibulum ante ipsum primis iInteger</a>
                                                                                                    <br /><a href="#" style="color:#582b00; text-decoration:underline;">Mauris suscipit mauris nec ipsum</a>
                                                                                                    <br /><a href="#" style="color:#582b00; text-decoration:underline;">Ehicula vel pulvinar arcu elementum</a>
                                                                                                    <br /><a href="#" style="color:#582b00; text-decoration:underline;">Duis fermentum scelerisque cursus</a>
                                                                                                </p>
                                                                                                <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/blue_left-sidebar-4-source/images/hr-middle.gif" width="320" height="11" alt="" />
                                                                                            </td>

                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr>

                                </table>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="font-family: Arial; font-size:10px; line-height:12px; text-align:center; color:#888888;">
                    <br />
                    <div id="php_footer_info"></div>
                    <br />
                </td>
            </tr>
        </table>

    </body>

</html>
