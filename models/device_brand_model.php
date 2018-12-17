    <?php

    /**
     * Description of dfevice_type_model
     *
     * @author ISMD
     */
    class device_brand_model extends Model {

        //put your code here
        function __construct() {
            parent::__construct();
            Session::init();
        }

        public function _selectAllDeviceBrand() {
            return $this->db->select('SELECT * FROM device_brand, device_type WHERE device_brand.dt_id=device_type.dt_id AND device_brand.deleted = :isDeleted', array(':isDeleted' => 0));
        }
        public function _selectAllDeviceType(){
            return $this->db->select('SELECT dt_id, dt_name FROM device_type WHERE deleted = :isDeleted', array(':isDeleted' => 0));
        }

        public function _insertDb($data) {

            //try
            {
                $result = $this->db->select('SELECT db_name, dt_id FROM device_brand WHERE db_name = :db AND dt_id = :dt AND deleted = :isDeleted', array(':db' => $data['db_name'], ':dt' => $data['dt_id'], ':isDeleted' => 0));
                if ($result) {
                    Session::set('dbError', true);
                } else {
                    $this->db->insert('device_brand', array(
                        'dt_id' => $data['dt_id'],
                        'db_name' => $data['db_name'],
                        'db_reg_date' => $data['db_reg_date'],
                        'db_reg_by' => $data['db_reg_by']
                    ));
                    Session::set('dbSuccess', true);
                }
            }
        }

         public function _edit($id) {
            return $this->db->select('SELECT db_id, db_name, dt_id FROM device_brand WHERE db_id = :dbid', array(':dbid' => $id));
        }


        public function _editSave($data) {
            try {
            $isThereChange = $this->db->select('SELECT * FROM device_brand WHERE deleted = :isDeleted', array(':isDeleted' => 0));
            if (($data['dt_id'] == $isThereChange[0]['dt_id']) && ($data['db_name'] == $isThereChange[0]['db_name'])) {
                Session::set('dbError', true);
                return false;
            }  else {
                $postData = array(
                    'dt_id' => $data['dt_id'],
                    'db_name' => $data['db_name']
                );

                $this->db->update('device_brand', $postData, "`db_id` = {$data['db_id']}");
                Session::set('dbSuccess', true);
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
            $this->db->delete('device_brand', $deleteData, "`db_id` = '".$id."'");
        }
    }