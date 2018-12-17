<?php

class Request extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->title = 'Request Registeration';
        $this->view->teaLists = $this->model->_selectAllTea();
        $this->view->casLists = $this->model->_selectAllCas();
        $this->view->recRequest = $this->model->_recentRequest();
        
        $id = Session::get('user_id');
        $this->view->render('request/index');
    }

    public function insertReq() {

        $data = array();
        $data['user_id'] = Session::get('user_id'); //this should be user session id
        if ($_POST['request_area'] == 'other') {
            $data['req_area'] = 9;
        } else {
            $data['req_area'] = $_POST['request_area']; //req-area gets from team and save team-id 
        }
        $data['req_type'] = $_POST['request_type']; //req-type gets from case and inserts case id
        $data['req_details'] = $_POST['request_details'];
        $data['req_time'] = date('Y-m-d h:i:s');
// @TODO: Do your error checking!

        $this->model->_insertReq($data);

        header('location: ' . URL . 'request');
    }

    public function sendFeedback() {
        $data = array();
        $data['rid'] = isset($_POST['rid']) ? $_POST['rid'] : '';
        $data['feedback'] = isset($_POST['feedback']) ? $_POST['feedback'] : '';
        $data['detail_feedback'] = isset($_POST['detail_feedback']) ? $_POST['detail_feedback'] : '';
        $this->model->_sendFeedback($data);
    }

    public function selectCaseId() {
        if ($_POST['dt']) {
            $dt = $_POST['dt'];
            $this->view->dt = $this->model->_selectCaseId($dt);
            echo '<option value="">-- Select --</option>';
            foreach ($this->view->dt as $key => $value) {
                echo '<option value="' . $value['case_id'] . '">' . $value['case_name'] . '</option>';
            }
//            echo '<option value="other"> Other </option>';
//echo json_encode($brand);
        }
    }

}
