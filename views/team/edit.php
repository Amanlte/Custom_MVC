<div class="wrapper_content">
    <div id="content">
        <h1>Edit Team</h1>
        <form action="<?php echo URL; ?>team/editSave/<?php echo $this->teaId[0]['team_id']?>" method="post" id="frm_tea">        
            <div id="form-area">
                <?php
                if (Session::get('teaSuccess') == true) {
                    echo '<p class="success">Msg: Record Successfuly  updated!</p><br />';
                    Session::set('teaSuccess', false);
                } else if (Session::get('teaError') == true) {
                    echo '<p class="msg_error">Msg: No change has been made!</p><br />';
                    Session::set('teaError', false);
                } else {
                    echo '<p class="pdo_error">' . Session::get('pdoError') . '</p><br />';
                    Session::remove('pdoError');
                }
                ?>

                <label class="label" >Team Name :  </label><input type="text" class="update" name="team_name" id="team_name" value="<?php echo $this->teaId[0]['team_name'] ?>"></br>
                <label class="label" >Team Leader :  </label><input type="text" class="update" name="team_leader" id="team_leader" value="<?php echo $this->teaId[0]['team_leader'] ?>"><input type="text" id="current_leader"></label></br>
            </div>
            <div id="form-button-area">
                <input type="reset" name="cancel" value="Back" onclick="javascript:history.back()" class="submit" id="button-last"  /><input type="submit" name="send" value="Update" class="submit" />
            </div>
        </form>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>	
            <script type="text/javascript">
                $(document).ready(function() {
                    //autocomplete
                    $("#team_leader").autocomplete({
                        source: "<?php echo URL; ?>team/selectUserId",
                        minLength: 1,
                        focus: function (event, ui) {
                        event.preventDefault();
                        $("#team_leader").val(ui.item.value);
                        },
                        select: function (event, ui) {
                            event.preventDefault();
                            $("#current_leader").val(ui.item.label);
                            $("#team_leader").val(ui.item.value);
                            return false;
                        }
                    });
                });
            </script>
        <script type="javascript">

            function save(){
                var query = $('#frm_tea').serialize();
                var url = 'directorate/editSave/<?php echo $this->teaId[0]['team_id']?>';
                $.post(url, query, function (response) {
                 alert (response);
                });
            }
        </script>
        <br /><br /><br /><br /><br /><br />
    </div>
</div>