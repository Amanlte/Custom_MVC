<?php
class Messages extends Controller{
    
    function __construct() {
        parent::__construct();
    }
    
//    function index () {
//        $this->view->title = "Messages";
//        
//        //$this->view->render('messages/index');
//    }
    
    public function getRequests() {
        
        $data = array();
        
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');
        
        $this->view->no_notifications = $this->model->_getRequests($data);
        if($this->view->no_notifications[0]['Notifications'] > 0)
            echo $this->view->no_notifications[0]['Notifications'];
    }
}