<?php

/**
 * Description of directorate_model
 *
 * @author ISMD
 */
class Functionalities_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM functionality WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _getAllRoleID() {
        return $this->db->select('SELECT role_id, role_name FROM role WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertFunc($data) {
        $result = $this->db->select('SELECT func_name FROM functionality WHERE func_name = :func AND deleted = :isDeleted', array(':func' => $data['func_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('funcError', true);
        } else {
            $this->db->insert('functionality', array(
                'func_name' => $data['func_name'],
                'func_reg_date' => $data['reg_date'],
                'func_reg_by' => $data['reg_by']
            ));
            Session::set('funcSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT func_id, func_name FROM functionality WHERE func_id = :funcid AND deleted = :isDeleted', array(':funcid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT func_name FROM functionality WHERE func_id = :id AND deleted = :isDeleted', array(':id' => $data['func_id'], ':isDeleted' => 0));
        if ($data['func_name'] == $isThareChange[0]['func_name']) {
            Session::set('funcError', true);
            return false;
        } else {
            $postData = array(
                'func_name' => $data['func_name']
            );

            $this->db->update('functionality', $postData, "`func_id` = {$data['func_id']}");
            Session::set('funcSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('functionality', $deleteData, "`func_id` = '" . $id . "'");
    }

}
