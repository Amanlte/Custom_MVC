<?php

class Status extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('cases/js/default.js');
    }

    function index() {
        $this->view->title = 'Status';

        $this->view->staLists = $this->model->_selectAll();
        $this->view->tableNames = $this->model->_getAllTables();
        $this->view->render('status/index');
    }

    public function insertSta() {

        $data = array();
        $data['stat_name'] = $_POST['status_name'];
        $data['stat_for'] = $_POST['status_for'];
        $data['stat_reg_date'] = date('Y-m-d h:i:s');
        $data['stat_reg_by'] = Session::get('user_full_name'); // get from session

        $this->model->_insertSta($data);

        header('location: ' . URL . 'status');
    }

    public function edit($id) {
        $this->view->title = 'Edit Status';
        $this->view->staId = $this->model->_edit($id);
        $this->view->tableNames = $this->model->_getAllTables();

        $this->view->render('status/edit');
    }

    public function editSave($id) {
        $data = array();
        $data['stat_id'] = $id;
        $data['stat_name'] = $_POST['status_name'];
        $data['stat_for'] = $_POST['status_for'];

        $this->model->_editSave($data);
        header('location: ' . URL . 'status/edit/' . $id);
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'status');
    }

}
