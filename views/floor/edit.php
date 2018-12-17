<div class="wrapper_content">
    <div id="content">
        <h1>Edit Floor</h1>
        <form action="<?php echo URL; ?>floor/editSave/<?php echo $this->flrId[0]['flr_id']?>" method="post" id="frm_flr">        
            <div id="form-area">
                <?php
                if (Session::get('flrSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('flrSuccess', false);
                } else if (Session::get('flrError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('flrError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Floor Name :  </label><input type="text" class="update" name="flr_name" id="flr_name" value="<?php echo $this->flrId[0]['flr_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
                var query = $('#frm_flr').serialize();
                var url = 'floor/editSave/<?php echo $this->flrId[0]['flr_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>
