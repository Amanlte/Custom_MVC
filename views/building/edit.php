<div class="wrapper_content">
    <div id="content">
        <h1>Edit Building</h1>
        <form action="<?php echo URL; ?>building/editSave/<?php echo $this->buiId[0]['bui_id']?>" method="post" id="frm_bui">        
            <div id="form-area">
                <?php
                if (Session::get('buiSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('buiSuccess', false);
                } else if (Session::get('buiError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('buiError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Building Name :  </label><input type="text" class="update" name="bui_name" id="bui_name" value="<?php echo $this->buiId[0]['bui_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
                var query = $('#frm_bui').serialize();
                var url = 'building/editSave/<?php echo $this->buiId[0]['bui_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>