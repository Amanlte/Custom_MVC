<?php

class Page_model extends Model {

    //put your code here

    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _getAllMenu($id) {
        return $this->db->select('SELECT menu_name, page FROM menu WHERE menu_id = :mid AND deleted = :isDeleted', array(':mid' => $id, ':isDeleted' => 0));
    }

    public function _getAllFuncId() {
        return $this->db->select('SELECT func_id, func_name FROM functionality WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllMenu() {
        return $this->db->select('SELECT * FROM menu, functionality WHERE menu.menu_id = functionality.func_id and menu.deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllFunc() {
        return $this->db->select('SELECT * FROM functionality WHERE assign_page = :isPage AND deleted = :isDeleted', array(':isPage' => 1, ':isDeleted' => 0));
    }

    public function _selectAllPages() {
        return $this->db->select('SELECT * FROM page WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAll() {
        //return $this->db->select('SELECT * FROM menu, role, functionality WHERE menu.role_id = role.role_id AND menu.menu_id = functionality.func_id');
        return $result = $this->db->select('SELECT * from menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }
    public function _selectAllFunctionalities() {
        //return $this->db->select('SELECT * FROM menu, role, functionality WHERE menu.role_id = role.role_id AND menu.menu_id = functionality.func_id');
        return $result = $this->db->select('SELECT func_id, func_name from functionality WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _getAllFunMenuId() {
        return $this->db->select('SELECT menu_id, menu_name FROM menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertPage($data) {
        $result = $this->db->select('SELECT page_id, fun_id FROM page WHERE page_id = :pg AND deleted = :isDeleted', array(':pg' => $data['func_id'], ':isDeleted' => 0));
        if ($result) {
            Session::set('fpError', true);
        } else { 
            $this->db->insert('page', array(
                'fun_id' => $data['func_id'],
                'page' => $data['page'],
                'reg_date' => $data['reg_date'],
                'reg_by' => $data['reg_by']
            ));
            Session::set('fpSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT * FROM page, functionality WHERE page_id = :id AND page.deleted = :isDeleted', array(':id' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT * FROM page WHERE page_id = :id AND deleted = :isDeleted', array(':id' => $data['page_id'], ':isDeleted' => 0));
        if ($data['func_id'] == $isThareChange[0]['func_id'] && $data['page'] == $isThareChange[0]['page']) {
            Session::set('fpError', true);
            return false;
        } else {
            $postData = array(
                'page' => $data['page'],
                'reg_date' => $data['reg_date'],
                'reg_by' => $data['reg_by']
            );

            $this->db->update('page', $postData, "`page_id` = {$data['page_id']}");
            Session::set('fpSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('page', $deleteData, "`page_id` = '" . $id . "'");
    }

}
