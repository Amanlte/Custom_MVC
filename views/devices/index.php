<div class="wrapper_content">
    <div id="content">
        <h1>New Device</h1>
        <form action="<?php echo URL; ?>devices/insertDev" method="post" id="frm_dev">
            <div id="form-area">
                <?php
                if (Session::get('devSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('devSuccess', false);
                } else if (Session::get('devError') == true) {
                    echo '<p class="msg_error">Msg: No duplicate tag number is allowed!</p><br />';
                    Session::set('devError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('devSuccess', false);
                }
                ?>
                <div id="form-area-left">
                    <label class="label" >User Id :  </label><input type="text" class="text search" name="user_name" id="user_name" placeholder="Type user's full name "/><input type="text" id="name_of_user" class="dis_input" readonly /><br />
                    <label class="label" >Device Type : </label> 
                    <select class="select_medium" name="device_type" id="device_type">
                        <option value="">Select Device Type</option>
                        <?php
                        foreach ($this->dtLists as $key => $value) {
                            echo '<option value="' . $value['dt_id'] . '">' . $value['dt_name'] . '</option>';
                        }
                        ?>
                    </select><br />
                    <label class="label" >Device Brand : </label>  <select class="select_medium" name="device_brand" id="device_brand">
                        <option value="">Select Device Brand</option>
                    </select><br />
                    <label class="label" >Model : </label>  <select class="select_medium" name="device_model" id="device_model">
                        <option value="">Select Device Model</option>
                    </select><br />
                    <label class="label" >Tag Number :  </label><input type="text" class="text" name="tag_number" id="tag_number"><br />

                </div>
                <div id="form-area-right">

                    <label class="label" >Hard Disk Size (in GB) :  </label><input type="text" class="text" name="hard_disk_size" id="hard_disk_size" onkeypress="return isNumberKey(event);" ></br>
                    <label class="label" >RAM Size (in GB) :  </label><input type="text" class="text" name="ram_size" id="ram_size" onkeypress="return isNumberKey(event);"></br>
                    <label class="label" >Status : </label>  <select class="select_medium"  name="status" id="status">
                        <option value="">Select Device Status</option>
                        <?php
                        foreach ($this->dsLists as $key => $value) {
                            echo '<option value="' . $value['stat_name'] . '">' . ucwords($value['stat_name']) . '</option>';
                        }
                        ?>
                    </select><br />
                    <label class="label" >Remark <span>[Optional]</span> : </label><textarea class="textarea" name="remark" id="remark"></textarea><br />
                </div>
                <div class="clear"></div>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last" /><input type="submit" name="send" value="Send" class="submit"  />
            </div>
        </form>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>
        <script type="text/javascript">
                        $(document).ready(function () {
                            //autocomplete
                            $("#user_name").autocomplete({
                                source: "<?php echo URL; ?>devices/selectUserId",
                                minLength: 1,
                                focus: function (event, ui) {
                                    event.preventDefault();
                                    $("#user_name").val(ui.item.value);
                                },
                                select: function (event, ui) {
                                    event.preventDefault();
                                    $("#name_of_user").val(ui.item.label);
                                    $("#user_name").val(ui.item.value);
                                    return false;
                                }
                            });
                        });
                        $(document).ready(function () {
                            $('#device_type').change(function () {
                                if ($(this).val() != '') {
                                    $("#device_brand").load("<?php echo URL; ?>devices/selectDeviceBrandId", {dt: $(this).val()});
                                } else {
                                    $("#device_brand").empty();
                                    $("#device_brand").html('<option value="">Select Device Brand</option>');
                                }
                            });
                        });
                        $(document).ready(function () {
                            $('#device_brand').change(function () {
                                if ($(this).val() != '') {
                                    $("#device_model").load("<?php echo URL; ?>devices/selectDeviceModelId", {dm: $(this).val()});
                                } else {
                                    $("#device_model").empty();
                                    $("#device_model").html('<option value="">Select Device Model</option>');
                                }
                            });
                        });
        </script>
        <div id="list-container">
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>ID</th><th>User Name</th><th>Device Type</th><th>Brand</th><th>Tag</th><th>Hard Disk</th><th>RAM</th><th>Remark</th><th>Status</th><th>Registration Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->devLists as $key => $value) {
                    $count++;
                    ?>
                    <tr id="<?php echo $count; ?>" class="<?php
                    if ($count % 2 == 0) {
                        echo 'dark';
                    } else
                        echo 'light';
                    ?>">
                            <?php
                            echo '<td>' . $value['dev_id'] . '</td>';
                            echo '<td>' . $value['user_full_name'] . '</td>';
                            echo '<td>';
                            foreach ($this->dtLists as $dtName) {
                                if ($value['dev_type'] == $dtName['dt_id'])
                                    echo $dtName['dt_name'];
                            }
                            echo '</td>';
                            echo '<td>';
                            foreach ($this->dbLists as $dbName) {
                                if ($value['dev_brand'] == $dbName['db_id'])
                                    echo $dbName['db_name'];
                            }
                            echo '</td>';
                            echo '<td>' . $value['dev_tag'] . '</td>';
                            echo '<td>' . $value['dev_pc_hd'] . '</td>';
                            echo '<td>' . $value['dev_pc_ram'] . '</td>';
                            echo '<td>' . $value['dev_remark'] . '</td>';
                            echo '<td>';
                            foreach ($this->dsLists as $dsName) {
                                if ($value['dev_status'] == $dsName['stat_id'])
                                    echo $dsName['stat_name'];
                            }echo '</td>';
                            echo '<td width="">' . $value['dev_reg_date'] . '</td>';
                            echo '<td>' . $value['dev_reg_by'] . '</td>';
                            echo '<td>';
                            if (Session::get('Update') == true && Session::get('Delete') == true) {
                                echo '<a href="' . URL . 'devices/edit/' . $value['dev_id'] . '">Edit</a> | ';
                            } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                                echo '<a href="' . URL . 'devices/edit/' . $value['dev_id'] . '">Edit</a> | ';
                            }
                            if (Session::get('Delete') == true) {
                                echo ' <a href=javascript:confirmDelete("' . URL . 'devices/delete/' . $value['dev_id'] . '")>Delete</a>';
                            }
                            echo '</td></tr>';
                        }
                        echo '</tbody>';
                        ?>
            </table>
        </div>
    </div>
</div>