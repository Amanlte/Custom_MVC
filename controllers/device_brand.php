<?php

class Device_Brand extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'Device Brand';
        
        $this->view->dtLists = $this->model->_selectAllDeviceType();
        $this->view->dbLists = $this->model->_selectAllDeviceBrand();
        
        $this->view->render('device_brand/index');
    }

    public function insertDb() {
        $data = array();
        $data['dt_id']=$_POST['dt_name'];
        $data['db_name'] = $_POST['db_name'];
        $data['db_reg_date'] = date('Y-m-d h:i:s');
        $data['db_reg_by'] = Session::get('user_full_name');

        // @TODO: Do your error checking!

        $this->model->_insertDb($data);
        header('location: ' . URL . 'device_brand');
    }

     public function edit($id) {
        $this->view->title = 'Edit Device Brand';
        
        $this->view->dbrId = $this->model->_edit($id);
        $this->view->dtLists = $this->model->_selectAllDeviceType();
        $this->view->dbLists = $this->model->_selectAllDeviceBrand();

        $this->view->render('device_brand/edit');
    }

    public function editSave($id) {
        $data = array();
        $data['db_id'] = $id;
        $data['dt_id'] = $_POST['device_type'];
        $data['db_name'] = $_POST['db_name'];
       

        // @TODO: Do your error checking!

        $this->model->_editSave($data);
        header('location: ' . URL . 'device_brand/edit/' . $id);
    }

     public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'device_brand');
    }

}
