<?php

class Additional_Solutions extends Controller {

    function __construct() {
        parent::__construct(); 
    }
    
    function index() {
        $this->view->title = 'Solution'; 
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');
        $this->view->casLists = $this->model->_selectAllCase($data);
        $this->view->solLists = $this->model->_selectAll($data);
        $this->view->render('additional_solutions/index');
    }
    
    public function insertSol() {
        
        $data = array();

        $data['case_id'] = $_POST['case_id'];
        $data['user_id'] = Session::get('user_id');;//this should be user session id
        $data['additional_solution'] = $_POST['additional_solution'];
        $data['sol_date'] = date('Y-m-d h:i:s');

        // @TODO: Do your error checking!

        $this->model->_insertSol($data);
        
        header('location: ' . URL . 'additional_solutions');
    }
     public function edit($id) {
        $this->view->title = 'Edit Solutions';
        $this->view->solId = $this->model->_edit($id);
        
        $this->view->render('additional_solutions/edit');        
    }
    public function editSave($id)
    {
        $data = array();
        $data['sol_id'] = $id;
        $data['additional_solution'] = $_POST['additional_solution'];

        // @TODO: Do your error checking!
        
        $this->model->_editSave($data);
        header('location: ' . URL . 'additional_solutions/edit/'.$id);
    }
    public function delete($id) {
        
        $this->model->_delete($id);
        header('location: ' . URL . 'additional_solutions');
    }

}