<div class="wrapper_content">
    <div id="content">
        <h1>Edit Permission</h1>
        <form action="<?php echo URL; ?>functionalities/editSave/<?php echo $this->funcId[0]['func_id']?>" method="post" id="frm_fun">        
            <div id="form-area">
                <?php
                if (Session::get('funcSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('funcSuccess', false);
                } else if (Session::get('funcError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('funcError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Permission Name :  </label><input type="text" class="update" name="func_name" id="func_name" value="<?php echo $this->funcId[0]['func_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
                var query = $('#frm_fun').serialize();
                var url = 'functionalities/editSave/<?php echo $this->funcId[0]['func_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>