<div class="wrapper_content">
    <div id="content">
        <h1>New Sub Menu</h1>
        <form action="<?php echo URL; ?>sub_menu/insertSubMenu" method="post" id="frm_sm">        
            <div id="form-area">
                <?php
                if (Session::get('smSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('smSuccess', false);
                } else if (Session::get('smError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                    Session::set('smError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('mmSuccess', false);
                }
                ?>

                <label class="label" >Sub Menu Name :  </label><input type="text" class="text" name="sub_menu_name" id="sub_menu_name"><br />
                <label class="label" >Permissions With Pages : </label>
                <?php
                echo '<table class="this">';
                echo '<tr><td><label id="ch">Select All</lable></td><td><input type="checkbox" id="selecctall" /></td></tr>';
                //echo '<tr><td>&nbsp</td><td>&nbsp</td></tr>';
                //foreach ($this->pageLists as $key => $value) {
                $func = array();
                $func_frm_db = array();

                foreach ($this->funcLists as $key => $value1) {
                    $all_funcs = $value1['func_id'];
                    $all_ = explode(',', $all_funcs);

                    foreach ($all_ as $key => $eachFuncName) {
                        array_push($func, $eachFuncName);
                    }
                    //print_r($all_);
                }
                foreach ($this->smLists as $key => $value2) {
                    $all_func = $value2['functionalities_id'];
                    $all_db = explode(',', $all_func);

                    foreach ($all_db as $key => $eachDbFuncName) {
                        array_push($func_frm_db, $eachDbFuncName);
                    }
                }
                $func = array_unique($func);
                $func_frm_db = array_unique($func_frm_db);
                $output = array_diff($func, $func_frm_db);

                foreach ($output as $fname) {
                    foreach ($this->funcLists as $key => $value1) {
                        if ($fname == $value1['func_id']) {
                            echo '<tr><td>' . $value1['func_name'] . '</td><td class="this"><input type="checkbox" class="checkbox checkbox1"  name="func_id[]" id="func_id" value="' . $value1['func_id'] . '" /></td></tr>';
                        }
                    }
                }
                echo '</table>';
                ?>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  /><input type="submit" name="send" value="Save" class="submit"  />
            </div>
        </form>
        <div class="demo_jui">
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>ID</th><th>Sub Menu</th><th>Permissions</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->smLists as $key => $value) {
                    $count++;
                    ?>
                    <tr>
                        <?php
                        echo '<td>' . $value['sub_menu_id'] . '</td>';
                        echo '<td width="30%">' . $value['sub_menu_name'] . '</td>';
                        echo '<td>';
                        $pages = $value['functionalities_id'];
                        $pages = explode(',', $pages);
                        foreach ($pages as $page) {
                            foreach ($this->funcLists as $func) {
                                if ($page == $func['func_id'])
                                    echo $func['func_name'] . '<br />';
                            }
                        }
                        echo '</td>';
                        echo '<td>' . $value['reg_date'] . '</td>';
                        echo '<td>' . $value['reg_by'] . '</td>';
                        echo '<td>';
                        if (Session::get('Update') == true && Session::get('Delete') == true) {
                            echo '<a href="' . URL . 'sub_menu/edit/' . $value['sub_menu_id'] . '">Edit</a> | ';
                        } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                            echo '<a href="' . URL . 'sub_menu/edit/' . $value['sub_menu_id'] . '">Edit</a>';
                        }
                        if (Session::get('Delete') == true) {
                            echo '<a href=javascript:confirmDelete("' . URL . 'sub_menu/delete/' . $value['sub_menu_id'] . '")>Delete</a>';
                        }
                        echo '</td></tr>';
                    }
                    echo '</tbody>';
                    ?>
            </table>
        </div>
    </div>
</div>