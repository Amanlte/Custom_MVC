<div class="wrapper_content">
    <div id="content">
        <h1>New User </h1>
        <form action="<?php echo URL; ?>users/insertUsers" method="post" id="frm_use">
            <div id="form-area">
                <div id="form-area-left">
                    <?php
                    if (Session::get('usersSuccess') == true && Session::get('pdoError') == false) {
                        echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                        Session::set('usersSuccess', false);
                    } else if (Session::get('usersError') == true) {
                        echo '<p class="msg_error">Msg: No duplicate user name number is allowed!</p><br />';
                        Session::set('usersError', false);
                        echo '<script>$(function(){$(".submit").click(function(){ jQuery(".pdo_error").fadeOut();});$(".text").click(function(){ jQuery(".pdo_error").fadeOut();});});</script>';
                    } else {
                        echo '<p class="msg_error">' . Session::get('pdoError') . '</p><br />';
                        Session::set('usersError', false);
                        Session::set('pdoError', false);
                    }
                    ?>
                    <label class="label" >Full Name :  </label><input type="text" class="text" name="full_name" id="full_name"></br>
                    <label class="label" >Building : </label>  <select class="select_medium" name="building" id="building">
                        <option value="">--Select--</option>
                        <?php
                        foreach ($this->buildingLists as $key => $value) {
                            echo '<option value="' . $value['bui_id'] . '">' . $value['bui_name'] . '</option>';
                        }
                        ?>
                    </select><br />
                    <label class="label" >Floor : </label>  <select class="select_medium" name="floor" id="floor">
                        <option value="">--Select--</option>
                        <?php
                        foreach ($this->floorLists as $key => $value) {
                            echo '<option value="' . $value['flr_id'] . '">' . $value['flr_name'] . '</option>';
                        }
                        ?>
                    </select><br /> 
                    <label class="label" >Directorate : </label>  <select class="select_medium" name="directorate" id="directorate">
                        <option value="">--Select--</option>
                        <?php
                        foreach ($this->dirName as $key => $value) {
                            echo '<option value="' . $value['dir_id'] . '">' . $value['dir_name'] . '</option>';
                        }
                        ?>
                    </select><br /> 
                    <label class="label" >Team : </label>  <select class="select_medium" name="team" id="team">
                        <option value="">--Select--</option>

                    </select><br /> 
                    <label class="label" >Position : </label>  <select class="select_medium" name="position" id="position">
                        <option value="">--Select--</option>
                        <?php
                        foreach ($this->positionLists as $key => $value) {
                            echo '<option value="' . $value['pos_id'] . '">' . $value['pos_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div id="form-area-right">
                    <p>&nbsp;</p>
                    <label class="label" >User Name :  </label><input type="text" class="text" name="user_name" id="user_name"></br>
                    <label class="label">User Password :  </label><input type="text" class="text" name="user_password" id="user_password"></br>
                    <label class="label" >Phone Number :  </label><input type="text" class="text" name="phone_number" id="phone_number" onkeypress="return isNumberKey(event)"></br>
                    <label class="label" >E-mail :  </label><input type="text" class="text" name="email" id="email"><span>[Optional]</span></br>
                    <label class="label" >Role : </label>  <select class="select_medium" name="roles" id="roles">
                        <option value="">--Select--</option>
                        <?php
                        foreach ($this->rolName as $key => $value) {
                            echo '<option value="' . $value['role_id'] . '">' . $value['role_name'] . '</option>';
                        }
                        ?>
                    </select><br />  

                </div>
                <div class="clear"></div>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="send" value="Submit" class="submit"  />
            </div>
        </form>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>	
        <script type="text/javascript">
                        $(document).ready(function() {
                            $('#directorate').change(function() {
                                if ($(this).val() != '') {
                                    $("#team").load("<?php echo URL; ?>users/selectTeamByDir", {dir: $(this).val()});
                                } else {
                                    $("#team").empty();
                                    $("#team").html('<option value="">--Select--</option>');
                                }
                            });
                        });
        </script>
        <div id="list-container">
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>ID</th><th>Full Name</th><th>Building</th><th>Floor</th><th>Directorate</th><th>Position</th>
                        <!--<th>Login Name</th><th>First Login</th>-->
                        <th>Phone</th>
                        <!--<th>Email</th>-->
                        <th>Role</th>
                        <!--<th>Registration Date</th><th>Registered By</th>-->
                        <th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->usersDetails as $key => $value) {
                    $count++;
                    ?>
                    <tr id="<?php echo $count; ?>" class="<?php
                    if ($count % 2 == 0) {
                        echo 'dark';
                    } else
                        echo 'light';
                    ?>">

                        <?php
                        echo '<td>' . $value['user_id'] . '</td>';
                        echo '<td>' . $value['user_full_name'] . '</td>';
                        echo '<td>' . $value['building'] . '</td>';
                        echo '<td>' . $value['floor'] . '</td>';
                        echo '<td>' . $value['directorate'] . '</td>';
                        echo '<td>' . $value['position'] . '</td>';
                        echo '<td>' . $value['user_phone'] . '</td>';
                        echo '<td>' . $value['role'] . '</td>';
                        echo '<td>';
                        if (Session::get('Update') == true && Session::get('Delete') == true) {
                            echo '<a href="' . URL . 'users/edit/' . $value['user_id'] . '">Edit</a> |';
                        } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                            echo '<a href="' . URL . 'users/edit/' . $value['user_id'] . '">Edit</a> |';
                        }
                        if (Session::get('Delete') == true) {
                            echo ' <a href=javascript:confirmDelete("' . URL . 'users/delete/' . $value['user_id'] . '")>Delete</a> | ';
                        }
                        echo '<a id="' . $value['user_id'] . '" rel="leanModalUser" name="viewdetail" href="#viewdetail" class="viewuserdetail">View Detail</a></td></tr>';
                    }
                    echo '</tbody>';
                    ?>
            </table>
        </div>
        <div id="viewdetail">
            <div id="viewdetail-ct">
                <div id="viewdetail-header">
                    <h2>User Details</h2>
                    <a class="modal_close" href="#"></a>
                </div>
                <div id='viewdetailcontent'>
                    <table id="vd"cellpadding="0" cellspacing="0" width="100%" class="bordered">
                        <tbody id="vd">

                        </tbody>
                    </table>
                    <h2 id="see_history">Click here for more detail</h2>
                    <div id="history">
                        <div id="tabs">
                            <ul>
                                <!--<li id="notification_li"><a href="#user">User Details</a></li>-->
                                <li id="notification_li"><a href="#device">User Devices(s)</a></li>
                                <li id="notification_li"><a href="#request">Request History</a></li>

                            </ul>
<!--                            <div id="user">
                                <div id="user_detail">
                                    <h3></h3>
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
                            </div>-->
                            <div id="device">
                                <div id="device_detail">
                                    <table width="100%" border="1" class="bordered">
                                        <thead>
                                            <tr>
                                                <th>Type</th><th>Brand</th><th>Model</th><th>Tag Number</th><th>Hard Disk(GB)</th><th>RAM(GB)</th><th>Reamark</th><th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody alight="left" id="dd">

                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                            <div id="request">
                                <div id="request_history">
                                    <table width="100%" border="1" class="bordered">
                                        <thead>
                                            <tr>
                                                <th>Case Name</th><th>Request Details</th><th>Request Time</th><th>Additional Solution</th><th>Status</th><th>Handled By</th>
                                            </tr>
                                        </thead>
                                        <tbody alight="left" id="rh">

                                        </tbody>
                                    </table>
                                </div>    
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>
        <script>
                        $(document).ready(function() {
                            $('.viewuserdetail').click(function() {
                                var id = $(this).attr('id');
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo URL; ?>users/viewUserDetails',
                                    data: {id: id},
                                    success: function(output) {
                                        $('#vd').html(output);
                                    }
                                });


//                                $.ajax({
//                                    type: 'POST',
//                                    url: '<?php echo URL; ?>users/viewUser',
//                                    data: {id: id},
//                                    success: function(output) {
//                                        $('#ud').html(output);
//                                    }
//                                });
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo URL; ?>users/viewDevice',
                                    data: {id: id},
                                    success: function(output) {
                                        $('#dd').html(output);
                                    }
                                });
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo URL; ?>users/viewHistory',
                                    data: {id: id},
                                    success: function(output) {
                                        $('#rh').html(output);
                                    }
                                });
                            });

                            $('a[rel*=leanModalUser]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});
                            $('#see_history').click(function() {
                                $('#history').toggle('fast');
                            });
                        });
        </script>
    </div>
</div>