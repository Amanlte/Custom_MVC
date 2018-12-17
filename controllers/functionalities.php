<?php

class Functionalities extends Controller {

    function __construct() {
         parent::__construct(); 
	     Session::init(); 
    }
    
    function index() {
        $this->view->title = 'Permission ';
        $this->view->roleId = $this->model->_getAllRoleID();
        $this->view->funcLists = $this->model->_selectAll();       
        $this->view->render('functionalities/index');
    }
    public function insertFunc() {
            $data = array();
            $data['func_name'] = $_POST['functionality_name'];
            $data['reg_date'] = date('Y-m-d h:i:s');
            $data['reg_by'] = Session::get('user_full_name');

            // @TODO: Do your error checking!

            $this->model->_insertFunc($data);
            header('location: ' . URL . 'functionalities');
    }
    
 	     public function edit($id) 
    {
        $this->view->title = 'Edit Permission';
        $this->view->funcId = $this->model->_edit($id);
        
        $this->view->render('functionalities/edit');
    }
    
    public function editSave($id)
    {
        $data = array();
        $data['func_id'] = $id;
        $data['func_name'] = $_POST['func_name'];

        // @TODO: Do your error checking!
        
        $this->model->_editSave($data);
        header('location: ' . URL . 'functionalities/edit/'.$id);
    }
    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'functionalities');
    }    
  }