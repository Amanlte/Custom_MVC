<?php

class Flogin extends Controller {
    function _construct() {
        parent::_construct();
        Session::init();
    }
    
    function index() {
        $this->view->title = 'Change your password';
        
        $this->view->render('flogin/index', true);
    }
}