<?php

/**
 * Description of dfevice_type_model
 *
 * @author ISMD
 */
class device_type_model extends Model {

    //put your code here
    function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _selectAll() {
        return $this->db->select('SELECT * FROM device_type WHERE deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _edit($id) {
        return $this->db->select('SELECT dt_id, dt_name FROM device_type WHERE dt_id = :dtid', array(':dtid' => $id) AND 'deleted = :isDeleted', array(':isDeleted' => 0));
    }

    public function _insertDt($data) {

        // try 
        {
            $result = $this->db->select('SELECT dt_name FROM device_type WHERE dt_name = :dt', array(':dt' => $data['dt_name']) AND 'deleted = :isDeleted', array(':isDeleted' => 0));
            if ($result) {
                Session::set('dtError', true);
            } else {
                $this->db->insert('device_type', array(
                    'dt_name' => $data['dt_name'],
                    'dt_reg_date' => $data['dt_reg_date'],
                    'dt_reg_by' => $data['dt_reg_by']
                ));
                Session::set('dtSuccess', true);
            }
        }
    }

    public function _editSave($data) {
        try {
            $isThareChange = $this->db->select('SELECT dt_name FROM device_type WHERE dt_id = :id', array(':id' => $data['dt_id']));
            if ($data['dt_name'] == $isThareChange[0]['dt_name']) {
                Session::set('dtError', true);
                return false;
            } else {
                $postData = array(
                    'dt_name' => $data['dt_name']
                );

                $this->db->update('device_type', $postData, "`dt_id` = {$data['dt_id']}");
                Session::set('dtSuccess', true);
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
        $this->db->delete('device_type', $deleteData, "`ds_id` = '" . $id . "'");
    }

}
