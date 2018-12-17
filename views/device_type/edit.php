<div class="wrapper_content">
    <div id="content">
        <h1>Edit Device Type</h1>
        <form action="<?php echo URL; ?>device_type/editSave/<?php echo $this->dtId[0]['dt_id']?>" method="post" id="frm_dt">        
            <div id="form-area">
                <?php
                if (Session::get('dtSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('dtSuccess', false);
                } else if (Session::get('dtError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('dtError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Device Type Name :  </label><input type="text" class="update" name="dt_name" id="dt_name" value="<?php echo $this->dtId[0]['dt_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
                var query = $('#frm_dt').serialize();
                var url = 'device_type/editSave/<?php echo $this->dirId[0]['dt_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>