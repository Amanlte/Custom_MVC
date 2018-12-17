<?php

class Roles extends Controller {

    function __construct() {
        parent::__construct(); 
        Session::init();
    }
    
    function index() {
        $this->view->title = 'Role';
        $this->view->roleLists = $this->model->_selectAll();
        $this->view->render('roles/index');
    }
    
    public function insertRole() {
            $data = array();
            
            $data['role_name'] = $_POST['role_name'];
            $data['reg_date'] = date('Y-m-d h:i:s');
            $data['reg_by'] = Session::get('user_full_name');

            // @TODO: Do your error checking!

            $this->model->_insertRole($data);
            header('location: ' . URL . 'roles');
    }
    
 	     public function edit($id) 
    {
        $this->view->title = 'Edit Role';
        $this->view->roleId = $this->model->_edit($id);
        
        $this->view->render('roles/edit');
    }
    
    public function editSave($id)
    {
        $data = array();
        $data['role_id'] = $id;
        $data['role_name'] = $_POST['role_name'];

        // @TODO: Do your error checking!
        
        $this->model->_editSave($data);
        header('location: ' . URL . 'roles/edit/'.$id);
    }
    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'roles');
    }
}