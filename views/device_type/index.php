    <div class="wrapper_content">
        <div id="content">
            <h1>Device Type</h1>
            <form action="<?php echo URL; ?>device_type/insertDt" method="post" id="frm_dt">        
                <div id="form-area">
                    <?php
                    if (Session::get('dtSuccess') == true && Session::get('pdoError') == false) {
                        echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                        Session::set('dtSuccess', false);
                    } else if (Session::get('dtError') == true) {
                        echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                        Session::set('dtError', false);
                    } else {
                        echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                        Session::remove('pdoError');
                        Session::set('dtSuccess', false);
                    }
                    ?>

                    <label class="label" >Device Type :  </label><input type="text" class="text" name="dt_name" id="dt_name"></br>
                </div>
                <div id="form-button-area">
                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  /><input type="submit" name="send" value="Save" class="submit"  />
                </div>
            </form>
            <div id="list-container">
                 <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                    <thead>
                        <tr>
                            <th>ID</th><th>Device Type</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                        </tr>
                    </thead>
                    <?php
                    echo '<tbody>';
                    $count = 0;
                    foreach ($this->dtLists as $key => $value) {
                        $count++;
                        ?>
                        <tr id="<?php echo $count; ?>" class="<?php
                        if ($count % 2 == 0) {
                            echo 'dark';
                        } else
                            echo 'light';
                        ?>">
                                <?php
                                echo '<td>' . $value['dt_id'] . '</td>';
                                echo '<td width="30%">' . $value['dt_name'] . '</td>';
                                echo '<td>' . $value['dt_reg_date'] . '</td>';
                                echo '<td>' . $value['dt_reg_by'] . '</td>';
                                echo '<td>';
                                    if (Session::get('Update') == true && Session::get('Delete') == true){
                                         echo '<a href="' . URL . 'device_type/edit/' . $value['dt_id'] . '">Edit</a> | ';}
                                    else if (Session::get('Update') == true && Session::get('Delete') == false){  
                                         echo '<a href="' . URL . 'device_type/edit/' . $value['dt_id'] . '">Edit</a>'; } 
                                    if (Session::get('Delete') == true){      
                                    echo '<a href=javascript:confirmDelete("' . URL . 'device_type/delete/' . $value['dt_id'] . '")>Delete</a>';}
                                echo '</td></tr>';
                            }
                            echo '</tbody>';
                            ?>
                </table>
            </div>
        </div>
    </div>