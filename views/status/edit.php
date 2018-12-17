<div class="wrapper_content">
    <div id="content">
        <h1>Edit Status</h1>
        <form action="<?php echo URL; ?>status/editSave/<?php echo $this->staId[0]['stat_id'] ?>" method="post" id="frm_sta">        
            <div id="form-area">
                <?php
                if (Session::get('staSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('staSuccess', false);
                } else if (Session::get('staError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('staError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Status Name :  </label><input type="text" class="text" name="status_name" id="status_name" value="<?php echo $this->staId[0]['stat_name'] ?>"><br />
                <label class="label" >Status For:  </label><select name="status_for" class="select_medium">
                    <option value="">--Select--</option>
                    <?php
                    foreach ($this->tableNames as $tblName) {
                        if ($this->staId[0]['stat_for'] == $tblName['TABLE_NAME']) {
                            echo '<option value="' . $tblName['TABLE_NAME'] . '" selected>' . ucwords(str_replace("_", " ", $tblName['TABLE_NAME'])) . '</option>';
                        } else {
                            echo '<option value="' . $tblName['TABLE_NAME'] . '">' . ucwords(str_replace("_", " ", $tblName['TABLE_NAME'])) . '</option>';
                        }
                    }
                    ?>
                </select><br />
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">
            function save(){
            var query = $('#frm_sta').serialize();
            var url = 'directorate/editSave/<?php echo $this->staId[0]['stat_id'] ?>';
            $.post(url, query, function (response) {
            alert (response);
            });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>