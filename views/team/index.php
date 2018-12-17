<div class="wrapper_content">
    <div id="content">
        <h1>New Team</h1>
        <form action="<?php echo URL; ?>team/insertTea" method="post" id="frm_tea">
            <div id="form-area">
                <?php
                if (Session::get('teaSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('teaSuccess', false);
                }else if (Session::get('teaError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                    Session::set('teaError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('teaSuccess', false);
                }
                ?>
                <label class="label" >Directorate Name : </label>  <select class="select_medium" name="directorate_name" id="directorate_name">
                    <?php
                    echo '<option value="">-- Select --</option>';
                    foreach ($this->dirLists as $key => $value) {
                        echo '<option value="' . $value['dir_id'] . '">' . $value['dir_name'] . '</option>';
                    }
                    ?>
                </select><br />  

                <label class="label" >Team Name :  </label><input type="text" class="text" name="team_name" id="team_name"></br>
                <label class="label" >Team Leader :  </label><input type="text" class="text" name="team_leader" id="team_leader"><input type="text" id="current_leader" class="dis_input" readonly></label></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="send" value="Submit" class="submit"  />
            </div>
        </form>
         <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>	
        <script type="text/javascript">
            $(document).ready(function() {
                //autocomplete
                $("#team_leader").autocomplete({
                    source: "<?php echo URL; ?>team/selectUserId",
                    minLength: 1,
                    focus: function (event, ui) {
                        event.preventDefault();
                        $("#team_leader").val(ui.item.value);
                    },
                    select: function (event, ui) {
                        event.preventDefault();
                        $("#current_leader").val(ui.item.label);
                        $("#team_leader").val(ui.item.value);
                        return false;
                    }
                });
            });
        </script>
        <div id="list-container">
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>Team ID</th><th>Team Name</th><th>Directorate Name</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->teaLists as $key => $value) {
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
                                echo '<td>' . $value['team_id'] . '</td>';
                                echo '<td>' . $value['team_name'] . '</td>';
                                echo '<td>' . $value['dir_name'] . '</td>';
                                echo '<td>' . $value['team_reg_date'] . '</td>';
                                echo '<td>' . $value['team_reg_by'] . '</td>';
                                echo '<td>';
                                    if (Session::get('Update') == true && Session::get('Delete') == true){
                                        echo ' <a href="' . URL . 'team/edit/' . $value['team_id'] . '">Edit</a> | ';}
                                    else if (Session::get('Update') == true && Session::get('Delete') == false){
                                        echo ' <a href="' . URL . 'team/edit/' . $value['team_id'] . '">Edit</a>';}
                                    if (Session::get('Delete') == true){
                                    echo '<a href=javascript:confirmDelete("' . URL . 'team/delete/' . $value['team_id'] . '")>Delete</a>';}
                                echo '</td></tr>';
                                ?></div><?php
                    }
                    echo '</tbody>';
                    ?>
            </table>
            </table>
        </div>
    </div>
</div>  