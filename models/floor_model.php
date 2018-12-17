<?php

/**
 * Description of directorate_model
 *
 * @author ISMD
 */
class Floor_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM floor WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _edit($id) {
        return $this->db->select('SELECT flr_id, flr_name FROM floor WHERE flr_id = :flrid AND deleted = :isDeleted', array(':flrid' => $id, ':isDeleted' => 0));
    }

    public function _insertFlr($data) {
        $result = $this->db->select('SELECT flr_name FROM floor WHERE flr_name = :flr AND deleted = :isDeleted', array(':flr' => $data['flr_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('flrError', true);
        } else {
            $this->db->insert('floor', array(
                'flr_name' => $data['flr_name'],
                'reg_date' => $data['reg_date'],
                'reg_by' => $data['reg_by']
            ));
            Session::set('flrSuccess', true);
        }
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT flr_name FROM floor WHERE flr_id = :id AND deleted = :isDeleted', array(':id' => $data['flr_id'], ':isDeleted' => 0));
        if ($data['flr_name'] == $isThareChange[0]['flr_name']) {
            Session::set('flrError', true);
            return false;
        } else {
            $postData = array(
                'flr_name' => $data['flr_name']
            );

            $this->db->update('floor', $postData, "`flr_id` = {$data['flr_id']}");
            Session::set('flrSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('floor', $deleteData, "`flr_id` = '" . $id . "'");
    }

}
