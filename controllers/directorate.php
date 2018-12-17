<?php

class Directorate extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'New Directorate';
        $this->view->dirLists = $this->model->_selectAll();
        $this->view->render('directorate/index');
    }

    public function insertDir() {
            $data = array();
            
            $data['dir_name'] = $_POST['dir_name'];
            $data['reg_date'] = date('Y-m-d h:i:s');
            $data['reg_by'] = Session::get('user_full_name');

            // @TODO: Do your error checking!

            $this->model->_insertDir($data);
            header('location: ' . URL . 'directorate');
    }

     public function edit($id) 
    {
        $this->view->title = 'Edit Directorate';
        $this->view->dirId = $this->model->_edit($id);
        
        $this->view->render('directorate/edit');
    }
    
    public function editSave($id)
    {
        $data = array();
        $data['dir_id'] = $id;
        $data['dir_name'] = $_POST['dir_name'];

        // @TODO: Do your error checking!
        
        $this->model->_editSave($data);
        header('location: ' . URL . 'directorate/edit/'.$id);
    }

    public function delete($id) {
        
        $this->model->_delete($id);
        header('location: ' . URL . 'directorate');
    }

}
