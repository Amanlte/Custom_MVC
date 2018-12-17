<?php

class Menu_relationship extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'Menu Relationship';
        $this->view->submenuname = $this->model->_getSubMenuName();
        $this->view->menuId = $this->model->_getAllMenuID();
        //$this->view->roleSubMenuId = $this->model->_getAllMenuRelationshipID();
        //$this->view->mrLists = $this->model->_selectAllMR();
        $this->view->render('menu_relationship/index');
    }

    public function getSubMenuName() {
        
    }
/*
  INSERT INSERT AND INSERT HERE IF NEEDED */
/*
  EDIT EDIT AND EDIT HERE IF NECESSARY */

}
