<?php

/**
 * Description of menu_model
 *
 * @author ISMD
 */
class Sub_Menu_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM sub_menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllFunc() {
        return $this->db->select('SELECT * FROM functionality WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllPages() {
        return $this->db->select('SELECT page_id,fun_id FROM page WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertSubMenu($data) {
        $result = $this->db->select('SELECT sub_menu_name FROM sub_menu WHERE sub_menu_name = :smenu AND deleted = :isDeleted', array(':smenu' => $data['sub_menu_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('smError', true);
        } else {
            $this->db->insert('sub_menu', array(
                'sub_menu_name' => $data['sub_menu_name'],
                'functionalities_id' => $data['functionalities_id'],
                'reg_date' => $data['reg_date'],
                'reg_by' => $data['reg_by']
            ));
            Session::set('smSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT sub_menu_id, sub_menu_name, functionalities_id FROM sub_menu WHERE sub_menu_id = :menuid AND deleted = :isDeleted', array(':menuid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT sub_menu_name,functionalities_id FROM sub_menu WHERE sub_menu_id = :id AND deleted = :isDeleted', array(':id' => $data['sub_menu_id'], ':isDeleted' => 0));
        if ($data['sub_menu_name'] == $isThareChange[0]['sub_menu_name'] && $data['functionalities_id'] == $isThareChange[0]['functionalities_id']) {
            Session::set('smError', true);
            return false;
        } else {
            $postData = array(
                'sub_menu_name' => $data['sub_menu_name'],
                'functionalities_id' => $data['functionalities_id']
            );

            $this->db->update('sub_menu', $postData, "`sub_menu_id` = {$data['sub_menu_id']}");
            Session::set('smSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('sub_menu', $deleteData, "`sub_menu_id` = '" . $id . "'");
    }

}
