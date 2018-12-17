<?php

class Device_Models extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'Device Model';
        $this->view->dtLists = $this->model->_selectAllDeviceType();
        $this->view->dmLists = $this->model->_selectAllDeviceModel();
        $this->view->dbLists = $this->model->_selectAllDeviceBrand();

        $this->view->render('device_models/index');
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

    public function insertDb() {
        $data = array();
        $data['dt_id'] = $_POST['device_type'];
        $data['db_id'] = $_POST['device_brand'];
        $data['dm_name'] = $_POST['dm_name'];
        $data['dm_reg_date'] = date('Y-m-d h:i:s');
        $data['dm_reg_by'] = Session::get('user_full_name');

        // @TODO: Do your error checking!

        $this->model->_insertDb($data);
        header('location: ' . URL . 'device_models');
    }

    public function edit($id) {
        $this->view->title = 'Edit Device Brand';

        $this->view->dmdId = $this->model->_edit($id);
        $this->view->dtLists = $this->model->_selectAllDeviceType();
        $this->view->dmLists = $this->model->_selectAllDeviceModel();
        $this->view->dbLists = $this->model->_selectAllDeviceBrand();
//        $this->view->dbLists = $this->model->_selectAllDeviceBrand();

        $this->view->render('device_models/edit');
    }

    public function editSave($id) {
        $data = array();
        $data['dm_id'] = $id;
        $data['dt_id'] = $_POST['device_type'];
        $data['db_id'] = $_POST['device_brand'];
        $data['dm_name'] = $_POST['dm_name'];


        // @TODO: Do your error checking!

        $this->model->_editSave($data);
        header('location: ' . URL . 'device_models/edit/' . $id);
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'device_models');
    }

}
