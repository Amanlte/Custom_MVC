<div class="wrapper_content">
    <div id="content">
        <h1>All Messages</h1>
        <form action="<?php echo URL; ?>menu/insertMenu" method="post" id="frm_mm">        
            <div id="form-area">
                <?php
                if (Session::get('mmSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('mmSuccess', false);
                } else if (Session::get('mmError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                    Session::set('mmError', false);
                } else if (Session::get('noOfMainMenu') == true) {
                    echo '<p class="msg_error">Msg: You exced the maximum input for main menu. You could create a sub menu!</p><br />';
                    Session::set('noOfMainMenu', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('mmSuccess', false);
                }
                ?>

                <label class="label" >Main Menu Name :  </label><input type="text" class="text" name="main_menu_name" id="main_menu_name"></br>
                <label class="label" >Sub Menus : </label>
                <?php
                echo '<table class="this">';
                echo '<tr><td><label id="ch">Select All</label></td><td><input type="checkbox" id="selecctall" /></td></tr>';
                $menu = array();
                $menu_frm_db = array();

                foreach ($this->submenuname as $key => $value1) {
                    $all_menus = $value1['sub_menu_id'];
                    $all_ = explode(',', $all_menus);
                    foreach ($all_ as $key => $eachMenuName) {
                        array_push($menu, $eachMenuName);
                        $all_menu_name = $value1['sub_menu_name'];
                    }
                }
                foreach ($this->mmLists as $key => $value2) {
                    $all_menu = $value2['sub_menu_id'];
                    $all = explode(',', $all_menu);

                    foreach ($all as $key => $eachDbMenuName) {
                        array_push($menu_frm_db, $eachDbMenuName);
                    }
                }

                $menu = array_unique($menu);
                $menu_frm_db = array_unique($menu_frm_db);
                $output = array_diff($menu, $menu_frm_db);
                foreach ($output as $subname) {
                    foreach ($this->submenuname as $key => $value3) {
                        if ($subname == $value3['sub_menu_id']) {
                            echo'<tr class="">'
                            . '<td class="this">' . $value3['sub_menu_name'] . '</td>'
                            . '<td class="this"><input type="checkbox" class="checkbox checkbox1"  name="sub_menu_id[]" id="sub_menu_id" value="' . $value3['sub_menu_id'] . '" /></td></tr>';
                        }
                    }
                }

//                foreach ($this->submenuname as $key => $value) {
//                    echo'<tr class="">'
//                    . '<td class="this">' . $value['sub_menu_name'] . '</td>'
//                    . '<tr><td class="this"><input type="checkbox" class="checkbox checkbox1"  name="sub_menu_id[]" id="sub_menu_id" value="' . $value['sub_menu_id'] . '" /></td></tr>'
//                    . '</tr>';
//                }
                echo '</table>';
                ?>
                <br /> 
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  /><input type="submit" name="send" value="Save" class="submit"  />
            </div>

        </form>
        <div class="demo_jui">
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>ID</th><th>Main Menu</th><th>Sub Menu(s)</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->mmLists as $key => $value) {
                    $count++;
                    ?>
                    <tr>
                        <?php
                        echo '<td>' . $value['menu_id'] . '</td>';
                        echo '<td width="30%">' . $value['main_menu_name'] . '</td>';
                        echo '<td width="30%">';
                        $all_ = $value['sub_menu_id'];
                        $all_ = explode(',', $all_);

                        foreach ($all_ as $all) {
                            foreach ($this->submenuname as $key => $sn) {
                                if ($all == $sn['sub_menu_id'])
                                    echo $sn['sub_menu_name'] . "</br>";
                            }
                        }
                        echo '</td>';
                        echo '<td>' . $value['reg_date'] . '</td>';
                        echo '<td>' . $value['reg_by'] . '</td>';
                        echo '<td>';
                        if (Session::get('Update') == true && Session::get('Delete') == true) {
                            echo '<a href="' . URL . 'menu/edit/' . $value['menu_id'] . '">Edit</a> | ';
                        } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                            echo '<a href="' . URL . 'menu/edit/' . $value['menu_id'] . '">Edit</a>';
                        }
                        if (Session::get('Delete') == true) {
                            echo '<a href=javascript:confirmDelete("' . URL . 'menu/delete/' . $value['menu_id'] . '")>Delete</a>';
                        }
                        echo '</td></tr>';
                    }
                    echo '</tbody>';
                    ?>


            </table>
        </div>
    </div>
</div>