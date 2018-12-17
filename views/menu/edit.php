<div class="wrapper_content">
    <div id="content">
        <script>
//            $().ready(function() {
//                $('#add').click(function() {
//                    return !$('#select_it option:selected').remove().appendTo('#selected_one');
//                });
//                $('#remove').click(function() {
//                    return !$('#selected_one option:selected').remove().appendTo('#select_it');
//                });
//                //to select all values in the second multiselect before submit
//                $('form').submit(function() {
//                    $('#selected_one option').each(function(i) {
//                        $(this).attr("selected", "selected");
//                    });
//                });
//            });
        </script>
        <h1>Edit Main Menu</h1>
        <form action="<?php echo URL; ?>menu/editSave/<?php echo $this->mmId[0]['menu_id'] ?>" method="post" id="frm_mm">        
            <div id="form-area">
                <?php
                if (Session::get('mmSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('mmSuccess', false);
                } else if (Session::get('mmError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('mmError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Main Menu Name :  </label>
                <input type="text" class="update" name="main_menu_name" id="mm_name" value="<?php echo $this->mmId[0]['main_menu_name']; ?>"></br>
                <label class="label">Available Sub-menu(s):</label>
                <div  id="form-area-right">
                    <table>
                        <tr>
                            <td>Selected Sub-menu(s)</td><td>&nbsp;
                            </td>
                        </tr>

                        <?php
                        $all_ = $this->mmId[0]['sub_menu_id'];
                        $all = explode(',', $all_);
                        echo '<tr><td><select id="selected_one" name="selected_one[]" multiple class="multi_select">';
                        foreach ($this->submenuname as $key => $value1) {
                            foreach ($all as $eachPage) {
                                if ($eachPage == $value1['sub_menu_id']) {
//                                    echo "<tr><td>{$value1['sub_menu_name']}</td><td><input type='checkbox' class='checkbox2' name='submenu[]' id='submenu' value='$eachPage' checked /></td></tr>";
                                    echo "<option value='$eachPage'>{$value1['sub_menu_name']}</option>";
                                }
                            }
                        }

                        echo '</select> <a href="#" class="add_remove" id="remove">&lt;&lt; Remove</a> </td></tr>';
                        ?>

                    </table>
                </div>
                <?php
                $subMenus = array();
                $subMenusFrmDb = array();
                foreach ($this->mmLists as $key => $value1) {
                    $all_sub = $value1['sub_menu_id'];
                    $all_db = explode(',', $all_sub);

                    foreach ($all_db as $key => $eachSubMenuName) {
                        array_push($subMenus, $eachSubMenuName);
                    }
                }
                foreach ($this->submenuname as $key => $value) {
                    $all_sub = $value['sub_menu_id'];
                    $all_db = explode(',', $all_sub);

                    foreach ($all_db as $key => $eachSubMenuName) {
                        array_push($subMenusFrmDb, $eachSubMenuName);
                    }
                }
                $subMenus = array_unique($subMenus);
                $output = array_diff($subMenusFrmDb, $subMenus);
                ?>

                <div  id="form-area-left">
                    <table>
                        <?php
                        echo '<tr><td><div class="multi_select_left"><select id="select_it" name="select_it[]" multiple class="multi_select">';
                        foreach ($this->submenuname as $key => $value) {
                            foreach ($output as $fname) {
                                if ($fname == $value['sub_menu_id']) {
                                    echo "<option value='$fname'>{$value['sub_menu_name']}</option>";
//                                    echo "<tr><td>{$value['sub_menu_name']}</td><td><input type='checkbox' class='checkbox1' name='submenu[]' id='submenu' value='$fname'></input> </td></tr>";
                                }
                            }
                        }
                        echo '</select><a class="add_remove" href="#" id="add">Add &gt;&gt;</a> </div> </td></tr>';
                        ?>
                    </table>
                </div>
                <div class="clear"></div>  
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">

            function save(){
            var query = $('#frm_mm').serialize();
            var url = 'mainmenu/editSave/<?php echo $this->mmId[0]['menu_id'] ?>';
            $.post(url, query, function (response) {
            alert (response);
            });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>