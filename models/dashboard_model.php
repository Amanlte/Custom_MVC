<?php

class Dashboard_Model extends Model {

    public function __construct() {
        parent::__construct();
        Session::init();
    }

    public function xhrInsert() {
//        $text = $_POST['text'];
//        
//        $this->db->insert('data', array('text' => $text));
//        
//        $data = array('text' => $text, 'id' => $this->db->lastInsertId());
//        echo json_encode($data);
    }

    public function xhrGetListings() {
//        $result = $this->db->select("SELECT * FROM data");
//        echo json_encode($result);
    }

    public function xhrDeleteListing() {
//        $id = (int) $_POST['id'];
//        $this->db->delete('data', "id = '$id'");
    }

    public function _frequentRequests($id) {
        return $this->db->SELECT('SELECT req_type,COUNT(*) as count, req_type FROM request GROUP BY req_type ORDER BY count DESC LIMIT 10;');
    }

    public function _selectReqType($rp) {
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');
//        if ($_POST['rp']) {
        if ($rp == 'week') {
            //SELECT CURRENT WEEK ONLY
            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type,req_assigned_to "
                            . "FROM `cases`, request "
                            . "WHERE YEAR(req_last_update) = YEAR(CURDATE()) AND WEEK(req_last_update) = WEEK(CURDATE()) "
                            . "AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
        } else if ($rp == 'month') {
            //SELECT CURRENT MONTH ONLY
            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE YEAR(req_last_update) = YEAR(CURDATE()) AND MONTH(req_time) = MONTH(CURDATE()) AND req_area = '" . $data['user_team'] . "' AND  `case_id` = req_type GROUP BY case_type;");
        } else if ($rp == 'quarter') {
            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE QUARTER(`req_last_update`) = QUARTER(curdate()) AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
        } else if ($rp == 'six_month') {
            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=6 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
        } else if ($rp == 'nine_month') {
            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=9 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
        } else if ($rp == 'annual') {
            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=12 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
        }
//        }
    }
    public function _selectAllTeamSummary($rp) {
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');
//        if ($_POST['rp']) {
        if ($rp == 'week') {
            //SELECT CURRENT WEEK ONLY
            return $this->db->SELECT("SELECT req_area, COUNT(*) as count, case_type,req_assigned_to "
                            . "FROM `team`, request "
                            . "WHERE YEAR(req_last_update) = YEAR(CURDATE()) AND WEEK(req_last_update) = WEEK(CURDATE()) "
                            . "AND `team_id` = req_area GROUP BY req_area;");
        } else if ($rp == 'month') {
            //SELECT CURRENT MONTH ONLY
            return $this->db->SELECT("SELECT req_area, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE YEAR(req_last_update) = YEAR(CURDATE()) AND MONTH(req_time) = MONTH(CURDATE()) AND  `team_id` = req_area GROUP BY req_area;");
        } else if ($rp == 'quarter') {
            return $this->db->SELECT("SELECT req_area, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE QUARTER(`req_last_update`) = QUARTER(curdate()) AND `team_id` = req_area GROUP BY req_area;");
        } else if ($rp == 'six_month') {
            return $this->db->SELECT("SELECT req_area, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=6 AND `team_id` = req_area GROUP BY req_area;");
        } else if ($rp == 'nine_month') {
            return $this->db->SELECT("SELECT req_area, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=9 AND `team_id` = req_area GROUP BY req_area;");
        } else if ($rp == 'annual') {
            return $this->db->SELECT("SELECT req_area, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=12 AND `team_id` = req_area GROUP BY req_area;");
        }
//        }
    }

    public function _selectReqTypeTm($rp) {
//        $data['user_team'] = Session::get('user_team');
//        $data['user_id'] = Session::get('user_id');
////        if ($_POST['rp']) {
//        if ($rp == 'week') {
//            //SELECT CURRENT WEEK ONLY
//            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type,req_assigned_to "
//                            . "FROM `cases`, request "
//                            . "WHERE YEAR(req_time) = YEAR(CURDATE()) AND WEEK(req_time) = WEEK(CURDATE()) "
//                            . "AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
//        } else if ($rp == 'month') {
//            //SELECT CURRENT MONTH ONLY
//            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE YEAR(req_time) = YEAR(CURDATE()) AND MONTH(req_time) = MONTH(CURDATE()) AND req_area = '" . $data['user_team'] . "' AND  `case_id` = req_type GROUP BY case_type;");
//        } else if ($rp == 'quarter') {
//            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE QUARTER(`req_time`) = QUARTER(curdate()) AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
//        } else if ($rp == 'six_month') {
//            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_time, CURDATE())<=6 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
//        } else if ($rp == 'nine_month') {
//            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_time, CURDATE())<=9 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
//        } else if ($rp == 'annual') {
//            return $this->db->SELECT("SELECT req_type, COUNT(*) as count, case_type, req_assigned_to FROM `cases`, request WHERE TIMESTAMPDIFF(MONTH, req_time, CURDATE())<=12 AND req_area = '" . $data['user_team'] . "' AND `case_id` = req_type GROUP BY case_type;");
//        }
//        }
    }

    public function _selectAllTeamMembers() {
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');
        return $this->db->SELECT("SELECT user_id, user_full_name FROM `users` WHERE user_team = '" . $data['user_team'] . "'");
    }

    public function _availableMembers() {
        return $this->db->SELECT("SELECT * FROM users "
                        . "WHERE user_team = :team AND deleted = :isDeleted", array(':team' => Session::get('user_team'), ':isDeleted' => 0));
    }

    public function _viewFrequentRequest() {
        $user_team = Session::get('user_team');
        $data_points = array();
        return $this->db->SELECT("SELECT req_type, COUNT(*) as count, req_type, (SELECT case_name FROM cases WHERE case_id = req_type) AS caseName from request WHERE req_area = '" . $user_team . "' GROUP BY req_type ORDER BY count DESC LIMIT 10;");
    }

    public function _viewAllTeamRequest() {
        $user_team = Session::get('user_team');
        $data_points = array();
        return $this->db->SELECT("SELECT req_area, COUNT(*) as count, req_area, (SELECT team_display_name FROM team WHERE team_id = req_area) AS teamName from request GROUP BY req_area ORDER BY count DESC;");
    }

    public function _selectReqStatus($rp) {
        $data['user_team'] = Session::get('user_team');
        $data['user_id'] = Session::get('user_id');
        if ($_POST['rp'])
            if ($rp == 'week') {
                //SELECT CURRENT WEEK ONLY
                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE YEAR(req_last_update) = YEAR(CURDATE()) AND WEEK(req_last_update) = WEEK(CURDATE()) AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
            } else if ($rp == 'month') {
                //SELECT CURRENT MONTH ONLY  
                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE YEAR(req_last_update) = YEAR(CURDATE()) AND MONTH(req_last_update) = MONTH(CURDATE()) AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
            } else if ($rp == 'quarter') {
                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE QUARTER(`req_last_update`) = QUARTER(curdate()) AND req_area = '" . $data['user_team'] . "'  AND `stat_id` = req_solution_status GROUP BY stat_name;");
            } else if ($rp == 'six_month') {
                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=6 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
            } else if ($rp == 'nine_month') {
                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=9 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
            } else if ($rp == 'annual') {
                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=12 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
            }
    }

    public function _selectReqStatusTm($trp) {
//        $data['user_team'] = Session::get('user_team');
//        $data['user_id'] = Session::get('user_id');
//        $data['teamMember'] = $_POST['teamMemberReport'];
////        if ($_POST['rp'])
////            if ($rp == 'week') {
//        //SELECT CURRENT WEEK ONLY
//        return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE req_assigned_to = '" . $data['teamMember'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
//            } else if ($rp == 'month') {
//                //SELECT CURRENT MONTH ONLY  
//                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE YEAR(req_last_update) = YEAR(CURDATE()) AND MONTH(req_last_update) = MONTH(CURDATE()) AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
//            } else if ($rp == 'quarter') {
//                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE QUARTER(`req_last_update`) = QUARTER(curdate()) AND req_area = '" . $data['user_team'] . "'  AND `stat_id` = req_solution_status GROUP BY stat_name;");
//            } else if ($rp == 'six_month') {
//                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=6 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
//            } else if ($rp == 'nine_month') {
//                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=9 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
//            } else if ($rp == 'annual') {
//                return $this->db->SELECT("SELECT req_solution_status, COUNT(*) as count, stat_name FROM `status`, request WHERE TIMESTAMPDIFF(MONTH, req_last_update, CURDATE())<=12 AND req_area = '" . $data['user_team'] . "' AND `stat_id` = req_solution_status GROUP BY stat_name;");
//            }
    }

    public function _changePassword($data) {
        $data['new_passowrd'] = Hash::create('sha256', $data['password'], HASH_PASSWORD_KEY);
        $postData = array(
            'user_password' => isset($data['new_passowrd']) ? $data['new_passowrd'] : ''
        );

        $this->db->update('users', $postData, "`user_id` = '{$data['user_id']}'");
        Session::set('userSuccess', true);
    }

    public function _selectCases($id) {

//        return $this->db->SELECT('SELECT *, '
//                        . '(SELECT case_name FROM cases WHERE case_id = request.req_type) AS caseName,'
////                        . '(SELECT additional_solution FROM solutions WHERE solutions.req_id = request.req_id GROUP BY case_id) AS addSolution, '
//                        . '(SELECT stat_name FROM status WHERE stat_id = request.req_solution_status) AS status, '
//                        . '(SELECT user_full_name FROM users WHERE user_id = request.req_assigned_to) AS handledBy '
////                        . 'FROM `request`  WHERE user_id IN (SELECT user_id FROM request WHERE req_id = :id) AND request.req_solution_status = :ss AND request.req_solution_status = :rs AND request.deleted = :isDeleted', array(':id' => $id, ':ss' => 1, ':rs' => 1, ':isDeleted' => 0));
//                        . 'FROM `request`  WHERE user_id IN (SELECT user_id FROM request WHERE req_id = :id) AND request.req_status <> 0 AND request.deleted = :isDeleted', array(':id' => $id, ':isDeleted' => 0));
        return $this->db->SELECT('SELECT * FROM cases WHERE deleted = 0');
    }

}
