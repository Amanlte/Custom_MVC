<?php

class Feedback extends Controller {

    function __construct() {
        parent::__construct(); 
    }
    
    function index() {
        $this->view->title = 'Solution Feedback';
        
        $this->view->render('feedback/index');
    }

}