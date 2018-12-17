<?php

class Devices extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->title = 'New Device';
        $this->view->devLists = $this->model->_selectAllDevices();
        $this->view->userId = $this->model->_getAllUserID();
        $this->view->dtLists = $this->model->_selectAllDeviceType();
        $this->view->dmLists = $this->model->_selectAllDeviceModel();
        $this->view->dsLists = $this->model->_selectAllDeviceStatus();
        $this->view->dbLists = $this->model->_selectAllDeviceBrand();
        $this->view->render('devices/index');
    }

    public function selectUserId() {
        if (isset($_GET['term']) && $_GET['term'] != '') {
            $username = $_GET['term'];
            $this->view->user = $this->model->_selectUserId($username);
            $json = array();
            foreach ($this->view->user as $key => $value) {
                $json[] = array('value' => $value['user_id'], 'label' => $value['user_full_name']);
            }
            echo json_encode($json);
        } else {
            echo '';
        }
    }

    public function selectDeviceBrandId() {
        if ($_POST['dt']) {
            $dt = $_POST['dt'];
            $this->view->dt = $this->model->_selectDeviceBrandId($dt);
            echo '<option value="">Select Device Brand</option>';
            foreach ($this->view->dt as $key => $value) {
                echo '<option value="' . $value['db_id'] . '">' . $value['db_name'] . '</option>';
            }
            //echo json_encode($brand);
        }
    }
    public function selectDeviceModelId() {
        if ($_POST['dm']) {
            $dm = $_POST['dm'];
            $this->view->dm = $this->model->_selectDeviceModelId($dm);
            echo '<option value="">Select Device Model</option>';
            foreach ($this->view->dm as $key => $value) {
                echo '<option value="' . $value['dm_id'] . '">' . $value['dm_name'] . '</option>';
            }
            //echo json_encode($brand);
        }
    }
    
    public function viewDevices($id) {
        $this->view->viewDevice = $this->model->_viewDevices($id);
    }

    public function insertDev() {
        $data = array();

        $data['user_id'] = $_POST['user_name'];
        $data['dev_type'] = $_POST['device_type'];
        $data['dev_brand'] = $_POST['device_brand'];
        $data['dev_model'] = $_POST['device_model'];
        $data['dev_tag'] = $_POST['tag_number'];
        $data['dev_pc_hd'] = $_POST['hard_disk_size'];
        $data['dev_pc_ram'] = $_POST['ram_size'];
        $data['dev_remark'] = $_POST['remark'];
        $data['dev_status'] = $_POST['status'];
        $data['dev_reg_date'] = date('Y-m-d h:i:s');
        $data['dev_reg_by'] = Session::get('user_full_name');



        // @TODO: Do your error checking!

        $this->model->_insertDev($data);
        header('location: ' . URL . 'devices');
    }

    public function edit($id) {
        $this->view->title = 'Edit Devices';
        $this->view->devId = $this->model->_edit($id);
        $this->view->dtLists = $this->model->_selectAllDeviceType();
        $this->view->dsLists = $this->model->_selectAllDeviceType();
        $this->view->dbLists = $this->model->_selectAllDeviceBrand();        
        $this->view->dsLists = $this->model->_selectAllDeviceStatus();

        $this->view->render('devices/edit');
    }

    public function editSave($id) {
        $data = array();
        $data['dev_id'] = $id;
        $data['user_id'] = $_POST['user_name'];
        $data['dev_type'] = $_POST['device_type'];
        $data['dev_brand'] = $_POST['device_brand'];
        $data['dev_model'] = $_POST['device_model'];
        $data['dev_tag'] = $_POST['tag_number'];
        $data['dev_pc_hd'] = $_POST['hard_disk_size'];
        $data['dev_pc_ram'] = $_POST['ram_size'];
        $data['dev_remark'] = $_POST['remark'];
        $data['dev_status'] = $_POST['status'];

        // @TODO: Do your error checking!

        $this->model->_editSave($data);
        header('location: ' . URL . 'devices/edit/' . $id);
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'devices');
    }

}
