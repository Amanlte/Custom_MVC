<?php

class Flogin_Model extends Model {
    function _construct(){
        parent::_construct();
        Session::init();
    }
}