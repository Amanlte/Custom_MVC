<?php

class Request_Status_Model extends Model {

  function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _getHandler() {

        return $this->db->select("SELECT * "
                        . "FROM `request`"
                        . "WHERE req_id = :rid AND request.req_status = :status AND request.req_area = :area AND team.team_leader = :id AND request.deleted = :isDeleted", array(':rid' => $data['id'], ':status' => '0', ':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted' => 0));
    }

}
