<?php

class Role_functionality extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'Role Functionality';
        $this->view->funcname = $this->model->_getFuncName();
        $this->view->roleId = $this->model->_getAllRoleID();
        $this->view->roleFunId = $this->model->_getAllRoleFunID();
        $this->view->rfLists = $this->model->_selectAllRF();
        $this->view->render('role_functionality/index');
    }

    public function getFuncName() {
        
    }

    public function insertRolFun() {

        //to insert the role for multiple functionality
        $Func = $_POST['functionality_id'];
        $allFunc = implode(',', $Func);

        //       foreach ($_POST['functionality_id'] as $fun) {
        $data = array();
        $data['func_name'] = $allFunc;
        $data['role_name'] = $_POST['role_id'];
        $data['reg_date'] = date('Y-m-d h:i:s');
        $data['reg_by'] = Session::get('user_full_name');

        // @TODO: Do your error checking!

        $this->model->_insertRolFun($data);

        header('location: ' . URL . 'role_functionality');
    }

    public function edit($id) {
        $this->view->title = 'Edit Functionality';
        
        $this->view->rfId = $this->model->_edit($id);// to fetch a row from role_functionality and functionality by role_id
        //$this->view->rfId1 = $this->model->_edit1($id);// to fetch a row from role_functionality and functionality by role_id
        $this->view->rfLists = $this->model->_selectAllRF(); // to fetch all rows from role_functionality
        $this->view->funcLists = $this->model->_selectAllFun();
        $this->view->render('role_functionality/edit');
    }

    public function editSave($id) {
        //to insert the role for multiple functionality
        $Func = $_POST['fun_name'];
        $allFunc = implode(',', $Func);
        $data = array();
        $data['func_id'] = $id;
        $data['fun_id'] = $allFunc;

        // @TODO: Do your error checking!

        $this->model->_editSave($data);
        header('location: ' . URL . 'role_functionality/edit/' . $id);
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'role_functionality');
    }

}
