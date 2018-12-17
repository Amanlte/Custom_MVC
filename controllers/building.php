<?php

class Building extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'New Building';
        $this->view->buiLists = $this->model->_selectAll();
        $this->view->render('building/index');
        
    }

    public function insertBui() {
            $data = array();
            
            $data['bui_name'] = $_POST['bui_name'];
            $data['reg_date'] = date('Y-m-d h:i:s');
            $data['reg_by'] = Session::get('user_full_name');

            // @TODO: Do your error checking!

            $this->model->_insertBui($data);
            header('location: ' . URL . 'building');
    }

     public function edit($id) 
    {
        $this->view->title = 'Edit Building';
        $this->view->buiId = $this->model->_edit($id);        
        $this->view->render('building/edit');
    }
    
    public function editSave($id)
    {
        $data = array();
        $data['bui_id'] = $id;
        $data['bui_name'] = $_POST['bui_name'];

        // @TODO: Do your error checking!
        
        $this->model->_editSave($data);
        header('location: ' . URL . 'building/edit/'.$id);
    }

    public function delete($id) {
        
        $this->model->_delete($id);
        header('location: ' . URL . 'building');
    }

}
