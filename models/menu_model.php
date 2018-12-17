<?php

/**
 * Description of menu_model
 *
 * @author ISMD
 */
class Menu_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _getAllMenuId() {
        return $this->db->select('SELECT menu_id, main_menu_name FROM menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _getSubMenuName() {
        return $this->db->select('SELECT sub_menu_id, sub_menu_name FROM sub_menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertMenu($data) {
        $result = $this->db->select('SELECT main_menu_name FROM menu WHERE main_menu_name = :menu AND deleted = :isDeleted', array(':menu' => $data['main_menu_name'], ':isDeleted' => 0));
        $result2 = $this->db->prepare('SELECT COUNT(*) FROM menu WHERE main_menu_name = :menu AND deleted = :isDeleted');
        $result2->execute(array(':menu' => $data['main_menu_name'], ':isDeleted' => 0));
        $count = $result2->rowCount();
        if ($result) {
            Session::set('mmError', true);
        } else if ($count > 7) {
            Session::set('noOfMainMenu', true);
        } else {
            $this->db->insert('menu', array(
                'main_menu_name' => $data['main_menu_name'],
                'sub_menu_id' => $data['sub_menu_name'],
                'reg_date' => $data['reg_date'],
                'reg_by' => $data['reg_by']
            ));
            Session::set('mmSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT menu_id, main_menu_name, sub_menu_id FROM menu WHERE menu_id = :menuid AND deleted = :isDeleted', array(':menuid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT main_menu_name, sub_menu_id FROM menu WHERE menu_id = :id AND deleted = :isDeleted', array(':id' => $data['menu_id'], ':isDeleted' => 0));
        if ($data['main_menu_name'] == $isThareChange[0]['main_menu_name'] && $data['sub_menu_id'] == $isThareChange[0]['sub_menu_id']) {
            Session::set('mmError', true);
            return false;
        } else {
            $postData = array(
                'main_menu_name' => $data['main_menu_name'],
                'sub_menu_id' => $data['sub_menu_id']
            );

            $this->db->update('menu', $postData, "`menu_id` = {$data['menu_id']}");
            Session::set('mmSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('menu', $deleteData, "`menu_id` = '" . $id . "'");
    }

}
