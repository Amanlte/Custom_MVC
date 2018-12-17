<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Devices_Model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _getAllUserID() {
        return $this->db->select('SELECT user_id, user_full_name FROM users WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectUserId($user_name) {
        return $this->db->select('SELECT user_id, user_full_name FROM users WHERE user_full_name LIKE :user_name AND deleted = :isDeleted', array(':user_name' => '%' . $user_name . '%', ':isDeleted' => 0));
    }

    public function _selectAllDevices() {
        return $this->db->select('SELECT * FROM devices, users where users.user_id = devices.user_id AND devices.deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllDeviceType() {
        return $this->db->select('SELECT dt_id, dt_name FROM device_type WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }
    public function _selectAllDeviceModel() {
        return $this->db->select('SELECT dm_id, dm_name FROM device_model WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllDeviceStatus() {
        return $this->db->select('SELECT stat_id, stat_name FROM status where stat_for = "devices" and deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectDeviceBrandId($dt) {
        return $this->db->select('SELECT db_id, db_name FROM device_brand WHERE dt_id = :id AND deleted = :isDeleted', array(':id' => $dt, ':isDeleted' => 0));
    }
    public function _selectDeviceModelId($dm) {
        return $this->db->select('SELECT dm_id, dm_name FROM device_model WHERE db_id = :id AND deleted = :isDeleted', array(':id' => $dm, ':isDeleted' => 0));
    }

    public function _selectAllDeviceBrand() {
        return $this->db->select("SELECT db_id, db_name FROM device_brand WHERE deleted = :isDeleted", array(':isDeleted' => 0));
    }

    public function _insertDev($data) {
        $result = $this->db->select('SELECT dev_tag FROM devices WHERE dev_tag = :dev AND deleted = :isDeleted', array(':dev' => $data['dev_tag'], ':isDeleted' => 0));
        if ($result) {
            Session::set('devError', true);
        } else {
            $this->db->insert('devices', array(
                'user_id' => $data['user_id'],
                'dev_type' => $data['dev_type'],
                'dev_brand' => $data['dev_brand'],
                'dev_model' => $data['dev_model'],
                'dev_tag' => $data['dev_tag'],
                'dev_pc_hd' => $data['dev_pc_hd'],
                'dev_pc_ram' => $data['dev_pc_ram'],
                'dev_remark' => $data['dev_remark'],
                'dev_status' => $data['dev_status'],
                'dev_reg_date' => $data['dev_reg_date'],
                'dev_reg_by' => $data['dev_reg_by']
            ));
            Session::set('devSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT * FROM devices WHERE dev_id = :devid', array(':devid' => $id));
    }
    
    public function _viewDevices($id) {
        return $this->db->select('SELECT * FROM devices WHERE dev_id = :devid', array(':devid' => $id));
    }

    public function _editSave($data) {
        $isThereChange = $this->db->select('SELECT * FROM devices WHERE dev_id = :id', array(':id' => $data['dev_id']));
        if (($data['dev_tag'] == $isThereChange[0]['dev_tag']) 
                && ($data['user_id'] == $isThereChange[0]['user_id'])
                && ($data['dev_type'] == $isThereChange[0]['dev_type']) 
                && ($data['dev_brand'] == $isThereChange[0]['dev_brand'])
                && ($data['dev_model'] == $isThereChange[0]['dev_model'])
                && ($data['dev_pc_hd'] == $isThereChange[0]['dev_pc_hd'])
                && ($data['dev_pc_ram'] == $isThereChange[0]['dev_pc_ram'])
                && ($data['dev_status'] == $isThereChange[0]['dev_status'])
                && ($data['dev_remark'] == $isThereChange[0]['dev_remark'])) {
            Session::set('devError', true);
            return false;
        } else {
            $postData = array(
                'user_id' => $data['user_id'],
                'dev_type' => $data['dev_type'],
                'dev_brand' => $data['dev_brand'],
                'dev_model' => $data['dev_model'],
                'dev_tag' => $data['dev_tag'],
                'dev_pc_hd' => $data['dev_pc_hd'],
                'dev_pc_ram' => $data['dev_pc_ram'],
                'dev_remark' => $data['dev_remark'],
                'dev_status' => $data['dev_status']
            );

            $this->db->update('devices', $postData, "`dev_id` = {$data['dev_id']}");
            Session::set('devSuccess', true);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('devices', $deleteData, "`dev_id` = '" . $id . "'");
    }

}
