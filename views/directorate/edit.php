<div class="wrapper_content">
    <div id="content">
        <h1>Edit Directorate</h1>
        <form action="<?php echo URL; ?>directorate/editSave/<?php echo $this->dirId[0]['dir_id']?>" method="post" id="frm_dir">        
            <div id="form-area">
                <?php
                if (Session::get('dirSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('dirSuccess', false);
                } else if (Session::get('dirError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('dirError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Directorate Name :  </label><input type="text" class="update" name="dir_name" id="dir_name" value="<?php echo $this->dirId[0]['dir_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
                var query = $('#frm_dir').serialize();
                var url = 'directorate/editSave/<?php echo $this->dirId[0]['dir_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>