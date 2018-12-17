<div class="wrapper_content">
    <div id="content">
        <h1>Edit Cases</h1>
        <form action="<?php echo URL; ?>cases/editSave/<?php echo $this->casId[0]['case_id'] ?>" method="post" id="frm_cas">        
            <div id="form-area">
                <?php
                if (Session::get('casSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('casSuccess', false);
                } else if (Session::get('casError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('casError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Case Name :  </label><input type="text" class="text" name="case_name" id="case_name" value="<?php echo $this->casId[0]['case_name'] ?>"></br>
                <label class="label" >Solution Name :  </label><input type="text" class="text" name="solution_name" id="solution_name" value="<?php echo $this->casId[0]['case_solution_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">
            function save(){
            var query = $('#frm_cas').serialize();
            var url = 'cases/editSave/<?php echo $this->casId[0]['case_id'] ?>';
            $.post(url, query, function (response) {
            alert (response);
            });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>
</div>