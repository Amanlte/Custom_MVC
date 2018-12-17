<?php

class Database extends PDO {

    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS) {
        //try {
        parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS);

        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Session::init();
//        } catch (PDOException $e) {
//            header('location: ' . URL . 'error/dbError');
//            ErrorLogger::add($e);
//        }
    }

    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC) {
        try {
            $sth = $this->prepare($sql);
            foreach ($array as $key => $value) {
                $sth->bindValue("$key", $value);
            }

            $sth->execute();
            return $sth->fetchAll($fetchMode);
        } catch (PDOException $ex) {
            Session::set('pdoError', $ex->getMessage() . ". For more details check pdo_error_logs file!");
            $error = "\r\n========================Error======================== \r\n\r\n[" . date('d-M-Y h:i:s') . ']  [ ErrorCode :' . $ex->getCode() . '] ' . $ex->getTraceAsString() .
                    " : \r\n\r\n ==>Error Message : " . $ex->getMessage() . "\r\n ======================== End ========================";
            ErrorLogger::add($error);
        }
    }

    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */
    public function insert($table, $data) {
        try {
            ksort($data);

            $fieldNames = implode('`, `', array_keys($data));
            $fieldValues = ':' . implode(', :', array_keys($data));

            $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

            foreach ($data as $key => $value) {
                $sth->bindValue(":$key", $value);
            }

            $sth->execute();
        } catch (PDOException $ex) {
            Session::set('pdoError', $ex->getMessage() . ". For more details check pdo_error_logs file!");
            $error = "\r\n========================Error======================== \r\n\r\n[" . date('d-M-Y h:i:s') . ']  [ ErrorCode :' . $ex->getCode() . '] ' . $ex->getTraceAsString() .
                    " : \r\n\r\n ==>Error Message : " . $ex->getMessage() . "\r\n ======================== End ========================";
            ErrorLogger::add($error);
        }
    }

    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data, $where) {
        try {
            ksort($data);

            $fieldDetails = NULL;
            foreach ($data as $key => $value) {
                $fieldDetails .= "`$key`=:$key,";
            }
            $fieldDetails = rtrim($fieldDetails, ',');

            $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

            foreach ($data as $key => $value) {
                $sth->bindValue(":$key", $value);
            }

            $sth->execute();
        } catch (PDOException $ex) {
            Session::set('pdoError', $ex->getMessage() . ". For more details check pdo_error_logs file!");
            $error = "\r\n========================Error======================== \r\n\r\n[" . date('d-M-Y h:i:s') . ']  [ ErrorCode :' . $ex->getCode() . '] ' . $ex->getTraceAsString() .
                    " : \r\n\r\n ==>Error Message : " . $ex->getMessage() . "\r\n ======================== End ========================";
            ErrorLogger::add($error);
        }
    }

    /**
     * delete
     * 
     * @param string $table
     * @param string $where
     * @param integer $limit
     * @return integer Affected Rows
     */
    public function delete($table, $data, $where) {
        try {
            ksort($data);

            $fieldDetails = NULL;
            foreach ($data as $key => $value) {
                $fieldDetails .= "`$key`=:$key,";
            }
            $fieldDetails = rtrim($fieldDetails, ',');

            $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

            foreach ($data as $key => $value) {
                $sth->bindValue(":$key", $value);
            }

            $sth->execute();
        } catch (PDOException $ex) {
            Session::set('pdoError', $ex->getMessage() . ". For more details check pdo_error_logs file!");
            $error = "\r\n========================Error======================== \r\n\r\n[" . date('d-M-Y h:i:s') . ']  [ ErrorCode :' . $ex->getCode() . '] ' . $ex->getTraceAsString() .
                    " : \r\n\r\n ==>Error Message : " . $ex->getMessage() . "\r\n ======================== End ========================";
            ErrorLogger::add($error);
        }
    }

}
