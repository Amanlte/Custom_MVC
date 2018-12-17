<div class="wrapper_content">
    <div id="content">
        <h1>Functionality Page Relationship</h1>
        <form action="<?php echo URL; ?>page/insertPage" method="post" id="frm_page">
            <div id="form-area">
                <?php
                if (Session::get('fpSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfully  saved!</p><br />';
                    Session::set('fpSuccess', false);
                    echo Session::get('me');
                } else if (Session::get('fpError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the functionality provided!</p><br />';
                    Session::set('fpError', false);
                    echo Session::get('me');
                    //echo 'pspg'.Session::get('pstpages');
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('fpSuccess', false);
                }
                ?>
                <label class="label" >Functionality Name : </label>  <select class="select_medium" name="func_id" id="func_id">
                    <option value="">-- Select --</option>
                    <?php
                    foreach ($this->funcId as $key => $value) {
                        echo '<option value="' . $value['func_id'] . '">' . $value['func_name'] . '</option>';
                    }
                    ?>
                </select><br />
                <label class="label" >Pages : </label>
                <?php
                // open the directory
                $dhandle = opendir('./views');
                // define an array to hold the files
                $files = array();

                if ($dhandle) {
                    // loop through all of the files
                    while (false !== ($fname = readdir($dhandle))) {
                        // if the file is not this file, and does not start with a '.' or '..',
                        // then store it for later display
                        if (($fname != '.') && ($fname != '..') && $fname != glob(".*") && ($fname != 'footer.php') && ($fname != 'login') && ($fname != '.DS_Store') &&
                                ($fname != 'header.php') && ($fname != '._.DS_Store') &&
                                ($fname != 'error') && ($fname != 'help') && ($fname != 'db.php') &&
                                ($fname != basename($_SERVER['PHP_SELF']))) {
                            // store the filename
                            $files[] = (is_dir("./$fname")) ? "{$fname}" : $fname;
                        }
                    }
                    // close the directory
                    closedir($dhandle);
                }

                //echo "<select name=\"file\" multiple='multiple'>\n";
                echo "";
                // Now loop through the files, echoing out a new select option for each one
                $n = '';
                echo '<table class="this">';
                echo '<tr><td><label id="ch">Select All</label></td><td><input type="checkbox" id="selecctall" /></td></tr>';
                $pages = array();
                foreach ($this->pageLists as $key => $value1) {
                    $all_pages = $value1['page'];
                    $all_db = explode(',', $all_pages);

                    foreach ($all_db as $key => $eachPageName) {
                        array_push($pages, $eachPageName);
                    }
                }
                $pages = array_unique($pages);
                $output = array_diff($files,$pages);
                foreach ($output as $fname) {
                    echo "<tr><td>{$fname}</td><td><input type='checkbox' class='checkbox1' name='page[]' value='$fname'></input> </td></tr>";
                       
                }
                echo '</table>';
                ?>

                <br />                               
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"  />&nbsp;&nbsp;<input type="submit" name="send" value="Submit" class="submit"  />
            </div>
        </form>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>	

        <div id="list-container">			
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>ID</th><th>Functionality</th><th>Pages</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->pageLists as $key => $value) {
                    $count++;
                    ?>
                    <tr id="<?php echo $count; ?>" class="<?php
                    if ($count % 2 == 0) {
                        echo 'dark';
                    } else
                        echo 'light';
                    ?>">
                            <?php
                            echo '<td>' . $value['page_id'] . '</td>';
                            echo '<td>';
                            foreach ($this->funcLists as $funcName) {
                                if ($value['fun_id'] == $funcName['func_id'])
                                    echo $funcName['func_name'];
                            }
                            echo '</td>';
                            $all_ = $value['page'];
                            $all_ = explode(',', $all_);
                            echo '<td>';

                            foreach ($all_ as $all) {
                                Session::set('all', $all);
                                echo $all . '</br>';
                            }
                            echo '</td>';
                            //echo '<td width="30%">' . $value['func_name'] . '</td>';
                            echo '<td>' . $value['reg_date'] . '</td>';
                            echo '<td>' . $value['reg_by'] . '</td>';
                            echo '<td>';
                            if (Session::get('Update') == true && Session::get('Delete') == true) {
                                echo '<a href="' . URL . 'page/edit/' . $value['page_id'] . '">Edit</a> |';
                            } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                                echo '<a href="' . URL . 'page/edit/' . $value['page_id'] . '">Edit</a>';
                            }
                            if (Session::get('Delete') == true) {
                                echo'<a href=javascript:confirmDelete("' . URL . 'page/delete/' . $value['page_id'] . '")>Delete</a>';
                            }
                            echo '</td></tr>';
                        }
                        echo '</tbody>';
                        ?>
            </table>
        </div>
    </div>
</div>