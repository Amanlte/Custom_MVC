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
        <h1>Edit Sub Menu</h1>
        <form action="<?php echo URL; ?>sub_menu/editSave/<?php echo $this->smId[0]['sub_menu_id'] ?>" method="post" id="frm_sm">        
            <div id="form-area">
                <?php
                if (Session::get('smSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('smSuccess', false);
                } else if (Session::get('smError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('smError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Sub Menu Name :  </label><input type="text" class="update" name="sub_menu_name" id="sub_menu_name" value="<?php echo $this->smId[0]['sub_menu_name'] ?>"><br />
                <label class="label" >Permissions With Pages : </label>
                <div  id="form-area-right">
                    <table>
                        <tr>
                            <td>Selected</td><td>&nbsp;
                            </td>
                        </tr>
                        <?php
                        $all_ = $this->smId[0]['functionalities_id'];
                        $all = explode(',', $all_);
                        echo '<tr><td><select id="selected_one" name="selected_one[]" multiple class="multi_select">';
                        foreach ($this->funcLists as $key => $value1) {
                            foreach ($all as $eachPage) {
                                if ($eachPage == $value1['func_id']) {
//                                    echo "<tr><td>{$value1['func_name']}</td><td><input type='checkbox' class='checkbox2' name='funcs[]' id='funcs' value='{func_id}' checked /></td></tr>";
                                    echo "<option value='{$value1['func_id']}'>{$value1['func_name']}</option>";
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
                foreach ($this->smLists as $key => $value1) {
                    $all_sub = $value1['functionalities_id'];
                    $all_db = explode(',', $all_sub);
                    foreach ($all_db as $key => $eachSubMenuName) {
                        array_push($subMenus, $eachSubMenuName);
                    }
                }
                foreach ($this->funcLists as $key => $value) {
                    $all_sub = $value['func_id'];
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
                        <!--<tr><td><label id="ch">Select All</label></td><td><input type="checkbox" id="selecctall" /></td></tr>-->
                        <?php
                        echo '<tr><td><div class="multi_select_left"><select id="select_it" name="select_it[]" multiple class="multi_select">';
                        foreach ($this->funcLists as $key => $value) {
                            foreach ($output as $fname) {
                                if ($fname == $value['func_id']) {
                                    echo "<option value='{$value['func_id']}'>{$value['func_name']}</option>";
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
    </div>
</div>