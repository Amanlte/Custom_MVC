<?php

class Dashboard extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
        Auth::handleLogin();
//        $this->view->js = array('dashboard/js/default.js');
//        $this->view->js = array('dashboard/css/dashboard.css');
//        $this->view->js = array('dashboard/js/dash_board.js');
//        $this->view->js = array('dashboard/js/for_dashboard.js');
    }

    function index() {
        $this->view->title = 'Dashboard';

        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');

        $this->view->viewFrequent = $this->model->_frequentRequests($data);
        $this->view->viewReqType = $this->model->_selectReqType($data);
        $this->view->viewCases = $this->model->_selectCases($data);
        $this->view->availableUsers = $this->model->_availableMembers();
        $this->view->teamMembers = $this->model->_selectAllTeamMembers();
        $this->view->render('dashboard/index');
    }

//    public function viewFrequent() {
//        header('Content-Type: application/json');
//        $data_points = array();
//
//        $this->view->viewFrequent = $this->db->SELECT('SELECT req_type,COUNT(*) as count, req_type FROM request GROUP BY req_type ORDER BY count DESC LIMIT 10;');
//        foreach ($this->view->viewDetail as $key => $row) {
//            $point = array('y' => $row['count'], 'indexLabel' => $row['req_type']);
//
//                array_push($data_points, $point);
//        }
//
//         echo json_encode($data_points, JSON_NUMERIC_CHECK);
//    }

    public function viewFrequentRequest() {
        header('Content-Type: application/json');
        $data_points = array();
        $this->view->topTen = $this->model->_viewFrequentRequest();
        if (is_array($this->view->topTen)) {
            foreach ($this->view->topTen as $key => $value) {
                $point = array('y' => $value['count'], 'indexLabel' => $value['caseName']);
                array_push($data_points, $point);
            }
            echo json_encode($data_points, JSON_NUMERIC_CHECK);
        }
    }


    public function selectReqType() {
        header('Content-Type: application/json');
        $data_points = array();
        if ($_POST['rp']) {
            $rp = $_POST['rp'];
            $this->view->rp = $this->model->_selectReqType($rp);
            foreach ($this->view->rp as $key => $value) {
                $point = array("y" => $value["count"], "label" => $value["case_type"]);
                array_push($data_points, $point);
            }
            $rpp = json_encode($data_points, JSON_NUMERIC_CHECK);
            ?>
            <script type="text/javascript">
                var role = <?php echo $rpp; ?>;
                var chart = new CanvasJS.Chart("repByType", {
                    title: {
                        text: "Service Provided By Type"
                    },
                    exportFileName: "Service Provided By Type", //Give any name accordingly
                    exportEnabled: true,
                    axisX: {
                        title: "Requests Type"
                    },
                    axisY: {
                        title: "Frequency"
                    },
                    //                        dataPointMaxWidth: 50,
                    data: [//array of dataSeries              
                        {
                            /*** Change type "column" to "bar", "area", "line" or "pie"***/
                            type: "column",
                            dataPoints: role
                        }
                    ]
                });

                chart.render();
            </script>
            <?php
        }
    }

    public function selectTypeSummary() {
        if ($_POST['rp']) {
            $rp = $_POST['rp'];
            echo '<span style="float: right;"><b>Summary</b></span></br><table style="float: right;">';
            $this->view->rp = $this->model->_selectReqType($rp);
            foreach ($this->view->rp as $key => $value) {
                echo '<tr><td style="text-align: right; padding-right: 10px;">' . $value['case_type'] . '</td>';
                echo '<td><b>' . $value['count'] . '</b></td></tr>';
            }
            echo '</table>';
        }
    }
    public function selectTeamSummary() {
        if ($_POST['rp']) {
            $rp = $_POST['rp'];
            echo '<span style="float: right;"><b>Summary</b></span></br><table style="float: right;">';
            $this->view->rp = $this->model->_selectReqType($rp);
            foreach ($this->view->rp as $key => $value) {
                echo '<tr><td style="text-align: right; padding-right: 10px;">' . $value['case_type'] . '</td>';
                echo '<td><b>' . $value['count'] . '</b></td></tr>';
            }
            echo '</table>';
        }
    }

    public function selectTypeSummaryTm() {
        echo '<style>.floatedTable {
            float:left;
            margin: 5px 10px;
        }
        .inlineTable {
            display: inline-block;
        }</style>';
        $this->view->viewTeamMembers = $this->model->_selectAllTeamMembers();
        if (is_array($this->view->viewTeamMembers)) {
            foreach ($this->view->viewTeamMembers as $key => $value1) {
                if ($_POST['rp']) {

                    echo'<table class="floatedTable" border=1><tr><td colspan="2">' . $value1['user_full_name'] . '</td></tr>';
                    $rp = $_POST['rp'];
                    echo '';
                    $this->view->rp = $this->model->_selectReqType($rp);
                    foreach ($this->view->rp as $key => $value) {
                        $data['user_team'] = Session::get('user_team');
                        $data['user_id'] = Session::get('user_id');
                        $con = mysqli_connect('127.0.0.1', 'root', 'root"123', 'nbe');
                        if ($rp == 'week') {
                            //SELECT CURRENT WEEK ONLY
                            $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type, req_assigned_to "
                                    . "FROM `cases`, request "
                                    . "WHERE req_assigned_to = '" . $value1['user_id'] . "' AND YEAR(req_last_update) = YEAR(CURDATE()) AND WEEK(req_last_update) = WEEK(CURDATE()) "
                                    . "AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
                        } else if ($rp == 'month') {
                            //SELECT CURRENT MONTH ONLY
                            $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND YEAR(req_last_update) = YEAR(CURDATE()) AND MONTH(req_time) = MONTH(CURDATE()) AND req_area = '" . $data['user_team'] . "' AND  `case_id` = req_type GROUP BY case_type;");
                        } else if ($rp == 'quarter') {
                            $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND QUARTER(`req_last_update`) = QUARTER(curdate()) AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
                        } else if ($rp == 'six_month') {
                            $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=6 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
                        } else if ($rp == 'nine_month') {
                            $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=9 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
                        } else if ($rp == 'annual') {
                            $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=12 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
                        }
                        $output = '';
                        while ($row = mysqli_fetch_array($result)) {
                            $output .= '<tr><td style="text-align: right; padding-right: 10px;">' . $row['case_type'] . '</td>';
                            $output .= '<td>' . $row['count'] . '</td></tr>';
                        }
                        mysqli_close($con);
                    }
                    if (isset($output)) {
                        echo $output . '</table>';
                    }
                }
            }
        }
    }

    public function selectStatusSummary() {
        if ($_POST['rp']) {
            $rp = $_POST['rp'];
            echo '<span style="float: right;"><b>Summary</b></span></br><table style="float: right;">';
            $this->view->rp = $this->model->_selectReqStatus($rp);
            foreach ($this->view->rp as $key => $value) {
                echo '<tr><td style="text-align: right; padding-right: 10px;">' . $value['stat_name'] . '</td>';
                echo '<td><b>' . $value['count'] . '</b></td></tr>';
            }
            echo '</table>';
        }
    }

    public function selectReqStatusTm() {
        echo '<style>.floatedTable {
            float:left;
            margin: 5px 10px;
        }
        .inlineTable {
            display: inline-block;
        }</style>';
        $this->view->viewTeamMembers = $this->model->_selectAllTeamMembers();
        if (is_array($this->view->viewTeamMembers)) {
            foreach ($this->view->viewTeamMembers as $key => $value1) {
                if ($_POST['rp']) {

                    echo'<table class="floatedTable" border=1><tr><td colspan="2">' . $value1['user_full_name'] . '</td></tr>';
                    $rp = $_POST['rp'];
                    echo '';
                    $this->view->rp = $this->model->_selectReqType($rp);
                    foreach ($this->view->rp as $key => $value) {
                        $data['user_team'] = Session::get('user_team');
                        $data['user_id'] = Session::get('user_id');
                        $con = mysqli_connect('127.0.0.1', 'root', 'root"123', 'nbe');
                        if ($rp == 'week') {
                            //SELECT CURRENT WEEK ONLY
                            $result = mysqli_query($con, "SELECT req_solution_status, COUNT(*) as count, stat_name, req_assigned_to FROM `status`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND YEAR(req_last_update) = YEAR(CURDATE()) AND WEEK(req_last_update) = WEEK(CURDATE()) "
                                    . "AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
                        } else if ($rp == 'month') {
                            //SELECT CURRENT MONTH ONLY
                            $result = mysqli_query($con, "SELECT req_solution_status, COUNT(*) as count, stat_name, req_assigned_to FROM `status`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND YEAR(req_last_update) = YEAR(CURDATE()) AND MONTH(req_time) = MONTH(CURDATE()) AND req_area = '" . $data['user_team'] . "' AND  `stat_id` = req_solution_status GROUP BY stat_name;");
                        } else if ($rp == 'quarter') {
                            $result = mysqli_query($con, "SELECT req_solution_status, COUNT(*) as count, stat_name, req_assigned_to FROM `status`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND QUARTER(`req_last_update`) = QUARTER(curdate()) AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
                        } else if ($rp == 'six_month') {
                            $result = mysqli_query($con, "SELECT req_solution_status, COUNT(*) as count, stat_name, req_assigned_to FROM `status`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=6 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
                        } else if ($rp == 'nine_month') {
                            $result = mysqli_query($con, "SELECT req_solution_status, COUNT(*) as count, stat_name, req_assigned_to FROM `status`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=9 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
                        } else if ($rp == 'annual') {
                            $result = mysqli_query($con, "SELECT req_solution_status, COUNT(*) as count, stat_name, req_assigned_to FROM `status`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=12 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
                        }

//                        $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE req_assigned_to = '" . $value1['user_id'] . "' AND `case_id` = req_type GROUP BY case_type;");

                        $output = '';
                        while ($row = mysqli_fetch_array($result)) {
                            $output .= '<tr><td style="text-align: right; padding-right: 10px;">' . $row['stat_name'] . '</td>';
                            $output .= '<td>' . $row['count'] . '</td></tr>';
                        }
                        mysqli_close($con);
                    }
                    if (isset($output)) {
                        echo $output . '</table>';
                    }
                }
            }
        }
    }

    public function changePassword() {
//        $data['password'] = $_POST['passwordRe'];
        $data = array();

        $data['user_id'] = Session::get('user_id');
        $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
        $this->model->_changePassword($data);
    }

    public function selectReqStatus() {
        header('Content-Type: application/json');
        $data_points = array();
        if ($_POST['rp']) {
            $rp = $_POST['rp'];
            $this->view->rp = $this->model->_selectReqStatus($rp);
            foreach ($this->view->rp as $key => $value) {
                $point = array("y" => $value["count"], "label" => $value["stat_name"]);
                array_push($data_points, $point);
            }
            $rpp = json_encode($data_points, JSON_NUMERIC_CHECK);
            ?>
            <script type="text/javascript">
                var role = <?php echo $rpp; ?>;
                var chart = new CanvasJS.Chart("repByReqStatus", {
                    title: {
                        text: "Service Provided By Status"
                    },
                    exportFileName: "Service Provided By Status", //Give any name accordingly
                    exportEnabled: true,
                    axisX: {
                        title: "Requests Status"
                    },
                    axisY: {
                        title: "Frequency"
                    },
                    //                        dataPointMaxWidth: 50,
                    data: [//array of dataSeries              
                        {
                            /*** Change type "column" to "bar", "area", "line" or "pie"***/
                            type: "pie",
                            dataPoints: role
                        }
                    ]
                });

                chart.render();
            </script>
            <?php
        }
    }

//    public function viewRequestByType() {
//        header('Content-Type: application/json');
//
//        $con = mysqli_connect('127.0.0.1', 'root', '', 'nbe');
//
//// Check connection
//        if (mysqli_connect_errno($con)) {
//            echo "Failed to connect to DataBase: " . mysqli_connect_error();
//        } else {
//            $user_team = Session::get('user_team');
//            $data_points = array();
////            $result = mysqli_query($con, "SELECT req_type,COUNT(*) as count, req_type, case_name FROM request, cases WHERE req_area = '" . $user_team . "' AND req_type=case_id GROUP BY req_type ORDER BY count DESC LIMIT 10;");
////                       $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type FROM `cases`, request WHERE (`req_time`BETWEEN DATE_ADD(CURDATE(), INTERVAL 2-DAYOFWEEK(CURDATE()) DAY)
////    AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY)) AND `case_id` = req_type GROUP BY case_type;");
////            if ($_POST['rp']) {
////                $rp = $_POST['rp'];
////                if ($rp == 'week') {
////                    $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type FROM `cases`, request WHERE (`req_time`BETWEEN DATE_ADD(CURDATE(), INTERVAL 2-DAYOFWEEK(CURDATE()) DAY)
////    AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY)) AND `case_id` = req_type GROUP BY case_type;");
////                } else if ($rp == 'month') {
////                    $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type FROM `cases`, request WHERE (`req_time`BETWEEN
////DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY)
////AND LAST_DAY(NOW())) AND `case_id` = req_type GROUP BY case_type;");
////                } else if ($rp == 'quarter') {
////                    $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type FROM `cases`, request WHERE QUARTER(`req_time`) = QUARTER(curdate()) AND `case_id` = req_type GROUP BY case_type;");
////                } else if ($rp == 'six_month') {
////                    $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type FROM `cases`, request WHERE (req_time > DATE_SUB(now(), INTERVAL 6 MONTH)) AND `case_id` = req_type GROUP BY case_type;");
////                } else if ($rp == 'nine_month') {
////                    $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type FROM `cases`, request WHERE (req_time > DATE_SUB(now(), INTERVAL 9 MONTH)) AND `case_id` = req_type GROUP BY case_type;");
////                } else if ($rp == 'annual') {
////                    $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type FROM `cases`, request WHERE YEAR(`req_time`) = YEAR(CURDATE()) AND `case_id` = req_type GROUP BY case_type;");
////                }
////            }
//
//            $result = mysqli_query($con, "SELECT req_type, COUNT(*) as count, case_type FROM `cases`, request WHERE `case_id` = req_type AND req_area = '" . $user_team . "' GROUP BY case_type;");
//            while ($row = mysqli_fetch_array($result)) {
//                $point = array('y' => $row['count'], 'label' => $row['case_type']);
//                array_push($data_points, $point);
//            }
//
//            echo json_encode($data_points, JSON_NUMERIC_CHECK);
//        }
//        mysqli_close($con);
//    }

    public function viewAllTeamRequest() {
        header('Content-Type: application/json');
        $data_points = array();
        $this->view->allTeam = $this->model->_viewAllTeamRequest();
        if (is_array($this->view->allTeam)) {
            foreach ($this->view->allTeam as $key => $value) {
                $point = array('y' => $value['count'], 'indexLabel' => $value['teamName']);
                array_push($data_points, $point);
            }
            echo json_encode($data_points, JSON_NUMERIC_CHECK);
        }
    }

    function logout() {
        Session::destroy();
        Session::set('login', true);
        header('location: ' . URL . 'login');
        exit;
    }

    function xhrInsert() {
//        $this->model->xhrInsert();
    }

    function xhrGetListings() {
//        $this->model->xhrGetListings();
    }

    function xhrDeleteListing() {
//        $this->model->xhrDeleteListing();
    }

}
