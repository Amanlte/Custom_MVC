<div class="wrapper_content">
    <div id="content">
        <h1>Device Model</h1>

        <form action="<?php echo URL; ?>device_models/insertDb" method="post" id="frm_db">        
            <div id="form-area">
                <?php
                if (Session::get('dmSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('dmSuccess', false);
                } else if (Session::get('dmError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                    Session::set('dmError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('dmSuccess', false);
                }
                ?>
                <label class="label" >Device Type : </label> <select class="select_medium" name="device_type" id="device_type">
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
                <label class="label" > Model :  </label><input type="text" class="text" name="dm_name" id="dm_name"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  /><input type="submit" name="send" value="Save" class="submit"  />
            </div>
        </form>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>
        <script type="text/javascript">
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
                        <th>Device Brand</th><th>Device Type</th><th>Device Model</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->dmLists as $key => $value) {

                    $count++;
                    ?>
                    <tr id="<?php echo $count; ?>" class="<?php
                    if ($count % 2 == 0) {
                        echo 'dark';
                    } else
                        echo 'light';
                    ?>">
                            <?php
//                            echo '<td>' . $value['dm_id'] . '</td>';
                            echo '<td>' . $value['db_name'] . '</td>';
                            echo '<td>' . $value['dtName'] . '</td>';
                            echo '<td>' . $value['dm_name'] . '</td>';
                            echo '<td>' . $value['dm_reg_date'] . '</td>';
                            echo '<td>' . $value['dm_reg_by'] . '</td>';
                            echo '<td>';
                            if (Session::get('Update') == true && Session::get('Delete') == true) {
                                echo '<a href="' . URL . 'device_models/edit/' . $value['dm_id'] . '">Edit</a> |';
                            } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                                echo '<a href="' . URL . 'device_models/edit/' . $value['dm_id'] . '">Edit</a>';
                            }

                            if (Session::get('Delete') == true) {
                                echo '<a href=javascript:confirmDelete("' . URL . 'device_model/delete/' . $value['dm_id'] . '")>Delete</a>';
                            }
                            echo '</td></tr>';
                        }
                        echo '</tbody>';
                        ?>
            </table>
        </div>
    </div>
</div>