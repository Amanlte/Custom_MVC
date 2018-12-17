<?php

class Position extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'New Position';
        $this->view->posLists = $this->model->_selectAll();
        $this->view->render('position/index');
    }

    public function insertPos() {
            $data = array();
            
            $data['pos_name'] = $_POST['pos_name'];
            $data['reg_date'] = date('Y-m-d h:i:s');
            $data['reg_by'] = Session::get('user_full_name');

            // @TODO: Do your error checking!

            $this->model->_insertPos($data);
            header('location: ' . URL . 'position');
    }

     public function edit($id) 
    {
        $this->view->title = 'Edit Position';
        $this->view->posId = $this->model->_edit($id);
        
        $this->view->render('position/edit');
    }
    
    public function editSave($id)
    {
        $data = array();
        $data['pos_id'] = $id;
        $data['pos_name'] = $_POST['pos_name'];

        // @TODO: Do your error checking!
        
        $this->model->_editSave($data);
        header('location: ' . URL . 'position/edit/'.$id);
    }

    public function delete($id) {
        
        $this->model->_delete($id);
        header('location: ' . URL . 'position');
    }

}
