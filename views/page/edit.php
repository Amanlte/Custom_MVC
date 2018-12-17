<div class="wrapper_content">
    <div id="content">
        <h1>Edit Pages for the Functionality 
            <?php
            foreach ($this->funcLists as $key => $page) {
                if ($this->pgId[0]['fun_id'] == $page['func_id'])
                    echo "<span>" . $page['func_name'] . "</span>";
            }
            ?></h1>
        <form action="<?php echo URL; ?>page/editSave/<?php echo $this->pgId[0]['page_id'] ?>" method="post" id="frm_pf_edit">        
            <div id="form-area">
                <?php
                if (Session::get('fpSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('fpSuccess', false);
                } else if (Session::get('fpError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('fpError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>
                <label class="label" >Select Pages : </label>
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
                echo '<div  id="form-area-right">';
                echo '<table class="this">';
                echo '<tr><td>Selected</td><td>&nbsp;</td></tr>';
                echo '<tr><td><label id="ch2">Select All</label></td><td><input type="checkbox" id="selecctall2" /></td></tr>';
                $all_ = $this->pgId[0]['page'];
                $all = explode(',', $all_);
                foreach ($all as $eachPage) {
                    echo "<tr><td>{$eachPage}</td><td><input type='checkbox' class='checkbox2' name='page[]' value='$eachPage' checked /></td></tr>";
                    ;
                }
                echo '</table>';
                echo '</div>';

                $pages = array();
                foreach ($this->pageLists as $key => $value1) {
                    $all_pages = $value1['page'];
                    $all_db = explode(',', $all_pages);

                    foreach ($all_db as $key => $eachPageName) {
                        array_push($pages, $eachPageName);
                    }
                }
                $pages = array_unique($pages);
                $output = array_diff($files, $pages);
                echo '<div  id="form-area-left">';
                echo '<table class="this">';
                echo '<tr><td><label id="ch">Select All</label></td><td><input type="checkbox" id="selecctall" /></td></tr>';
                foreach ($output as $fname) {
                    echo "<tr><td>{$fname}</td><td><input type='checkbox' class='checkbox1' name='page[]' value='$fname'></input> </td></tr>";
                }
                echo '</table>';
                echo '</div>';
                ?>
                <br /> 
                <div class="clear"></div>        
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="javascript">
            function save(){
            var query = $('#frm_rof').serialize();
            var url = 'role_functionality/editSave/<?php echo $this->fpId[0]['fp_id'] ?>';
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
    </div>
</div>

<script>
    $(document).ready(function() {
                $('#selecctall2').click(function(event) {  //on click 
                    if (this.checked) { // check select status
                        $('.checkbox2').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"     
                            $('#ch2').text('Deselect All');
                        });
                    } else {
                        $('.checkbox2').each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"     
                            $('#ch2').text('Select All');   
                           
                        });
                    }
                });
                $('.checkbox2').click(function(event) {
                $('#selecctall2').attr('checked', false);
                    $('#ch2').text('Select All'); 
                });
            });
</script>