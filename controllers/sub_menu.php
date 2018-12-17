<?php

class Sub_Menu extends Controller {

    function __construct() {
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->title = 'New Sub Menu';
        $this->view->smLists = $this->model->_selectAll();
        $this->view->funcLists = $this->model->_selectAllFunc();
        $this->view->pageLists = $this->model->_selectAllPages();
        $this->view->render('sub_menu/index');
    }

    public function insertSubMenu() {
        //to insert the pages
        $func = $_POST['func_id'];
        $allFunc = implode(',', $func);

        $data = array();

        $data['sub_menu_name'] = $_POST['sub_menu_name'];
        $data['functionalities_id'] = $allFunc;
        $data['reg_date'] = date('Y-m-d h:i:s');
        $data['reg_by'] = Session::get('user_full_name');

        // @TODO: Do your error checking!

        $this->model->_insertSubMenu($data);
        header('location: ' . URL . 'sub_menu');
    }

    public function edit($id) {
        $this->view->title = 'Edit Sub Menu';
        $this->view->smId = $this->model->_edit($id);
        $this->view->funcLists = $this->model->_selectAllFunc();
        $this->view->pageLists = $this->model->_selectAllPages();
        $this->view->smLists = $this->model->_selectAll();

        $this->view->render('sub_menu/edit');
    }

    public function editSave($id) {
        //to insert the pages
        $pages = $_POST['selected_one'];
        $allPages = implode(',', $pages);

        $data = array();
        $data['sub_menu_id'] = $id;
        $data['sub_menu_name'] = $_POST['sub_menu_name'];
        $data['functionalities_id'] = $allPages;

        // @TODO: Do your error checking!

        $this->model->_editSave($data);
        header('location: ' . URL . 'sub_menu/edit/' . $id);
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'sub_menu');
    }

}
