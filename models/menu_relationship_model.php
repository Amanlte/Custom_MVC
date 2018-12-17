
<?php

class Menu_relationship_model extends Model {

    //put your code here

    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _getSubMenuName() {
        return $this->db->select('SELECT sub_menu_id, sub_menu_name FROM sub_menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _getAllMenuId() {
        return $this->db->select('SELECT menu_id, menu_name FROM menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

      public function _selectAllSubMenu() {
        return $this->db->select('SELECT * FROM sub_menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllMenu() {
        return $this->db->select('SELECT * FROM menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    /*     public function _selectAllRole() {
      return $this->db->select('SELECT * FROM role where role_id = '.$id.'');
      } */
//WHAT IS THIS
    /*
    public function _selectAllRF() {
        //return $this->db->select('SELECT * FROM role_functionality, role, functionality WHERE role_functionality.role_id = role.role_id AND role_functionality.fun_id = functionality.func_id');
        return $result = $this->db->select('SELECT * '
                . ' FROM role '
                . ' JOIN role_functionality ON role_functionality.role_id = role.role_id AND role_functionality.deleted = :isDeleted', array(':isDeleted' => 0));
    } */

    public function _getAllMenuRelationshipId() {
        return $this->db->select('SELECT sub_menu_id, sub_menu_name FROM sub_menu WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }
    //NO NEED OF INSERTION
/*
    public function _insertMenuReltionship($data) {
        $result = $this->db->select('SELECT menu_id FROM r_functionality WHERE role_id = :rol AND deleted = :isDeleted', array(':rol' => $data['role_name'], ':isDeleted' => 0));
        if ($result) {
            Session::set('rfError', true);
        } else {
            $this->db->insert('role_functionality', array(
                'role_id' => $data['role_name'],
                'fun_id' => $data['func_name'],
                'rf_reg_date' => $data['reg_date'],
                'rf_reg_by' => $data['reg_by']
            ));
            Session::set('rfSuccess', true);
        }
    } 

    public function _edit($id) {
        return $this->db->select('SELECT role_functionality.role_id, role_functionality.fun_id, rf_id, func_name FROM role_functionality, functionality WHERE rf_id = :rfid and functionality.func_id = role_functionality.fun_id AND role_functionality.deleted = :isDeleted', array(':rfid' => $id, ':isDeleted' => 0));
    }

    public function _editSave($data) {
        $isThareChange = $this->db->select('SELECT fun_id FROM role_functionality WHERE rf_id = :id', array(':id' => $data['func_id']));
        if ($data['fun_id'] == $isThareChange[0]['fun_id']) {
            Session::set('rfError', true);
            return false;
        } else {
            $postData = array(
                'fun_id' => $data['fun_id']
            );

            $this->db->update('role_functionality', $postData, "`rf_id` = {$data['func_id']}");
            Session::set('rfSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('role_functionality', $deleteData, "`rf_id` = '" . $id . "'");
    } */

}


