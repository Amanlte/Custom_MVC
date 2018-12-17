<?php

/**
 * Description of directorate_model
 *
 * @author ISMD
 */
class Roles_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM role WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertRole($data) {

        $result = $this->db->select('SELECT role_name FROM role WHERE role_name = :role AND deleted = :isDeleted', array(':role' => $data['role_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('rolError', true);
        } else {
            $this->db->insert('role', array(
                'role_name' => $data['role_name'],
                'role_reg_date' => $data['reg_date'],
                'role_reg_by' => $data['reg_by']
            ));
            Session::set('rolSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT role_id, role_name FROM role WHERE role_id = :roleid AND deleted = :isDeleted', array(':roleid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {

        $isThareChange = $this->db->select('SELECT role_name FROM role WHERE role_id = :id AND deleted = :isDeleted', array(':id' => $data['role_id'], ':isDeleted' => 0));
        if ($data['role_name'] == $isThareChange[0]['role_name']) {
            Session::set('rolError', true);
            return false;
        } else {
            $postData = array(
                'role_name' => $data['role_name']
            );

            $this->db->update('role', $postData, "`role_id` = {$data['role_id']}");
            Session::set('rolSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('role', $deleteData, "`role_id` = '" . $id . "'");
    }

}
