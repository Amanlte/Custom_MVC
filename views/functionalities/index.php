<div class="wrapper_content">
    <div id="content">
        <h1>New Permission</h1>
        <form action="<?php echo URL; ?>functionalities/insertFunc" method="post" id="frm_fun">
            <div id="form-area">
                <?php
                if (Session::get('funcSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('funcSuccess', false);
                } else if (Session::get('funcError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                    Session::set('funcError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('funcSuccess', false);
                }
                ?>
                <label class="label" >Permision Name :  </label><input type="text" class="text" name="functionality_name" id="functionality_name"></br>

            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last" /><input type="submit" name="send" value="Submit" class="submit"  />
            </div>
        </form>            
        <div id="list-container">
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>ID</th><th>Permission Name</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>

                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->funcLists as $key => $value) {

                    $count++;
                    ?>
                    <tr id="<?php echo $count; ?>" class="<?php
                    if ($count % 2 == 0) {
                        echo 'dark';
                    } else
                        echo 'light';
                    ?>">
                            <?php
                            echo '<td>' . $value['func_id'] . '</td>';
                            echo '<td width="30%">' . $value['func_name'] . '</td>';
                            echo '<td>' . $value['func_reg_date'] . '</td>';
                            echo '<td>' . $value['func_reg_by'] . '</td>';
                            echo '<td>';
                            if (Session::get('Update') == true && Session::get('Delete') == true) {
                                echo '<a href="' . URL . 'functionalities/edit/' . $value['func_id'] . '">Edit</a> |';
                            } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                                echo '<a href="' . URL . 'functionalities/edit/' . $value['func_id'] . '">Edit</a>';
                            }
                            if (Session::get('Delete') == true) {
                                echo '<a href=javascript:confirmDelete("' . URL . 'functionalities/delete/' . $value['func_id'] . '")>Delete</a>';
                            }
                            echo '</td></tr>';
                        }
                        echo '</tbody>';
                        ?>
            </table>
        </div>
    </div>
</div>
