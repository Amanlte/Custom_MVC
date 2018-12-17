<?php

class Menu extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'New Main Menu';
        $this->view->mmLists = $this->model->_selectAll();
        $this->view->menuId = $this->model->_getAllMenuID();
        $this->view->submenuname = $this->model->_getSubMenuName();
        $this->view->render('menu/index');
    }

    public function insertMenu() {
        $data = array();

        $sub_menu = $_POST['sub_menu_id'];
        $sub_menu = implode(',', $sub_menu);
        $data['main_menu_name'] = $_POST['main_menu_name'];
        $data['sub_menu_name'] = $sub_menu;
        $data['reg_date'] = date('Y-m-d h:i:s');
        $data['reg_by'] = Session::get('user_full_name');

        // @TODO: Do your error checking!

        $this->model->_insertMenu($data);
        header('location: ' . URL . 'menu');
    }

    public function edit($id) {
        $this->view->title = 'Edit Main Menu';
        $this->view->mmId = $this->model->_edit($id);
        $this->view->mmLists = $this->model->_selectAll();
        $this->view->submenuname = $this->model->_getSubMenuName();

        $this->view->render('menu/edit');
    }

    public function editSave($id) {
        $submenu = $_POST['selected_one'];
        $submenu = implode(',', $submenu);
        $data = array();
        $data['menu_id'] = $id;
        $data['main_menu_name'] = $_POST['main_menu_name'];
        $data['sub_menu_id'] = $submenu;

        // @TODO: Do your error checking!

        $this->model->_editSave($data);
        header('location: ' . URL . 'menu/edit/' . $id);
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'menu');
    }

}
