    <div class="wrapper_content">
        <div id="content">
            <h1>New Directorate</h1>
            <form action="<?php echo URL; ?>directorate/insertDir" method="post" id="frm_dir">        
                <div id="form-area">
                    <?php
                    if (Session::get('dirSuccess') == true && Session::get('pdoError') == false) {
                        echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                        Session::set('dirSuccess', false);
                    } else if (Session::get('dirError') == true) {
                        echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                        Session::set('dirError', false);
                    } else {
                        echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                        Session::remove('pdoError');
                         Session::set('dirSuccess', false);
                    }
                    ?>

                    <label class="label" >Directorate Name :  </label><input type="text" class="text" name="dir_name" id="dir_name"></br>
                </div>
                <div id="form-button-area">
                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  /><input type="submit" name="send" value="Save" class="submit"  />
                </div>
            </form>
            <div class="demo_jui">
                <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                    <thead>
                        <tr>
                            <th>ID</th><th>Directorate</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                        </tr>
                    </thead>
                    <?php
                    echo '<tbody>';
                    $count = 0;
                    foreach ($this->dirLists as $key => $value) {
                        $count++;
                        ?>
                        <tr>
                                <?php
                                echo '<td>' . $value['dir_id'] . '</td>';
                                echo '<td width="30%">' . $value['dir_name'] . '</td>';
                                echo '<td>' . $value['reg_date'] . '</td>';
                                echo '<td>' . $value['reg_by'] . '</td>';
                                echo '<td>';
                                    if (Session::get('Update') == true && Session::get('Delete') == true){
                                        echo '<a href="' . URL . 'directorate/edit/' . $value['dir_id'] . '">Edit</a> | ';}
                                    else if (Session::get('Update') == true && Session::get('Delete') == false){
                                        echo '<a href="' . URL . 'directorate/edit/' . $value['dir_id'] . '">Edit</a>';}   
                                    if (Session::get('Delete') == true){  
                                    echo '<a href=javascript:confirmDelete("' . URL . 'directorate/delete/' . $value['dir_id'] . '")>Delete</a>';}
                                echo '</td></tr>';
                            }
                            echo '</tbody>';
                            ?>
                </table>
            </div>
        </div>
    </div>