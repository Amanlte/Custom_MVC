<?php
Auth::handleLogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?= (isset($this->title)) ? $this->title . ' - Online User Support' : 'MVC'; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo URL; ?>public/images/favicon.ico" type="image/x-icon" />

        <link rel="stylesheet" href="<?php echo URL; ?>public/css/default.css" />    
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/menu.css" /> 
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/reset.css" /> 
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/404.css" /> 
        <link rel="stylesheet" type="text/css"href="<?php echo URL; ?>public/css/demo_table_jui.css" />
        <!-- for auto fill -->
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/jquery-ui-1.8.2.custom.css" />
        <!--- end for auto fill -->

        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.min.js"></script>
        <!--<script type="text/javascript" src="<?php echo URL; ?>public/js/js.js"></script>-->
        <script type="text/javascript" src="<?php echo URL; ?>public/js/ui.multiselect.js"></script>
        <!--jquery.datatables paginate & table column sort for table-->
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.datatables.js"></script>
        <!--Jquery for form validation-->
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/form_validator.js"></script> 
<!--        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/canvasjs.min.js"></script>-->
        <script type="text/javascript" src="<?php echo URL; ?>public/js/tab.js"></script> 
        <?php
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
            }
        }
        ?> 
        <script>
            function confirmDelete(delUrl) {
                if (confirm("Are you sure you want to delete")) {
                    document.location = delUrl;
                }
            }
        </script>
        <!--To show/hide content -->
        <script type="text/javascript" language="JavaScript">

            function ReverseDisplay(d) {
                if (document.getElementById(d).style.display == "none") {
                    document.getElementById(d).style.display = "block";
                }
                else {
                    document.getElementById(d).style.display = "none";
                }
            }
        </script>
        <!--  to append multi-select values to another multi-select -->
        <script>
            $().ready(function () {
                $('#add').click(function () {
                    return !$('#select_it option:selected').remove().appendTo('#selected_one');
                });
                $('#remove').click(function () {
                    return !$('#selected_one option:selected').remove().appendTo('#select_it');
                });
                //to select all values in the second multiselect before submit
                $('form').submit(function () {
                    $('#selected_one option').each(function (i) {
                        $(this).attr("selected", "selected");
                    });
                });

            });

        </script>
        <script>
            jQuery(function ($) {
                setInterval(function () {
                    $.get('<?php echo URL; ?>view_request/getTotalRequests', function (newRowCount) {
                        $('#notification_count').html(newRowCount);
                        if ($('#notification_count').is(':empty')) {
                            $("#notification_count").hide();
                        }
                    });
                }, 1000); // 1000ms == 1 seconds
            });

            jQuery(function ($) {
                setInterval(function () {
                    $.get('<?php echo URL; ?>view_request/getRequests', function (newRowCount) {
                        $('#notification_count1').html(newRowCount);
                        if ($('#notification_count1').is(':empty')) {
                            $("#notification_count1").hide();
                        }
                    });
                }, 1000); // 1000ms == 1 seconds
            });
            jQuery(function ($) {
                setInterval(function () {
                    $.get('<?php echo URL; ?>view_request/getOtherRequests', function (newRowCount) {
                        $('#other_notification_count').html(newRowCount);
                        if ($('#other_notification_count').is(':empty')) {
                            $("#other_notification_count").hide();
                        }
                    });
                }, 1000); // 1000ms == 1 seconds
            });

            jQuery(function ($) {
                setInterval(function () {
                    $.get('<?php echo URL; ?>view_request/getForwardedRequests', function (allNewRequests) {
                        $('#forwarded_notification_count').html(allNewRequests);
                        if ($('#forwarded_notification_count').is(':empty')) {
                            $("#forwarded_notification_count").hide();
                        }
                    });
                }, 1000); // 1000ms == 1 seconds
            });

            jQuery(function ($) {
                setInterval(function () {
                    $.get('<?php echo URL; ?>view_request/getAssignedRequests', function (allNewRequests) {
                        $('#assigned_notification_count').html(allNewRequests);
                        if ($('#assigned_notification_count').is(':empty')) {
                            $("#assigned_notification_count").hide();
                        }
                    });
                }, 1000); // 1000ms == 1 seconds
            });

            jQuery(function ($) {
                setInterval(function () {
                    $.get('<?php echo URL; ?>view_request/getAssignedRequests', function (allNewRequests) {
                        $('#assigned_notification_count1').html(allNewRequests);
                        if ($('#assigned_notification_count1').is(':empty')) {
                            $("#assigned_notification_count1").hide();
                        }
                    });
                }, 1000); // 1000ms == 1 seconds
            });

//            This is for notification drop down handller
//            $(document).ready(function() {
//                $("#notificationLink").click(function() {
//                    $("#notificationContainer").fadeToggle(300);
//                    return false;
//                });
//
//                //Document Click
//                $(document).click(function() {
//                    $("#notificationContainer").hide();
//                });
//                //Popup Click
//                $("#notificationContainer").click(function() {
//                    //return false
//                });
//
//            });
        </script>
        <script>

//            $(document).ready(function() {
//                // To get the username for view detail
//                if ($('#user_name').val() != '') {
//                    $("#dis_user_name").load("<?php echo URL; ?>view_request/selectUserName", {uid: $('#user_name').val()});
//                } else {
//                    $("#dis_usere_name").empty();
//                }
//            });
        </script>
        <script type="text/javascript">
            setTimeout(function () {
                $('.success').fadeOut();
                $('.success').val('');
            }, 3000);
            $(function () {
                $('.submit').click(function () {
                    jQuery('.msg_error').fadeOut();
                });
                $('.text').click(function () {
                    jQuery('.msg_error').fadeOut();
                });
                $('.select').click(function () {
                    jQuery('.msg_error').fadeOut();
                });
                $('.select_medium').click(function () {
                    jQuery('.msg_error').fadeOut();
                });
                $('.textarea').click(function () {
                    jQuery('.msg_error').fadeOut();
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dt').dataTable({
                    bJQueryUI: true,
                    bPaginate: true,
                    bLengthChange: true,
                    bFilter: true,
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    sPaginationType: "full_numbers"
                });
            });
            $(document).ready(function () {
                $('#dt2').dataTable({
                    bJQueryUI: true,
                    bPaginate: true,
                    bLengthChange: true,
                    bFilter: true,
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    sPaginationType: "full_numbers"
                });
            });
            $(document).ready(function () {
                $('#dt3').dataTable({
                    bJQueryUI: true,
                    bPaginate: true,
                    bLengthChange: true,
                    bFilter: true,
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    sPaginationType: "full_numbers"
                });
            });
            $(document).ready(function () {
                $('#add').click(function () {
                    return !$('#select1 option:selected').remove().appendTo('#select2');
                });
                $('#remove').click(function () {
                    return !$('#select2 option:selected').remove().appendTo('#select1');
                });



                $("#search").keyup(function () {
                    $("#debug").text("");
                    var searchterms = $("#search").val().toLowerCase().split(' ');
                    $('tbody tr').each(function (i, row) {
                        $(row).hide(1);
                        $("td", row).each(function (y, td) {
                            var tdValue = $(td).text().toLowerCase();
                            searchterms.forEach(function (entry) {
                                if (tdValue.indexOf(entry) != -1) {
                                    $(row).show(100);
                                }
                            });
                        });
                    });
                });
                var dataTable = $('#dt').dataTable();
                setTimeout(function () {
                    dataTable.fnDraw(false);
                }, 1000);
            });
            /* to select all checkboxes at once */
            $(document).ready(function () {
                $('#selecctall').click(function (event) {  //on click 
                    if (this.checked) { // check select status
                        $('.checkbox1').each(function () { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"     
                            $('#ch').text('Deselect All');
                        });
                    } else {
                        $('.checkbox1').each(function () { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"     
                            $('#ch').text('Select All');

                        });
                    }
                });
                $('.checkbox1').click(function (event) {
                    $('#selecctall').attr('checked', false);
                    $('#ch').text('Select All');
                });
            });
            $(function () {
                $("#tabs").tabs();
                $("#tabs1").tabs();
                $("#tabs_solutions").tabs();
                $("#tabs_solutions_forwaded").tabs();
                $("#tabs_solutions_forwaded_list").tabs();
                $("#tabs_solutions_other").tabs();
                $("#tabs_solutions_others").tabs();
                $("#tabs_solutions_assigned").tabs();
                $("#tabs_forwarded").tabs();
                $("#tabs_other").tabs();
                $("#tabs_assigned").tabs();
                $("#tabs_report").tabs();
            });
        </script>
    </head>
    <body onload="updateClock();
            setInterval('updateClock()', 1000)">
              <?php
              // if (!$sock = @fsockopen('192.168.7.10', 8080, $num, $error, 5))
              //     echo 'Offline';
              // else
              //     echo 'Online';
              ?>
        <div >
            <div style="visibility:hidden">
                <a href="http://apycom.com/">Apycom jQuery Menus</a>
            </div>
        </div>
        <div class="wrapper_header">
            <div id="header">
                <div id="top">
                    <div id="logo">
                        <a href="index.php"><img src="<?php echo URL; ?>public/images/logo.gif" /><h1>National Bank of Ethiopia<span>Online User Support</span></h1></a>
                    </div>
                    <div id="notification">
                        <ul id="nav">
                            <?php if (Session::get('user_role') != 5) { ?>
                                <li id="notification_li">
                                    <span id="<?php
                                    if (Session::get('user_role') == 2) {
                                        echo 'notification_count';
                                    } else if (Session::get('user_role') == 3) {
                                        echo 'assigned_notification_count';
                                    }
                                    ?>" class="bg_notification"></span>
                                    <a href="<?php echo URL; ?>view_request" id="notificationLink">Notifications</a>
                                </li>
                                <li id="notification_li">
                                    <span id="" class="bg_forwarded_notification"></span>
                                    <a href="<?php echo URL; ?>request_status" id="notificationLink">Request Status</a>
                                </li>
                            <?php } else {
                                ?>
                                <li id="notification_li">
                                    <span id="uforwarded_notification_count"></span>
                                    <a href="<?php echo URL; ?>request_status" id="notificationLink">Request Status</a>
                                </li>
                                <?php
                            }
                            ?>

                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
                <div id="menu">
                    <ul class="menu">
                        <?php
                        $current_url = isset($_GET['url']) ? $_GET['url'] : null;
                        $current_url = rtrim($current_url, '/');
                        $current_url = filter_var($current_url);
                        $current_url = explode('/', $current_url);
                        ?>
                        <li class="<?php
                        if (isset($_GET['url']) && $_GET['url'] == 'dashboard')
                            echo 'current';
                        else
                            echo '';
                        ?>"><a href="<?php echo URL; ?>dashboard"><span>Home</span></a></li>
                            <?php
                            if (Session::get('user_role') == 5) {
                                echo '<li class="';
                                if (isset($_GET['url']) && $_GET['url'] == 'request')
                                    echo 'current';
                                else
                                    echo '';
                                echo '"><a href="request" class="parent"><span>Make Request</span></a></li>';
                            } else {
                                foreach (Session::get('allmm') as $key => $allMainMenu) {
                                    echo '<li class="';
                                    if (isset($_GET['url']) && $_GET['url'] == $current_url[0])
                                        echo 'current';
                                    else
                                        echo '';
                                    echo '"><a href="" class="parent"><span>' . ucwords($allMainMenu) . '</span></a>';
                                    echo '<div>';
                                    echo '<ul>';
                                    foreach (Session::get($allMainMenu) as $key => $allSubMenu) {
                                        echo '<li><a href="" class="parent"><span>' . ucwords($allSubMenu) . '</span></a>';
                                        echo '<div>';
                                        echo '<ul>';
                                        foreach (Session::get($allSubMenu) as $key => $pages) {
                                            if ($pages != 'dashboard') {
                                                echo '<li><a href="' . URL . $pages . '"><span>' . ucwords(str_replace('_', ' ', $pages)) . '</span></a></li>';
                                            }
                                        }
                                        echo '</ul>';
                                        echo '</div>';
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                    echo '</div>';
                                    echo '</li>';
                                }
                            }
                            ?>
                        <li><a href="<?php echo URL; ?>help"><span>Help</span></a></li>
                        <li class="last"><a href="#"><span>Contacts</span></a></li>
                        <!--<li ><a href="contacts"><span>Contacts</span></a></li>-->
                        <ul id="welcome_user">
                            <li><b>Welcome : </b><?php echo ucwords(Session::get('user_full_name')); ?></li>
                            <li class="midile">|</li>
                            <li><a href="<?php echo URL; ?>dashboard/logout">Log Out</a></li>
                        </ul>
                    </ul>
                </div>
                <span id="clock">&nbsp;</span>
            </div>
        </div>
