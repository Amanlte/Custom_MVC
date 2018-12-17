<div class="wrapper_content">
    <?php if (Session::get('user_role') == 2) { ?>
        <div id="content">
<?php
//$firstDate = date( 'Y-m-d', strtotime( 'Last Monday', strtotime('-1 week') ));
//$lastDate = date( 'Y-m-d', strtotime( 'First Sunday', strtotime('-1 week') ));
//echo $firstDate.'</br>'.$lastDate;
?>
            <div id="tabs">
                <ul>
                    <li id="notification_li"><span id="notification_count1" class="bg_new_request"></span><a href="#new_request">New Request(s)</a></li>
                    <li id="notification_li"><span id="forwarded_notification_count" class="bg_new_forwarded"></span><a href="#forwarded">Forwarded</a></li>
                    <li id="notification_li"><span id="other_notification_count" class="bg_other_request"></span><a href="#other_requests">Other On Going</a></li>
                    <li><a href="#notifications">Notification(s)</a></li>
                </ul>
                <div id="new_request">
                    <div id="list-container">
                        <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Request </th><th>Request Detail</th><th>Time</th><th>Requested By</th><th>#</th>
                                </tr>
                            </thead>
                            <?php
                            echo '<tbody>';
                            $count = 0;
                            foreach ($this->viewReq as $key => $value) {

                                $count++;
                                ?>
                                <tr id="<?php echo $count; ?>" class="<?php
                                if ($count % 2 == 0) {
                                    echo 'dark';
                                } else {
                                    echo 'light';
                                }
                                ?>">
                                        <?php
                                        echo '<td>' . $value['req_id'] . '</td>';
                                        if (empty($value['caseName'])) {
                                            echo '<td id="dis_case_name">Other</td><input type="hidden" value="Other" id="case_id" />';
                                        } else {
                                            echo '<td id="dis_case_name">' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_id" />';
                                        }
                                        echo '<td title="' . $value['req_details'] . '">' . WordCount::word_limit($value['req_details'], 5) . '...</td>';
                                        echo '<td>' . HumanTime::humanTiming($value['req_time']) . '</td>';
                                        echo '<td id="dis_user_name">' . $value['fullName'] . '</td>'
                                        . '<input type="hidden" value="' . $value['user_id'] . '" id="user_id" />';
                                        echo '<td><a id="' . $value['req_id'] . '" class="takeaction" href="#takeaction" rel="leanModal">Take Action</a> | <a id="' . $value['req_id'] . '" rel="leanModal" class="viewdetail" href="#viewdetail">View Detail</a></td>';
                                        echo '</tr>';
                                        ?>
                                    </div>
                                    <?php
                                }
                                echo '</tbody>';
                                ?>
                        </table>
                    </div>
                    <div id="viewdetail">
                        <div id="viewdetail-ct">

                            <div id="viewdetail-header">
                                <h2>Request Details</h2>
                                <a class="modal_close" href="#"></a>
                            </div>
                            <div id="viewdetailcontent">
                                <div id="tabs_solutions">
                                    <ul>
                                        <li id="notification_li"><a href="#request">Request</a></li>
                                        <li id="notification_li"><a href="#solution">Solutions</a></li>
                                    </ul>
                                    <div id="request">
                                        <table width="100%" border="1" class="bordered">
                                            <tbody alight="left" id="vd">

                                            </tbody>

                                        </table>
                                    </div>
                                    <div id="solution">
                                        <table width="100%" border="1" class="bordered">
                                            <tbody alight="left" id="tabs_solutions_assigned">

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <h2 id="see_history">Click here for more detail</h2>
                                <div id="history">
                                    <div id="tabs1">
                                        <ul>
                                            <li id="notification_li"><a href="#tabs-2">User Details</a></li>
                                            <li id="notification_li"><a href="#tabs-1">Device</a></li>
                                            <li><a href="#tabs-3">Request History</a></li>
                                        </ul>
                                        <div id="tabs-2">
                                            <div id="user_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>User ID</td><td>Full Name</td><td>Building</td><td>Floor</td><td>Directorate</td><td>Team</td><td>Position</td><td>Phone</td><td>Email</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="ud">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="tabs-1">
                                            <div id="device_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Type</td><td>Brand</td><td>Model</td><td>Tag Number</td><td>Hard Disk(GB)</td><td>RAM(GB)</td><td>Remark</td><td>Status</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="dd">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="tabs-3">
                                            <div id="history_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Request </td><td>Request Detail</td><td>Request Time</td><td>Status</td><td>Handled By</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="hd">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>
                        <script>
                            //to view detail of requests
                            $(document).ready(function () {
                                $('.viewdetail').click(function () {
                                    var id = $(this).attr('id');
                                    //                                    var uid = $('#user_id').attr('value');
                                    //                                    alert(uid);
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewRequest',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#vd').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/additionalSol',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#tabs_solutions_assigned').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewDevice',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#dd').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewUser',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#ud').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewHistory',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#hd').html(output);
                                        }
                                    });
                                });
                                $('a[rel*=leanModal]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});

                                $('#see_history').click(function () {
                                    $('#history').toggle('fast');
                                });
                            });
                        </script>

                    </div>
                </div>

                <div id="forwarded">
                    <div id="list-container">
                        <table cellpadding="0" cellspacing="0" width="100%" id="dt2" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Request </th><th>Request Detail</th><th>Time</th><th>Requested By</th><th>Forwarded By</th><th>Status</th><th>#</th>
                                </tr>
                            </thead>
                            <?php
                            echo '<tbody>';
                            $count = 0;
                            foreach ($this->forwardReq as $key => $value) {

                                $count++;
                                ?>
                                <tr id="<?php echo $count; ?>" class="<?php
                                if ($count % 2 == 0) {
                                    echo 'dark';
                                } else
                                    echo 'light';
                                ?>">
                                        <?php
                                        echo '<td>' . $value['req_id'] . '</td>';
                                        if (empty($value['caseName'])) {
                                            echo '<td id="dis_case_name">Other</td><input type="hidden" value="Other" id="case_id1" />';
                                        } else {
                                            echo '<td id="dis_case_name">' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_id1" />';
                                        }
                                        echo '<td title="' . $value['req_details'] . '">' . WordCount::word_limit($value['req_details'], 5) . '...</td>';
                                        echo '<td>' . HumanTime::humanTiming($value['req_time']) . '</td>';
                                        echo '<td id="dis_user_name">' . $value['fullName'] . '</td><input type="hidden" value="' . $value['user_id'] . '" class="user_id1" />';
                                        echo '<td id="">' . $value['teamName'] . '</td>';
                                        echo '<td id="">' . $value['reqStatus'] . '</td>';
                                        echo '<td><a id="' . $value['req_id'] . '" class="takeaction" href="#takeaction" rel="leanModal">Take Action</a> | <a id="' . $value['req_id'] . '" rel="leanModal2" class="viewdetail_forwarded_request" href="#viewdetail_forwarded_request">View Detail</a></td>';
                                        echo '</tr>';
                                        ?></div><?php
                                }
                                echo '</tbody>';
                                ?>
                        </table>
                    </div>
                    <div id="viewdetail_forwarded_request">
                        <div id="viewdetail-ct">
                            <div id="viewdetail-header">
                                <h2>Request Details</h2>
                                <a class="modal_close" href="#"></a>
                            </div>
                            <div id="viewdetailcontent">
                                <div id="tabs_solutions_forwaded_list">
                                    <ul>
                                        <li id="notification_li"><a href="#request">Request</a></li>
                                        <li id="notification_li"><a href="#solution">Solutions</a></li>
                                    </ul>
                                    <div id="request">
                                        <table width="100%" border="1" class="bordered">
                                            <tbody alight="left" id="vd2">

                                            </tbody>

                                        </table>
                                    </div>
                                    <div id="solution">
                                        <table width="100%" border="1" class="bordered">
                                            <tbody alight="left" id="tabs_solutions_forwaded">

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <h2 id="see_history2">Click here for more detail</h2>
                                <div id="history2">
                                    <div id="tabs_forwarded">
                                        <ul>
                                            <li id="notification_li"><a href="#user_details_f">User Details</a></li>
                                            <li id="notification_li"><a href="#device_detais_f">Device</a></li>
                                            <li><a href="#request_history_f">Request History</a></li>
                                        </ul>
                                        <div id="user_details_f">
                                            <div id="user_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>User ID</td><td>Full Name</td><td>Building</td><td>Floor</td><td>Directorate</td><td>Team</td><td>Position</td><td>Phone</td><td>Email</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="ud2">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="device_detais_f">
                                            <div id="device_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Type</td><td>Brand</td><td>Model</td><td>Tag Number</td><td>Hard Disk(GB)</td><td>RAM(GB)</td><td>Remark</td><td>Status</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="dd2">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="request_history_f">
                                            <div id="history_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Request </td><td>Request Detail</td><td>Request Time</td><td>Status</td><td>Handled By</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="hd2">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>
                            <script>
                            //to view detail of requests
                            $(document).ready(function () {
                                $('.viewdetail_forwarded_request').click(function () {
                                    var id = $(this).attr('id');
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/forwardedRequest',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#vd2').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/additionalSol',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#tabs_solutions_forwaded').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewDevice',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#dd2').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewUser',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#ud2').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewHistory',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#hd2').html(output);
                                        }
                                    });
                                });
                                $('#see_history2').click(function () {
                                    $('#history2').toggle('fast');
                                });
                                $('a[rel*=leanModal2]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});
                            });
                            </script>
                        </div>
                    </div>
                </div>
                <div id="other_requests">
                    <div id="list-container">
                        <table cellpadding="0" cellspacing="0" width="100%" id="dt3" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Request </th><th>Request Detail</th><th>Time</th><th>Requested By</th><th>Assigned To</th><th>Status</th><th>#</th>
                                </tr>
                            </thead>
                            <?php
                            echo '<tbody>';
                            $count = 0;
                            foreach ($this->viewOtherReq as $key => $value) {

                                $count++;
                                ?>
                                <tr id="<?php echo $count; ?>" class="<?php
                                if ($count % 2 == 0) {
                                    echo 'dark';
                                } else
                                    echo 'light';
                                ?>">
                                        <?php
                                        echo '<td>' . $value['req_id'] . '</td>';
                                        if (empty($value['caseName'])) {
                                            echo '<td id="dis_case_name">Other</td><input type="hidden" value="Other" id="case_id" />';
                                        } else {
                                            echo '<td id="dis_case_name">' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_id" />';
                                        }
                                        echo '<td title="' . $value['req_details'] . '">' . WordCount::word_limit($value['req_details'], 5) . '...</td>';
                                        echo '<td>' . HumanTime::humanTiming($value['req_time']) . '</td>';
                                        echo '<td id="dis_user_name">' . $value['fullName'] . '</td>'
                                        . '<td>' . $value['assTo'] . '</td>'
                                        . '<td>' . $value['reqStatus'] . '</td>'
                                        . '<input type="hidden" value="' . $value['user_id'] . '" id="user_id" />';
                                        echo '<td><a id="' . $value['req_id'] . '" class="takeaction" href="#takeaction" rel="leanModal">Take Action</a> | <a id="' . $value['req_id'] . '" rel="leanModal" class="viewdetail_other_request" href="#viewdetail_other_request">View Detail</a></td>';
                                        echo '</tr>';
                                        ?></div><?php
                                }
                                echo '</tbody>';
                                ?>
                        </table>
                    </div>
                    <div id="viewdetail_other_request">
                        <div id="viewdetail-ct">
                            <div id="viewdetail-header">
                                <h2>Request Details</h2>
                                <a class="modal_close" href="#"></a>
                            </div>
                            <div id="viewdetailcontent">
                                <div id="tabs_solutions_other">
                                    <ul>
                                        <li id="notification_li"><a href="#request">Request</a></li>
                                        <li id="notification_li"><a href="#solution">Solutions</a></li>
                                    </ul>
                                    <div id="request">
                                        <table width="100%" border="1" class="bordered">
                                            <tbody alight="left" id="vdo">

                                            </tbody>

                                        </table>
                                    </div>
                                    <div id="solution">
                                        <table width="100%" border="1" class="bordered">
                                            <tbody alight="left" id="tabs_solutions_others">

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <h2 id="see_history_other_request">Click here for more detail</h2>
                                <div id="history_other_request">
                                    <div id="tabs_other">
                                        <ul>
                                            <li id="notification_li"><a href="#user_details_o">User Details</a></li>
                                            <li id="notification_li"><a href="#device_details_o">Device</a></li>
                                            <li><a href="#history_o">Request History</a></li>
                                        </ul>
                                        <div id="user_details_o">
                                            <div id="user_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>User ID</td><td>Full Name</td><td>Building</td><td>Floor</td><td>Directorate</td><td>Team</td><td>Position</td><td>Phone</td><td>Email</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="udo">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="device_details_o">
                                            <div id="device_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Type</td><td>Brand</td><td>Model</td><td>Tag Number</td><td>Hard Disk(GB)</td><td>RAM(GB)</td><td>Remark</td><td>Status</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="ddo">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="history_o">
                                            <div id="history_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Request </td><td>Request Detail</td><td>Request Time</td><td>Status</td><td>Handled By</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="hdo">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>
                        <script>
                            //to view detail of requests
                            $(document).ready(function () {
                                $('.viewdetail_other_request').click(function () {
                                    var id = $(this).attr('id');
                                    //                                    var uid = $('#user_id').attr('value');
                                    //                                    alert(uid);
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewOtherRequest',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#vdo').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/additionalSol',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#tabs_solutions_others').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewDevice',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#ddo').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewUser',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#udo').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewHistory',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#hdo').html(output);
                                        }
                                    });
                                });
                                $('a[rel*=leanModal]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});

                                $('#see_history_other_request').click(function () {
                                    $('#history_other_request').toggle('fast');
                                });
                            });
                        </script>

                    </div>

                </div>
                <div id="notifications">
                    <p>Special notifications would go here...</p>
                </div>
                <div id="takeaction">
                    <div id="viewdetail-ct">
                        <div id="viewdetail-header">
                            <h2>Take Action</h2>
                            <a class="modal_close" href="#"></a>
                        </div>
                        <form name="frm_act" id="frm_act" action="">
                            <div id="takeactioncontent">
                                <div id="form-area">
                                    <label class="success" id="action_result"></label><br />
                                    <label class="label" >Actions :  </label>
                                    <select name="actions" id="actions" class="select_medium">
                                        <option value=""> - Select -</option>
                                        <option value="assign"> Assign</option>
                                        <option value="solve"> Take action by yourself</option>
                                        <option value="forward"> Forward to another team</option>
                                        <option value="escalate"> Escalate/Out-source</option>
                                    </select><input type="hidden" name="rid" id="rid" value=""/>
                                    <div id="action_area">
                                        <div id="assign">
                                            <label class="label">Assign to : </label>
                                            <select class="select_medium" id="members" name="members">
                                                <option value="">-- Select --</option>
                                                <?php
                                                foreach ($this->availableUsers as $key => $value) {
                                                    echo '<option value="' . $value['user_id'] . '">' . $value['user_full_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div id="solve">
                                            <label class="label">Change Status To : </label><select class="select_medium" id="statusto" name="statusto">
                                                <option value="">-- Select --</option>
                                                <?php
                                                foreach ($this->requestStatus as $key => $value) {
                                                    if($value['stat_id']<>13)
                                                    echo '<option value="' . $value['stat_id'] . '">' . $value['stat_name'] . '</option>';
                                                }
                                                ?>
                                            </select><br />
                                            <h4 id="add_sol">Click here to add additional solution</h4>
                                            <div id="show_solution">
                                                <label class="label">Additional Solution : </label><textarea row="" cols="" class="textarea" id="solution"></textarea>
                                            </div>
                                        </div>
                                        <div id="forward">
                                            <label class="label">Forward to : </label><select class="select_medium" id="team" name="team">
                                                <option value="">-- Select --</option>
                                                <?php
                                                foreach ($this->availableTeams as $key => $value) {
                                                    if (Session::get('user_team') != $value['team_id'])
                                                        echo '<option value="' . $value['team_id'] . '">' . $value['team_name'] . '</option>';
                                                }
                                                ?>
                                            </select> <br />
                                            <label class="label">Reason : </label><textarea row="" cols="" class="textarea" id="reason">This request does not belong to my team.</textarea><br />
                                        </div>
                                        <div id="escalate">
                                            <label class="label">Escalate to : </label><input type="text" maxlength="100" class="text" id="escalate"/>
                                        </div>
                                        <br />
                                        <label class="label">Remark : </label><textarea maxlength="500" class="textarea" id="remark"></textarea><br />
                                    </div>
                                </div>
                            </div>

                            <div id="viewdetail-footer">
                                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="but_actions" value="Submit" class="submit"  />
                            </div>
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>
                <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>
                 <!--<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>-->
                <script>
                            //to view detail of requests
                            $(document).ready(function () {
                                $('.takeaction').click(function () {
                                    $('#rid').val($(this).attr('id'));
                                    //var case_id = $('#case_id').val();
                                    var frm = $('#frm_act');
                                    frm.submit(function (ev) {
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo URL; ?>view_request/takeAction',
                                            data: {
                                                rid: $('#rid').val(),
                                                caseId: $('#case_id').val(),
                                                actions: $('#actions').val(),
                                                members: $('#members').val(),
                                                team: $('#team').val(),
                                                statusto: $('#statusto').val(),
                                                escalateto: $('#escalate').val(),
                                                reason: $('#reason').val(),
                                                remark: $('#remark').val(),
                                                solution: $('#solution').val()
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

                                $('#actions').live('change', function () {
                                    var selected = $('#actions option:selected').val();
                                    if (selected == 'assign') {
                                        $('#action_area').show();
                                        $('#assign').show();
                                        $('#solve').hide();
                                        $('#forward').hide();
                                        $('#escalate').hide();
                                    } else if (selected == 'solve') {
                                        $('#action_area').show();
                                        $('#solve').show();
                                        $('#assign').hide();
                                        $('#forward').hide();
                                        $('#escalate').hide();
                                    } else if (selected == 'forward') {
                                        $('#action_area').show();
                                        $('#forward').show();
                                        $('#assign').hide();
                                        $('#solve').hide();
                                        $('#escalate').hide();
                                    } else if (selected == 'escalate') {
                                        $('#action_area').show();
                                        $('#escalate').show();
                                        $('#assign').hide();
                                        $('#solve').hide();
                                        $('#forward').hide();
                                    } else {
                                        $('#action_area').hide('fast');
                                    }
                                });


                                $('#add_sol').click(function () {
                                    $('#show_solution').toggle('fast');
                                });
                            });
                            $('input[type="reset"]').on('click', function (e) {
                                e.preventDefault();
                                $('#actions').val('');
                                $('#action_area').hide('fast');
                            });
                </script>
            </div>
        </div>
<?php } else if (Session::get('user_role') == 3) { ?>
        <div id="content">
            <div id="tabs">
                <ul>
                    <li id="notification_li"><span id="assigned_notification_count1" class="bg_new_request"></span><a href="#assigned">Assigned Request(s)</a></li>
                    <li><a href="#notifcation">Notification(s)</a></li>
                </ul>
                <div id="assigned">
                    <div id="list-container">
                        <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Request </th><th>Request Detail</th><th>Time</th><th>Requested By</th><th>#</th>
                                </tr>
                            </thead>
                            <?php
                            echo '<tbody>';
                            $count = 0;
                            foreach ($this->assignedReq as $key => $value) {

                                $count++;
                                ?>
                                <tr id="<?php echo $count; ?>" class="<?php
                                if ($count % 2 == 0) {
                                    echo 'dark';
                                } else
                                    echo 'light';
                                ?>">
                                        <?php
                                        echo '<td>' . $value['req_id'] . '</td>';
                                        if (empty($value['caseName'])) {
                                            echo '<td id="dis_case_name">Other</td><input type="hidden" value="Other" id="case_id" />';
                                        } else {
                                            echo '<td id="dis_case_name">' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_id" />';
                                        }
                                        echo '<td title="' . $value['req_details'] . '">' . WordCount::word_limit($value['req_details'], 5) . '...</td>';
                                        echo '<td>' . HumanTime::humanTiming($value['req_time']) . '</td>';
                                        echo '<td id="dis_user_name">' . $value['fullName'] . '</td><input type="hidden" value="' . $value['user_id'] . '" id="user_id" />';
                                        echo '<td><a id="' . $value['req_id'] . '" class="takeaction" href="#takeaction" rel="leanModal">Take Action</a> | <a id="' . $value['req_id'] . '" rel="leanModal" class="viewdetail" href="#viewdetail">View Detail</a></td>';
                                        echo '</tr>';
                                        ?></div><?php
                                }
                                echo '</tbody>';
                                ?>
                        </table>
                    </div>

                    <div id="viewdetail">
                        <div id="viewdetail-ct">
                            <div id="viewdetail-header">
                                <h2>Request Details</h2>
                                <a class="modal_close" href="#"></a>
                            </div>
                            <div id="viewdetailcontent">
                                <div id="tabs_solutions_assigned">
                                    <ul>
                                        <li id="notification_li"><a href="#request">Request</a></li>
                                        <li id="notification_li"><a href="#solution">Solutions</a></li>
                                    </ul>
                                    <div id="request">
                                        <table width="100%" border="1" class="bordered">
                                            <tbody alight="left" id="vd">

                                            </tbody>

                                        </table>
                                    </div>
                                    <div id="solution">
                                        <table width="100%" border="1" class="bordered">
                                            <tbody alight="left" id="solution_assigned">

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <h2 id="see_history">Click here for more detail</h2>

                                <div id="history">
                                    <div id="tabs_assigned">
                                        <ul>
                                            <li id="notification_li"><a href="#tabs-2">User Details</a></li>
                                            <li id="notification_li"><a href="#tabs-1">Device</a></li>
                                            <li><a href="#tabs-3">Request History</a></li>
                                        </ul>
                                        <div id="tabs-2">
                                            <div id="user_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>User ID</td><td>Full Name</td><td>Building</td><td>Floor</td><td>Directorate</td><td>Team</td><td>Position</td><td>Phone</td><td>Email</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="ud">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="tabs-1">
                                            <div id="device_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Type</td><td>Brand</td><td>Model</td><td>Tag Number</td><td>Hard Disk(GB)</td><td>RAM(GB)</td><td>Remark</td><td>Status</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="dd">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="tabs-3">
                                            <div id="history_detail">

                                                <table width="100%" border="1" class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Request </td><td>Request Detail</td><td>Request Time</td><td>Status</td><td>Handled By</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody alight="left" id="hd">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--</div>-->
                            </div>
                        </div>
                        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>
                        <script>
                            //to view detail of requests
                            $(document).ready(function () {
                                $('.viewdetail').click(function () {
                                    var id = $(this).attr('id');
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/assignedRequest',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#vd').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/additionalSol',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#solution_assigned').html(output);
                                        }
                                    });

                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewDevice',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#dd').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewUser',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#ud').html(output);
                                        }
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewHistory',
                                        data: {id: id},
                                        success: function (output) {
                                            $('#hd').html(output);
                                        }
                                    });
                                });
                                $('a[rel*=leanModal]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});


                                $('#see_history').click(function () {
                                    $('#history').toggle('fast');
                                });
                            });
                        </script>
                    </div>
                </div>
                <div id="notifcation">
                    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
                    <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
                </div>
                <div id="takeaction">
                    <div id="viewdetail-ct">
                        <div id="viewdetail-header">
                            <h2>Take Action</h2>
                            <a class="modal_close" href="#"></a>
                        </div>
                        <form name="frm_act" id="frm_act" action="">
                            <div id="takeactioncontent">
                                <div id="form-area">
                                    <label class="success" id="action_result"></label><br />
<!--                                    <label class="label" >Actions :  </label>
                                    <select name="actions" id="actions" class="select_medium">
                                        <option value=""> - Select -</option>
                                        <option value="solve"> Take Action</option>
                                        <option value="escalate"> Escalate</option>
                                    </select>-->
                                    <input type="hidden" name="rid" id="rid" value=""/>
                                    <!--<div id="action_area">-->
                                        <div id="solve">
                                            <label class="label">Current Status : </label><select class="select_medium" id="statusto" name="statusto">
                                                <option value="">-- Select --</option>
                                                <?php
                                                foreach ($this->requestStatus as $key => $value) {
                                                    if($value['stat_id']<>13 && $value['stat_id']<> 4 && $value['stat_id']<>5)
                                                    echo '<option value="' . $value['stat_id'] . '">' . $value['stat_name'] . '</option>';
                                                }
                                                ?>
                                            </select><br />
                                            <label class="label" id="add_sol">Click here to add additional solution : </label><div class="show_solution"><textarea row="" cols="" class="textarea" id="solution" name="solution" class="show_solution"></textarea></div><br/><br/>
                                        </div>
<!--                                        <div id="escalate">
                                            <label class="label">Escalate to : </label><input type="text" maxlength="100" class="text" id="escalateto"/>
                                        </div>-->
                                        <br />
                                        <label class="label">Remark : </label><textarea maxlength="500" class="textarea" id="remark"></textarea><br />
                                    <!--</div>-->
                                </div>
                            </div>

                            <div id="viewdetail-footer">
                                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="but_actions" value="Submit" class="submit"  />
                            </div>
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>
                <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>
                <script>
                            //to view detail of requests
                            $(document).ready(function () {
                                $('.takeaction').click(function () {
                                    $('#rid').val($(this).attr('id'));
                                    var frm = $('#frm_act');
                                    frm.submit(function (ev) {
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo URL; ?>view_request/takeActionTeamMember',
                                            data: {
                                                rid: $('#rid').val(),
                                                caseId: $('#case_id').val(),
//                                                actions: $('#actions').val(),
                                                statusto: $('#statusto').val(),
                                                escalateto: $('#escalateto').val(),
                                                remark: $('#remark').val(),
                                                solution: $('#solution').val()
                                            },
                                            success: function (data) {
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
                                $('a[rel*=leanModal]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});

                                $('#actions').live('change', function () {
                                    var selected = $('#actions option:selected').val();
                                    if (selected == 'solve') {
                                        $('#action_area').show();
                                        $('#solve').show();
                                        $('#escalate').hide();
                                    } else if (selected == 'escalate') {
                                        $('#action_area').show();
                                        $('#escalate').show();
                                        $('#solve').hide();
                                    } else {
                                        $('#action_area').hide('fast');
                                    }
                                });



                                $('#add_sol').click(function () {
                                    $('.show_solution').toggle('fast');
                                });
                            });
                            $('input[type="reset"]').on('click', function (e) {
                                e.preventDefault();
                                $('#actions').val('');
                                $('#action_area').hide('fast');
                            });
                </script>
            </div>
        </div>
<?php } ?>
</div>