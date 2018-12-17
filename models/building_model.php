<?php

/**
 * Description of building_model
 *
 * @author ISMD
 */
class Building_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM building WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _edit($id) {
        return $this->db->select('SELECT bui_id, bui_name FROM building WHERE bui_id = :buiid AND deleted = :isDeleted', array(':buiid' => $id, ':isDeleted' => 0));
    }

    public function _insertBui($data) {
        $result = $this->db->select('SELECT bui_name FROM building WHERE bui_name = :bui AND deleted = :isDeleted', array(':bui' => $data['bui_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('buiError', true);
        } else {
            $this->db->insert('building', array(
                'bui_name' => $data['bui_name'],
                'reg_date' => $data['reg_date'],
                'reg_by' => $data['reg_by']
            ));
            Session::set('buiSuccess', true);
        }
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT bui_name FROM building WHERE bui_id = :id AND deleted = :isDeleted', array(':id' => $data['bui_id'], ':isDeleted' => 0));
        if ($data['bui_name'] == $isThareChange[0]['bui_name']) {
            Session::set('buiError', true);
            return false;
        } else {
            $buitData = array(
                'bui_name' => $data['bui_name']
            );

            $this->db->update('building', $buitData, "`bui_id` = {$data['bui_id']}");
            Session::set('buiSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('building', $deleteData, "`bui_id` = '" . $id . "'");
    }

}
