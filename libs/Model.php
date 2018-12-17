<?php

class Model {

    function __construct() {
        $this->view = new View();
        
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        date_default_timezone_set('Africa/Addis_Ababa'); // make this match the server timezone
    }

}