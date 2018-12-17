<div id="content">
    <h1>Dashboard</h1>
    <!---->

    <?php
    $role = Session::get('user_role');
    if (($role == 2) || ($role == 4)) {
        ?>

        <div id="tabs">
            <ul>
                <li><a href="#yourDetails">Your Actions</a></li>
                <li><a href="#reports">Reports</a></li>
            </ul>
            <div id="yourDetails">
                <div class="vert-line">
                    <div class="form-area-left" style="width: 50%;">
                        <h3> User Details </h3>
                        <?PHP
                        echo 'Full Name: ' . Session::get('user_password') . "<br />";
                        echo 'Full Name: ' . Session::get('user_full_name') . "<br />";
                        echo 'Login Name: ' . Session::get('user_login_name') . "<br />";
                        ?> 
                        <a href="#takeaction" rel="leanModal" style="color: blue;"><b>Change your password</b></a>
                    </div>
                    <div id="form-area-right">
                        <!--<div id="chartContainer" style="height: 400px; width: 100%;"></div>-->
                        <div id="chartContainer" style="height: 400px; width: 100%;">1321</div>
                    </div>
                </div>
            </div>
            <div id="reports">
                <div>
                    <label>Report For: </label> 
                    <select class="select_medium" name="report" id="report" autofocus>
                        <option value="">-- Select --</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="quarter">This Quarter</option>
                        <option value="six_month">6 Months</option>
                        <option value="nine_month">9 Months</option>
                        <option value="annual">This Year</option>
                    </select>

                </div>
                <div id="tabs_report" style="min-height: 600px;">
                    <?php
                    if ($role == 2) {
                        ?>
                        <ul>
                            <li><a href="#teamReport">Team Report</a></li>
                            <li><a href="#teamMembersReport">Individual Report(s)</a></li>
                        </ul>
                        <div id="teamReport">
                            <div id="form-area-left"> 
                                <div id="summaryByType" style="height: 100px;"></div>
                                <div id="repByType" style="height: auto; width: 100%;"></div>
                            </div>
                            <div id="form-area-right">
                                <div id="summaryByStatus" style="height: 100px;"></div>
                                <div id="repByReqStatus" style="height: auto; width: 100%;"></div>
                            </div> 


                        </div>
                        <div id="teamMembersReport">
                            <table class="display">
                                <tr>
                                    <td>By Type</td>
                                    <td>By Status</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id="summaryByTypeTr"></div>

                                    </td>
                                    <td>
                                        <div id="summaryByStatusTr"></div>

                                    </td>
                                </tr>
                            </table>

                        </div>

                        <?php
                    } elseif ($role == 4) {
                        ?>

                        <?php
                    }
                    ?>
                    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>

                </div>
            </div>
        </div>
        <?php
    } elseif ($role == 3) {
        ?>
        <div id="yourDetails">
            <div class="vert-line">
                <div class="form-area-left" style="width: 50%;">
                    <h3> User Details </h3>
                    <?PHP
                    echo 'Full Name: ' . Session::get('user_password') . "<br />";
                    echo 'Full Name: ' . Session::get('user_full_name') . "<br />";
                    echo 'Login Name: ' . Session::get('user_login_name') . "<br />";
                    ?> 
                    <a href="#takeaction" rel="leanModal" style="color: blue;"><b>Change your password</b></a>
                </div>
                <div id="form-area-right">
                    <!--<div id="chartContainer" style="height: 400px; width: 100%;"></div>-->
                    <div id="chartContainer" style="height: 400px; width: 100%;">1321</div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div id="yourDetails">
            <table>
                <!--<div class="vert-line">-->
                <tr>
                    <td style="width: 40%;" valign="top">
                        <div class="form-area-left" style="width: 50%;">
                            <h3> User Details </h3>
                            <?PHP
//                    echo 'Full Name: ' . Session::get('user_password') . "<br />";
                            echo 'Full Name: ' . Session::get('user_full_name') . "<br />";
                            echo 'Login Name: ' . Session::get('user_login_name') . "<br />";
                            ?> 
                            <a href="#takeaction" rel="leanModal" style="color: blue;"><b>Change your password</b></a>
                        </div>

                    </td>

                    <td>

                        <div class="form-area-right" style="padding-left: 10px;"> 
                            <h1>Heavy duty printer problem help desk</h1>
                            <h2>If the printer is not printing please follow the following steps</h2>
                            <ol>
                                <li class="list_regular">Please check the printer is on and display ready </li>
                                <li class="list_regular">
                                    Please check the printer network cable is plugged to the printer and having green blinking light if it have please go to  step 3 otherwise please plugin the cable .
                                </li>
                                <li class="list_regular">If you can please printer test page from the printer.</li>
                                <li class="list_regular">Please check your computer connection is working or not by opening any internet page.</li>
                                <li class="list_regular">Please print a document to check the printer is working if not please send us request further help.</li>

                            </ol>
                            <h1> Printer problem help desk</h1>
                            <h2>If the printer is not printing please follow the following steps</h2>
                            <ol>
                            <li class="list_regular">Please check the printer and the user’s computer (which is plugged to the printer) is on.</li>
                            <li class="list_regular">Please check the printer cable is plugged to the printer and the user‘s computer and go to step 3 otherwise please plugin the cable.</li>
                            <li class="list_regular">Please printer test page from the user’s computer.</li>
                            <li class="list_regular">Please go to your computer and check your computer connection is working or not.</li>
                            <li class="list_regular">Please print a document to check the printer is working if not please send us request further help.</li>
                            </ol>
                            <h1>Computer no display</h1>
                            <h2>Computer don’t have any display please follow the following steps</h2>
                            <ol>
                            <li class="list_regular">Does your computer turned on?</li>
                            <li class="list_regular">Is a computer power cable having a power?</li>
                           <li class="list_regular">Is your monitor power cable having a power?</li>
                           <li class="list_regular">Please check your power divider if it is working or not?</li>
                            <li class="list_regular">If it is not working after all please send us request further help.</li>
                            </ol>

                            <!--<div id="chartContainer" style="height: 400px; width: 100%;"></div>-->
                            <!--<div id="chartContainer" style="height: 400px; width: 100%;">1321</div>-->
                        </div>  
                    </td>

                </tr>
            </table>

            <!--</div>-->
        </div>
        <?php
    }
    ?>
    <!--    <div id="takeaction">
            <form name="frm_chp" id="frm_chp" action="">
                <div id="takeactioncontent">
                    <div id="form-area">
                        <input type="text" class="text" name="currentPassword1" id="currentPassword1" value="<?php echo Session::get('user_password'); ?>"/><br />
                        <label class="label">Current Password: </label><input type="password" class="text" name="currentPassword" id="currentPassword"/><br />
                        <label class="label">New Password: </label><input type="password" class="text" name="passwordNew" id="passwordNew"/><br />
                        <label class="label">Retype Password: </label><input type="password" class="text" name="password" id="password"/><br />
                        </div>
                    </div>
                </div>
    
                <div id="viewdetail-footer">
                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="but_actions" value="Change" class="submit"  />
                </div>
            </form>
    
        </div>-->
    <div id="takeaction">
        <div id="viewdetail-ct">
            <div id="viewdetail-header">
                <h2>Take Action</h2>
                <a class="modal_close" href="#"></a>
            </div>
            <form name="frm_act" id="frm_act" action="">
                <div id="takeactioncontent">
                    <div id="form-area">
                        <label class="label">New Password: </label><input type="password" class="text" name="passwordNew" id="passwordNew"/><br />
                        <label class="label">Retype Password: </label><input type="password" class="text" name="password" id="password"/><br />
                    </div>
                </div>

                <div id="viewdetail-footer">
                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="but_actions" value="Change" class="submit"  />
                </div>
            </form>
            <div class="clear"></div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>
    <script>
        //to view detail of requests
        $(document).ready(function () {
            $('.takeaction').click(function () {
                //var case_id = $('#case_id').val();
                var frm = $('#frm_act');
                frm.submit(function (ev) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo URL; ?>dashboard/changePassword',
                        data: {
                            password: $('#password').val()
                        },
                        success: function (data) {
                            //alert(data);
                            $('#frm_act')[0].reset();
                            $('#actions').val('');
                            $('#action_area').hide('fast');
                            $("#lean_overlay").fadeOut(200);
                            $("#takeaction").fadeOut(200);
                            $('.modal_close').css({"display": "none"});
                            location.reload();
                        }
                    });
                    ev.preventDefault();
                });
            });
            $('a[rel*=leanModal]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});


        });
        $('input[type="reset"]').on('click', function (e) {
            e.preventDefault();
            $('#actions').val('');
            $('#action_area').hide('fast');
        });
    </script>
    <script>
//        // to check same password
//        jQuery.validator.setDefaults({
//            debug: true,
//            success: "valid"
//        });
//        $("#frm_chp").validate({
//            rules: {
//                password: "required",
//                passwordRe: {
//                    equalTo: "#passwordNew"
//                }
//            }
//        });
        //to view detail of requests
        $(document).ready(function () {
            $('.takeaction').click(function () {
                $('#rid').val($(this).attr('id'));
                var frm = $('#frm_act');
                frm.submit(function (ev) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo URL; ?>dashboard/changePassword',
                        data: {
                            password: $('#password').val()
                        },
                        success: function (data) {
                            alert(data);
                            $('#frm_act')[0].reset();
//                                                $('#actions').val('');
//                                                $('#action_area').hide('fast');
                            $("#lean_overlay").fadeOut(200);
                            $("#takeaction").fadeOut(200);
                            $('.modal_close').css({"display": "none"});
                            location.reload();
                        }
                    });
                    ev.preventDefault();
                });
            });
            // to check same password
            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
            });
            $("#frm_chp").validate({
                rules: {
                    password: "required",
                    passwordRe: {
                        equalTo: "#passwordNew"
                    }
                }
            });
//            $('.takeaction').click(function () {
////                $('#uid').val($(this).attr('id'));
//                //var case_id = $('#case_id').val();
//                var frm = $('#frm_chp');
//                frm.submit(function (ev) {
//                    $.ajax({
//                        type: 'POST',
//                        url: '<?php echo URL; ?>dashboard/changePassword',
//                        data: {
//                            password: $('#password').val()
//                        },
//                        success: function (data) {
//                            //alert(data);
//                            $('#frm_chp')[0].reset();
//                            $("#takeaction").fadeOut(200);
//                            $('.modal_close').css({"display": "none"});
//                            location.reload();
//                        }
//                    });
//                    ev.preventDefault();
//                });
//            });
            $('a[rel*=leanModal]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});
        });
    </script>
    <script>
        //to load the div with report...
        $(document).ready(function () {
            $('#report').change(function () {
                if ($(this).val() != '') {
                    $("#repByType").load("<?php echo URL; ?>dashboard/selectReqType", {rp: $(this).val()});
                    $("#summaryByType").load("<?php echo URL; ?>dashboard/selectTypeSummary", {rp: $(this).val()});
                    $("#summaryByTypeTr").load("<?php echo URL; ?>dashboard/selectTypeSummaryTm", {rp: $(this).val()});
                    $("#repByReqStatus").load("<?php echo URL; ?>dashboard/selectReqStatus", {rp: $(this).val()});
                    $("#summaryByStatusTr").load("<?php echo URL; ?>dashboard/selectReqStatusTm", {rp: $(this).val()});
                    $("#summaryByStatus").load("<?php echo URL; ?>dashboard/selectStatusSummary", {rp: $(this).val()});
                } else {
                    $("#summaryByTypeTr").empty();
                    $("#summaryByType").empty();
                    $("#repByType").empty();
                    $("#summaryByStatus").empty();
                    $("#summaryByStatusTr").empty();
                    $("#repByReqStatus").empty();
                }
            });
//            $('#teamMemberReport').change(function () {
//                if ($(this).val() != '') {
//                    $("#repByType").load("<?php echo URL; ?>dashboard/selectReqType", {trp: $(this).val()});
//                    $("#summaryByType").load("<?php echo URL; ?>dashboard/selectTypeSummary", {trp: $(this).val()});
//                    $("#repByReqStatusTr").load("<?php echo URL; ?>dashboard/selectReqStatusTm", {rp: $(this).val()});
//                    $("#summaryByStatus").load("<?php echo URL; ?>dashboard/selectStatusSummary", {trp: $(this).val()});
//                } else {
//                    $("#summaryByType").empty();
//                    $("#repByType").empty();
//                    $("#summaryByStatus").empty();
//                    $("#repByReqStatus").empty();
//                }
//            });
        });
    </script>
    <!--    <div id="tabs_report">
                        <ul>
                            <li><a href="#teamReport">Team Report</a></li>
                            <li><a href="#teamMemberReport">Team Members Report</a></li>
                        </ul>
                        <div id="teamReport">
    
        </div>-->
    <!--    <div id="teamMemberReport">
    
        </div>
    </div>-->
    <?php
//    $role = Session::get('user_role');
//    if (($role <> 5) && ($role <> 1)) {
//        
    ?>
    <!--    <div id="form-area-right">
            <div id="chartContainer" style="height: 400px; width: 100%;"></div>
        </div>-->
    //<?php
//    } else if ((Session::get('user_role') == 4)) {
//        
    ?>
    <!--    <div id="form-area-right">
            <div id="chartContainer" style="height: 400px; width: 100%;"></div>
        </div>-->
    //<?php
//    } else {
//        echo " <h1>To Make Request</h1>
//            <ol>
//                <li>Login to the system</li>
//                <li>Click on 'Make Request'</li>
//                <li>Select Request Area (If you don't know to whom you send your request select 'Other'from the options provided)</li>
//                <li>Select Request Type (If your request is not found in the options  select 'Other'from the options provided)</li>
//                <li>Write details of your details</li>
//                <li>Click the 'Send' button</li>
//                <li>.....</li>
//            </ol>
//            <h1>To See Request Status</h1>
//            <ol>
//                <li>Login to the system</li>
//                <li>Click on 'Request Status'</li>
//                <li>.....</li>
//            </ol>
//            <h1>To Send Feedback</h1>
//            <ol>
//                <li>Login to the system</li>
//                <li>Click on 'Make Request'</li>
//                <li>If you have not sent feedback for your last request, the 'Send Feedback' Form will be displayed automatically. Rank the support provided and write you comment if you have any.</li>
//                <li>.....</li>
//            </ol>";    //USE FOR ANOTHER PURPOSE
//    }
    ?>
<!--    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.min.js"></script>-->
    <script type="text/javascript">

        $(document).ready(function () {
            var role = "<?php echo $role; ?>";
            //for director
            if (role == 4) {
                $.getJSON("dashboard/viewAllTeamRequest", function (result) {
                    var chart = new CanvasJS.Chart("chartContainer", {
                        theme: "theme1",
                        title: {
                            text: "All Incoming Requests"
                        },
                        data: [
                            {
                                type: "pie",
                                showInLegend: true,
                                toolTipContent: "({y}) - #percent %",
                                legendText: "{indexLabel}",
                                dataPoints: result
                            }
                        ]
                    });
                    chart.render();
                });
            }
            else {
                $.getJSON("dashboard/viewFrequentRequest", function (result) {
                    var chart = new CanvasJS.Chart("chartContainer", {
                        theme: "theme1",
                        title: {
                            text: "Top Ten Frequent Requests"
                        },
                        data: [
                            {
                                type: "pie",
                                showInLegend: true,
                                toolTipContent: "({y}) - #percent %",
                                legendText: "{indexLabel}",
                                dataPoints: result
                            }
                        ]
                    });
                    chart.render();
                });
            }
        });
    </script>
    <script type="text/javascript" src="<?php echo URL; ?>public/js/canvasjs.min.js"></script>
    <!--<div id="content">-->

    <!--</div>-->
</div>
