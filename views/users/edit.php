    <div class="wrapper_content">
        <div id="content">
            <h1>Edit User</h1>
            <form action="<?php echo URL; ?>users/editSave/<?php echo $this->userId[0]['user_id'] ?>" method="post" id="frm_use">        
                <div id="form-area">
                    <?php
                    if (Session::get('userSuccess') == true) {
                        echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                        Session::set('userSuccess', false);
                    } else if (Session::get('userError') == true) {
                        echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                        Session::set('userError', false);
                    } else {
                        echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                        Session::remove('pdoError');
                    }
                    ?>
                    <label class="label" >Full Name :  </label><input type="text" class="text" name="full_name" id="full_name"  value="<?php echo $this->userId[0]['user_full_name'] ?>"><br />
                    <label class="label" >User Name :  </label><input type="text" class="text" name="user_name" id="user_name"  value="<?php echo $this->userId[0]['user_login_name'] ?>"></br>
                    <label class="label" >Building : </label>  <select class="select_medium" name="building" id="building">
                        <?php
                        foreach ($this->buildingLists as $key => $value) {
                            if ($this->userId[0]['user_building'] == $value['bui_id']) {
                                echo '<option value="' . $value['bui_id'] . '" selected>' . $value['bui_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['bui_id'] . '">' . $value['bui_name'] . '</option>';
                            }
                        }                    
                        ?>
                    </select><br />
                    <label class="label" >Floor : </label>  <select class="select_medium" name="floor" id="floor" name="floor">
                        <?php
                        foreach ($this->floorLists as $key => $value) {
                            if ($this->userId[0]['user_floor'] == $value['flr_id']) {
                                echo '<option value="' . $value['flr_id'] . '" selected>' . $value['flr_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['flr_id'] . '">' . $value['flr_name'] . '</option>';
                            }
                        }                    
                        ?>
                    </select><br /> 
                    <label class="label" >Directorate : </label>  <select class="select_medium" name="directorate" id="directorate">
                        <?php
                        foreach ($this->dirLists as $key => $value) {
                            if ($this->userId[0]['user_directorate'] == $value['dir_id']) {
                                echo '<option value="' . $value['dir_id'] . '" selected>' . $value['dir_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['dir_id'] . '">' . $value['dir_name'] . '</option>';
                            }
                        }                    
                        ?>
                    </select><br /> 
                    <label class="label" >Team : </label>  <select class="select_medium" name="team" id="team">
                        <?php
                        foreach ($this->teamLists as $key => $value) {
                            if ($this->userId[0]['user_team'] == $value['team_id']) {
                                echo '<option value="' . $value['team_id'] . '" selected>' . $value['team_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['team_id'] . '">' . $value['team_name'] . '</option>';
                            }
                        }                    
                        ?>
                    </select><br /> 
                    <label class="label" >Position : </label>  <select class="select_medium" name="position" id="position">
                        <?php
                        foreach ($this->positionLists as $key => $value) {
                            if ($this->userId[0]['user_position'] == $value['pos_id']) {
                                echo '<option value="' . $value['pos_id'] . '" selected>' . $value['pos_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['pos_id'] . '">' . $value['pos_name'] . '</option>';
                            }
                        }                    
                        ?>
                    </select> <span>[Optional]</span><br /> 
                    <label class="label" >Phone Number :  </label><input type="text" class="text" name="phone_number" id="phone_number" onkeypress="return isNumberKey(event)"  value="<?php echo $this->userId[0]['user_phone'] ?>"></br>
                    <label class="label" >E-mail :  </label><input type="text" class="text" name="email" id="email" value="<?php echo $this->userId[0]['user_email'] ?>"><span>[Optional]</span></br>
                    <label class="label" >Role : </label>  <select class="select_medium" name="roles" id="roles">
                        <?php
                        foreach ($this->rolName as $key => $value) {
                            if ($this->userId[0]['user_role'] == $value['role_id']) {
                                echo '<option value="' . $value['role_id'] . '" selected>' . $value['role_name'] . '</option>';
                            } else {
                                echo '<option value="' . $value['role_id'] . '">' . $value['role_name'] . '</option>';
                            }
                        }
                        ?>
                    </select><br />  


                </div>
                <div id="form-button-area">
                    <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
                </div>
            </form>
            <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>	
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#directorate').change(function() {
                        if ($(this).val() != '') {
                            $("#team").load("<?php echo URL; ?>users/selectTeamByDirForEdit", {dir: $(this).val()});
                        } else {
                            $("#team").empty();
                            $("#team").html('<option value="">--Select--</option>');
                        }
                    });
                });
            </script>
        </div>
    </div>