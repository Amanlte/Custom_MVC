<?php
Auth::handleLoginsOnSameBrowser();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?= (isset($this->title)) ? $this->title . ' - Online User Support' : 'Online User Support'; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo URL; ?>public/images/favicon.ico" type="image/x-icon" /> 
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/default.css" />    
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/menu.css" /> 
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/jquery-ui.css" />

        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/custom.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/js.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/form_validator.js"></script>

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/js.js"></script>
    </head>
    <body><div style="visibility:hidden">
            <a href="http://apycom.com/">Apycom jQuery Menus</a>
        </div>
        <div class="wrapper_header">
            <div id="header">
                <div id="top">
                    <div id="logo">
                        <a href="index"><img src="<?php echo URL; ?>public/images/logo.gif" /><h1>National Bank of Ethiopia<span>Online User Support</span></h1></a>
                    </div>
                    <div id="notification">
                        <h2>Message</h2>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="wrapper_content">
            <div id="content">
                <hr />
                <div id="welcome-note">
                    <h1> Welcome To ISMD Online User Support :</h1>
                    <p>
                        <ol class="w_icon">
                            <li class="w_icon">This <strong>Online User Support </strong> tracking system is developed by Information System
                                Management Directorate staffs, to accept National Bank of Ethiopia users’ IT request. It is the
                                pleasure of the Directorate to accept your query through this robustic system and give an
                                appropriate answer to it, to the maximum satisfaction level which is expected from each member
                                of the Directorate. Moreover, the system enables technical and the management staff to track
                                the progress of each activity easily, to capture Knowledge for further reference and documentation.
                                Therefore, kindly send us any Support issues related to the following:</li>
                            </br>
                            <ol>
                                <li class="list">Computer and Computer Application support</li>
                                <li class="list">Antivirus</li>
                                <li class="list">Internet</li>
                                <li class="list">Domain account creation and to Join computer to domain</li>
                                <li class="list">IPT phone</li>
                                <li class="list">Mail (Exchange ) outlook problem</li>
                                <li class="list">File server problem</li>
                                <li class="list">Network problem</li>
                                <li class="list">Printer problem</li>
                                <li class="list">FEMOS  problem</li>
                                <li class="list">EATS problem</li>
                                <li class="list">Credit Information System(CIS) Problem</li>
                                <li class="list">Core Banking (QBS) problem</li>
                                <li class="list">Library related requests</li>
                                <li class="list">File recording related requests</li>
                            </ol>
                        </ol>
                    </p>
                </div>
                <div id="login-area">  
                    <form action="login/run" id="login-form" method="post">
                        <fieldset><legend style="margin-left: 80%;">Login</legend>
                            <span>Provide your username and password and then click on Login button.</span>
                            <?php
                            if (Session::get('loginError') == true) {
                                echo '<p class="msg_error">Login Failed</p><br />';
                                Session::set('loginError', false);
                            } else {
                                echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                                Session::remove('pdoError');
                            }
                            ?>
                            <label class="label">Username : </label>  <input type="text" class="text" name="username" /><br><br>
                                    <label class="label">Password : </label>  <input type="password" class="text" name="password" /><br><br>
                                            <input type="submit" name="Login" value="Login" class="submit" id="button-last" />
                                            <a href="#takeaction" rel="leanModal">How To Use</a>
                                            </fieldset>
                                            </form>
                                            </div>
                                            </div>
                                            </div>  


                                            <script>
                                                $(function () {
                                                    $("#dialog-2").dialog({
                                                        autoOpen: false,
                                                        buttons: {
                                                            OK: function () {
                                                                $(this).dialog("close");
                                                            }
                                                        },
                                                        title: "How to Use",
                                                        position: {
                                                            my: "center center",
                                                            at: "center center"
                                                        }
                                                    });
                                                    $("#opener-2").click(function () {
                                                        $("#dialog-2").dialog("open");
                                                    });
                                                });
                                            </script>
        
                                            <div id="dialog-2" title="Dialog Title goes here...">Content goes here!
                                                <!--                                                <div align='center'><OBJECT
                                                                                                        classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                                                                                                        codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,124,0" 
                                                                                                        width=1249 height=945>
                                                                                                        <param name= "Movie" 
                                                                                                               value="2.swf">
                                                                                                            <param name="allowFullScreen" value="true">
                                                                                                                <embed src="2.swf" width="1249" height="945" loop="0" quality="high" pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" allowFullScreen="true"></embed></OBJECT>
                                                                                                </div>-->

                                            </div>
                                            <button id="opener-2">How to Use</button>

                                            <div class="wrapper_footer">
                                                <div id="footer">
                                                    Copy Right &COPY; 2014 NBE Developers Team
                                                </div>
                                            </div>
                                            </body>
                                            </html>