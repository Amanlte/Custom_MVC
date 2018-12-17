    <div class="wrapper_content">
        <div id="content">
            <h1>Device Brand</h1>
            <form action="<?php echo URL; ?>device_brand/insertDb" method="post" id="frm_db">        
                <div id="form-area">
                    <?php
                    if (Session::get('dbSuccess') == true && Session::get('pdoError') == false) {
                        echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                        Session::set('dbSuccess', false);
                    } else if (Session::get('dbError') == true) {
                        echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                        Session::set('dbError', false);
                    } else {
                        echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                        Session::remove('pdoError');
                         Session::set('dbSuccess', false);
                    }
                    ?>
                    <label class="label" > Type : </label>  <select class="select_medium"  name="dt_name" id="dt_name">
                        <?php
                        echo '<option value="">-- Select --</option>';
                        foreach ($this->dtLists as $key => $value) {
                            echo '<option value="' . $value['dt_id'] . '">' . $value['dt_name'] . '</option>';
                        }
                        ?>
                    </select><br />
                    <label class="label" > Brand :  </label><input type="text" class="text" name="db_name" id="db_name"></br>
                   </div>
                <div id="form-button-area">
                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  /><input type="submit" name="send" value="Save" class="submit"  />
                </div>
            </form>
            <div id="list-container">
                <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                    <thead>
                        <tr>
                            <th>ID</th><th>Device Brand</th><th>Device Type</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                        </tr>
                    </thead>
                    <?php
                    echo '<tbody>';
                    $count = 0;
                    foreach ($this->dbLists as $key => $value) {

                        $count++;
                        ?>
                        <tr id="<?php echo $count; ?>" class="<?php
                        if ($count % 2 == 0) {
                            echo 'dark';
                        } else
                            echo 'light';
                        ?>">
                                <?php
                                echo '<td>' . $value['db_id'] . '</td>';
                                echo '<td>' . $value['db_name'] . '</td>';
                                echo '<td>' . $value['dt_name'] . '</td>';
                                echo '<td>' . $value['db_reg_date'] . '</td>';
                                echo '<td>' . $value['db_reg_by'] . '</td>';
                                echo '<td>';
                                if (Session::get('Update') == true && Session::get('Delete') == true) {
                                    echo '<a href="' . URL . 'device_brand/edit/' . $value['db_id'] . '">Edit</a> |';
                                } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                                    echo '<a href="' . URL . 'device_brand/edit/' . $value['db_id'] . '">Edit</a>';
                                }

                                if (Session::get('Delete') == true) {
                                    echo '<a href=javascript:confirmDelete("' . URL . 'device_brand/delete/' . $value['db_id'] . '")>Delete</a>';
                                }
                                echo '</td></tr>';
                            }
                            echo '</tbody>';
                            ?>
                </table>
            </div>
        </div>
    </div>