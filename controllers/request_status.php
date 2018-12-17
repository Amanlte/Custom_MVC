<?php

class Request_Status extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->title = 'Request Status';
         $this->view->reqLists = $this->model->_viewHistory();
         $this->view->recRequest = $this->model->_recentRequest();
        $this->view->render('request_status/index');
    }

}
