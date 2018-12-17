<div class="wrapper_content">
    <div id="content">
        <h1>Additional Solution(s) For Registered Cases</h1>
        <form action="<?php echo URL; ?>additional_solutions/insertSol" method="post" id="frm_sol">
            <div id="form-area">

                <?php
                if (Session::get('solSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Record Successfuly  saved!</p><br />';
                    Session::set('solSuccess', false);
                } else if (Session::get('solError') == true) {
                    echo '<p class="msg_error">Msg: Record exists with the provided case name, you can edit that additional solution to add more solution. </p><br />';
                    Session::set('solError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('solSuccess', false);
                }
                ?>
                <label class="label" >Select Case: </label>  
                <select class="select" name="case_id" id="case_id">
                    <option value=""> -- Select -- </option>
                    <?php
                    foreach ($this->casLists as $key => $value) {
                        echo '<option value="' . $value['case_id'] . '">' . $value['case_name'] . '</option>';
                    }
                    ?>
                </select><br />
                <label class="label" >Additional Solution :</label><textarea class="textarea" name="additional_solution" id="additional_solution"></textarea><br />

            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="send" value="Submit" class="submit"  />
            </div>
        </form>
        <div id="list-container">
            <h2>Additional Solution(s) Added by You</h2>
            <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                <thead>
                    <tr>
                        <th>Case</th><th>Additional Solution</th><th>Solution Date</th><th>#</th>
                    </tr>
                </thead>
                <?php
                echo '<tbody>';
                $count = 0;
                foreach ($this->solLists as $key => $value) {
                    ?><div class="pagedemo _current" style=""><?php
                        $count++;
                        ?>
                        <tr id="<?php echo $count; ?>" class="<?php
                        if ($count % 2 == 0) {
                            echo 'dark';
                        } else
                            echo 'light';
                        ?>">
                                <?php
                                 $solution_details = explode(',', $value['additional_solution']);
                                echo '<td>' . $value['caseName'] . '</td>';
                                echo '<td><ol class="list_normal">';
                                foreach ($solution_details AS $details) {
                                if (!empty($details)) {
                                    echo '<li>' . $details . '</li>';
                                }
                            }
                            echo '</ol></td>';
                                echo '<td>' . $value['sol_date'] . '</td>';
                                echo '<td>';
                                if (Session::get('Update') == true && Session::get('Delete') == true)
                                    echo '<a href="' . URL . 'additional_solutions/edit/' . $value['sol_id'] . '">Edit</a> |';
                                else if (Session::get('Update') == true && Session::get('Delete') == false)
                                    echo '<a href="' . URL . 'additional_solutions/edit/' . $value['sol_id'] . '">Edit</a>';

                                if (Session::get('Delete') == true)
                                    echo '<a href=javascript:confirmDelete("' . URL . 'additional_solutions/delete/' . $value['sol_id'] . '")>Delete</a>';
                                echo'</td>';
                                echo '</tr>';
                                ?></div><?php
                    }
                    echo '</tbody>';
                    ?>
            </table>
        </div>
    </div>
</div>