    <div class="wrapper_content">
        <div id="content">
            <h1>Role Functionality Relationship</h1>
            <form action="<?php echo URL; ?>role_functionality/insertRolFun" method="post" id="frm_rof">
                <div id="form-area">
                    <?php
                    if (Session::get('rfSuccess') == true && Session::get('pdoError') == false) {
                        echo '<p class="success">Msg: Record Successfully  saved!</p><br />';
                        Session::set('rfSuccess', false);
                    } else if (Session::get('rfError') == true) {
                        echo '<p class="msg_error">Msg: Record exists with the role provided!</p><br />';
                        Session::set('rfError', false);
                    } else {
                        echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                        Session::remove('pdoError');
                        Session::set('rfSuccess', false);
                    }
                    ?>
                    <label class="label" >Role Name : </label>  <select class="select_medium" name="role_id" id="role_id">
                        <option value="">-- Select --</option>
                        <?php
                        foreach ($this->roleId as $key => $value) {
                            echo '<option value="' . $value['role_id'] . '">' . $value['role_name'] . '</option>';
                        }
                        ?>
                    </select><br />
                    <label class="label" >Permissions : </label>
                    <?php
                    echo '<table class="this">';
                    echo '<tr><td>Select All</td><td><input type="checkbox" id="selecctall" /></td></tr>';
                    foreach ($this->roleFunId as $key => $value) {
                        echo'<tr class="">'
                        . '<td class="this">' . $value['func_name'] . '</td>'
                        . '<td class="this"><input type="checkbox" class="checkbox checkbox1"  name="functionality_id[]" id="functionality_id" value="' . $value['func_id'] . '" /></td>'
                        . '</tr>';
                    }
                    echo '</table>';
                    ?>
                    <br />                               
                </div>
                <div id="form-button-area">
                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  />&nbsp;&nbsp;<input type="submit" name="send" value="Submit" class="submit"  />
                </div>
            </form>
            <div id="list-container">			
                <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                    <thead>
                        <tr>
                            <th>ID</th><th>Role</th><th>Permissions</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                        </tr>
                    </thead>
                    <?php
                    echo '<tbody>';
                    $count = 0;
                    foreach ($this->rfLists as $key => $value) {
                        $count++;
                        ?>
                        <tr id="<?php echo $count; ?>" class="<?php
                        if ($count % 2 == 0) {
                            echo 'dark';
                        } else
                            echo 'light';
                        ?>">
                                <?php
                                echo '<td>' . $value['rf_id'] . '</td>';
                                echo '<td width="30%">' . $value['role_name'] . '</td>';
                                $all_ = $value['fun_id'];
                                $all_ = explode(',', $all_);
                                echo '<td width = "30%">';

                                foreach ($all_ as $all) {
                                    foreach ($this->funcname as $key => $funcName) {
                                        if ($all == $funcName['func_id'])
                                            echo $funcName['func_name'] . "</br>";
                                    }
                                }
                                echo '</td>';
                                echo '<td>' . $value['rf_reg_date'] . '</td>';
                                echo '<td>' . $value['rf_reg_by'] . '</td>';
                                echo '<td>';
                                    if (Session::get('Update') == true && Session::get('Delete') == true){
                                        echo '<a href="' . URL . 'role_functionality/edit/' . $value['rf_id'] . '">Edit</a> | ';}
                                    else if (Session::get('Update') == true && Session::get('Delete') == false){ 
                                        echo '<a href="' . URL . 'role_functionality/edit/' . $value['rf_id'] . '">Edit</a>';}
                                    if (Session::get('Delete') == true){                                       
                                    echo' <a href=javascript:confirmDelete("' . URL . 'role_functionality/delete/' . $value['rf_id'] . '")>Delete</a>';}
                                echo '</td></tr>';
                            }
                            echo '</tbody>';
                            ?>
                </table>
            </div>
        </div>
    </div>