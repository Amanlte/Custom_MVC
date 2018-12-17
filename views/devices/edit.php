<div class="wrapper_content">
    <div id="content">
        <h1>Edit Devices</h1>
        <form action="<?php echo URL; ?>devices/editSave/<?php echo $this->devId[0]['dev_id'] ?>" method="post" id="frm_dev">        
            <div id="form-area">
                <?php
                if (Session::get('devSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('devSuccess', false);
                } else if (Session::get('devError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('devError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <div id="form-area-left">
                    <label class="label" >User Id :  </label><input type="text" class="text search" name="user_name" id="user_name" value="<?php echo $this->devId[0]['user_id']; ?>"/><input type="text" id="name_of_user" class="dis_input" readonly /><br />

                    <!--<label class="label" >User Id:  </label><input type="text" class="text search" name="user_name" id="user_name" value="<?php echo $this->devId[0]['user_id']; ?>" /><br />-->
                    <label class="label" >Device Type : </label> 
                    <select class="select_medium" name="device_type" id="device_type">
                        <option value="">Select Device Type</option>
                        <?php
                        foreach ($this->dtLists as $key => $value) {
                            if ($this->devId[0]['dev_type'] == $value['dt_id']) {
                                echo '<option value="' . $value['dt_id'] . '" selected>' . $value['dt_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['dt_id'] . '">' . $value['dt_name'] . '</option>';
                            }
                        }
                        ?>
                    </select><br />
                    <label class="label" >Device Brand : </label>  
                    <select class="select_medium" name="device_brand" id="device_brand">
                        <option value="">Select Device Type</option>
                        <?php
                        foreach ($this->dbLists as $key => $value) {
                            if ($this->devId[0]['dev_brand'] == $value['db_id']) {
                                echo '<option value="' . $value['db_id'] . '" selected>' . $value['db_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['db_id'] . '">' . $value['db_name'] . '</option>';
                            }
                        }
                        ?>
                    </select><br /> 
                    <label class="label" >Tag Number :  </label><input type="text" class="text" name="tag_number" id="tag_number"  value="<?php echo $this->devId[0]['dev_tag']; ?>" /><br />

                </div>
                <div id="form-area-right">

                    <label class="label" >Hard Disk Size (in GB) :  </label><input type="text" class="text" name="hard_disk_size" id="hard_disk_size" value="<?php echo $this->devId[0]['dev_pc_hd']; ?>" onkeypress="return isNumberKey(event);" ></br>  
                    <label class="label" >RAM Size (in GB) :  </label><input type="text" class="text" name="ram_size" id="ram_size" value="<?php echo $this->devId[0]['dev_pc_ram']; ?>" onkeypress="return isNumberKey(event);"></br>
                    <label class="label" >Status : </label>  
                    <select class="select_medium"  name="status" id="status">
                        <option value="">Select Device Status</option>
                        <?php
                        foreach ($this->dsLists as $key => $value) {
                            if ($this->devId[0]['dev_status'] == $value['stat_id']) {
                                echo '<option value="' . $value['stat_id'] . '" selected>' . $value['stat_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['stat_id'] . '">' . $value['stat_name'] . '</option>';
                            }
                            // echo '<option value="' . $value['stat_name'] . '">' . ucwords($value['stat_name']) . '</option>';
                        }
                        ?>
                    </select><br />
                    <label class="label" >Remark <span>[Optional]</span> : </label><textarea class="textarea" name="remark" id="remark"><?php echo $this->devId[0]['dev_remark']; ?></textarea><br />                    
                </div>
                <div class="clear"></div>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
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
        </script>
        <script>
            function save() {
                var query = $('#frm_dev').serialize();
                var url = 'devices/editSave/<?php echo $this->dirId[0]['dev_id'] ?>';
                $.post(url, query, function (response) {
                    alert(response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>
</div>