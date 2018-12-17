<?php

class Team extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->title = 'Team Registeration';
        $this->view->dirLists = $this->model->_selectAllDir();
        $this->view->teaLists = $this->model->_selectAll();
        $this->view->render('team/index');
    }

    public function selectUserId() {
        if (isset($_GET['term'])) {
            $q = $_GET['term'];
            $this->view->user = $this->model->_selectUserId($q);
            $json = array();
            foreach ($this->view->user as $key => $value) {
                $json[] = array('value' => $value['user_id'], 'label' => $value['user_full_name']);
            }
            echo json_encode($json);
        }
    }

    public function insertTea() {
        $data = array();
        $data['dir_id'] = $_POST['directorate_name'];
        $data['team_name'] = $_POST['team_name'];
        $data['team_leader'] = $_POST['team_leader'];
        $data['team_reg_date'] = date('Y-m-d h:i:s');
        $data['team_reg_by'] = Session::get('user_full_name'); //this should take session id 

        $this->model->_insertTea($data);
        header('location: ' . URL . 'team');
    }

    public function edit($id) {
        $this->view->title = 'Edit Team';
        $this->view->teaId = $this->model->_edit($id);

        $this->view->render('team/edit');
    }

    public function editSave($id) {
        $data = array();
        $data['team_id'] = $id;
        $data['team_name'] = $_POST['team_name'];
        $data['team_leader'] = $_POST['team_leader'];

        // @TODO: Do your error checking!

        $this->model->_editSave($data);
        header('location: ' . URL . 'team/edit/' . $id);
    }

    public function currentLeader() {

        if (isset($_POST['dt']) && $_POST['dt'] > 0) {
            
            $user = $_POST['dt'];
            $this->view->tl = $this->model->_currentLeader($user);
            echo $this->view->tl[0]['user_full_name'];
        } else {
                echo 'Not assigned yet';
        }
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'team');
    }

}
