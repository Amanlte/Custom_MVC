<?php

class Status_Model extends Model {

    public function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM status WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }
    
    public function _getAllTables() {
        return $this->db->select('SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE=:tableType AND TABLE_SCHEMA=:db', array(':tableType' => 'BASE TABLE', ':db' => 'nbe'));
    }

    public function _insertSta($data) {

        $result = $this->db->select('SELECT stat_name FROM status WHERE stat_name = :stat AND deleted = :isDeleted', array(':stat' => $data['stat_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('staError', true);
        } else {
            $this->db->insert('status', array(
                'stat_name' => $data['stat_name'],
                'stat_for' => $data['stat_for'],
                'stat_reg_date' => $data['stat_reg_date'],
                'stat_reg_by' => $data['stat_reg_by']
            ));
            Session::set('staSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT stat_id, stat_name,stat_for FROM status WHERE stat_id = :statid AND deleted = :isDeleted', array(':statid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {

        $isThareChange = $this->db->select('SELECT stat_name, stat_for FROM status WHERE stat_id = :id AND deleted = :isDeleted', array(':id' => $data['stat_id'], ':isDeleted' => 0));
        if ($data['stat_name'] == $isThareChange[0]['stat_name'] && $data['stat_for'] == $isThareChange[0]['stat_for']) {
            Session::set('staError', true);
            return false;
        } else {
            $postData = array(
                'stat_name' => $data['stat_name'],
                'stat_for' => $data['stat_for']
            );

            $this->db->update('status', $postData, "`stat_id` = {$data['stat_id']}");
            Session::set('staSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('status', $deleteData, "`stat_id` = '" . $id . "'");
    }

}
