<div class="wrapper_content">
    <div id="content">
        <h1>Edit Device Brand</h1>
        <form action="<?php echo URL; ?>device_brand/editSave/<?php echo $this->dbrId[0]['db_id']?>" method="post" id="frm_db">        
            <div id="form-area">
                <?php
                if (Session::get('dbSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('dbSuccess', false);
                } else if (Session::get('dbError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('dbError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>
                    <label class="label" >Device Type : </label> <select class="select_medium" name="device_type" id="device_type">
                            <option value="">Select Device Type</option>
                            <?php
                                foreach ($this->dtLists as $key => $value) {
                                    if($this->dbrId[0]['dt_id'] == $value['dt_id']) {
                                        echo '<option value="'.$value['dt_id'].'" selected>'.$value['dt_name'].'</option>';
                                    } else {
                                        echo '<option value="'.$value['dt_id'].'">'.$value['dt_name'].'</option>';
                                    }
                                }
                            ?>
                        </select><br />
                <label class="label" >Device Brand Name :  </label><input type="text" class="update" name="db_name" id="db_name" value="<?php echo $this->dbrId[0]['db_name'] ?>"></br>
              </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
                var query = $('#frm_db').serialize();
                var url = 'device_brand/editSave/<?php echo $this->dbrId[0]['db_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>