<?php

class Floor extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'New Floor';
        $this->view->flrLists = $this->model->_selectAll();
        $this->view->render('floor/index');
    }

    public function insertFlr() {
            $data = array();
            
            $data['flr_name'] = $_POST['flr_name'];
            $data['reg_date'] = date('Y-m-d h:i:s');
            $data['reg_by'] = Session::get('user_full_name');

            // @TODO: Do your error checking!

            $this->model->_insertFlr($data);
            header('location: ' . URL . 'floor');
    }

     public function edit($id) 
    {
        $this->view->title = 'Edit Floor';
        $this->view->flrId = $this->model->_edit($id);
        
        $this->view->render('floor/edit');
    }
    
    public function editSave($id)
    {
        $data = array();
        $data['flr_id'] = $id;
        $data['flr_name'] = $_POST['flr_name'];

        // @TODO: Do your error checking!
        
        $this->model->_editSave($data);
        header('location: ' . URL . 'floor/edit/'.$id);
    }

    public function delete($id) {
        
        $this->model->_delete($id);
        header('location: ' . URL . 'floor');
    }

}
