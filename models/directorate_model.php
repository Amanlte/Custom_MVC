<?php

/**
 * Description of directorate_model
 *
 * @author ISMD
 */
class Directorate_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM directorate WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _edit($id) {
        return $this->db->select('SELECT dir_id, dir_name FROM directorate WHERE dir_id = :dirid AND deleted = :isDeleted', array(':dirid' => $id, ':isDeleted' => 0));
    }

    public function _insertDir($data) {
        $result = $this->db->select('SELECT dir_name FROM directorate WHERE dir_name = :dir AND deleted = :isDeleted', array(':dir' => $data['dir_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('dirError', true);
        } else {
            $this->db->insert('directorate', array(
                'dir_name' => $data['dir_name'],
                'reg_date' => $data['reg_date'],
                'reg_by' => $data['reg_by']
            ));
            Session::set('dirSuccess', true);
        }
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT dir_name FROM directorate WHERE dir_id = :id AND deleted = :isDeleted', array(':id' => $data['dir_id'], ':isDeleted' => 0));
        if ($data['dir_name'] == $isThareChange[0]['dir_name']) {
            Session::set('dirError', true);
            return false;
        } else {
            $postData = array(
                'dir_name' => $data['dir_name']
            );

            $this->db->update('directorate', $postData, "`dir_id` = {$data['dir_id']}");
            Session::set('dirSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('directorate', $deleteData, "`dir_id` = '" . $id . "'");
    }

}
