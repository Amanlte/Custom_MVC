<div class="wrapper_content">
    <div id="content">
        <h1>Edit Role</h1>
        <form action="<?php echo URL; ?>roles/editSave/<?php echo $this->roleId[0]['role_id']?>" method="post" id="frm_rol">        
            <div id="form-area">
                <?php
                if (Session::get('rolSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('rolSuccess', false);
                } else if (Session::get('rolError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('rolError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Role Name :  </label><input type="text" class="update" name="role_name" id="role_name" value="<?php echo $this->roleId[0]['role_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
                var query = $('#frm_rol').serialize();
                var url = 'roles/editSave/<?php echo $this->roleId[0]['role_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>