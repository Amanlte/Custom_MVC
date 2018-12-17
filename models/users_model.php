<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM users WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectDetails() {
        return $this->db->select('SELECT * FROM users, team, directorate,role WHERE users.user_role = role.role_id and users.user_team=team.team_id and directorate.dir_id=users.user_directorate and users.deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectUserDetails() {
        return $this->db->select('SELECT *, (select bui_name from building where bui_id = users.user_building) as building,'
                        . '(select flr_name from floor where flr_id = users.user_floor) as floor,'
                        . '(select dir_name from directorate where dir_id = users.user_directorate) as directorate,'
                        . '(select pos_name from position where pos_id = users.user_position) as position,'
                        . '(select role_name from role where role_id = users.user_role) as role'
                        . ' FROM users WHERE users.deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllBuilding() {
        return $this->db->select('SELECT * FROM building WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllFloor() {
        return $this->db->select('SELECT * FROM floor WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllPostion() {
        return $this->db->select('SELECT * FROM position WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllDir() {
        return $this->db->select('SELECT dir_id, dir_name FROM directorate WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllTea() {
        return $this->db->select('SELECT team_id,team_name FROM team WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllRol() {
        return $this->db->select('SELECT role_id,role_name FROM role WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertUsers($data) {

        $result = $this->db->select('SELECT user_login_name FROM users WHERE user_login_name = :users AND deleted = :isDeleted', array(':users' => $data['user_login_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('userError', true);
        } else {
            $this->db->insert('users', array(
                'user_full_name' => $data['user_full_name'],
                'user_building' => $data['user_building'],
                'user_floor' => $data['user_floor'],
                'user_directorate' => $data['user_directorate'],
                'user_team' => $data['user_team'],
                'user_position' => $data['user_position'],
                'user_login_name' => $data['user_login_name'],
                'user_password' => Hash::create('sha256', $data['user_password'], HASH_PASSWORD_KEY),
                'first_login' => '0',
                'user_phone' => $data['user_phone'],
                'user_email' => $data['user_email'],
                'user_role' => $data['user_role'],
                'user_reg_date' => $data['user_reg_date'],
                'user_reg_by' => $data['user_reg_by']
            ));
            Session::set('usersSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT * FROM users WHERE user_id = :useid AND deleted = :isDeleted', array(':useid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {

        $isThereChange = $this->db->select('SELECT * FROM users WHERE user_id = :id', array(':id' => $data['user_id']));
        if (($data['user_full_name'] == $isThereChange[0]['user_full_name'] && $data['user_building'] == $isThereChange[0]['user_building']) && ($data['user_floor'] == $isThereChange[0]['user_floor'] && $data['user_directorate'] == $isThereChange[0]['user_directorate']) && ($data['user_team'] == $isThereChange[0]['user_team'] && $data['user_position'] == $isThereChange[0]['user_position']) && ($data['user_phone'] == $isThereChange[0]['user_phone'] && $data['user_email'] == $isThereChange[0]['user_email']) && ($data['user_role'] == $isThereChange[0]['user_role'] && $data['user_status'] == $isThereChange[0]['user_status'])) {
            Session::set('userError', true);
            return false;
        } else {
            $postData = array(
                'user_full_name' => $data['user_full_name'],
                'user_building' => $data['user_building'],
                'user_floor' => $data['user_floor'],
                'user_directorate' => $data['user_directorate'],
                'user_team' => $data['user_team'],
                'user_position' => $data['user_position'],
                'user_login_name' => $data['user_login_name'],
                'user_phone' => $data['user_phone'],
                'user_email' => $data['user_email'],
                'user_role' => $data['user_role']
            );

            $this->db->update('users', $postData, "`user_id` = {$data['user_id']}");
            Session::set('userSuccess', true);
        }
    }

    public function _selectTeamByDir($dir) {
        return $this->db->select('SELECT team_id, team_name, dir_id FROM team WHERE dir_id = :did AND deleted = :isDeleted', array(':did' => $dir, 'isDeleted' => 0));
    }

    public function _viewUserDetails($id) {
        return $this->db->select('SELECT *, (select bui_name from building where bui_id = users.user_building) as building,'
                        . '(select flr_name from floor where flr_name = users.user_floor) as floor, '
                        . '(select dir_name from directorate where dir_id = users.user_directorate) as directorate,'
                        . '(select pos_name from position where pos_id = users.user_position) as position,'
                        . '(select role_name from role where role_id = users.user_role) as role'
                        . ' FROM users WHERE user_id = :id AND users.deleted = :isDeleted', array(':id' => $id, ':isDeleted' => 0));
    }
//        public function _viewUser($id) {
//
//        return $this->db->select('SELECT *, (select bui_name from building where bui_id = users.user_building) as building,'
//                        . '(select flr_name from floor where flr_id = users.user_floor) as floor,'
//                        . '(select dir_name from directorate where dir_id = users.user_directorate) as directorate,'
//                        . '(select team_name from team where team_id = users.user_team) as team,'
//                        . '(select pos_name from position where pos_id = users.user_position) as position,'
//                        . '(select role_name from role where role_id = users.user_role) as role'
//                        . ' FROM users WHERE user_id = :id AND users.deleted = :isDeleted', array(':id' => $id, ':isDeleted' => 0));
//    }

    public function _viewDevice($id) {

        return $this->db->select('SELECT *, (SELECT dt_name FROM device_type WHERE dt_id = devices.dev_type) as device_name,'
                        . '(SELECT db_name FROM device_brand WHERE db_id = devices.dev_brand) as brand, '
                        . '(SELECT stat_name FROM status WHERE stat_id = devices.dev_status) as status, '
                        . '(SELECT db_name FROM device_brand WHERE db_id = devices.dev_brand) as model '
                        . 'FROM devices WHERE devices.user_id = :id', array(':id' => $id));
    }

    public function _viewRequest($id) {
        return $this->db->select('SELECT *, (SELECT case_name FROM cases WHERE case_id = request.req_type) as caseName,'
//                        . '(SELECT additional_solution FROM solutions WHERE solutions.req_id = request.req_id GROUP BY case_id) as addSolution, '
                        . '(SELECT stat_name FROM status WHERE stat_id = request.req_solution_status) as status, '
                        . '(SELECT user_full_name FROM users WHERE user_id = request.req_assigned_to) as handledBy '
                        . 'FROM `request` WHERE request.user_id = :id AND request.req_solution_status = :ss AND request.req_status = :rs AND request.deleted = :isDeleted', array(':id' => $id, ':ss' => 1, ':rs' => 1, ':isDeleted' => 0));
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('users', $deleteData, "`user_id` = '" . $id . "'");
    }

}
