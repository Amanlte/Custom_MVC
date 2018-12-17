    <div class="wrapper_content">
        <div id="content">
            <h1>New Floor</h1>
            <form action="<?php echo URL; ?>floor/insertFlr" method="post" id="frm_flr">        
                <div id="form-area">
                    <?php
                    if (Session::get('flrSuccess') == true && Session::get('pdoError') == false) {
                        echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                        Session::set('flrSuccess', false);
                    } else if (Session::get('flrError') == true) {
                        echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                        Session::set('flrError', false);
                    } else {
                        echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                        Session::remove('pdoError');
                         Session::set('flrSuccess', false);
                    }
                    ?>

                    <label class="label" >Floor Name :  </label><input type="text" class="text" name="flr_name" id="flr_name"></br>
                </div>
                <div id="form-button-area">
                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  /><input type="submit" name="send" value="Save" class="submit"  />
                </div>
            </form>
            <div class="demo_jui">
                <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                    <thead>
                        <tr>
                            <th>ID</th><th>Floor</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                        </tr>
                    </thead>
                    <?php
                    echo '<tbody>';
                    $count = 0;
                    foreach ($this->flrLists as $key => $value) {
                        $count++;
                        ?>
                        <tr>
                                <?php
                                echo '<td>' . $value['flr_id'] . '</td>';
                                echo '<td width="30%">' . $value['flr_name'] . '</td>';
                                echo '<td>' . $value['reg_date'] . '</td>';
                                echo '<td>' . $value['reg_by'] . '</td>';
                                echo '<td>';
                                    if (Session::get('Update') == true && Session::get('Delete') == true){
                                        echo '<a href="' . URL . 'floor/edit/' . $value['flr_id'] . '">Edit</a> | ';}
                                    else if (Session::get('Update') == true && Session::get('Delete') == false){
                                        echo '<a href="' . URL . 'floor/edit/' . $value['flr_id'] . '">Edit</a>';}   
                                    if (Session::get('Delete') == true){  
                                    echo '<a href=javascript:confirmDelete("' . URL . 'floor/delete/' . $value['flr_id'] . '")>Delete</a>';}
                                echo '</td></tr>';
                            }
                            echo '</tbody>';
                            ?>
                </table>
            </div>
        </div>
    </div>
