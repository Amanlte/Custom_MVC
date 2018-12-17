<div class="wrapper_content">
    <div id="content">
        <h1>New Status</h1>
        <form action="<?php echo URL; ?>status/insertSta" method="post" id="frm_sta">
            <div id="form-area">

                <?php
                if (Session::get('staSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('staSuccess', false);
                } else if (Session::get('staError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                    Session::set('staError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('staSuccess', false);
                }
                ?>
                <label class="label" >Status:  </label><input type="text" class="text" name="status_name" id="status_name"></br>
                <label class="label" >Status For:  </label><select name="status_for" class="select_medium">
                    <option value="">--Select--</option>
                    <?php
                    foreach ($this->tableNames as $tblName) {
                        echo '<option value="' . $tblName['TABLE_NAME'] . '">' . ucwords(str_replace("_", " ", $tblName['TABLE_NAME'])) . '</option>';
                    }
                    ?>
                </select><br />
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="send" value="Send" class="submit"  />
            </div>
        </form>
        <div id="list-container">
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>Status ID</th><th>Status Name</th><th>Status For</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->staLists as $key => $value) {
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
                                echo '<td>' . $value['stat_id'] . '</td>';
                                echo '<td>' . $value['stat_name'] . '</td>';
                                echo '<td>' . $value['stat_for'] . '</td>';
                                echo '<td>' . $value['stat_reg_date'] . '</td>';
                                echo '<td>' . $value['stat_reg_by'] . '</td>';
                                echo '<td>';
                                if (Session::get('Update') == true && Session::get('Delete') == true) {
                                    echo '<a href="' . URL . 'status/edit/' . $value['stat_id'] . '">Edit</a> |';
                                } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                                    echo '<a href="' . URL . 'status/edit/' . $value['stat_id'] . '">Edit</a>';
                                }
                                if (Session::get('Delete') == true) {
                                    echo '<a href=javascript:confirmDelete("' . URL . 'status/delete/' . $value['stat_id'] . '")>Delete</a>';
                                }
                                echo '</td></tr>';
                                ?></div><?php
                    }
                    echo '</tbody>';
                    ?>
            </table>
        </div>
    </div>
</div>