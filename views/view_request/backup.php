<div class="wrapper_content">
    <div id="content">
        <div class="cd-tabs">
            <nav>
                <ul class="cd-tabs-navigation">
                    <li><a data-content="inbox" class="selected" href="#0">New Request(s)</a></li>
                    <li><a data-content="new" href="#0">Notifaction(s)</a></li>
                    <li><a data-content="trash" href="#0">Trash</a></li>
                </ul> <!-- cd-tabs-navigation -->
            </nav>

            <ul class="cd-tabs-content">
                <li data-content="inbox" class="selected">

                    <h1>New Request</h1>
                    <div id="list-container">
                        <table cellpadding="0" cellspacing="0" width="100%" id="dt" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Request Type</th><th>Request Detail</th><th>Time</th><th>Requested By</th><th>#</th>
                                </tr>
                            </thead>
                            <?php
                            echo '<tbody>';
                            $count = 0;
                            foreach ($this->viewReq as $key => $value) {

                                $count++;
                                ?>
                                <tr id="<?php echo $count; ?>" class="<?php
                                if ($count % 2 == 0) {
                                    echo 'dark';
                                } else
                                    echo 'light';
                                ?>">
                                        <?php
                                        echo '<td>' . $value['req_id'] . '</td>';
                                        echo '<td id="dis_case_name">' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" />';
                                        echo '<td title="' . $value['req_details'] . '">' . WordCount::word_limit($value['req_details'], 5) . '...</td>';
                                        echo '<td>' . HumanTime::humanTiming($value['req_time']) . '</td>';
                                        echo '<td id="dis_user_name">' . $value['fullName'] . '</td><input type="hidden" value="' . $value['user_id'] . '" id="user_name" />';
                                        echo '<td><a id="' . $value['req_id'] . '" href="#takeaction" rel="leanModal">Take Action</a> | <a id="' . $value['req_id'] . '" rel="leanModal" class="viewdetail" href="#viewdetail">View Detail</a></td>';
                                        echo '</tr>';
                                        ?></div><?php
                                }
                                echo '</tbody>';
                                ?>
                        </table>
                    </div>
                    <div id="viewdetail">
                        <div id="viewdetail-ct">
                            <div id="viewdetail-header">
                                <h2>Request Details</h2>
                                <a class="modal_close" href="#"></a>
                            </div>
                            <div id="viewdetailcontent">
                                <table width="100%" border="1" class="overflow">
                                    <tbody alight="left" id="vd">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.leanModal.min.js"></script>
                        <script>
                            //to view detail of requests
                            $(document).ready(function() {
                                $('.viewdetail').click(function() {
                                    var id = $(this).attr('id');
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo URL; ?>view_request/viewRequest',
                                        data: {id: id},
                                        success: function(output) {
                                            $('#vd').html(output);
                                        }
                                    });
                                });
                                $('a[rel*=leanModal]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});
                            });
                        </script>
                    </div>
                    <div id="takeaction">
                        <form name="frm_act" id="frm_act" action="<?php echo URL; ?>view_request/takeAction" method="POST">
                            <div id="viewdetail-ct">
                                <div id="viewdetail-header">
                                    <h2>Take Action</h2>
                                    <a class="modal_close" href="#"></a>
                                </div>
                                <div id="takeactioncontent">
                                    <div id="form-area">
                                        <label class="success" id="action_result"></label><br />
                                        <label class="label" >Actions :  </label>
                                        <select id="actions" class="select_medium">
                                            <option value=""> - Select -</option>
                                            <option value="assign"> Assign</option>
                                            <option value="solve"> Take action by yourself</option>
                                            <option value="forward"> Forward to another team</option>
                                            <option value="escalate"> Escalate/Out-source</option>
                                        </select><input type="text" name="rid" id="rid"/>
                                        <div id="action_area">

                                        </div>
                                    </div>
                                </div>

                                <div id="viewdetail-footer">
                                    <input type="reset" name="cancel" value="Cancel" class="submit" id="button-last"/><input type="submit" name="but_actions" value="Submit" class="submit"  />
                                </div>
                                <div class="clear"></div>
                            </div>
                        </form>
                        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>
                        <script>
                            //to view detail of requests
                            $(document).ready(function() {
                                $('.takeaction').click(function() {
                                    var id = $(this).attr('id');
                                    $('#rid').val(id);

                                    var frm = $('#frm_act');
                                    frm.submit(function(ev) {
                                        ev.preventDefault();
                                        $.ajax({
                                            type: frm.attr('method'),
                                            url: frm.attr('action'),
                                            data: frm.serialize(),
                                            success: function(data) {
                                                alert(data);
                                            }
                                        });
                                    });
                                });
                                $('a[rel*=leanModal]').leanModal({top: 50, overlay: 0.4, closeButton: ".modal_close"});

                                $('#actions').live('change', function() {
                                    var selected = $('#actions option:selected').val();
                                    if (selected != '') {
                                        $.ajax({
                                            url: '<?php echo URL; ?>view_request/buildUI',
                                            data: {selected: selected},
                                            type: 'POST',
                                            success: function(result) {
                                                $('#action_area').html();
                                                $('#action_area').html(result).serialize();
                                            }
                                        });
                                    } else {
                                        $('#action_area').empty();
                                    }
                                });
                            });
                            $('input[type="reset"]').on('click', function(e) {
                                e.preventDefault();
                                $('#actions').val('');
                                $('#action_area').empty();
                            });
                        </script>
                    </div>
                </li>

                <li data-content="new">
                    <p>New Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non a voluptatibus, ex odit totam cumque nihil eos asperiores ea, labore rerum. Doloribus tenetur quae impedit adipisci, laborum dolorum eaque ratione quaerat, eos dicta consequuntur atque ex facere voluptate cupiditate incidunt.</p>

                    <p>New Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non a voluptatibus, ex odit totam cumque nihil eos asperiores ea, labore rerum. Doloribus tenetur quae impedit adipisci, laborum dolorum eaque ratione quaerat, eos dicta consequuntur atque ex facere voluptate cupiditate incidunt.</p>
                </li>

                <li data-content="gallery">
                    <p>Gallery Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque tenetur aut, cupiditate, libero eius rerum incidunt dolorem quo in officia.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ipsa vero, culpa doloremque voluptatum consectetur mollitia, atque expedita unde excepturi id, molestias maiores delectus quos molestiae. Ab iure provident adipisci eveniet quisquam ratione libero nam inventore error pariatur optio facilis assumenda sint atque cumque, omnis perspiciatis. Maxime minus quam voluptatum provident aliquam voluptatibus vel rerum. Soluta nulla tempora aspernatur maiores! Animi accusamus officiis neque exercitationem dolore ipsum maiores delectus asperiores reprehenderit pariatur placeat, quaerat sed illum optio qui enim odio temporibus, nulla nihil nemo quod dicta consectetur obcaecati vel. Perspiciatis animi corrupti quidem fugit deleniti, atque mollitia labore excepturi ut.</p>
                </li>

                <li data-content="store">
                    <p>Store Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum recusandae rem animi accusamus quisquam reprehenderit sed voluptates, numquam, quibusdam velit dolores repellendus tempora corrupti accusantium obcaecati voluptate totam eveniet laboriosam?</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi, enim, pariatur. Ab assumenda, accusantium! Consequatur magni placeat quae eos dicta, cum expedita sunt facilis est impedit possimus dolorum sequi nostrum nobis sit praesentium molestias nulla laudantium fugit corporis nam ut saepe harum ipsam? Debitis accusantium, omnis repudiandae modi, distinctio illo voluptatibus aperiam odio veritatis, quam perferendis eaque ullam. Temporibus tempore ad voluptates explicabo ea sit deleniti ipsum quos dolores tempora odio, ab corporis molestiae, eaque optio, perferendis! Cumque libero quia modi! Totam magni rerum id iusto explicabo distinctio, magnam, labore sed nemo expedita velit quam, perspiciatis non temporibus sit minus voluptatum. Iste, cumque sunt suscipit facere iusto asperiores, ullam dolorum excepturi quidem ea quibusdam deserunt illo. Nesciunt voluptates repellat ipsam.</p>
                </li>

                <li data-content="settings">
                    <p>Settings Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam nam magni, ullam nihil a suscipit, ex blanditiis, adipisci tempore deserunt maiores. Nostrum officia, ratione enim eaque nihil quis ea, officiis iusto repellendus. Animi illo in hic, maxime deserunt unde atque a nesciunt? Non odio quidem deserunt animi quod impedit nam, voluptates eum, voluptate consequuntur sit vel, et exercitationem sint atque dolores libero dolorem accusamus ratione iste tenetur possimus excepturi. Accusamus vero, dignissimos beatae tempore mollitia officia voluptate quam animi vitae.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique ipsam eum reprehenderit minima at sapiente ad ipsum animi doloremque blanditiis unde omnis, velit molestiae voluptas placeat qui provident ab facilis.</p>
                </li>

                <li data-content="trash">
                    <p>Trash Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque a iure nostrum animi praesentium, numquam quidem, nemo, voluptatem, aspernatur incidunt. Fugiat aspernatur excepturi fugit aut, dicta reprehenderit temporibus, nobis harum consequuntur quo sed, illum.</p>
                    <p>Trash Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque a iure nostrum animi praesentium, numquam quidem, nemo, voluptatem, aspernatur incidunt. Fugiat aspernatur excepturi fugit aut, dicta reprehenderit temporibus, nobis harum consequuntur quo sed, illum.</p>
                    <p>Trash Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque a iure nostrum animi praesentium, numquam quidem, nemo, voluptatem, aspernatur incidunt. Fugiat aspernatur excepturi fugit aut, dicta reprehenderit temporibus, nobis harum consequuntur quo sed, illum.</p>
                    <p>Trash Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque a iure nostrum animi praesentium, numquam quidem, nemo, voluptatem, aspernatur incidunt. Fugiat aspernatur excepturi fugit aut, dicta reprehenderit temporibus, nobis harum consequuntur quo sed, illum.</p>
                    <p>Trash Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque a iure nostrum animi praesentium, numquam quidem, nemo, voluptatem, aspernatur incidunt. Fugiat aspernatur excepturi fugit aut, dicta reprehenderit temporibus, nobis harum consequuntur quo sed, illum.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima doloremque optio tenetur, natus voluptatum error vel dolorem atque perspiciatis aliquam nemo id libero dicta est saepe laudantium provident tempore ipsa, accusamus similique laborum, consequatur quia, aut non maiores. Consectetur minus ipsum aliquam pariatur dolorem rerum laudantium minima perferendis in vero voluptatem suscipit cum labore nemo explicabo, itaque nobis debitis molestias officiis? Impedit corporis voluptates reiciendis deleniti, magnam, fuga eveniet! Velit ipsa quo labore molestias mollitia, quidem, alias nisi architecto dolor aliquid qui commodi tempore deleniti animi repellat delectus hic. Alias obcaecati fuga assumenda nihil aliquid sed vero, modi, voluptatem? Vitae voluptas aperiam nostrum quo harum numquam earum facilis sequi. Labore maxime laboriosam omnis delectus odit harum recusandae sint incidunt, totam iure commodi ducimus similique doloremque! Odio quaerat dolorum, alias nihil quam iure delectus repellendus modi cupiditate dolore atque quasi obcaecati quis magni excepturi vel, non nemo consequatur, mollitia rerum amet in. Nesciunt placeat magni, provident tempora possimus ut doloribus ullam!</p>
                </li>
            </ul> <!-- cd-tabs-content -->
        </div> <!-- cd-tabs -->
    </div>
</div>

