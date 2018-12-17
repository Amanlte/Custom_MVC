<div class="wrapper_content">
    <div id="content">
        <?php
        $data['user_team'] = Session::get('user_team');
        ?>
        <h1>New Case</h1>


        <form action="<?php echo URL; ?>cases/insertCas"  method="post" id="frm_cas">
            <div id="form-area">
                <?php
                if (Session::get('casSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('casSuccess', false);
                } else if (Session::get('casError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the name provided!</p><br />';
                    Session::set('casError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('casSuccess', false);
                }
                ?>
                <div id="form-area-left">
                    <label class="label" >Case Id :  </label><input type="text" class="text" name="case_id" readonly id="case_id" value="<?php
                    if (Session::get('casAuto') == true) {
                        if ($data['user_team'] == 1) {
                            echo 'CBSSM001';
                            Session::set('casAuto', FALSE);
                        } else if ($data['user_team'] == 2) {
                            echo 'EATS001';
                            Session::set('casAuto', FALSE);
                        } else if ($data['user_team'] == 3) {
                            echo 'ECRB001';
                            Session::set('casAuto', FALSE);
                        } else if ($data['user_team'] == 4) {
                            echo 'ESM001';
                            Session::set('casAuto', FALSE);
                        } else if ($data['user_team'] == 5) {
                            echo 'ITPR001';
                            Session::set('casAuto', FALSE);
                        } else if ($data['user_team'] == 6) {
                            echo 'KM001';
                            Session::set('casAuto', FALSE);
                        } else if ($data['user_team'] == 7) {
                            echo 'NIM001';
                            Session::set('casAuto', FALSE);
                        } else if ($data['user_team'] == 8) {
                            echo 'NSA001';
                            Session::set('casAuto', FALSE);
                        } else if ($data['user_team'] == 9) {
                            echo 'USHD001';
                            Session::set('casAuto', FALSE);
                        }
                    } else {
                        foreach ($this->casAuto as $key => $value) {

                            $team_abrv = substr($value['case_id'], 0, -3); // this removes the last three characters from string
                            $newstring = substr($value['case_id'], -3);    // to select only the last three characters
                            $add = $newstring + 1;
                            echo $team_abrv . sprintf("%'.03d\n", $add);
                        }
                    }
                    ?>"><br />

                    <label class="label" >Case Type : </label>  
                    <select class="select_medium" name="case_type" id="case_type">
                        <option value=""> Select Case Type</option>
                        <option value="Hardware" >Hardware</option>
                        <option value="Software">Software</option>
                        <option value="Other">Other</option>
                    </select><br />
                    <label class="label" >Case Name :  </label><input type="text" class="text"name="case_name" id="case_name"></br> 
                    <label class="label" >Possible Cause(s) : <br /><span>[Use commas to separate different causes.]</span></label><textarea class="textarea"name="case_details" id="case_details"></textarea><br /> 
                </div>
                <div id="form-area-right">
                    <label class="label" >Solution Briefly : </label><input type="text" class="text" name="solution_name" id="solution_name"> </br> 
                    <label class="label" >Solution Details(Steps) :<br /><span>[Use commas to separate different steps.]</span></label><textarea class="textarea"name="solution_details"></textarea>  <br />                          
                </div>
                <div class="clear"></div>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last" /><input type="submit" name="send" value="Submit" class="submit"  />
            </div>
        </form>
        <div id="list-container">
            <h2>Registered Cases</h2>
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>ID</th><th>Type</th><th>Case Name</th><th>Possible Cause(s)</th><th>Solution Briefly</th><th>Solution Details (Steps)</th><th>Registered Date</th><th>Registered By</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->casLists as $key => $value) {
                    $count++;
                    ?>
                    <tr id="<?php echo $count; ?>" class="<?php
                    if ($count % 2 == 0) {
                        echo 'dark';
                    } else
                        echo 'light';
                    ?>">
                            <?php
                            $case_details = explode(',', $value['case_details']);
                            $solution_details = explode(',', $value['case_solution_details']);

                            echo '<td>' . $value['case_id'] . '</td>';
                            echo '<td>' . $value['case_type'] . '</td>';
                            echo '<td>' . $value['case_name'] . '</td>';
                            echo '<td><ol class="list_normal">';

                            foreach ($case_details AS $details) {
                                if (!empty($details)) {
                                    echo '<li class="list_normal">' . $details . '</li>';
                                }
                            }
                            echo '</ol></td>';
                            echo '<td>' . $value['case_solution_name'] . '</td>';
                            echo '<td><ol class="list_normal">';
                            foreach ($solution_details AS $details) {
                                if (!empty($details)) {
                                    echo '<li>' . $details . '</li>';
                                }
                            }
                            echo '</ol>';
                            //<!-- To show/hide content -->
                            foreach ($this->solLists as $solName) {
                                if ($value['case_id'] == $solName['case_id']) {
                                    echo '<a href="javascript:ReverseDisplay(\'' . $solName['case_id'] . '\')">more...</a>';
                                    echo '<div id="' . $solName['case_id'] . '" style="display:none;">';
                                    echo '<B><I>Additional solution: </br></I></B><ol class="list_normal">';
                                    $additionalSolution = $solName['additional_solution'];
                                    $detailsAdditional = explode(',', $additionalSolution);
                                    foreach ($detailsAdditional as $allSolution) {
                                        echo '<li>' . $allSolution . '</li>';
                                    }
                                    echo '</ol><B><I>Added by:</I></B>' . $solName['addedBY'] . '</br><B><I>On:</I></B>' . $solName['sol_date'] . '</br>';

                                    echo '</div>';
                                }
                            }



                            echo '</td>';
                            echo '<td>' . $value['case_reg_date'] . '</td>';
                            echo '<td>' . $value['case_reg_by'] . '</td>';
                            echo '<td>';
                            if (Session::get('Update') == true && Session::get('Delete') == true) {
                                echo '<a href="' . URL . 'cases/edit/' . $value['case_id'] . '">Edit</a> | ';
                            } else if (Session::get('Update') == true && Session::get('Delete') == false) {
                                echo '<a href="' . URL . 'cases/edit/' . $value['case_id'] . '">Edit</a>';
                            }

                            if (Session::get('Delete') == true) {
                                echo '<a href=javascript:confirmDelete("' . URL . 'cases/delete/' . $value['case_id'] . '") id="del">Delete</a>';
                            }
                            echo '</td></tr>';
                        }
                        echo '</tbody>';
                        ?>
            </table>
        </div>
    </div>
</div>