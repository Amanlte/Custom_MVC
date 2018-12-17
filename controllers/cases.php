<?php

class Cases extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
        $this->view->js = array('cases/js/default.js');
    }

    function index() {
        // Set the case page title
        $this->view->title = 'New Case';
        $data['user_team'] = Session::get('user_team');

        $this->view->casLists = $this->model->_selectAll($data);
        $this->view->solLists = $this->model->_selectAllAdditonal($data);
        $this->view->casAuto = $this->model->_selectCaseId($data);
        $this->view->teamId = $this->model->_selectAllTea();

        // rendering the case page
        $this->view->render('cases/index');
    }

    public function insertCas() {
        $team = Session::get('user_team');
        $data = array();

        $data['case_id'] = $_POST['case_id'];
        $data['case_area'] = $team;
        $data['case_type'] = $_POST['case_type'];
        $data['case_name'] = $_POST['case_name'];
        $data['case_details'] = $_POST['case_details'];
        $data['solution_name'] = $_POST['solution_name'];
        $data['solution_details'] = $_POST['solution_details'];
        $data['case_reg_date'] = date('Y-m-d h:i:s');
        $data['case_reg_by'] = Session::get('user_full_name');

        $this->model->_insertCas($data);

        header('location: ' . URL . 'cases');
    }

    public function edit($id) {
//        $this->view->title = 'Edit Cases';
//        $this->view->casId = $this->model->_edit($id);
//        $this->view->tableNames = $this->model->_getAllTables();
//
//        $this->view->render('cases/edit');
        
        $this->view->title = 'Edit Cases';
        $this->view->casId = $this->model->_edit($id);
        $this->view->tableNames = $this->model->_getAllTables();

        $this->view->render('cases/edit');
    }

    public function editSave($id) {
        $data = array();
//        $data['case_id'] = $id;
//        $data['case_name'] = $_POST['case_name'];
//        $data['case_solution_name'] = $_POST['solution_name'];
//
//        $this->model->_editSave($data);
//        header('location: ' . URL . 'cases/edit/' . $id);
        $data = array();
        $data['case_id'] = $id;
        $data['case_name'] = $_POST['case_name'];
        $data['case_solution_name'] = $_POST['solution_name'];

        $this->model->_editSave($data);
        header('location: ' . URL . 'cases/edit/' . $id);
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'cases');
    }

}
