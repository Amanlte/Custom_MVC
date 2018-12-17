    <?php

    class Page extends Controller {

        function __construct() {
            parent::__construct();
            Session::init();
        }

        function index() {
            $this->view->title = 'Page';            
            $this->view->funcId = $this->model->_selectAllFunc();
            $this->view->funcLists = $this->model->_selectAllFunctionalities();
            $this->view->pageLists = $this->model->_selectAllPages();
            
            $this->view->render('page/index');
        }

        public function insertPage() {
            $page = $_POST['page'];
            $pages = implode(',', $page);
            $data = array();
            $data['func_id'] = $_POST['func_id'];
            $data['page'] = $pages;
            $data['reg_date'] = date('Y-m-d h:i:s');
            $data['reg_by'] = Session::get('user_full_name');
            $this->model->_insertPage($data);
            header('location: ' . URL . 'page');
        }

        public function edit($id) {
            $this->view->title = 'Edit Pages for Functionality';
            $this->view->pgId = $this->model->_edit($id);
            $this->view->funcLists = $this->model->_selectAllFunctionalities();
            $this->view->pageLists = $this->model->_selectAllPages();
            $this->view->render('page/edit');
        }

        public function editSave($id) {
            $page = $_POST['page'];
            $pages = implode(',', $page);            
            $data = array();
            $data['page_id'] = $id;
            $data['func_id'] = $_POST['func_id'];
            $data['page'] = $pages;
            $data['reg_date'] = date('Y-m-d h:i:s');
            $data['reg_by'] = Session::get('user_full_name');
            // @TODO: Do your error checking!

            $this->model->_editSave($data);
            header('location: ' . URL . 'page/edit/' . $id);
        }

        public function delete($id) {

            $this->model->_delete($id);
            header('location: ' . URL . 'page');
        }

    }
