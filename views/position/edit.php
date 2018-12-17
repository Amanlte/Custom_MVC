<div class="wrapper_content">
    <div id="content">
        <h1>Edit Position</h1>
        <form action="<?php echo URL; ?>position/editSave/<?php echo $this->posId[0]['pos_id']?>" method="post" id="frm_pos">        
            <div id="form-area">
                <?php
                if (Session::get('posSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('posSuccess', false);
                } else if (Session::get('posError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('posError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Position Name :  </label><input type="text" class="update" name="pos_name" id="pos_name" value="<?php echo $this->posId[0]['pos_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
                var query = $('#frm_pos').serialize();
                var url = 'position/editSave/<?php echo $this->posId[0]['pos_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>