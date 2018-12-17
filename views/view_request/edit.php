<div class="wrapper_content">
    <div id="content">
        <h1>Edit Role of 
            <?php
            foreach ($this->rfLists as $key => $role) {
                if ($this->rfId[0]['roleId'] == $role['role_id'])
                    echo "<span>".$role['role_name']."</span>";
            }
            ?></h1>
        <form action="<?php echo URL; ?>role_functionality/editSave/<?php echo $this->rfId[0]['rf_id'] ?>" method="post" id="frm_rof">        
            <div id="form-area">
                <?php
                if (Session::get('rfSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('rfSuccess', false);
                } else if (Session::get('rfError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('rfError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>
                <label class="label" >Select Functionalities:</label> </br></br>

                <?php
                foreach ($this->funcLists as $key => $value) {
                    echo '<input type="checkbox" class="checkbox" name="fun_name[]" id="fun_name" value="' . $value['func_id'] . '"';
                    foreach ($this->rfLists as $key => $v) {
                        $all_ = $v['fun_id'];
                        $all_ = explode(',', $all_);
                        foreach ($all_ as $all) {
                            $dbh = new PDO('mysql:host=localhost;dbname=nbe', 'root', '');
                            foreach ($dbh->query('SELECT * FROM role_functionality, functionality where rf_id = "' . $this->rfId[0]['rf_id'] . '" and func_id = "' . $all . '"') as $row) {
                                
                            }
                        }
                    }

                    $allf_ = $row['fun_id'];
                    $allf_ = explode(',', $allf_);
                    foreach ($allf_ as $allf) {
                        if ($value['func_id'] == $allf) {
                            echo 'checked="checked"';
                        } else {
                            echo '';
                        }
                    }
                    echo '>' . $value['func_name'] . '</input></br>';
                }
                ?>	

            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
            var query = $('#frm_rof').serialize();
            var url = 'role_functionality/editSave/<?php echo $this->rfId[0]['rf_id'] ?>';
            $.post(url, query, function (response) {
            alert (response);
            });
            }
        </script>

        <script>
            function displayVals() {
                var multipleValues = $("#multiple").val() || [];
                $("p").html("<b>Single:</b> " + singleValues +
                        " <b>Multiple:</b> " + multipleValues.join(", "));
            }
            $("select").change(displayVals);
            displayVals();
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>
</div>