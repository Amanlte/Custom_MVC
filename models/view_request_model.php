<?php

class View_Request_Model extends Model {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _SELECTAll() {
        return $this->db->SELECT('SELECT * FROM request, cases where ((request.req_type = cases.case_area) and (request.req_area = "other" or request.req_type="other"))');
    }

    public function _edit($id) {
        return $this->db->SELECT('SELECT * FROM request WHERE req_id = :reqmid', array(':reqid' => $id));
    }

    public function _editSave($data) {

        $isThareChange = $this->db->SELECT('SELECT * FROM request WHERE req_id = :id', array(':id' => $data['req_id']));
        if ($data['team_name'] == $isThareChange[0]['team_name']) {
            Session::set('vrError', true);
            return false;
        } else {
            $postData = array(
                'team_name' => $data['team_name']
            );

            $this->db->update('team', $postData, "`team_id` = {$data['team_id']}");
            Session::set('teaSuccess', true);
        }
    }

    public function _SELECTCaseName($id) {
        return $this->db->SELECT('SELECT case_name FROM cases WHERE case_id = :id AND deleted = :isDeleted', array(':id' => $id, ':isDeleted' => 0));
    }

    public function _SELECTUserName($id) {
        return $this->db->SELECT('SELECT user_full_name FROM users WHERE user_id = :id AND deleted = :isDeleted', array(':id' => $id, ':isDeleted' => 0));
    }

    public function _viewDevice($id) {

        return $this->db->select('SELECT *, (SELECT dt_name FROM device_type WHERE dt_id = devices.dev_type) as device_name,'
                        . '(SELECT db_name FROM device_brand WHERE db_id = devices.dev_brand) as brand, '
                        . '(SELECT stat_name FROM status WHERE stat_id = devices.dev_status) as status, '
                        . '(SELECT db_name FROM device_brand WHERE db_id = devices.dev_brand) as model '
                        . 'FROM `devices` WHERE user_id IN (SELECT user_id FROM request WHERE req_id = :id)', array(':id' => $id));
    }

    public function _viewHistory($id) {

        return $this->db->SELECT('SELECT *, '
                        . '(SELECT case_name FROM cases WHERE case_id = request.req_type) AS caseName,'
//                        . '(SELECT additional_solution FROM solutions WHERE solutions.req_id = request.req_id GROUP BY case_id) AS addSolution, '
                        . '(SELECT stat_name FROM status WHERE stat_id = request.req_solution_status) AS status, '
                        . '(SELECT user_full_name FROM users WHERE user_id = request.req_assigned_to) AS handledBy '
//                        . 'FROM `request`  WHERE user_id IN (SELECT user_id FROM request WHERE req_id = :id) AND request.req_solution_status = :ss AND request.req_solution_status = :rs AND request.deleted = :isDeleted', array(':id' => $id, ':ss' => 1, ':rs' => 1, ':isDeleted' => 0));
                        . 'FROM `request`  WHERE user_id IN (SELECT user_id FROM request WHERE req_id = :id) AND request.req_status <> 0 AND req_area = \'' . Session::get('user_team') . '\' AND request.deleted = :isDeleted', array(':id' => $id, ':isDeleted' => 0));
    }

    public function _viewUser($id) {

        return $this->db->SELECT('SELECT *, '
                        . '(SELECT bui_name FROM building where bui_id = users.user_building) AS building,'
                        . '(SELECT flr_name FROM floor where flr_id = users.user_floor) AS floor,'
                        . '(SELECT dir_name FROM directorate where dir_id = users.user_directorate) AS directorate,'
                        . '(SELECT team_name FROM team where team_id = users.user_team) AS team,'
                        . '(SELECT pos_name FROM position where pos_id = users.user_position) AS position,'
                        . '(SELECT role_name FROM role where role_id = users.user_role) AS role'
                        . ' FROM users, request WHERE request.user_id = users.user_id AND request.req_id = :id AND request.deleted = :isDeleted', array(':id' => $id, ':isDeleted' => 0));
    }

    public function _getAssignedRequests($uid) {

        return $this->db->SELECT("SELECT COUNT(*) AS Nofitications FROM `request`"
                        . "WHERE request.req_solution_status <> 1 AND request.req_assigned_to = :id AND request.deleted = :isDeleted", array(':id' => $uid, ':isDeleted' => 0));
    }

    public function _getRequests($data) {

        return $this->db->SELECT("SELECT COUNT(*) AS Nofitications FROM `team`,`request`"
                        . "WHERE request.req_status = :status AND request.req_solution_status = 13 AND request.req_assigned_to IS NULL AND request.req_area = :area AND team.team_leader = :id AND request.deleted = :isDeleted", array(':status' => '0', ':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _getOtherRequests($data) {

        return $this->db->SELECT("SELECT COUNT(*) AS Nofitications FROM `team`,`request`"
                        . "WHERE request.req_solution_status NOT IN(13,1) AND request.req_area = :area AND team.team_leader = :id AND request.deleted = :isDeleted", array(':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _getForwardedRequests($data) {

        return $this->db->SELECT("SELECT COUNT(*) AS Nofitications FROM `team`, `request`"
                        . "WHERE request.req_area = :area AND team.team_leader = :id AND request.req_forwarded_to = :fid AND request.req_solution_status  <>1  AND request.deleted = :isDeleted", array(':area' => $data['user_team'], ':id' => $data['user_id'], ':fid' => $data['user_team'], ':isDeleted' => 0));
    }

    public function _assignedRequests($data) {

        return $this->db->SELECT("SELECT *, (SELECT user_full_name FROM users where user_id = request.user_id) AS fullName, "
                        . "(SELECT case_name FROM cases where case_id = request.req_type) AS caseName "
                        . "FROM `request`"
                        . "WHERE request.req_solution_status <> 1 AND request.req_assigned_to = :id AND request.deleted = :isDeleted", array(':id' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _assignedRequest($data) {

        return $this->db->SELECT("SELECT *, (SELECT user_full_name FROM users where user_id = request.user_id) AS fullName, "
                        . "(SELECT case_name FROM cases where case_id = request.req_type) AS caseName "
                        . "FROM `request`"
                        . "WHERE request.req_id = :rid AND request.req_solution_status <> 1 AND request.req_assigned_to = :id AND request.deleted = :isDeleted", array(':rid' => $data['id'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _additionalSol($data) {

        return $this->db->SELECT("SELECT *, "
                        . "(SELECT additional_solution FROM solutions where case_id = request.req_type) AS additionalSo, "
                        . "(SELECT case_name FROM cases where case_id = request.req_type) AS caseName, "
                        . "(SELECT case_solution_name FROM cases where case_id = request.req_type) AS caseSolution, "
                        . "(SELECT case_solution_details FROM cases where case_id = request.req_type) AS solution "
                        . "FROM `request` "
                        . "WHERE request.req_id = :rid AND request.deleted = :isDeleted", array(':rid' => $data['id'], ':isDeleted' => 0));
    }

    public function _additionalSolution($data) {

        return $this->db->SELECT("SELECT *, "
                        . "(SELECT case_solution_details FROM cases where case_id = request.req_type) AS caseName "
                        . "FROM `request`"
                        . "WHERE request.req_id = :rid AND request.deleted = :isDeleted", array(':rid' => $data['id'], ':isDeleted' => 0));
    }

    public function _viewRequests($data) {

        return $this->db->SELECT("SELECT *, (SELECT user_full_name FROM users where user_id = request.user_id) AS fullName, "
                        . "(SELECT case_name FROM cases where case_id = request.req_type) AS caseName "
                        . "FROM `team`,`request`"
                        . "WHERE request.req_status = :status AND request.req_solution_status = 13 "
                        . "AND request.req_assigned_to IS NULL AND request.req_area = :area "
                        . "AND team.team_leader = :id AND request.deleted = :isDeleted", array(':status' => '0', ':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _viewOtherRequests($data) {

        return $this->db->SELECT("SELECT *, "
                        . "(SELECT user_full_name FROM users where user_id = request.user_id) AS fullName, "
                        . "(SELECT user_full_name FROM users where user_id = request.req_assigned_to) AS assTo, "
                        . "(SELECT stat_name FROM status where stat_id = request.req_solution_status) AS reqStatus, "
                        . "(SELECT case_name FROM cases where case_id = request.req_type) AS caseName FROM `team`,`request`"
                        . "WHERE request.req_solution_status NOT IN (13,1) AND request.req_area = :area AND team.team_leader = :id AND request.deleted = :isDeleted", array(':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _forwardedRequests($data) {

        return $this->db->SELECT("SELECT *, (SELECT stat_name FROM status where stat_id = request.req_solution_status) AS reqStatus, (SELECT user_full_name FROM users where user_id = request.user_id) AS fullName, (SELECT case_name FROM cases where case_id = request.req_type) AS caseName, (SELECT team_name FROM team where team_leader = request.req_forwarded_by) AS teamName FROM `team`, `request`"
                        . "WHERE request.req_area = :area AND team.team_leader = :id AND request.req_forwarded_to = :fid AND request.req_solution_status  <>1  AND request.deleted = :isDeleted", array(':area' => $data['user_team'], ':id' => $data['user_id'], ':fid' => $data['user_team'], ':isDeleted' => 0));
    }

    public function _forwardedRequest($data) {

        return $this->db->SELECT("SELECT *, (SELECT user_full_name FROM users where user_id = request.user_id) AS fullName, (SELECT case_name FROM cases where case_id = request.req_type) AS caseName, (SELECT team_name FROM team where team_leader = request.req_forwarded_by) AS teamName FROM `team`, `request`"
                        . "WHERE req_id = :rid AND request.req_area = :area AND team.team_leader = :id AND request.req_forwarded_to = :fid AND request.req_solution_status  <>1  AND request.deleted = :isDeleted", array(':rid' => $data['id'], ':area' => $data['user_team'], ':id' => $data['user_id'], ':fid' => $data['user_team'], ':isDeleted' => 0));
    }

    public function _viewRequest($data) {

        return $this->db->SELECT("SELECT *, (SELECT user_full_name FROM users where user_id = request.user_id) AS fullName, (SELECT case_name FROM cases where case_id = request.req_type) AS caseName FROM `team`,`request`"
                        . "WHERE req_id = :rid AND request.req_status = :status AND request.req_area = :area AND team.team_leader = :id AND request.deleted = :isDeleted", array(':rid' => $data['id'], ':status' => '0', ':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _viewOtherRequest($data) {

        return $this->db->SELECT("SELECT *, (SELECT stat_name FROM status where stat_id = request.req_solution_status) AS reqStatus, (SELECT user_full_name FROM users where user_id = request.user_id) AS fullName, (SELECT case_name FROM cases where case_id = request.req_type) AS caseName FROM `team`,`request`"
                        . "WHERE req_id = :rid AND request.req_solution_status NOT IN (0,1) AND request.req_area = :area AND team.team_leader = :id AND request.deleted = :isDeleted", array(':rid' => $data['id'], ':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

//    public function _viewSolution($id) {
//
//        return $this->db->SELECT("SELECT *, (SELECT additional_solution FROM solutions where case_id = request.req_type) AS additionalSolution, "
//                        . "(SELECT case_name FROM cases where case_id = request.req_type) AS caseName "
//                        . "FROM `request`"
//                        . " request.deleted = :isDeleted", array(':isDeleted' => 0));
//    }

    public function _availableMembers() {
        return $this->db->SELECT("SELECT * FROM users "
                        . "WHERE user_status = '6' AND user_id != :user AND user_team = :team AND deleted = :isDeleted", array(':team' => Session::get('user_team'), ':user' => Session::get('user_id'), ':isDeleted' => 0));
    }

    public function _availableTeams() {
        return $this->db->SELECT("SELECT team.team_id, team.team_name, directorate.dir_name FROM team, directorate WHERE directorate.dir_name = 'Information System Management Directorate' AND team.dir_id = directorate.dir_id AND team.deleted = :isDeleted", array(':isDeleted' => 0));
    }

    public function _getStatus() {
        return $this->db->SELECT("SELECT * FROM status "
                        . "WHERE stat_for = :request AND deleted = :isDeleted", array(':request' => 'request', ':isDeleted' => 0));
    }

    public function _takeAction($data) {

        //'req_solution_status' => $data['status_to'],
        //'req_forwarded_to' => $data['team'],
        //'escalated_to' => $data['escalate']

        $rid = isset($data['rid']) ? $data['rid'] : '';
        $postData = array();
        if (isset($_POST['actions'])) {

            if ($_POST['actions'] == 'assign') {

                $postData = array(
                    'req_assigned_to' => isset($data['assign_to']) ? $data['assign_to'] : '',
                    'req_assigned_by' => isset($data['by']) ? $data['by'] : '',
                    'team_leader_remark' => isset($data['remark']) ? $data['remark'] : '',
                    'req_status' => isset($data['status']) ? 1 : ''
                );
                echo 'Successfully Assigned';
            } else if ($_POST['actions'] == 'forward') {
                $postData = array(
                    'req_area' => isset($data['forward_to']) ? $data['forward_to'] : '',
                    'req_forwarded_to' => isset($data['forward_to']) ? $data['forward_to'] : '',
                    'req_forwarded_by' => isset($data['by']) ? $data['by'] : '',
                    'req_forward_reason' => isset($data['freason']) ? $data['freason'] : '',
                    'team_leader_remark' => isset($data['remark']) ? $data['remark'] : '',
                    'req_status' => isset($data['status']) ? 1 : '',
                    'req_forwarded_at' => isset($data['date']) ? $data['date'] : ''
                );

                echo 'Successfully Forwarded';
            } else if ($_POST['actions'] == 'solve') {
                $postData = array(
                    'team_leader_remark' => isset($data['remark']) ? $data['remark'] : '',
                    'req_status' => isset($data['status']) ? 1 : '',
                    'req_solution_status' => isset($data['statusto']) ? $data['statusto'] : '',
                    'req_assigned_to' => isset($data['by']) ? $data['by'] : ''
                );
                if (!empty($data['solution']) || $data['solution'] != '') {
                    $this->db->insert('solutions', array(
                        'case_id' => isset($data['caseId']) ? $data['caseId'] : '',
                        'req_id' => $rid,
                        'user_id' => isset($data['by']) ? $data['by'] : '',
                        'additional_solution' => isset($data['solution']) ? $data['solution'] : '',
                        'sol_date' => isset($data['date']) ? $data['date'] : ''
                    ));
                }
                echo 'Successfully Saved';
            } else {
                $postData = array(
                    'req_escalated_to' => isset($data['escalate_to']) ? $data['escalate_to'] : '',
                    'req_escalation_reason' => isset($data['ereason']) ? $data['ereason'] : '',
                    'team_leader_remark' => isset($data['remark']) ? $data['remark'] : '',
                    'req_status' => isset($data['status']) ? 1 : '',
                    'req_escalated_on' => isset($data['date']) ? $data['date'] : ''
                );

                echo 'Successfully Escalated';
            }
        }

        $this->db->update('request', $postData, "`req_id` = {$rid}");
    }

    public function _takeActionTeamMember($data) {

        //'req_solution_status' => $data['status_to'],
        //'req_forwarded_to' => $data['team'],
        //'escalated_to' => $data['escalate']

        $rid = isset($data['rid']) ? $data['rid'] : '';
        $postData = array();
//        if (isset($_POST['actions'])) {
//            if ($_POST['actions'] == 'solve') {
        $postData = array(
            'team_member_remark' => isset($data['remark']) ? $data['remark'] : '',
            'req_status' => isset($data['status']) ? 1 : '',
            'req_solution_status' => isset($data['statusto']) ? $data['statusto'] : ''
        );
        if (!empty($data['solution']) || $data['solution'] != '') {
            $this->db->insert('solutions', array(
                'case_id' => isset($data['caseId']) ? $data['caseId'] : '',
                'req_id' => $rid,
                'user_id' => isset($data['by']) ? $data['by'] : '',
                'additional_solution' => isset($data['solution']) ? $data['solution'] : '',
                'sol_date' => isset($data['date']) ? $data['date'] : ''
            ));
        }
        echo 'Successfully Saved';
//            } else {
//                $postData = array(
//                    'req_escalated_to' => isset($data['escalate_to']) ? $data['escalate_to'] : '',
//                    'req_escalation_reason' => isset($data['ereason']) ? $data['ereason'] : '',
//                    'team_member_remark' => isset($data['remark']) ? $data['remark'] : '',
//                    'req_status' => isset($data['status']) ? 1 : '',
//                    'req_escalated_on' => isset($data['date']) ? $data['date'] : ''
//                );
//
//                echo 'Successfully Escalated';
//            }
//        }

        $this->db->update('request', $postData, "`req_id` = {$rid}");
    }

}
