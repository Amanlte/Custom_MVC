<?php

class View_Request extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $id = Session::get('all');

        $data = array();
        $this->view->title = 'View Request';

        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');

        $this->view->viewReq = $this->model->_viewRequests($data);
        $this->view->viewOtherReq = $this->model->_viewOtherRequests($data);
        $this->view->forwardReq = $this->model->_forwardedRequests($data);
        $this->view->assignedReq = $this->model->_assignedRequests($data);
        $this->view->rvLists = $this->model->_selectAll();

        $this->view->availableUsers = $this->model->_availableMembers();
        $this->view->requestStatus = $this->model->_getStatus();
        $this->view->availableTeams = $this->model->_availableTeams();
        $this->view->render('view_request/index');
    }

    public function edit($id) {
        $this->view->title = 'Edit View Request';

        $this->view->rfId = $this->model->_edit($id);
        $this->view->render('view_request/edit');
    }

//    public function _edit($id) {
//        return $this->db->select('SELECT req_id, req_assigned_to,req_status FROM request WHERE req_id = :reid', array(':reid' => $id));
//    }
//
//    public function _editSave($data) {
//        try {
//            $isThareChange = $this->db->select('SELECT req_assigned_to,req_status FROM request WHERE req_id = :id', array(':id' => $data['req_id']));
//            if ($data['req_assigned_to'] == $isThareChange[0]['req_assigned_to'] && $data['req_status'] == $isThareChange[0]['req_status']) {
//                Session::set('vrError', true);
//                return false;
//            } else {
//                $postData = array(
//                    'req_assigned_to' => $data['req_assigned_to'],
//                    'req_status' => $data['req_status']
//                );
//
//                $this->db->update('request', $postData, "`req_id` = {$data['req_id']}");
//                Session::set('rvSuccess', true);
//            }
//        } catch (PDOException $ex) {
//            Session::set('pdoError', $ex->getMessage() . ". For more details check pdo_error_logs file!");
//            $error = "\r\n========================Error on Update======================== \r\n\r\n[" . date('d-M-Y h:i:s') . ']  [ ErrorCode :' . $ex->getCode() . '] ' . $ex->getTraceAsString() .
//                    " : \r\n\r\n ==>Error Message : " . $ex->getMessage() . "\r\n ======================== End ========================";
//            ErrorLogger::add($error);
//        }
//    }

    public function selectCaseName() {
        if ($_POST['id']) {
            $id = $_POST['id'];
            $this->view->cn = $this->model->_selectCaseName($id);
            Session::set('case_name', $this->view->cn[0]['case_name']);
            echo '<td>' . $this->view->cn[0]['case_name'] . '</td>';
        }
    }

    public function selectUserName() {
        if ($_POST['uid']) {
            $id = $_POST['uid'];
            $this->view->un = $this->model->_selectUserName($id);
            $user = $this->view->un[0]['user_full_name'];
            Session::set('request_by', $user);
            echo $this->view->un[0]['user_full_name'];
        }
    }

    public function getRequests() {
        $data = array();

        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');

        $this->view->no_notifications = $this->model->_getRequests($data);
        if ($this->view->no_notifications[0]['Nofitications'] > 0)
            echo $this->view->no_notifications[0]['Nofitications'];
    }

    public function getTotalRequests() {
        $data = array();

        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');

        $this->view->no_notifications = $this->model->_getRequests($data);
        $this->view->no_forwarded_notifications = $this->model->_getForwardedRequests($data);
        $this->view->no_other_notifications = $this->model->_getOtherRequests($data);
        if ($this->view->no_notifications[0]['Nofitications'] > 0 || $this->view->no_forwarded_notifications[0]['Nofitications'] > 0 || $this->view->no_other_notifications[0]['Nofitications'] > 0)
            echo $this->view->no_notifications[0]['Nofitications'] + $this->view->no_forwarded_notifications[0]['Nofitications'] + $this->view->no_other_notifications[0]['Nofitications'];
    }

    public function getForwardedRequests() {
        $data = array();

        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');

        $this->view->no_notifications = $this->model->_getForwardedRequests($data);
        if ($this->view->no_notifications[0]['Nofitications'] > 0)
            echo $this->view->no_notifications[0]['Nofitications'];
    }

    public function getOtherRequests() {
        $data = array();

        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');

        $this->view->no_notifications = $this->model->_getOtherRequests($data);
        if ($this->view->no_notifications[0]['Nofitications'] > 0)
            echo $this->view->no_notifications[0]['Nofitications'];
    }

    public function getAssignedRequests() {

        $data['user_id'] = Session::get('user_id');

        $this->view->no_notifications = $this->model->_getAssignedRequests($data['user_id']);
        if ($this->view->no_notifications[0]['Nofitications'] > 0)
            echo $this->view->no_notifications[0]['Nofitications'];
    }

    public function buildUI() {

        if (isset($_POST['selected'])) {
            $selected = $_POST['selected'];
        }

        $this->view->availableUsers = $this->model->_availableMembers();
        $this->view->requestStatus = $this->model->_getStatus();
        $this->view->availableTeams = $this->model->_availableTeams();
        if ($selected == 'assign') {
            echo '<label class="label">Assign to : </label><select class="select_medium" id="members">'
            . '<option value="">-- Select --</option>';
            foreach ($this->view->availableUsers as $key => $value) {
                echo '<option value="' . $value['user_id'] . '">' . $value['user_full_name'] . '</option>';
            }
            echo '</select> <br />'
            . '<label class="label">Remark : </label><textarea maxlength="500" class="textarea" id="remark" /><br />';
        } else if ($selected == 'solve') {
            echo '<label class="label">Change Status To : </label><select class="select_medium" id="statusto">'
            . '<option value="">-- Select --</option>';
            foreach ($this->view->requestStatus as $key => $value) {
                echo '<option value="' . $value['stat_id'] . '">' . $value['stat_name'] . '</option>';
            }
            echo '</select><br />';
            echo '<label class="label">Solution : </label><textarea row="" cols="" class="textarea" id="solution" /><br />';
            echo '<label class="label">Remark : </label><textarea maxlength="500" class="textarea" id="remark" /><br />';
        } else if ($selected == 'forward') {
            echo '<label class="label">Forward to : </label><select class="select_medium" id="team">'
            . '<option value="">-- Select --</option>';
            foreach ($this->view->availableTeams as $key => $value) {
                echo '<option value="' . $value['team_id'] . '">' . $value['team_name'] . '</option>';
            }
            echo '</select> <br />'
            . '<label class="label">Reason : </label><textarea row="" cols="" class="textarea" id="reason">This request does not belong to my team.</textarea><br />';
        } else if ($selected == 'escalate') {
            echo '<label class="label">Escalate to : </label><input type="text" maxlength="100" class="text" id="escalate"/> <br />'
            . '<label class="label">Remark : </label><textarea maxlength="500" class="textarea" id="remark"></textarea><br />';
        }
    }

    public function viewRequest() {

        $data = array();

        if (isset($_POST['id'])) {
            $rid = $_POST['id'];
        }

        $data['id'] = $rid;
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');


        $this->view->viewDetail = $this->model->_viewRequest($data);
        foreach ($this->view->viewDetail as $key => $value) {
////            $phpdate = ;
//            $mysqldate = ;

            if (empty($value['caseName'])) {
                echo '<tr><th>Request </th><td>Other</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" /></tr>';
            } else {
                echo '<tr><th>Request </th><td>' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" /></tr>';
            }
            echo '<tr><th>Request Detail</th><td>' . $value['req_details'] . '</td></tr>';
            echo '<tr><th>Date</th><td>' . date('d/m/Y', strtotime($value['req_time'])) . '</td></tr>';
            echo '<tr><th>Time</th><td>' . date('H:i a', strtotime($value['req_time'])) . '</td></tr>';
            echo '<tr><th>Requested By</th><td>' . $value['fullName'] . '</td></tr>';
//            echo '<tr><th>Status</th><td>' . $value['req_status'] . '</td></tr>';
        }
    }

    public function viewOtherRequest() {

        $data = array();

        if (isset($_POST['id'])) {
            $rid = $_POST['id'];
        }

        $data['id'] = $rid;
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');


        $this->view->viewDetail = $this->model->_viewOtherRequest($data);
        foreach ($this->view->viewDetail as $key => $value) {


            if (empty($value['caseName'])) {
                echo '<tr><th>Request </th><td>Other</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" /></tr>';
            } else {
                echo '<tr><th>Request </th><td>' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" /></tr>';
            }
            echo '<tr><th>Request Detail</th><td>' . $value['req_details'] . '</td></tr>';
            echo '<tr><th>Date</th><td>' . date('d/m/Y', strtotime($value['req_time'])) . '</td></tr>';
            echo '<tr><th>Time</th><td>' . date('H:i a', strtotime($value['req_time'])) . '</td></tr>';
            echo '<tr><th>Requested By</th><td>' . $value['fullName'] . '</td></tr>';
            echo '<tr><th>Status</th><td>' . $value['reqStatus'] . '</td></tr>';
        }
    }

    public function forwardedRequest() {

        $data = array();

        if (isset($_POST['id'])) {
            $rid = $_POST['id'];
        }

        $data['id'] = $rid;
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');


        $this->view->viewDetail = $this->model->_forwardedRequest($data);
        foreach ($this->view->viewDetail as $key => $value) {


            if (empty($value['caseName'])) {
                echo '<tr><th>Request </th><td>Other</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" /></tr>';
            } else {
                echo '<tr><th>Request </th><td>' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" /></tr>';
            }
            echo '<tr><th>Request Detail</th><td>' . $value['req_details'] . '</td></tr>';
            echo '<tr><th>Date</th><td>' . date('d/m/Y', strtotime($value['req_time'])) . '</td></tr>';
            echo '<tr><th>Time</th><td>' . date('H:i a', strtotime($value['req_time'])) . '</td></tr>';
            echo '<tr><th>Requested By</th><td>' . $value['fullName'] . '</td></tr>';
            echo '<tr><th>Forwarded By</th><td>' . $value['teamName'] . '</td></tr>';
//            echo '<tr><th>Status</th><td>' . $value['req_status'] . '</td></tr>';
        }
    }

    public function assignedRequest() {

        $data = array();

        if (isset($_POST['id'])) {
            $rid = $_POST['id'];
        }

        $data['id'] = $rid;
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');


        $this->view->viewDetail = $this->model->_assignedRequest($data);
        if ($this->view->viewDetail != 0) {
            foreach ($this->view->viewDetail as $key => $value) {
                if (empty($value['caseName'])) {
                    echo '<tr><th>Request </th><td>Other</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" /></tr>';
                } else {
                    echo '<tr><th>Request </th><td>' . $value['caseName'] . '</td><input type="hidden" value="' . $value['req_type'] . '" id="case_name" /></tr>';
                }
                echo '<tr><th>Request Detail</th><td>' . $value['req_details'] . '</td></tr>';
                echo '<tr><th>Date</th><td>' . date('d/m/Y', strtotime($value['req_time'])) . '</td></tr>';
                echo '<tr><th>Time</th><td>' . date('H:i a', strtotime($value['req_time'])) . '</td></tr>';
                echo '<tr><th>Team Leader Remark</th><td>' . $value['team_leader_remark'] . '</td></tr>';
                echo '<tr><th>Requested By</th><td>' . $value['fullName'] . '</td></tr>';
            }
        } else {
            echo 'There is no assiened requests.';
        }
    }

    public function additionalSol() {

        $data = array();

        if (isset($_POST['id'])) {
            $rid = $_POST['id'];
        }

        $data['id'] = $rid;
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');


        $this->view->viewDetail = $this->model->_additionalSol($data);
        if ($this->view->viewDetail != 0) {
            echo '<tr><th>Case</th><th>Solution Briefly</th><th>Solution Detail(s)/Steps</th><th>Additional Solution</th></tr>';
            echo '<tr>';
            foreach ($this->view->viewDetail as $key => $value) {
                $solution_details = explode(',', $value['solution']);
                $additional_solution = explode(',', $value['additionalSo']);
                echo '<td>' . $value['caseName'] . '</td>';
                echo '<td>' . $value['caseSolution'] . '</td>';
                echo '<td><ol class="list_normal">';
                foreach ($solution_details AS $details) {
                    if (!empty($details)) {
                        echo '<li>' . $details . '</li>';
                    }
                }
                echo '</ol></td>';
                if (empty($value['additionalSo'])) {
                    echo '<td></td>';
                } else {
                    echo '<td><ol class="list_normal">';
                    foreach ($additional_solution AS $add_so) {
                        if (!empty($add_so)) {
                            echo '<li>' . $add_so . '</li>';
                        }
                    }
                    echo '</ol></td>';
                }
            }
            echo '</tr>';
        } else {
            echo 'There is no solution registered for this case.';
        }
    }

    public function additionalSolution() {

        $data = array();

        if (isset($_POST['id'])) {
            $rid = $_POST['id'];
        }

        $data['id'] = $rid;
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');

        $this->view->viewAddSol = $this->model->_additionalSolution($data);

        if (is_array($this->view->viewAddSol)) {
            foreach ($this->view->viewAddSol as $key => $solution) {
                echo '<tr>';
                echo '<td>' . $solution['caseName'] . '</td>'
                . '<td>' . $solution['req_details'] . '</td>'
                . '<td>' . $solution['addSolution'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">' . print_r($this->view->viewAddSol) . 'There is no solution registered by this case.</td></tr>';
        }
    }

    public function viewHistory() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $this->view->viewHistory = $this->model->_viewHistory($id);

        if (is_array($this->view->viewHistory)) {
            foreach ($this->view->viewHistory as $key => $history) {
                echo '<tr>';
                echo '<td>' . $history['caseName'] . '</td>'
                . '<td>' . $history['req_details'] . '</td>'
                . '<td>' . $history['req_time'] . '</td>'
//                . '<td>' . $history['addSolution'] . '</td>'
                . '<td>' . $history['status'] . '</td>'
                . '<td>' . $history['handledBy'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">' . print_r($this->view->viewHistory) . 'There is no history registered by this user.</td></tr>';
        }
    }

//    public function additionalSolution() {
//        if (isset($_POST['id'])) {
//            $id = $_POST['id'];
//        }
//        $data['id'] = $id;
//        $this->view->viewAddSol = $this->model->_viewSolution($id);
//
//        if (is_array($this->view->viewAddSol)) {
//            foreach ($this->view->viewAddSol as $key => $solution) {
//                echo '<tr>';
//                echo '<td>' . $solution['caseName'] . '</td>'
//                . '<td>' . $solution['req_details'] . '</td>'
//                . '<td>' . $solution['additionalSolution'] . '</td>';
//                echo '</tr>';
//            }
//        } else {
//            echo '<tr><td colspan="6">' . print_r($this->view->viewAddSol) . 'There is no any solution registered by this case.</td></tr>';
//        }
//    }

    public function viewDevice() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $this->view->viewUserDevice = $this->model->_viewDevice($id);
        if (is_array($this->view->viewUserDevice)) {
            foreach ($this->view->viewUserDevice as $key => $device) {

                echo'<tr>'
                . '<td>' . $device['device_name'] . '</td>'
                . '<td>' . $device['brand'] . '</td>'
                . '<td>' . $device['model'] . '</td>'
                . '<td>' . $device['dev_tag'] . '</td>'
                . '<td>' . $device['dev_pc_hd'] . '</td>'
                . '<td>' . $device['dev_pc_ram'] . '</td>'
                . '<td>' . $device['dev_remark'] . '</td>'
                . '<td>' . $device['status'] . '</td></tr>';
            }
        } else {
            echo '<tr><td colspan="6">' . print_r($this->view->viewUserDevice) . 'There is no any history registered by this user.</td></tr>';
        }
    }

    public function viewUser() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $this->view->viewUser = $this->model->_viewUser($id);
        if (is_array($this->view->viewUser)) {
            foreach ($this->view->viewUser as $key => $user) {

                echo'<tr>';
                echo '<td>' . $user['user_id'] . '</td>'
                . '<td>' . $user['user_full_name'] . '</td>'
                . '<td>' . $user['building'] . '</td>'
                . '<td>' . $user['floor'] . '</td>'
                . '<td>' . $user['directorate'] . '</td>'
                . '<td>' . $user['team'] . '</td>'
                . '<td>' . $user['position'] . '</td>'
                . '<td>' . $user['user_phone'] . '</td>'
                . '<td>' . $user['user_email'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="8">Information about this user not found.</td></tr>';
        }
    }

    public function takeAction() {

        $data = array();

        if (isset($_POST['actions'])) {
            $data['rid'] = isset($_POST['rid']) ? $_POST['rid'] : '';
            $data['caseId'] = isset($_POST['caseId']) ? $_POST['caseId'] : '';
            $data['assign_to'] = isset($_POST['members']) ? $_POST['members'] : '';
            $data['remark'] = isset($_POST['remark']) ? $_POST['remark'] : '';

            if ($_POST['actions'] == 'forward') {
                $data['freason'] = isset($_POST['reason']) ? $_POST['reason'] : '';
            } else if ($_POST['actions'] == 'escalate') {
                $data['ereason'] = isset($_POST['reason']) ? $_POST['reason'] : '';
            }

            $data['solution'] = isset($_POST['solution']) ? $_POST['solution'] : '';
            $data['forward_to'] = isset($_POST['team']) ? $_POST['team'] : '';
            $data['escalate_to'] = isset($_POST['escalate']) ? $_POST['escalate'] : '';
            $data['by'] = Session::get('user_id');
            $data['date'] = date('Y-m-d h:i:s');
            $data['statusto'] = isset($_POST['statusto']) ? $_POST['statusto'] : '';
            $data['status'] = isset($_POST['statusto']) ? $_POST['solution'] : '';
        }
        $this->model->_takeAction($data);
    }

    public function takeActionTeamMember() {

        $data = array();
            $data['rid'] = isset($_POST['rid']) ? $_POST['rid'] : '';
            $data['caseId'] = isset($_POST['caseId']) ? $_POST['caseId'] : '';
            $data['assign_to'] = isset($_POST['members']) ? $_POST['members'] : '';
            $data['remark'] = isset($_POST['remark']) ? $_POST['remark'] : '';

            if ($_POST['actions'] == 'forward') {
                $data['freason'] = isset($_POST['reason']) ? $_POST['reason'] : '';
            } else if ($_POST['actions'] == 'escalate') {
                $data['ereason'] = isset($_POST['reason']) ? $_POST['reason'] : '';
            }

            $data['solution'] = isset($_POST['solution']) ? $_POST['solution'] : '';
            $data['forward_to'] = isset($_POST['team']) ? $_POST['team'] : '';
            $data['escalate_to'] = isset($_POST['escalateto']) ? $_POST['escalateto'] : '';
            $data['by'] = Session::get('user_id');
            $data['date'] = date('Y-m-d h:i:s');
            $data['statusto'] = isset($_POST['statusto']) ? $_POST['statusto'] : '';
            $data['status'] = isset($_POST['statusto']) ? $_POST['solution'] : '';
       
        $this->model->_takeActionTeamMember($data);
    }

//    public function takeTeamMemberAction() {
//        $this->model->_takeActionTeamMember($data);
//    }
}
