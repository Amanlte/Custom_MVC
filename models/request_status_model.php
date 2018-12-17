<?php

class Request_Status_Model extends Model {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _getHandler() {

        return $this->db->select("SELECT * "
                        . "FROM `request`"
                        . "WHERE req_id = :rid AND request.req_status = :status AND request.req_area = :area AND team.team_leader = :id AND request.deleted = :isDeleted", array(':rid' => $data['id'], ':status' => '0', ':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _recentRequest() {
        $id = Session::get('user_id');
        return $this->db->SELECT('SELECT *, '
                        . '(SELECT case_name FROM cases WHERE case_id = request.req_type) AS caseName,'
                        . '(SELECT stat_name FROM status WHERE stat_id = request.req_solution_status) AS status '
                        . 'FROM `request`  WHERE user_id  = ' . $id . ' AND request.req_status != 1 AND request.deleted = 0 ORDER BY req_time  DESC LIMIT 1 ', array(':isDeleted' => 0));
//                . ' ));
    }
    public function _viewHistory() {
        $id = Session::get('user_id');
        return $this->db->SELECT('SELECT *, '
                        . '(SELECT case_name FROM cases WHERE case_id = request.req_type) AS caseName,'
                        . '(SELECT stat_name FROM status WHERE stat_id = request.req_solution_status) AS status '
                        . 'FROM `request`  WHERE user_id  = ' . $id . ' AND request.req_status != 1 AND request.deleted = 0', array(':isDeleted' => 0));
//                . ' ));
    }

}
