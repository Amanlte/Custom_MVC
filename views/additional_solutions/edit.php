<div class="wrapper_content">
    <div id="content">
        <h1>Edit Solutions</h1>
        <form action="<?php echo URL; ?>additional_solutions/editSave/<?php echo $this->solId[0]['sol_id'] ?>" method="post" id="frm_sol">        
            <div id="form-area">
                <?php
                if (Session::get('solSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('solSuccess', false);
                } else if (Session::get('solError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('solError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Additional Solution :  </label><textarea class="textarea" name="additional_solution" id="additional_solution"><?php echo $this->solId[0]['additional_solution'] ?></textarea></br>
                <!--<label class="label" >Solution Status :  </label><input type="text" class="text" name="request_status" id="request_status" value="<?php echo $this->solId[0]['sol_status'] ?>"></br>-->
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
            var query = $('#frm_dir').serialize();
            var url = 'directorate/editSave/<?php echo $this->solId[0]['sol_id'] ?>';
            $.post(url, query, function (response) {
            alert (response);
            });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>