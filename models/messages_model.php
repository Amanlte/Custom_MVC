<?php

class Messages_Model extends Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function _getMessages() {
        
    }
    
    public function _getRequests($data) {
        
        return $this->db->select("SELECT COUNT(*) as Notifications FROM request "
                . "WHERE req_status = :status AND req_area = :area AND user_id = :id AND deleted = :isDeleted", 
                array(':status'=> 'New', ':area' => $data['user_team'], ':id' => $data['user_id'], ':isDeleted'=> 0));
    }
}