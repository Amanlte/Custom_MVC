<?php

class device_type extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'Device Type';
        $this->view->dtLists = $this->model->_selectAll();
        $this->view->render('device_type/index');
    }

    public function insertDt() {
            $data = array();
            
            $data['dt_name'] = $_POST['dt_name'];
            $data['dt_reg_date'] = date('Y-m-d h:i:s');
            $data['dt_reg_by'] = Session::get('user_full_name');

            // @TODO: Do your error checking!

            $this->model->_insertDt($data);
            header('location: ' . URL . 'device_type');
    }

     public function edit($id) 
    {
       $this->view->title = 'Edit Device Type';
        $this->view->dtId = $this->model->_edit($id);
        
        $this->view->render('device_type/edit');    
    }
    
    public function editSave($id)
    {
        $data = array();
        $data['dt_id'] = $id;
        $data['dt_name'] = $_POST['dt_name'];

        // @TODO: Do your error checking!
        
        $this->model->_editSave($data);
        header('location: ' . URL . 'device_type/edit/'.$id);
    }

     public function delete($id) {
        
        $this->model->_delete($id);
        header('location: ' . URL . 'device_type');
    }

}
