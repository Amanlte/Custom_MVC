<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logger
 *
 * @author user
 */
class ErrorLogger {

    const FILENAME = 'logs/pdoerrorlogs/pdo_log_error.txt';

    public static function add($error) {
        file_put_contents(self::FILENAME, $error, FILE_APPEND);
    }

}
