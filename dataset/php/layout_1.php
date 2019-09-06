<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $parse_uri[0] . 'wp-load.php';
require_once($wp_load);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Christmas Mail</title>
    </head>
    <style type="text/css" media="screen">
        body {background-color:#fff;margin:0;padding:0;}
        img {margin:0;padding:0;display:block;border:none;}
        a {color:#555964;text-decoration:none;}
        a:hover {text-decoration:none;}
    </style>
    <link rel='stylesheet' href='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/css/styles.css' type='text/css' media='all' />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type='text/javascript' src='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/js/tiny_mce/tiny_mce.js'></script>
    <script type='text/javascript' src='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/js/tiny_mce/jquery.tinymce.js'></script>
    <script type='text/javascript' src='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/js/tiny_mce/tiny_mce_src.js'></script>
    <script type='text/javascript' src='<?php echo Application_Mail_Subscriber::get_application_uri() ?>/js/mail_subscriber_template.js'></script>

    <script type="text/javascript">
        var mail_subscriber_app_uri = "<?php echo Application_Mail_Subscriber::get_application_uri() ?>";
        var mail_subscriber_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>

</head>


<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">       
        <tr>
            <td align="center" height="40" valign="middle">
                <p style="font-family:Arial, Helvetica, sans-serif;font-size:8pt;color:#333;margin-top:3px;margin-bottom:5px;margin-right:0;margin-left:4px;" >
                    <div id="php_header_info"></div>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" align="center">
                <table width="614" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td background="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/christmas_mail/images/body_bg.jpg" valign="top" align="center">
                            <!--[if gte mso 9]>
                            <v:image xmlns:v="urn:schemas-microsoft-com:vml" id="Back" style='behavior: url(#default#VML); display:inline-block;position:absolute; height:800px; width:614px;top:0;left:0;border:0;z-index:1;' src="images/body_bg.jpg"/>
                            <![endif]-->
                            <table width="614" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="361" background="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/christmas_mail/images/header.png"><!--[if gte mso 9]>
                  <v:image xmlns:v="urn:schemas-microsoft-com:vml" id="Header" style='behavior: url(#default#VML); display:inline-block;position:absolute; height:361px; width:614px;top:0;left:0;border:0;z-index:2;' src="images/header.png"/>
                  <![endif]-->
                                    </td>
                                </tr>
                                <tr><td height="153" valign="top" align="center">
                                        <div class="content_area" id="edit_area_0">
                                            <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/christmas_mail/images/title.png" width="614" height="153" border="0" alt="Merry Christmas and Happy New Year" style="display:block;" />
                                        </div>
                                    </td></tr>
                                <tr>
                                    <td height="150" valign="middle" align="center">
                                        <div class="content_area" id="edit_area_1">
                                            <!--[if gte mso 9]>
                      <v:shape xmlns:v="urn:schemas-microsoft-com:vml" id="Text" style='behavior: url(#default#VML); display:inline-block;position:absolute; height:150px; width:614px;top:0px;left:55px;border:0;z-index:3;'>
                      <div style="width:500px;text-align:center;">
                      <![endif]--><center><font style="font-size:24px;" size="3" face="Georgia" color="#43011c">
                                                    <i>I wish you lots of love, joy and happiness.<br>
                                                            May you have the best holidays this year and<br>
                                                                all your dreams come true.</i></font></center>
                                                                <!--[if gte mso 9]>
                                                                </div>
                                                                </v:shape>
                                                                <![endif]-->
                                                                </div>
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="136" valign="top" align="right">
                                                                        <img src="<?php echo Application_Mail_Subscriber::get_application_uri() ?>/templates/christmas_mail/images/candles.png" width="176" height="136" border="0" alt="Candles" style="display:block;">
                                                                    </td>
                                                                </tr>
                                                                </table>
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="56" valign="middle" align="center">
                                                                        <font style="font-size:11px;" size="1" face="Arial" color="#343434">
                                                                            <div id="php_footer_info"></div>
                                                                        </font>
                                                                    </td>
                                                                </tr>
                                                                </table>
                                                                </td>
                                                                </tr>
                                                                </table>


                                                                </body>
                                                                </html>
