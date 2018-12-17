<div class="wrapper_content">
    <div id="content">
        <h1>Edit Device Model</h1>
        <form action="<?php echo URL; ?>device_models/editSave/<?php echo $this->dmdId[0]['dm_id'] ?>" method="post" id="frm_dm">
            <div id="form-area">
                <?php
                if (Session::get('dmSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('dmSuccess', false);
                } else if (Session::get('dmError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('dmError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>
                <label class="label" >Device Type : </label> 
                <select class="select_medium" name="device_type" id="device_type">
                    <option value="">Select Device Type</option>
                    <?php
                    foreach ($this->dtLists as $key => $value) {
                        if ($this->dmdId[0]['dt_id'] == $value['dt_id']) {
                            echo '<option value="' . $value['dt_id'] . '" selected>' . $value['dt_name'] . '</option>';
                        } else {
                            echo '<option value="' . $value['dt_id'] . '">' . $value['dt_name'] . '</option>';
                        }
                    }
                    ?>
                </select><br />
                <label class="label" >Device Brand : </label> 
                <select class="select_medium" name="device_brand" id="device_brand">
                    <option value="">Select Device Brand</option>
                    <?php
                    foreach ($this->dbLists as $key => $value) {
                        if ($this->dmdId[0]['db_id'] == $value['db_id']) {
                            echo '<option value="' . $value['db_id'] . '" selected>' . $value['db_name'] . '</option>';
                        } else {
                            echo '<option value="' . $value['db_id'] . '">' . $value['db_name'] . '</option>';
                        }
                    }
                    ?>
                </select><br />
                <label class="label" >Device Model :  </label><input type="text" class="update" name="dm_name" id="dm_name" value="<?php echo $this->dmdId[0]['dm_name'] ?>"></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">
            function save(){
            var query = $('#frm_dm').serialize();
            var url = 'device_models/editSave/<?php echo $this->dmdId[0]['dm_id'] ?>';
            $.post(url, query, function (response) {
            alert (response);
            });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>