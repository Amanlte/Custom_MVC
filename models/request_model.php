<?php

class Request_Model extends Model {

    public function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAllTea() {
        return $this->db->select('SELECT team_id, team_name FROM team WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _recentRequest() {
        $id = Session::get('user_id');
        return $this->db->SELECT('SELECT *, (SELECT case_name FROM cases WHERE case_id = req_type) AS userRequest '
                        . 'FROM `request`  WHERE user_id  = ' . $id . ' AND request.req_solution_status = 1 AND req_satisfaction_level = 0 AND request.deleted = 0 ORDER BY req_time  DESC LIMIT 1');
    }

    public function _selectAllCas() {
        return $this->db->select('SELECT case_id, case_name FROM cases WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertReq($data) {
        try {

            $area = $data['req_area'];
            $type = $data['req_type'];
            $id = $data['user_id'];
            $result = $this->db->select('SELECT * FROM `request` '
                    . 'where DATE_SUB(DATE_FORMAT(NOW(), "%Y-%m-%d %r"),INTERVAL 20 MINUTE) <= `req_time` '
                    . 'AND req_area =:area AND req_type = :type AND user_id = :id AND deleted = :isDeleted', array(':isDeleted' => 0, ':type' => $type, ':id' => $id, ':area' => $area));
//             `req_area` = 1 AND `req_type` = \'NBE-NWS-04\' AND `deleted` = 0

            if ($result) {
                Session::set('reqError', true);
            } else {
                $this->db->insert('request', array(
                    'user_id' => $data['user_id'],
                    'req_area' => $data['req_area'],
                    'req_type' => $data['req_type'],
                    'req_details' => $data['req_details'],
                    'req_time' => $data['req_time'],
                    'req_last_update' => date('Y-m-d h:i:s'),
                    'req_solution_status' => '13',
                    'req_status' => '0'
                ));
                Session::set('reqSuccess', true);
            }
        } catch (PDOException $ex) {
            Session::set('reqError', true);
            Session::set('pdoError', 'Your request could not be processed this time. To send your request use the telephone line <strong>5260</strong>.' . $ex->getMessage());
            $error = "\r\n========================Error======================== \r\n\r\n[" . date('d-M-Y h:i:s') . ']  [ ErrorCode :' . $ex->getCode() . '] ' . $ex->getTraceAsString() .
                    " : \r\n\r\n ==>Error Message : " . $ex->getMessage() . "\r\n ======================== End ========================";
            ErrorLogger::add($error);
        }
    }

    public function _sendFeedback($data) {
        $rid = isset($data['rid']) ? $data['rid'] : '';
        $postData = array(
            'req_satisfaction_level' => isset($data['feedback']) ? $data['feedback'] : '',
            'req_comment' => isset($data['detail_feedback']) ? $data['detail_feedback'] : ''
        );


        $this->db->update('request', $postData, "`req_id` ={$rid}");
    }

    public function _selectCaseId($dt) {
        return $this->db->select('SELECT case_id, case_name FROM cases WHERE case_area = :id AND deleted = :isDeleted', array(':id' => $dt, ':isDeleted' => 0));
    }

}
