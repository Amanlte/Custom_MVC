<?php

/**
 * Description of dfevice_type_model
 *
 * @author ISMD
 */
class device_models_model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAllDeviceType() {
        return $this->db->select('SELECT * FROM device_type WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }
    public function _selectAllDeviceBrand() {
        return $this->db->select("SELECT db_id, db_name FROM device_brand WHERE deleted = :isDeleted", array(':isDeleted' => 0));
    }
    public function _selectDeviceBrandId($dt) {
        return $this->db->select('SELECT db_id, db_name FROM device_brand WHERE dt_id = :id AND deleted = :isDeleted', array(':id' => $dt, ':isDeleted' => 0));
    }

//    public function _selectAllDeviceBrand() {
//        return $this->db->select('SELECT * FROM `device_brand` WHERE `deleted` =0 GROUP BY(`db_name`)');
//    }

    public function _selectAllDeviceBrand1() {
        return $this->db->select('SELECT * FROM device_brand, device_type WHERE device_brand.dt_id=device_type.dt_id AND device_brand.deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _selectAllDeviceModel() {
        return $this->db->select('SELECT *, (SELECT dt_name FROM device_type WHERE device_type.dt_id = device_model.dt_id) AS dtName FROM device_brand, device_model WHERE device_brand.db_id=device_model.db_id AND device_model.deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertDb($data) {

        $result = $this->db->select('SELECT dm_name, db_id, dt_id FROM device_model WHERE dt_id = :dt AND dm_name = :dm AND db_id =:db AND deleted =:isDeleted', array(':dm' => $data['dm_name'], ':dt' => $data['dt_id'], ':db' => $data['db_id'], ':isDeleted' => 0));
        if ($result) {
            Session::set('dmError', true);
        } else {
            $this->db->insert('device_model', array(
                'dt_id' => $data['dt_id'],
                'db_id' => $data['db_id'],
                'dm_name' => $data['dm_name'],
                'dm_reg_date' => $data['dm_reg_date'],
                'dm_reg_by' => $data['dm_reg_by']
            ));
            Session::set('dmSuccess', true);
        }
    }

    public function _edit($id) {
        return $this->db->select('SELECT dm_id, dm_name, db_id, dt_id, '
                        . '(SELECT dt_name FROM device_type WHERE device_type.dt_id = device_model.dt_id) AS dtName '
                        . 'FROM device_model WHERE dm_id = :dmid', array(':dmid' => $id));
    }

    public function _editSave($data) {
        try {
            $isThereChange = $this->db->select('SELECT * FROM device_model WHERE deleted = :isDeleted', array(':isDeleted' => 0));
            if (($data['db_id'] == $isThereChange[0]['db_id']) && ($data['dt_id'] == $isThereChange[0]['dt_id']) && ($data['dm_name'] == $isThereChange[0]['dm_name'])) {
                Session::set('dmError', true);
                return false;
            } else {
                $postData = array(
                    'dt_id' => $data['dt_id'],
                    'db_id' => $data['db_id'],
                    'dm_name' => $data['dm_name']
                );

                $this->db->update('device_model', $postData, "`dm_id` = {$data['dm_id']}");
                Session::set('dmSuccess', true);
            }
        } catch (PDOException $ex) {
            Session::set('pdoError', $ex->getMessage() . ". For more details check pdo_error_logs file!");
            $error = "\r\n========================Error on Update======================== \r\n\r\n[" . date('d-M-Y h:i:s') . ']  [ ErrorCode :' . $ex->getCode() . '] ' . $ex->getTraceAsString() .
                    " : \r\n\r\n ==>Error Message : " . $ex->getMessage() . "\r\n ======================== End ========================";
            ErrorLogger::add($error);
        }
    }

    public function _delete($id) {
        $deleteData = array('deleted' => 1);
        $this->db->delete('device_model', $deleteData, "`dm_id` = '" . $id . "'");
    }

}
