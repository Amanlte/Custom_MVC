    <div class="wrapper_content">
        <div id="content">
            <h1>New Role</h1>
            <form action="<?php echo URL; ?>roles/insertRole" method="post" id="frm_rol">
                <div id="form-area">
                    <?php
                    if (Session::get('roleSuccess') == true && Session::get('pdoError') == false) {
                        echo '<p class="success">Msg: Record Successfully  saved!</p><br />';
                        Session::set('rolSuccess', false);
                    } else if (Session::get('rolError') == true) {
                        echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                        Session::set('rolError', false);
                    } else {
                        echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                        Session::remove('pdoError');
                        Session::set('roleSuccess', false);
                    }
                    ?>
                    <label class="label" >Role Name :  </label><input type="text" class="text" name="role_name" id="role_name"></br>
                </div>
                <div id="form-button-area">
                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  />&nbsp;&nbsp;<input type="submit" name="send" value="Send" class="submit"  />
                </div>
            </form>
            <div id="list-container">
                <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                    <thead>
                        <tr>
                            <th>ID</th><th>Role Name</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                        </tr>
                    </thead>
                    <?php
                    echo '<tbody>';
                    $count = 0;
                    foreach ($this->roleLists as $key => $value) {
                        ?><div class="pagedemo _current" style=""><?php
                            $count++;
                            ?>
                            <tr id="<?php echo $count; ?>" class="<?php
                        if ($count % 2 == 0) {
                            echo 'dark';
                        } else
                            echo 'light';
                            ?>">
                                <?php
                                    echo '<td>' . $value['role_id'] . '</td>';
                                    echo '<td width="30%">' . $value['role_name'] . '</td>';
                                    echo '<td>' . $value['role_reg_date'] . '</td>';
                                    echo '<td>' . $value['role_reg_by'] . '</td>';
                                    echo '<td>';
                                        if (Session::get('Update') == true && Session::get('Delete') == true){
                                            echo '<a href="' . URL . 'roles/edit/' . $value['role_id'] . '">Edit</a> |';}
                                        else if (Session::get('Update') == true && Session::get('Delete') == false){ 
                                            echo '<a href="' . URL . 'roles/edit/' . $value['role_id'] . '">Edit</a>';}
                                        if (Session::get('Delete') == true){ 
                                        echo '<a href=javascript:confirmDelete("' . URL . 'roles/delete/' . $value['role_id'] . '")>Delete</a>';}
                                    echo '</td></tr>';
                                    ?></div><?php
                                }
                                echo '</tbody>';
                                ?>
                </table>

            </div>

        </div>
    </div>