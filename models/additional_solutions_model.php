<?php

class Additional_Solutions_Model extends Model {

    public function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll($data) {
        return $this->db->select('SELECT *,'
                        . "(SELECT case_name FROM cases where case_id = solutions.case_id) AS caseName "
                        . ' FROM solutions WHERE user_id =:user AND deleted = :isDeleted', array(':user' => $data['user_id'], ':isDeleted' => 0));
    }

    public function _selectAllCase($data) {
        return $this->db->select('SELECT * FROM cases WHERE case_area =:area AND deleted = :isDeleted', array(':area' => $data['user_team'], ':isDeleted' => 0));
    }

    public function _insertSol($data) {


        $isThareChange = $this->db->select('SELECT * FROM solutions WHERE case_id = :id AND user_id =:uid AND deleted = :isDeleted', array(':uid' => $data['user_id'], ':id' => $data['case_id'], ':isDeleted' => 0));
        if ($data['case_id'] == $isThareChange[0]['case_id']) {
            Session::set('solError', true);
            return false;
        } else {
            $this->db->insert('solutions', array(
                'case_id' => $data['case_id'],
                'user_id' => $data['user_id'],
                'additional_solution' => $data['additional_solution'],
                'sol_date' => $data['sol_date']
            ));
            Session::set('solSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT sol_id, additional_solution FROM solutions WHERE sol_id = :solid and deleted = :isDeleted', array(':solid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {

        $isThareChange = $this->db->select('SELECT additional_solution FROM solutions WHERE sol_id = :id and deleted = :isDeleted', array(':id' => $data['sol_id'], ':isDeleted' => 0));
        if ($data['additional_solution'] == $isThareChange[0]['additional_solution']) {
            Session::set('solError', true);
            return false;
        } else {
            $postData = array(
                'additional_solution' => $data['additional_solution']
            );

            $this->db->update('solutions', $postData, "`sol_id` = {$data['sol_id']}");
            Session::set('solSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('solutions', $deleteData, "`sol_id` = '" . $id . "'");
    }

}
