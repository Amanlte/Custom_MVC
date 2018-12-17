<?php

/**
 * Description of position_model
 *
 * @author ISMD
 */
class Position_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM position WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _edit($id) {
        return $this->db->select('SELECT pos_id, pos_name FROM position WHERE pos_id = :posid AND deleted = :isDeleted', array(':posid' => $id, ':isDeleted' => 0));
    }

    public function _insertPos($data) {
        $result = $this->db->select('SELECT pos_name FROM position WHERE pos_name = :pos AND deleted = :isDeleted', array(':pos' => $data['pos_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('posError', true);
        } else {
            $this->db->insert('position', array(
                'pos_name' => $data['pos_name'],
                'reg_date' => $data['reg_date'],
                'reg_by' => $data['reg_by']
            ));
            Session::set('posSuccess', true);
        }
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT pos_name FROM position WHERE pos_id = :id AND deleted = :isDeleted', array(':id' => $data['pos_id'], ':isDeleted' => 0));
        if ($data['pos_name'] == $isThareChange[0]['pos_name']) {
            Session::set('posError', true);
            return false;
        } else {
            $postData = array(
                'pos_name' => $data['pos_name']
            );

            $this->db->update('position', $postData, "`pos_id` = {$data['pos_id']}");
            Session::set('posSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('position', $deleteData, "`pos_id` = '" . $id . "'");
    }

}
