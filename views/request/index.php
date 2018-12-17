<div class="wrapper_content">
    <div id="content">

        <h1>Support Request </h1>
        <form action="<?php echo URL; ?>request/insertReq" method="post" id="frm_req">
            <div id="form-area">
                <?php
//                echo date('Y-m-d h:i:s');
                if (Session::get('reqSuccess') == true && Session::get('pdoError') == false) {
                    echo '<p class="success">Msg: Your request is successfully sent!</p><br />';
                    Session::set('reqSuccess', false);
                } else if (Session::get('reqError') == true) {
                    echo '<p class="msg_error">Msg: You have already sent this request. </p><br />';
                    Session::set('reqError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                    Session::set('reqSuccess', false);
                }
                ?>
                <label class="label" >Request Area : </label>  
                <select class="select_medium" name="request_area" id="request_area">
                    <option value=""> -- Select -- </option>
                    <?php
                    foreach ($this->teaLists as $key => $value) {
                        echo '<option value="' . $value['team_id'] . '">' . $value['team_name'] . '</option>';
                    }
                    ?>
                    <option value="other"> Other </option>
                </select><br />
                <label class="label" >Request Type : </label>  
                <select class="select_medium" name="request_type" id="request_type">
                    <option value=""> -- Select -- </option>
                </select><br />
                <label class="label" >Request Details : </label><textarea class="textarea" name="request_details" id="request_details"></textarea><br />

            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last" /><input type="submit" name="send" value="Send" class="submit"  />
            </div>
        </form>
        
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>	
        <script>
            $(document).ready(function () {
                $('#request_area').change(function () {
                    if ($(this).val() != '' && $(this).val() != 'other') {
                        $("#request_type").load("<?php echo URL; ?>request/selectCaseId", {dt: $(this).val()});
                        $("#request_type").prop('disabled', false);
                    } else {
                        $("#request_type").prop('disabled', true);
//                        $("#request_type").empty();
//                        $("#request_type").html('<option value="">-- Select --</option>');
                        $("#request_type").html('<option value="9" selected="selected"> Other </option>');
                    }
                });
            });
        </script>
        <style>
            .one_line{
                display: block;
            }

            #lightbox{
                display:none;
                position:absolute;
                z-index:1000;
                background: #777;
                opacity: 0.3;
                width:90%;
                height:59%;
                top: 27%;
            }
            #lightbox_area{
                position: fixed;
                top: 50%;
                left: 50%;
                /* bring your own prefixes */
                transform: translate(-50%, -50%);
                margin:50px auto;
                background:#fff;
                /*    width:auto;
                    height:auto;*/
                padding:10px;
                border:1px solid #444;
                border-radius:20px;
            }

        </style>
        <div id="lightbox">
            <div id="lightbox_area">
                <div id="viewdetail-ct">
                    <div id="viewdetail-header">
                        <h2>We want to hear from you</h2>
                        <!--<a class="modal_close" href="#"></a>-->
                    </div>
                    <form name="frm_act" id="frm_act" action="">
                        <div id="takeactioncontent">
                            <?php
                            echo 'Send us your feedback for <a href="javascript:ReverseDisplay(\'details\')"><font color=\'blue\'>your last request</font></a> that have been solved';
                            echo '<div id="details" style="display:none;">';
                            foreach ($this->recRequest as $key => $value) {

                                echo '</br><B><I>Your Request: </I></B>';
                                echo $value['userRequest'] . '</br>';

                                echo '</br><B><I>Your Request Details: </I></B>';
                                echo $value['req_details'] . '</br></br><B><I>Solved at:</I></B>' . $value['req_last_update'] . '</br>';
                            }
                            echo '</div>';
                            ?>
                            <div id="form-area">
                                <label class="label">How did you find the solution provided ? : </label> 
                              
                                <select id="feedback" class="select_long">
                                    <option value="1">Below Satisfactory </option>
                                    <option value="2">Satisfactory </option>
                                    <option value="3">Good</option>
                                    <option value="4">Very Good</option>
                                    <option value="5" selected>Excellent</option>
                                </select>
                                <br/><input type="hidden" name="rid" id="rid" value="<?php foreach ($this->recRequest as $key => $recent) { echo $recent['req_id']; } ?>"/>
                                <br><input type="hidden" name="satisfaction" id="satisfaction" value="<?php foreach ($this->recRequest as $key => $recent) { echo $recent['req_satisfaction_level']; } ?>"/>
                                <label class="label" >Tell us more on the support provided : </label><textarea class="textarea" id="detail_feedback" name="detail_feedback"></textarea><br />
                            </div>
                        </div>

                        <div id="viewdetail-footer">
                            <input type="submit" name="but_actions" value="Submit" class="submit"  />
                        </div>
                    </form>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                var frm = $('#frm_act');
                frm.submit(function (ev) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo URL; ?>request/sendFeedback',
                        data: {
                            rid: $('#rid').val(),
                            feedback: $('#feedback').val(),
                            detail_feedback: $('#detail_feedback').val()
                        },
                        success: function (data) {
                            $('#frm_act')[0].reset();
                            $('.modal_close').css({"display": "none"});
                            location.reload();
                        }
                    });
                    ev.preventDefault();
                });
                //Open dialog
                setInterval(function () {
                    if (($('#satisfaction').attr('value') == 0) && ($('#rid').attr('value') !== '')) {
//                        $('#takeaction').dialog('open');
                        $('#lightbox').fadeTo(1000, 1);
                        $("#wrapper").css({'text-shadow': '0px 0px 10px #000'});
                    }
                }, 1000);

            });
        </script>
    </div>
</div>