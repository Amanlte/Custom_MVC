<?php

/**
 * Description of cases_model
 *
 * @author ISMD
 */
class Cases_Model extends Model {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll($data) {
        return $this->db->select('SELECT * FROM cases WHERE case_area =:area AND deleted = :isDeleted', array(':area' => $data['user_team'], ':isDeleted' => 0));
    }

    public function _getAllTables() {
        return $this->db->select('SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE=:tableType AND TABLE_SCHEMA=:db', array(':tableType' => 'BASE TABLE', ':db' => 'nbe'));
    }

    public function _selectAllAdditonal($data) {
        return $this->db->select('SELECT *, (SELECT user_full_name FROM users WHERE user_id = solutions.user_id) AS addedBY FROM solutions WHERE  deleted = :isDeleted', array(':isDeleted' => 0));
    }

//    public function _selectAllAdditonal($data) {
//        return $this->db->select('SELECT *, (SELECT user_full_name FROM users WHERE user_id = solutions.user_id) AS addedBY FROM solutions '
//                        . 'WHERE  case_id IN '
//                . '(SELECT * FROM cases WHERE case_id =:case_id) AND deleted = :isDeleted', array(':case_id' => $data['id'], ':isDeleted' => 0));
//    }

    public function _selectCaseId($data) {
        $result = $this->db->select('SELECT case_id FROM cases WHERE case_area =:area ORDER BY case_id DESC LIMIT 1', array(':area' => $data['user_team']));
        if ($result) {
            return $result;
        } else {
            Session::set('casAuto', true);
        }
    }

    public function _selectAllTea() {
        return $this->db->select('SELECT team_id, team_name FROM team WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertCas($data) {
        $result = $this->db->select('SELECT case_name FROM cases WHERE case_name = :cas AND deleted = :isDeleted', array(':cas' => $data['case_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('casError', true);
        } else {
            $this->db->insert('cases', array(
                'case_id' => $data['case_id'],
                'case_area' => $data['case_area'],
                'case_type' => $data['case_type'],
                'case_name' => $data['case_name'],
                'case_details' => $data['case_details'],
                'case_solution_name' => $data['solution_name'],
                'case_solution_details' => $data['solution_details'],
                'case_reg_date' => $data['case_reg_date'],
                'case_reg_by' => $data['case_reg_by']
            ));
            Session::set('casSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT case_id, case_name,case_solution_name FROM cases WHERE case_id = :casid AND deleted = :isDeleted', array(':casid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT case_name, case_solution_name FROM cases WHERE case_id = :id', array(':id' => $data['case_id']));
        if ($data['case_name'] == $isThareChange[0]['case_name'] && $data['case_solution_name'] == $isThareChange[0]['case_solution_name']) {
            Session::set('casError', true);
            return false;
        } else {
            $postData = array(
                'case_name' => $data['case_name'],
                'case_solution_name' => $data['case_solution_name']
            );

            $this->db->update('cases', $postData, "`case_id` = '{$data['case_id']}'");
            Session::set('casSuccess', true);
        }
    }

    public function _delete($id) {

        $deleteData = array('deleted' => 1);
        $this->db->delete('cases', $deleteData, "`case_id` = '" . $id . "'");
    }

}
