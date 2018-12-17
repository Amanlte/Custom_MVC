<?php

class Team_Model extends Model {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM team, directorate where team.dir_id=directorate.dir_id and team.deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectUserId($user_name) {
        return $this->db->select('SELECT user_id, user_full_name FROM users WHERE user_full_name LIKE :user_name AND deleted = :isDeleted', array(':user_name' => '%' . $user_name . '%', ':isDeleted' => 0));
    }

    public function _selectAllDir() {
        return $this->db->select('SELECT dir_id, dir_name FROM directorate WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _currentLeader($user_id) {
        return $this->db->select('SELECT user_full_name FROM users WHERE user_id = :user_id AND deleted = :isDeleted', array(':user_id' => $user_id, ':isDeleted' => 0));
    }

    public function _insertTea($data) {
        $result = $this->db->select('SELECT team_name FROM team WHERE team_name = :tname AND deleted = :isDeleted', array(':tname' => $data['team_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('teaError', true);
        } else {
            $this->db->insert('team', array(
                'dir_id' => $data['dir_id'],
                'team_name' => $data['team_name'],
                'team_leader' => $data['team_leader'],
                'team_reg_date' => $data['team_reg_date'],
                'team_reg_by' => $data['team_reg_by']
            ));
            Session::set('teaSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT * FROM team WHERE team_id = :teamid AND deleted = :isDeleted', array(':teamid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {

        $isThareChange = $this->db->select('SELECT team_name, team_leader FROM team WHERE team_id = :id AND deleted = :isDeleted', array(':id' => $data['team_id'], ':isDeleted' => 0));
        if (($data['team_name'] == $isThareChange[0]['team_name']) && ($data['team_leader'] == $isThareChange[0]['team_leader'])) {
            Session::set('teaError', true);
            return false;
        } else {
            $postData = array(
                'team_name' => $data['team_name'],
                'team_leader' => $data['team_leader'],
            );

            $this->db->update('team', $postData, "`team_id` = {$data['team_id']}");
            Session::set('teaSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('team', $deleteData, "`team_id` = '" . $id . "'");
    }

}
