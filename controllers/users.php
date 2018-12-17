<?php

class Users extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->title = 'Users';
        $this->view->usersLists = $this->model->_selectAll();
        $this->view->usersDetails = $this->model->_selectUserDetails();
        $this->view->usersAdditionalDetails = $this->model->_selectDetails();
        $this->view->buildingLists = $this->model->_selectAllBuilding();
        $this->view->floorLists = $this->model->_selectAllFloor();
        $this->view->positionLists = $this->model->_selectAllPostion();
        $this->view->dirName = $this->model->_selectAllDir();
        $this->view->teamName = $this->model->_selectAllTea();
        $this->view->rolName = $this->model->_selectAllRol();
        $this->view->render('users/index');
    }

    public function insertUsers() {
        $data = array();

        $data['user_full_name'] = $_POST['full_name'];
        $data['user_building'] = $_POST['building'];
        $data['user_floor'] = $_POST['floor'];
        $data['user_directorate'] = $_POST['directorate'];
        $data['user_team'] = $_POST['team'];
        $data['user_position'] = $_POST['position'];
        $data['user_login_name'] = $_POST['user_name'];
        $data['user_password'] = $_POST['user_password'];
        $data['user_phone'] = $_POST['phone_number'];
        $data['user_email'] = $_POST['email'];
        $data['user_role'] = $_POST['roles'];
        $data['user_reg_date'] = date('Y-m-d h:i:s');
        $data['user_reg_by'] = Session::get('user_full_name');




        // @TODO: Do your error checking!

        $this->model->_insertUsers($data);
        header('location: ' . URL . 'users');
    }

    public function edit($id) {
        $this->view->title = 'Edit users';
        $this->view->userId = $this->model->_edit($id);
        $this->view->rolName = $this->model->_selectAllRol();
        $this->view->positionLists = $this->model->_selectAllPostion();
        $this->view->buildingLists = $this->model->_selectAllBuilding();
        $this->view->floorLists = $this->model->_selectAllFloor();
        $this->view->dirLists = $this->model->_selectAllDir();
        $this->view->teamLists = $this->model->_selectAllTea();
        $this->view->render('users/edit');
    }

    public function editSave($id) {
        $data = array();
        $data['user_id'] = $id;
        $data['user_full_name'] = $_POST['full_name'];
        $data['user_building'] = $_POST['building'];
        $data['user_floor'] = $_POST['floor'];
        $data['user_directorate'] = $_POST['directorate'];
        $data['user_team'] = $_POST['team'];
        $data['user_position'] = $_POST['position'];
        $data['user_login_name'] = $_POST['user_name'];
        $data['user_phone'] = $_POST['phone_number'];
        $data['user_email'] = $_POST['email'];
        $data['user_role'] = $_POST['roles'];

        // @TODO: Do your error checking!

        $this->model->_editSave($data);
        header('location: ' . URL . 'users/edit/' . $id);
    }

    public function selectTeamByDir() {
        if ($_POST['dir']) {
            $dir = $_POST['dir'];
            $this->view->dir = $this->model->_selectTeamByDir($dir);
            echo '<option value="">--Select--</option>';
            foreach ($this->view->dir as $key => $value) {
                echo '<option value="' . $value['team_id'] . '">' . $value['team_name'] . '</option>';
            }
        }
    }

    public function selectTeamByDirForEdit() {
        if ($_POST['dir']) {
            $dir = $_POST['dir'];
            $this->view->dir = $this->model->_selectTeamByDir($dir);
            echo '<option value="">--Select--</option>';
            foreach ($this->view->dir as $key => $value) {
                if ($dir == $value['dir_id']) {
                    echo '<option value="' . $value['team_id'] . '" selected>' . $value['team_name'] . '</option>';
                } else {
                    echo '<option value="' . $value['team_id'] . '">' . $value['team_name'] . '</option>';
                }
            }
        }
    }

    public function viewUserDetails() {
        if (isset($_POST['id'])) {
            $uid = $_POST['id'];
        }
        $this->view->viewUser = $this->model->_viewUserDetails($uid);

        foreach ($this->view->viewUser as $key => $value) {
            echo '<tr><th>Full Name</th><td class="td_value">' . $value['user_full_name'] . '</td><th>Login Name</th><td class="td_value">' . $value['user_login_name'] . '</td></tr>';
            echo '<tr><th>ID </th><td class="td_value">' . $value['user_id'] . '</td><th>Phone</th><td class="td_value">' . $value['user_phone'] . '</td></tr>';
            echo '<tr><th>Building</th><td class="td_value">' . $value['building'] . '</td><th>e-mail</th><td class="td_value">' . $value['user_email'] . '</td></tr>';
            echo '<tr><th>Floor</th><td class="td_value">' . $value['floor'] . '</td><th>Role</th><td class="td_value">' . $value['role'] . '</td></tr>';
            echo '<tr><th>Directorate</th><td class="td_value">' . $value['directorate'] . '</td><th>Registered on</th><td class="td_value">' . $value['user_reg_date'] . '</td></tr>';
            echo '<tr><th>Position</th><td class="td_value">' . $value['position'] . '</td><th>Registered by</th><td class="td_value">' . $value['user_reg_by'] . '</td></tr>';
        }
    }
//
//    public function viewUser() {
//        if (isset($_POST['id'])) {
//            $uid = $_POST['id'];
//        }
//
//        $this->view->viewUser = $this->model->_viewUser($uid);
//        if (is_array($this->view->viewUser)) {
//            foreach ($this->view->viewUser as $key => $user) {
//
//                echo'<tr>';
//                echo '<td>' . $user['user_id'] . '</td>'
//                . '<td>' . $user['user_full_name'] . '</td>'
//                . '<td>' . $user['building'] . '</td>'
//                . '<td>' . $user['user_floor'] . '</td>'
//                . '<td>' . $user['directorate'] . '</td>'
//                . '<td>' . $user['team'] . '</td>'
//                . '<td>' . $user['position'] . '</td>'
//                . '<td>' . $user['user_phone'] . '</td>'
//                . '<td>' . $user['user_email'] . '</td>';
//                echo '</tr>';
//            }
//        } else {
//            echo '<tr><td colspan="8">Information about this user not found.</td></tr>';
//        }
//    }

    public function viewDevice() {
        if (isset($_POST['id'])) {
            $uid = $_POST['id'];
        }

        $this->view->viewUserDevice = $this->model->_viewDevice($uid);
        if (is_array($this->view->viewUserDevice)) {
            foreach ($this->view->viewUserDevice as $key => $device) {

                echo'<tr>'
                . '<td>' . $device['device_name'] . '</td>'
                . '<td>' . $device['brand'] . '</td>'
                . '<td>' . $device['model'] . '</td>'
                . '<td>' . $device['dev_tag'] . '</td>'
                . '<td>' . $device['dev_pc_hd'] . '</td>'
                . '<td>' . $device['dev_pc_ram'] . '</td>'
                . '<td>' . $device['dev_remark'] . '</td>'
                . '<td>' . $device['status'] . '</td></tr>';
            }
        } else {
            echo '<tr><td colspan="6">' . print_r($this->view->viewUserDevice) . 'There is no any history registered by this user.</td></tr>';
        }
    }

       public function viewHistory() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $this->view->viewHistory = $this->model->_viewRequest($id);

        if (is_array($this->view->viewHistory)) {
            foreach ($this->view->viewHistory as $key => $history) {
                echo '<tr>';
                echo '<td>' . $history['caseName'] . '</td>'
                . '<td>' . $history['req_details'] . '</td>'
                . '<td>' . $history['req_time'] . '</td>'
                . '<td>' . $history['addSolution'] . '</td>'
                . '<td>' . $history['status'] . '</td>'
                . '<td>' . $history['handledBy'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">' . print_r($this->view->viewHistory) . 'There is no any history registered by this user.</td></tr>';
        }
    }

    public function delete($id) {

        $this->model->_delete($id);
        header('location: ' . URL . 'users');
    }

}
