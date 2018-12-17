<?php

class Login extends Controller {

    function __construct() {
        parent::__construct();    
    }
    
    function index() 
    {    
        $this->view->title = 'Login';
        
        $this->view->render('login/index', $noInclude = true);
        
    }
    
    public function run()
    {
        $this->model->_run();
    }
    

}