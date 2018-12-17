<?php

class Request_Status extends Controller {

     function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->title = 'Request Status';
        $this->view->render('request_status/index');
    }

    public function getHandler() {

        $this->view->handle_by = $this->model->_getHandler();
        
        if(is_array($this->view->handle_by)) {
        echo '<label class="label">Request To :</label><p>'.$this->view->handle_by[][].'</p><br />';
        echo '<label class="label">Request Type :</label><p>'.$this->view->handle_by[][].'</p><br />';
        //echo '<label class="label">Request On :</label><p>'.$this->view->handle_by[][].'</p><br />';
        } else{
            echo '<label class="label">Noone is assigned.</label><br />';
        }
    }

}
