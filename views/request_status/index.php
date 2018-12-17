<div class="wrapper_content">
    <div id="content">
        <h1>Recent Request</h1>
        <div id="form-area">
            <div id="form-area-left">
                <h2>Your Request Details</h2>

                <?php
                foreach ($this->recRequest as $key => $value) {
                    ?>

                    <?php
                    echo '<td>' . $value['req_details'] . '</td>';
                }
                echo '</tbody>';
                ?>



            </div>
            <div id="form-area-right">
                <h2>Request Status</h2>
                <?php
                foreach ($this->recRequest as $key => $value) {
                    ?>

                    <?php
                    if (empty($value['status'])) {
                        echo '<td><h2>Waiting...<h2></td>';
                    } else {
                        echo '<td><h2>' . $value['status'] . '</h2></td>';
                    }
                }
                echo '</tbody>';
                ?>

            </div>
            <div class="clear"></div>
        </div>
        <br /><br /><br /><br />
        <h2>Your Other Requests </h2>
        <div id="list-container">
            <div id="list-container">
                <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                    <thead>
                        <tr>
                            <th>Request</th><th>Request Detail</th><th>Request Time</th><th>Status</th>
                        </tr>
                    </thead>
                    <?php
                    echo '<tbody>';
                    $count = 0;
                    foreach ($this->reqLists as $key => $value) {
                        $count++;
                        ?>
                        <tr id="<?php echo $count; ?>" class="<?php
                    if ($count % 2 == 0) {
                        echo 'dark';
                    } else
                        echo 'light';
                        ?>">
                            <?php
                                if (empty($value['caseName'])) {
                                    echo '<td>Other</td>';
                                } else {
                                    echo '<td>' . $value['caseName'] . '</td>';
                                }
                                echo '<td>' . $value['req_details'] . '</td>'
                                . '<td>' . $value['req_time'] . '</td>';
                                if (empty($value['status'])) {
                                    echo '<td>Waiting...</td>';
                                } else {
                                    echo '<td>' . $value['status'] . '</td>';
                                }
                            }
                            echo '</tbody>';
                            ?>
                </table>
            </div>
        </div>
    </div>
</div>